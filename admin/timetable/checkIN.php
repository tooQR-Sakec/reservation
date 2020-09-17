<?php
include('../../db.php');

$guestEmail = $_POST['guestEmail'];
$startTime = $_POST['startTime'];
$checkInTime = time();

$checkINSQL = "UPDATE booking SET status ='checked' WHERE guestEmail = :guestEmail AND startTime = :startTime";
$checkINSTMT = $conn->prepare($checkINSQL);
$checkINSTMT->bindParam(':guestEmail', $guestEmail);
$checkINSTMT->bindParam(':startTime', $startTime);
$checkINSTMT->execute();

$getSQL = "SELECT * FROM logs WHERE guestEmail = :guestEmail AND startTime = :startTime";
$getSTMT = $conn->prepare($getSQL);
$getSTMT->bindParam(':guestEmail', $guestEmail);
$getSTMT->bindParam(':startTime', $startTime);
$getSTMT->execute();

$insertLogSQL = "INSERT INTO logs (tableID, guestName, guestEmail, numberOfPeople, roomID, startTime, endTime, status) VALUES (:tableID, :name, :email, :numberOfPeople, :roomID, :checkInTime, NULL, 'checked')";
$insertLogSTMT = $conn->prepare($insertLogSQL);

while ($row = $getSTMT->fetchObject()) {
	$tableID = $row->tableID;
	$guestName = $row->guestName;
	$numberOfPeople = $row->numberOfPeople;
	$roomID = $row->roomID;

	$insertLogSTMT->bindParam(':tableID', $tableID);
	$insertLogSTMT->bindParam(':name', $guestName);
	$insertLogSTMT->bindParam(':email', $guestEmail);
	$insertLogSTMT->bindParam(':numberOfPeople', $numberOfPeople);
	$insertLogSTMT->bindParam(':roomID', $roomID);
	$insertLogSTMT->bindParam(':checkInTime', $checkInTime);
	$insertLogSTMT->execute();
}
