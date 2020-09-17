<?php
include('../../db.php');

$guestEmail = $_POST['guestEmail'];
$startTime = $_POST['startTime'];

$cancelSQL = "DELETE FROM booking WHERE guestEmail = :guestEmail AND startTime = :startTime";
$cancelSTMT = $conn->prepare($cancelSQL);
$cancelSTMT->bindParam(':guestEmail', $guestEmail);
$cancelSTMT->bindParam(':startTime', $startTime);
$cancelSTMT->execute();

$cancelLogSQL = "UPDATE logs SET status = 'cancelled' WHERE guestEmail = :guestEmail AND startTime = :startTime";
$cancelLogSTMT = $conn->prepare($cancelLogSQL);
$cancelLogSTMT->bindParam(':guestEmail', $guestEmail);
$cancelLogSTMT->bindParam(':startTime', $startTime);
$cancelLogSTMT->execute();