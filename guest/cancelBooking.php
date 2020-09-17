<?php
include('../db.php');

$startTime = $_POST['startTime'];
$guestEmail = $_POST['guestEmail'];

$updateSQL="UPDATE logs SET status='Cancelled' WHERE startTime = :startTime AND guestEmail = :guestEmail";
$updateSTMT = $conn->prepare($updateSQL);
$updateSTMT->bindParam(':startTime', $startTime);
$updateSTMT->bindParam(':guestEmail', $guestEmail);
$updateSTMT->execute();

$cancelSQL = "DELETE FROM booking WHERE startTime = :startTime AND guestEmail = :guestEmail";
$cancelSTMT = $conn->prepare($cancelSQL);
$cancelSTMT->bindParam(':startTime', $startTime);
$cancelSTMT->bindParam(':guestEmail', $guestEmail);
$cancelSTMT->execute();

