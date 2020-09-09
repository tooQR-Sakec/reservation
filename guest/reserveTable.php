<?php
include('../db.php');

$guestName = $_POST['guestName'];
$guestEmail = $_POST['guestEmail'];
$guestCapacity = $_POST['guestCapacity'];
$guestDate = $_POST['guestDate'];
$guestSlot = $_POST['guestSlot'];

$getTableSQL = "SELECT booking.tableID, capacity FROM booking inner join tables on booking.tableID = tables.tableID GROUP BY tableID HAVING COUNT(CASE WHEN slot = :slot THEN 1 END) = 0";
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
/* data{
	capacity: guest capacity,
	table: {
		1: capacity,
		2: capacity,
	}
} */
// to python api
//print_r($data);
//output python
// suppose table 4 and 5
//$fromPython = "[5,6]";
$availableTables = json_decode($fromPython);

if(!$availableTables) { // if table not available
	echo "full";
	exit;
}

$reserveTableSQL = "INSERT INTO booking (tableID, slot, guestEmail) VALUES (:tableID, :slot, :email)";
$reserveTableSTMT = $conn->prepare($reserveTableSQL);
$reserveTableSTMT->bindParam(':slot', $guestSlot);
$reserveTableSTMT->bindParam(':email', $guestEmail);

foreach($availableTables as $tableID) {
	$reserveTableSTMT->bindParam(':tableID', $tableID);
	$reserveTableSTMT->execute();
}