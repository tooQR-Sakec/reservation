<?php
include('../../db.php');

$bookingID = $_POST['bookingID'];
$checkOutTime = time();

$checkOutReservedSQL = "UPDATE reserved SET status = 'checkedOut', endTime = :checkOutTime WHERE bookingID = :bookingID";
$checkOutReservedSTMT = $conn->prepare($checkOutReservedSQL);
$checkOutReservedSTMT->bindParam(':bookingID', $bookingID);
$checkOutReservedSTMT->bindParam(':checkOutTime', $checkOutTime);
$checkOutReservedSTMT->execute();