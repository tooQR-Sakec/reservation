<?php
include('../db.php');

$tableID = $_POST['tableID'];

$capacitySQL = "SELECT capacity FROM tables WHERE tableID = :tableID";
$capacitySTMT = $conn->prepare($capacitySQL);
$capacitySTMT->bindParam(':tableID', $tableID);
$capacitySTMT->execute();
$capacityRow = $capacitySTMT->fetchObject();

$capacity = $capacityRow->capacity;
echo $capacity;