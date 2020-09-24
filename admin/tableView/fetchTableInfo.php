<?php
include('../../db.php');

$tableID = $_POST['tableID'];

$tableInfoSQL = "SELECT * FROM tables WHERE tableID = :tableID";
$tableInfoSTMT = $conn->prepare($tableInfoSQL);
$tableInfoSTMT->bindParam(':tableID', $tableID);
$tableInfoSTMT->execute();
$tableInfoRow = $tableInfoSTMT->fetchObject();

$data['capacity'] = $tableInfoRow->capacity;
$data['blocked'] = $tableInfoRow->blocked;
echo json_encode($data);