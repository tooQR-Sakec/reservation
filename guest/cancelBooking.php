<?php
include('../db.php');

$bookingID = $_POST['bookingID'];

$updateBookingSQL="UPDATE booking SET status='cancelled' WHERE bookingID = :bookingID";
$updateBookingSTMT = $conn->prepare($updateBookingSQL);
$updateBookingSTMT->bindParam(':bookingID', $bookingID);
$updateBookingSTMT->execute();

$updateReservedSQL = "UPDATE reserved SET status='cancelled' WHERE bookingID = :bookingID";
$updateReservedSTMT = $conn->prepare($updateReservedSQL);
$updateReservedSTMT->bindParam(':bookingID', $bookingID);
$updateReservedSTMT->execute();

