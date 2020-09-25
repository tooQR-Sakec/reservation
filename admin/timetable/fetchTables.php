<?php
include('../../db.php');

$dayStart = $_POST['date'];
$dayEnd = $dayStart + 86399;

$fetchTableSQL = "SELECT * FROM tables";
$fetchTableSTMT = $conn->prepare($fetchTableSQL);
$fetchTableSTMT->execute();

$statusSQL = "SELECT *, reserved.startTime, reserved.endTime, reserved.status FROM reserved INNER JOIN booking
	ON reserved.bookingID = booking.bookingID
	WHERE tableID = :tableID AND reserved.status != 'cancelled'
	AND (reserved.startTime BETWEEN :startTime AND :endTime)";
$getStatusSTMT = $conn->prepare($statusSQL, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
$getStatusSTMT->bindParam(':startTime', $dayStart);
$getStatusSTMT->bindParam(':endTime', $dayEnd);

while($tableRow = $fetchTableSTMT->fetchObject()) {
	$tableID = $tableRow->tableID;
	$getStatusSTMT->bindParam(':tableID', $tableID);
	$getStatusSTMT->execute();
	$data["allTables"][] = $tableID;

	while($statusRow = $getStatusSTMT->fetchObject()) {
		$table['tableID'] = $tableID;
		$table['bookingID'] = $statusRow->bookingID;
		$table['guestName'] = $statusRow->guestName;
		$table['guestMobile'] = $statusRow->guestMobile;
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