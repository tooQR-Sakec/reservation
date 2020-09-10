<?php
include('../db.php');

$tableID = $_POST['tableID'];
$slot = $_POST['slot'];
$date = $_POST['date'];

$statusSQL = "SELECT * FROM booking WHERE tableID = :tableID AND slot = :slot AND date = :date";
$getStatusSTMT = $conn->prepare($statusSQL);
$getStatusSTMT->bindParam(':tableID', $tableID);
$getStatusSTMT->bindParam(':slot', $slot);
$getStatusSTMT->bindParam(':date', $date);
$getStatusSTMT->execute();
$statusRow = $getStatusSTMT->fetchObject();

if(isset($statusRow->guestEmail)) {
	$data['guestName'] = $statusRow->guestName;
	$data['guestEmail'] = $statusRow->guestEmail;
	$data['date'] = $statusRow->date;
	$data['numberOfPeople'] = $statusRow->numberOfPeople;
	$data['roomID'] = $statusRow->roomID;
	echo json_encode($data);
} else {
	echo "none";
}