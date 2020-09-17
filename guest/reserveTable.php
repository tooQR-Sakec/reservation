<?php
include('../db.php');

$guestName = $_POST['guestName'];
$guestEmail = $_POST['guestEmail'];
$guestCapacity = $_POST['guestCapacity'];
$guestStartTime = $_POST['guestStartTime'];
$guestEndTime = $_POST['guestEndTime'];
$roomID = $_POST['roomID'];

// check Hotel timings

// query to directly get table
$getTableSQL = "SELECT TOP 1 tables.tableID, tables.capacity
	FROM tables
	WHERE (tables.reserved = 0) AND capacity = :guestCapacity
	AND tables.tableID NOT IN (
		SELECT booking.tableID
		FROM booking
		WHERE (NOT (booking.startTime > :guestStartTime)) OR (NOT (booking.endTime < :guestEndTime))
		GROUP BY booking.tableID)";

$getTableSTMT = $conn->prepare($getTableSQL, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
$getTableSTMT->bindParam(':guestStartTime', $guestStartTime);
$getTableSTMT->bindParam(':guestEndTime', $guestEndTime);
$getTableSTMT->bindParam(':guestCapacity', $guestCapacity);
$getTableSTMT->execute();
$rowCount = $getTableSTMT->rowCount();

try {
	// set the PDO error mode to exception
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$conn->beginTransaction();
	if ($rowCount == 1) {
		$tableRow = $getTableSTMT->fetchObject();
		$reservedTables[] = $tableRow->tableID;
	} else {
		// query to get table count
		$getTableCountSQL = "SELECT count(*) AS tableCount, capacity
		FROM tables
		WHERE tableID NOT IN (
			SELECT tableID
			FROM booking
			WHERE (NOT (booking.startTime > :guestStartTime)) OR (NOT (booking.endTime < :guestEndTime))
			GROUP BY tableID
		)
		AND reserved = '0'
		GROUP BY capacity";

		$getTableCountSTMT = $conn->prepare($getTableCountSQL);
		$getTableCountSTMT->bindParam(':guestStartTime', $guestStartTime);
		$getTableCountSTMT->bindParam(':guestEndTime', $guestEndTime);
		$getTableCountSTMT->execute();

		while ($tableRow = $getTableCountSTMT->fetchObject()) {
			$tableCount = $tableRow->tableCount;
			$capacity = $tableRow->capacity;
			$availableSlot[$capacity] = $tableCount;
		}

		// query to get table data
		$getTableDataSQL = "DECLARE @returnCount INT
		SET @returnCount = :requiredCount
		SELECT TOP (@returnCount) tableID, capacity
			FROM tables
			WHERE tables.tableID NOT IN (
				SELECT tableID
				FROM booking
				WHERE (NOT (booking.startTime > :guestStartTime)) OR (NOT (booking.endTime < :guestEndTime))
				GROUP BY tableID
			) AND reserved = 0 AND capacity = :capacity";

		$getTableDataSTMT = $conn->prepare($getTableDataSQL);
		$getTableDataSTMT->bindParam(':guestStartTime', $guestStartTime);
		$getTableDataSTMT->bindParam(':guestEndTime', $guestEndTime);

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