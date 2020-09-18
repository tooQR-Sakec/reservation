<?php
include('../../db.php');

$hotelStartTime=$_POST['hotelStartTime'];
$hotelEndTime=$_POST['hotelEndTime'];

$timeSQL="UPDATE settings SET value = :hotelStartTime WHERE parameter = 'startTime'";
$timeSTMT=$conn->prepare($timeSQL);
$timeSTMT->bindParam(':hotelStartTime',$hotelStartTime);
$timeSTMT->execute();

$closeTimeSQL="UPDATE settings SET value = :hotelEndTime WHERE parameter = 'endTime'";
$closeTimeSTMT=$conn->prepare($closeTimeSQL);
$closeTimeSTMT->bindParam(':hotelEndTime',$hotelEndTime);
$closeTimeSTMT->execute();