<?php
include('../db.php');

$statusName = $_POST['statusName'];
$statusEmail = $_POST['statusEmail'];

$getStatusSQL = "SELECT * FROM booking WHERE guestEmail = :guestEmail";
$getStatusSTMT = $conn->prepare($getStatusSQL);
$getStatusSTMT->bindParam(':guestEmail', $statusEmail);
$getStatusSTMT->execute();
$statusRow = $getStatusSTMT->fetchObject();

$data['slot'] = $statusRow->slot;
$data['guestName'] = $statusRow->guestName;
$data['date'] = $statusRow->date;
$data['numberOfPeople'] = $statusRow->numberOfPeople;
echo json_encode($data);