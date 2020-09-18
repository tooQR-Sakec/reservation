<?php
include('../db.php');

$guestName = $_POST['guestName'];
$guestEmail = $_POST['guestEmail'];
$guestCapacity = $_POST['guestCapacity'];
$guestStartTime = $_POST['guestStartTime'];
$guestEndTime = $_POST['guestEndTime'];
$roomID = $_POST['roomID'];

// buffer timing
$bufferSQL = "SELECT value FROM settings WHERE parameter = 'bufferTime'";
$bufferSTMT = $conn->prepare($bufferSQL);
$bufferSTMT->execute();
$bufferTime = $bufferSTMT->fetchObject()->value;
$startTime  = $guestStartTime - $bufferTime;
$endTime  = $guestEndTime + $bufferTime;

// check Hotel start timing
$startTimeSQL = "SELECT value FROM settings WHERE parameter = 'startTime'";
$startTimeSTMT = $conn->prepare($startTimeSQL);
$startTimeSTMT->execute();
$restaurantStart = explode(":", $startTimeSTMT->fetchObject()->value);
$restaurantStartSeconds = $restaurantStart[0] * 3600 + $restaurantStart[1] * 60;
$startTimeSeconds = date("H", $startTime) * 3600 + date("i", $startTime) * 60;
// check Hotel end timing
$endTimeSQL = "SELECT value FROM settings WHERE parameter = 'endTime'";
$endTimeSTMT = $conn->prepare($endTimeSQL);
$endTimeSTMT->execute();
$restaurantEnd = explode(":", $endTimeSTMT->fetchObject()->value);
$restaurantEndSeconds = $restaurantEnd[0] * 3600 + $restaurantStart[1] * 60;
$endTimeSeconds = date("H", $endTime) * 3600 + date("i", $endTime) * 60;
if ($restaurantStartSeconds > $restaurantEndSeconds) {
	if ($startTimeSeconds < $restaurantEndSeconds) {
		$startTimeSeconds += 86400;
	}
	if ($endTimeSeconds < $restaurantEndSeconds) {
		$endTimeSeconds += 86400;
	}
	$restaurantEndSeconds += 86400;
}
if (($startTimeSeconds < $restaurantStartSeconds) || ($restaurantEndSeconds < $startTimeSeconds) || ($restaurantEndSeconds < $endTimeSeconds) || ($endTimeSeconds < $restaurantStartSeconds)) {
	echo "Closed";
	exit;
}

// query to directly get table
$getTableSQL = "DECLARE @startTime BIGINT = :startTime,
@endTime BIGINT = :endTime;
SELECT TOP 1 tables.tableID, tables.capacity
FROM tables
WHERE (tables.reserved = 0) AND capacity = :guestCapacity
AND tables.tableID NOT IN (
	SELECT booking.tableID
	FROM booking
	WHERE (@startTime > booking.startTime AND @startTime < booking.endTime)
		OR (@endTime > booking.startTime AND @endTime < booking.endTime)
		OR (@startTime <= booking.startTime AND booking.endTime <= @endTime)
	GROUP BY booking.tableID)";

