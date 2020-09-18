<?php
include('../../db.php');

$hotelStartTime=$_POST['hotelStartTime'];
$startTimeParam = "startTime";
$hotelEndTime=$_POST['hotelEndTime'];
$endTimeParam = "endTime";

$timeSQL="UPDATE settings SET value = :value WHERE parameter = :parameter";
$timeSTMT=$conn->prepare($timeSQL);

$timeSTMT->bindParam(':parameter', $startTimeParam);
$timeSTMT->bindParam(':value', $hotelStartTime);
$timeSTMT->execute();

$timeSTMT->bindParam(':parameter', $endTimeParam);
$timeSTMT->bindParam(':value', $hotelEndTime);
$timeSTMT->execute();