<?php
include('../../db.php');

$bookingID = $_POST['bookingID'];
$extendBuffer = 1800;

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

	$checkTableSQL = "DECLARE @startTime BIGINT = :startTime,
		@endTime BIGINT = :endTime;
		SELECT CASE
			WHEN EXISTS(
				SELECT * FROM reserved
				WHERE tableID = :tableID
				AND bookingID != :bookingID
				AND (status = 'reserved' OR status = 'checkedIn')
				AND ((reserved.startTime < @endTime AND @endTime < reserved.endTime)
					OR @startTime < reserved.endTime AND reserved.endTime < @endTime))
			THEN 0 ELSE 1 END AS BIT, bookingID
			FROM reserved";

	$checkTableSTMT = $conn->prepare($checkTableSQL);
	$checkTableSTMT->bindParam(':tableID', $tableID);
	$checkTableSTMT->bindParam(':bookingID', $bookingID);
	$checkTableSTMT->bindParam(':startTime', $startTime);
	$checkTableSTMT->bindParam(':endTime', $newEndTime);
	$checkTableSTMT->execute();
	print_r($checkTableSTMT->fetchObject());
	exit;
	if(!$checkTableSTMT->fetchObject()->BIT) {
		$extendOK = 0;
	};
}

if($extendOK) {
	$extendSQL = "UPDATE reserved SET endTime = :endTime WHERE bookingID = :bookingID";
	$extendSTMT = $conn->prepare($extendSQL);
	$extendSTMT->bindParam(':endTime', $newEndTime);
	$extendSTMT->bindParam(':bookingID', $bookingID);
	$extendSTMT->execute();
} else {
	/*
	check booking conflict and soft delete all the reservations
	for every booking conflict, try to re-book in other tables by calling reserve.php
	if all bookings are successful then extend current booking
	else show error
	*/
	"Can't Extend!"; 
}


