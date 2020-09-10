<?php
include('../db.php');

$slot = $_POST['slot'];
$date = $_POST['date'];
$guestEmail = $_POST['guestEmail'];

$cancelSQL = "DELETE FROM booking WHERE slot = :slot AND guestEmail = :guestEmail AND date = :date";
$cancelSTMT = $conn->prepare($cancelSQL);
$cancelSTMT->bindParam(':slot', $slot);
$cancelSTMT->bindParam(':date', $date);
$cancelSTMT->bindParam(':guestEmail', $guestEmail);
$cancelSTMT->execute();