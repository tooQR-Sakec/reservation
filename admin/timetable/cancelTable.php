<?php
include('../../db.php');

$bookingID = $_POST['bookingID'];

$cancelReservedSQL = "UPDATE reserved SET status = 'cancelled' WHERE bookingID = :bookingID";
$cancelReservedSTMT = $conn->prepare($cancelReservedSQL);
$cancelReservedSTMT->bindParam(':bookingID', $bookingID);
$cancelReservedSTMT->execute();

$cancelBookingSQL = "UPDATE booking SET status = 'cancelled' WHERE bookingID = :bookingID";
$cancelBookingSTMT = $conn->prepare($cancelBookingSQL);
$cancelBookingSTMT->bindParam(':bookingID', $bookingID);
$cancelBookingSTMT->execute();