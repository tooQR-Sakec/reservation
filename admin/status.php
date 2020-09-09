<?php
include('../db.php');

$tableID = $_POST['tableID'];
$slot = $_POST['slot'];

$statusSQL = "SELECT * FROM booking WHERE tableID = :tableID AND slot = :slot";
$getStatusSTMT = $conn->prepare($statusSQL);
$getStatusSTMT->bindParam(':tableID', $tableID);
$getStatusSTMT->bindParam(':slot', $slot);
$getStatusSTMT->execute();
$statusRow = $getStatusSTMT->fetchObject();

$guestEmail = "none";
if(isset($statusRow->guestEmail))
	$guestEmail = $statusRow->guestEmail;
echo $guestEmail;