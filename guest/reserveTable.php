<?php
include('../db.php');

$guestName = $_POST['guestName'];
$guestEmail = $_POST['guestEmail'];
$guestCapacity = $_POST['guestCapacity'];
$guestDate = $_POST['guestDate'];
$guestSlot = $_POST['guestSlot'];
$roomID = $_POST['roomID'];

// query to directly get table
$getTableSQL = "SELECT tableID, capacity
	FROM tables
	WHERE tables.tableID NOT IN (
		SELECT tableID
		FROM booking
		WHERE slot = :slot AND date = :guestDate
		GROUP BY tableID
	) AND reserved = 0 AND capacity = :guestCapacity
	LIMIT 1";

$getTableSTMT = $conn->prepare($getTableSQL);
$getTableSTMT->bindParam(':slot', $guestSlot);
$getTableSTMT->bindParam(':guestDate', $guestDate);
$getTableSTMT->bindParam(':guestCapacity', $guestCapacity);
$getTableSTMT->execute();
$rowCount = $getTableSTMT->rowCount();
if ($rowCount == 1) {
	$tableRow = $getTableSTMT->fetchObject();
	echo $tableRow->tableID;
} else {
	// query to get table count
	$getTableCountSQL = "SELECT count(*) AS tableCount, capacity
		FROM tables
		WHERE tableID NOT IN (
			SELECT tableID
			FROM booking
			WHERE slot = :slot AND date = :guestDate
			GROUP BY tableID
		)
		AND reserved = '0'
		GROUP BY capacity";

	$getTableCountSTMT = $conn->prepare($getTableCountSQL);
	$getTableCountSTMT->bindParam(':slot', $guestSlot);
	$getTableCountSTMT->bindParam(':guestDate', $guestDate);
	$getTableCountSTMT->execute();

	while ($tableRow = $getTableCountSTMT->fetchObject()) {
		$tableCount = $tableRow->tableCount;
		$capacity = $tableRow->capacity;
		$availableSlot[$capacity] = $tableCount;
	}

	// query to get table data
	$getTableDataSQL = "SELECT tableID, capacity
		FROM tables
		WHERE tables.tableID NOT IN (
			SELECT tableID
			FROM booking
			WHERE slot = :slot AND date = :guestDate
			GROUP BY tableID
		) AND reserved = 0 AND capacity = :capacity
		LIMIT :requiredCount";

	$getTableDataSTMT = $conn->prepare($getTableDataSQL);
	$getTableDataSTMT->bindParam(':slot', $guestSlot);
	$getTableDataSTMT->bindParam(':guestDate', $guestDate);

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
	$data["capacity"] = $guestCapacity;
	$data["table"] = $availableTables;
	print_r($availableTables);
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
	$availableTables = json_decode($result, true);

	$reserveTableSQL = "INSERT INTO booking (tableID, slot, guestName, guestEmail, date, numberOfPeople, roomID) VALUES (:tableID, :slot, :name, :email, :date, :numberOfPeople, :roomID)";
	$reserveTableSTMT = $conn->prepare($reserveTableSQL);
	$reserveTableSTMT->bindParam(':slot', $guestSlot);
	$reserveTableSTMT->bindParam(':name', $guestName);
	$reserveTableSTMT->bindParam(':email', $guestEmail);
	$reserveTableSTMT->bindParam(':date', $guestDate);
	$reserveTableSTMT->bindParam(':numberOfPeople', $guestCapacity);
	$reserveTableSTMT->bindParam(':roomID', $roomID);

	foreach ($availableTables as $tableID) {
		echo $tableID;
		$reserveTableSTMT->bindParam(':tableID', $tableID);
		$reserveTableSTMT->execute();
	}
}
