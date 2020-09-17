<?php
include('../../db.php');

$dayStart = $_POST['date'];
$dayEnd = $dayStart + 86399;

$fetchTableSQL = "SELECT * FROM tables";
$fetchTableSTMT = $conn->prepare($fetchTableSQL);
$fetchTableSTMT->execute();

$statusSQL = "SELECT * FROM booking WHERE tableID = :tableID AND (startTime BETWEEN :startTime AND :endTime)";
$getStatusSTMT = $conn->prepare($statusSQL);
$getStatusSTMT->bindParam(':startTime', $dayStart);
$getStatusSTMT->bindParam(':endTime', $dayEnd);

while($tableRow = $fetchTableSTMT->fetchObject()) {
	$tableID = $tableRow->tableID;
	$getStatusSTMT->bindParam(':tableID', $tableID);
	$getStatusSTMT->execute();
	$statusRow = $getStatusSTMT->fetchObject();
	$data["allTables"][] = $tableID;

	if(isset($statusRow->guestEmail)) {
		$table['tableID'] = $tableID;
		$table['guestName'] = $statusRow->guestName;
		$table['guestEmail'] = $statusRow->guestEmail;
		$table['numberOfPeople'] = $statusRow->numberOfPeople;
		$table['roomID'] = $statusRow->roomID;
		$table['startTime'] = $statusRow->startTime;
		$table['endTime'] = $statusRow->endTime;
		$table['status'] = $statusRow->status;
		$data["bookedTables"][] = $table;
	}
}
if(isset($data)) {
	echo json_encode($data);
} else {
	echo null;
}