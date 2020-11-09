<?php
include('../../db.php');

$bookingID = $_POST['bookingID'];

// get extend duration
$extendDurationSQL = "SELECT * FROM settings WHERE parameter = 'extendDuration'";
$extendDurationSTMT = $conn->prepare($extendDurationSQL);
$extendDurationSTMT->execute();
$extendBuffer = $extendDurationSTMT->fetchObject()->value;

// get timings of currently booked table
$tableInfoSQL = "SELECT * FROM reserved WHERE bookingID = :bookingID";
$tableInfoSTMT = $conn->prepare($tableInfoSQL);
$tableInfoSTMT->bindParam(':bookingID', $bookingID);
$tableInfoSTMT->execute();
$extendOK = 1;
while ($row = $tableInfoSTMT->fetchObject()) {
	$table["tableID"] = $row->tableID;
	$table["startTime"] = $row->startTime;
	$table["endTime"] = $row->endTime;
	$table["newEndTime"] = $table["endTime"] + $extendBuffer;
	$data[] = $table;
}

foreach ($data as $table) {
	$tableID = $table["tableID"];
	$startTime = $table["startTime"];
	$newEndTime = $table["newEndTime"];

	// check if table timings overlap. Bit = 1 for overlap
	$checkTableSQL = "DECLARE @startTime BIGINT = :startTime,
		@endTime BIGINT = :endTime;
		SELECT CASE WHEN EXISTS(
			SELECT * FROM reserved
			WHERE tableID = :tableID
			AND bookingID != :bookingID
			AND (status != 'cancelled' AND status != 'checkedIn')
			AND ((reserved.startTime < @endTime AND @endTime < reserved.endTime)
				OR (@startTime < reserved.endTime AND reserved.endTime < @endTime)))
		THEN 1 ELSE 0 END AS BIT";

	$checkTableSTMT = $conn->prepare($checkTableSQL);
	$checkTableSTMT->bindParam(':tableID', $tableID);
	$checkTableSTMT->bindParam(':bookingID', $bookingID);
	$checkTableSTMT->bindParam(':startTime', $startTime);
	$checkTableSTMT->bindParam(':endTime', $newEndTime);
	$checkTableSTMT->execute();
	if ($checkTableSTMT->fetchObject()->BIT) {
		$extendOK = 0;
	}
}

// extend table timings if no overlap
if ($extendOK) {
	$extendSQL = "UPDATE reserved SET endTime = :endTime WHERE bookingID = :bookingID";
	$extendSTMT = $conn->prepare($extendSQL);
	$extendSTMT->bindParam(':endTime', $newEndTime);
	$extendSTMT->bindParam(':bookingID', $bookingID);
	$extendSTMT->execute();
	echo "Table Timings Extended!";
} else {
	echo "Can't Extend!";
}
