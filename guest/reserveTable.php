<?php
include('../db.php');

$guestName = $_POST['guestName'];
$guestEmail = $_POST['guestEmail'];
$guestCapacity = $_POST['guestCapacity'];
$guestDate = $_POST['guestDate'];
$guestSlot = $_POST['guestSlot'];
$roomID = $_POST['roomID'];

$getTableSQL = "SELECT booking.tableID, capacity
	FROM booking inner join tables on booking.tableID = tables.tableID
	WHERE reserved = 0
	GROUP BY tableID
	HAVING COUNT(CASE WHEN slot = :slot THEN 1 END) = 0";
$getTableSTMT = $conn->prepare($getTableSQL);
$getTableSTMT->bindParam(':slot', $guestSlot);
$getTableSTMT->execute();

while ($tableRow = $getTableSTMT->fetchObject()) {
	$tableID = $tableRow->tableID;
	$capacity = $tableRow->capacity;
	$availableSlot[$tableID] = $capacity;
}
$data["capacity"] = $guestCapacity;
$data["table"] = $availableSlot;
$data = json_encode($data);

$ch = curl_init('localhost:5000');
# Setup request to send json via POST.
curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
# Return response instead of printing.
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
# Send request.
$result = curl_exec($ch);
curl_close($ch);

if($result == "False") { // if table not available
	echo "full";
	exit;
}
$availableTables = json_decode($result, true);

$reserveTableSQL = "INSERT INTO booking (tableID, slot, guestName, guestEmail, date, numberOfPeople, roomID) VALUES (:tableID, :slot, :name, :email, :date, :numberOfPeople, :roomID)";
$reserveTableSTMT = $conn->prepare($reserveTableSQL);
$reserveTableSTMT->bindParam(':slot', $guestSlot);
$reserveTableSTMT->bindParam(':name', $guestName);
$reserveTableSTMT->bindParam(':email', $guestEmail);
$reserveTableSTMT->bindParam(':date', $guestDate);
$reserveTableSTMT->bindParam(':numberOfPeople', $guestCapacity);
$reserveTableSTMT->bindParam(':roomID', $roomID);

foreach($availableTables as $tableID) {
	echo $tableID;
	$reserveTableSTMT->bindParam(':tableID', $tableID);
	$reserveTableSTMT->execute();
}