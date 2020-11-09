<?php
include('../../db.php');

$bLimitDay = $_POST['bLimitDay'];

$bLimitDSQL = "UPDATE settings SET value = :bLimitDay WHERE parameter = 'bookingPerDay'";
$bLimitDSTMT = $conn->prepare($bLimitDSQL);
$bLimitDSTMT->bindParam(':bLimitDay', $bLimitDay);
$bLimitDSTMT->execute();
