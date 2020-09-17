<?php
include('../../db.php');

$fetchTableSQL = "SELECT * FROM tables";
$fetchTableSTMT = $conn->prepare($fetchTableSQL);
$fetchTableSTMT->execute();

while($tableRow = $fetchTableSTMT->fetchObject()) {
	$tableID = $tableRow->tableID;
	$capacity = $tableRow->capacity;
	$tableInfo['tableID'] = $tableID;
	$tableInfo['capacity'] = $capacity;
	$data[] = $tableInfo;
}

echo json_encode($data);