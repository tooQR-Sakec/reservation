<?php
include('../db.php');
include('../reserve.php');

$guestName = $_POST['guestName'];
$guestMobile = $_POST['guestMobile'];
$guestCapacity = $_POST['guestCapacity'];
$guestStartTime = $_POST['guestStartTime'];
$guestFoodType = $_POST['guestFoodType'];
$roomID = $_POST['roomID'];

// calculate duration of reservation
switch ($guestFoodType) {
	case 1:
		$foodType = "breakfast";
		break;
	case 2:
		$foodType = "lunch";
		break;
	case 3:
		$foodType = "dinner";
		break;
}
$foodTypeSQL = "SELECT value FROM settings WHERE parameter = :foodType";
$foodTypeSTMT = $conn->prepare($foodTypeSQL);
$foodTypeSTMT->bindParam(':foodType', $foodType);
$foodTypeSTMT->execute();
$duration = $foodTypeSTMT->fetchObject()->value;
$guestEndTime  = $guestStartTime + $duration;

reserveTable($conn, $guestName, $guestMobile, $guestCapacity, $guestStartTime, $guestEndTime, $roomID);