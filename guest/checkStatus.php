<?php
include('../db.php');

$statusName = $_POST['statusName'];
$statusEmail = $_POST['statusEmail'];

$getStatusSQL = "SELECT * FROM booking WHERE guestEmail = :guestEmail GROUP BY slot, date";
$getStatusSTMT = $conn->prepare($getStatusSQL);
$getStatusSTMT->bindParam(':guestEmail', $statusEmail);
$getStatusSTMT->execute();

while($statusRow = $getStatusSTMT->fetchObject()) {
	$booking['slot'] = $statusRow->slot;
	$booking['guestName'] = $statusRow->guestName;
	$booking['date'] = $statusRow->date;
	$booking['numberOfPeople'] = $statusRow->numberOfPeople;
	$booking['roomID'] = $statusRow->roomID;
	$data[] = $booking;
}

if(isset($data)) {
	echo json_encode($data);
} else {
	echo null;
}