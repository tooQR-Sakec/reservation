<?php
include('../db.php');

$statusName = $_POST['statusName'];
$statusEmail = $_POST['statusEmail'];

$getStatusSQL = "SELECT * FROM booking WHERE status = 'reserved' AND guestEmail = :guestEmail";
$getStatusSTMT = $conn->prepare($getStatusSQL);
$getStatusSTMT->bindParam(':guestEmail', $statusEmail);
$getStatusSTMT->execute();

while($statusRow = $getStatusSTMT->fetchObject()) {
	$booking['bookingID'] = $statusRow->bookingID;
	$booking['guestName'] = $statusRow->guestName;
	$booking['numberOfPeople'] = $statusRow->numberOfPeople;
	$booking['roomID'] = $statusRow->roomID;
	$booking['startTime'] = $statusRow->startTime;
	$booking['endTime'] = $statusRow->endTime;
	$data[] = $booking;
}

if(isset($data)) {
	echo json_encode($data);
} else {
	echo null;
}