$getTableSTMT = $conn->prepare($getTableSQL, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
$getTableSTMT->bindParam(':startTime', $startTime);
$getTableSTMT->bindParam(':endTime', $endTime);
$getTableSTMT->bindParam(':guestCapacity', $guestCapacity);
$getTableSTMT->execute();
$tableRow = $getTableSTMT->fetchObject();

try {
	// set the PDO error mode to exception
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$conn->beginTransaction();
	if (isset($tableRow->tableID)) {
		$reservedTables[] = $tableRow->tableID;
	} else {
		// query to get table count
		$getTableCountSQL = "DECLARE @startTime BIGINT = :startTime,
		@endTime BIGINT = :endTime;
		SELECT count(*) AS tableCount, capacity
		FROM tables
		WHERE tableID NOT IN (
			SELECT tableID
			FROM booking
			WHERE (@startTime > booking.startTime AND @startTime < booking.endTime)
				OR (@endTime > booking.startTime AND @endTime < booking.endTime)
				OR (@startTime <= booking.startTime AND booking.endTime <= @endTime)
			GROUP BY tableID
		)
		AND reserved = '0'
		GROUP BY capacity";

		$getTableCountSTMT = $conn->prepare($getTableCountSQL);
		$getTableCountSTMT->bindParam(':startTime', $startTime);
		$getTableCountSTMT->bindParam(':endTime', $endTime);
		$getTableCountSTMT->execute();

		while ($tableRow = $getTableCountSTMT->fetchObject()) {
			$tableCount = $tableRow->tableCount;
			$capacity = $tableRow->capacity;
			$availableSlot[$capacity] = $tableCount;
		}

		// query to get table data
		$getTableDataSQL = "DECLARE @returnCount INT  = :requiredCount,
		@startTime BIGINT = :startTime,
		@endTime BIGINT = :endTime;
		SELECT TOP (@returnCount) tableID, capacity
			FROM tables
			WHERE tables.tableID NOT IN (
				SELECT tableID
				FROM booking
				WHERE (@startTime > booking.startTime AND @startTime < booking.endTime)
					OR (@endTime > booking.startTime AND @endTime < booking.endTime)
					OR (@startTime <= booking.startTime AND booking.endTime <= @endTime)
				GROUP BY tableID
			) AND reserved = 0 AND capacity = :capacity";

		$getTableDataSTMT = $conn->prepare($getTableDataSQL);
		$getTableDataSTMT->bindParam(':startTime', $startTime);
		$getTableDataSTMT->bindParam(':endTime', $endTime);

		if (!isset($availableSlot)) { // if table not available
			echo "full";
			exit;
		}
		foreach ($availableSlot as $capacity => $count) {
			$requiredCount = ceil($guestCapacity / $capacity);

			// get table for each capacity
			$getTableDataSTMT->bindParam(':capacity', $capacity);
			$getTableDataSTMT->bindParam(':requiredCount', $requiredCount, PDO::PARAM_INT);
			$getTableDataSTMT->execute();
			while ($tableRow = $getTableDataSTMT->fetchObject()) {
				$tableID = $tableRow->tableID;
				$capacity = $tableRow->capacity;
				$availableTables[$tableID] = $capacity;
			}

			// avoid table with capacity greater then guest capacity
			if ($capacity > $guestCapacity) {
				break;
			}
		}
		print_r($availableTables);
		$data["capacity"] = $guestCapacity;
		$data["table"] = $availableTables;
		$data = json_encode($data);

		$ch = curl_init('localhost:5000');
		# Setup request to send json via POST.
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		# Return response instead of printing.
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		# Send request.
		$result = curl_exec($ch);
		curl_close($ch);

		if ($result == "False") { // if table not available
			echo "full";
			exit;
		}
		$reservedTables = json_decode($result, true);
	}

	print_r($reservedTables);
	// booking table
	$reserveTableSQL = "INSERT INTO booking (tableID, guestName, guestEmail, numberOfPeople, roomID, startTime, endTime, status) VALUES (:tableID, :name, :email, :numberOfPeople, :roomID, :startTime, :endTime, :status)";
	$reserveTableSTMT = $conn->prepare($reserveTableSQL);
	$reserveTableSTMT->bindParam(':name', $guestName);
	$reserveTableSTMT->bindParam(':email', $guestEmail);
	$reserveTableSTMT->bindParam(':numberOfPeople', $guestCapacity);
	$reserveTableSTMT->bindParam(':roomID', $roomID);
	$reserveTableSTMT->bindParam(':startTime', $guestStartTime);
	$reserveTableSTMT->bindParam(':endTime', $guestEndTime);
	$reserveTableSTMT->bindParam(':status', $status);

	//logs table
	$logTableSQL = "INSERT INTO logs (tableID, guestName, guestEmail, numberOfPeople, roomID, startTime, endTime, status) VALUES (:tableID, :name, :email, :numberOfPeople, :roomID, :startTime, :endTime, :status)";
	$status = "reserved";
	$logTableSTMT = $conn->prepare($logTableSQL);
	$logTableSTMT->bindParam(':name', $guestName);
	$logTableSTMT->bindParam(':email', $guestEmail);
	$logTableSTMT->bindParam(':numberOfPeople', $guestCapacity);
	$logTableSTMT->bindParam(':roomID', $roomID);
	$logTableSTMT->bindParam(':startTime', $guestStartTime);
	$logTableSTMT->bindParam(':endTime', $guestEndTime);
	$logTableSTMT->bindParam(':status', $status);

	foreach ($reservedTables as $tableID) {
		$reserveTableSTMT->bindParam(':tableID', $tableID);
		$reserveTableSTMT->execute();
		$logTableSTMT->bindParam(':tableID', $tableID);
		$logTableSTMT->execute();
	}
	$conn->commit();
} catch (PDOException $e) {
	$conn->rollBack();
	echo "Failed " . $e->getMessage();
}
