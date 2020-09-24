<?php
include('../../db.php');

$bookingID = $_POST['bookingID'];
$checkInTime = time();

$checkInReservedSQL = "UPDATE reserved SET status = 'checkedIn', startTime = :checkInTime WHERE bookingID = :bookingID";
$checkInReservedSTMT = $conn->prepare($checkInReservedSQL);
$checkInReservedSTMT->bindParam(':bookingID', $bookingID);
$checkInReservedSTMT->bindParam(':checkInTime', $checkInTime);
$checkInReservedSTMT->execute();

$checkInBookingSQL = "UPDATE booking SET status = 'checked' WHERE bookingID = :bookingID";
$checkInBookingSTMT = $conn->prepare($checkInBookingSQL);
$checkInBookingSTMT->bindParam(':bookingID', $bookingID);
$checkInBookingSTMT->execute();