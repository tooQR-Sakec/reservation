<?php
include('../../db.php');

$guestEmail = $_POST['guestEmail'];
$startTime = $_POST['startTime'];
$endTime = time();

$checkOUTSQL = "UPDATE logs SET endTime = :endTime WHERE guestEmail = :guestEmail AND status = 'checked'";
$checkOUTSTMT = $conn->prepare($checkOUTSQL);
$checkOUTSTMT->bindParam(':guestEmail', $guestEmail);
$checkOUTSTMT->bindParam(':endTime', $endTime);
$checkOUTSTMT->execute();

$deleteSQL = "DELETE FROM  booking WHERE guestEmail = :guestEmail AND startTime = :startTime";
$deleteSTMT = $conn->prepare($deleteSQL);
$deleteSTMT->bindParam(':guestEmail', $guestEmail);
$deleteSTMT->bindParam(':startTime', $startTime);
$deleteSTMT->execute();