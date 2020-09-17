<?php
include('../db.php');

$statusName = $_POST['statusName'];
$statusEmail = $_POST['statusEmail'];

$getStatusSQL = "SELECT * FROM booking
	WHERE tableID in (
		SELECT min(tableID) FROM booking
		WHERE guestEmail = :guestEmail
		GROUP BY startTime)";
$getStatusSTMT = $conn->prepare($getStatusSQL);
$getStatusSTMT->bindParam(':guestEmail', $statusEmail);
$getStatusSTMT->execute();

while($statusRow = $getStatusSTMT->fetchObject()) {
	$booking['guestName'] = $statusRow->guestName;
	$booking['numberOfPeople'] = $statusRow->numberOfPeople;
	$booking['startTime'] = $statusRow->startTime;
	$booking['endTime'] = $statusRow->endTime;
	$booking['roomID'] = $statusRow->roomID;
	$data[] = $booking;
}

if(isset($data)) {
	echo json_encode($data);
} else {
	echo null;
}