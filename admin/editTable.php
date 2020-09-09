<?php
include('../db.php');

$tableID = $_POST['tableID'];
$capacity = $_POST['capacity'];

echo $tableID;

$editSQL = "UPDATE tables SET capacity = :capacity WHERE tableID = :tableID";
$editSTMT = $conn->prepare($editSQL);
$editSTMT->bindParam(':tableID', $tableID);
$editSTMT->bindParam(':capacity', $capacity);
$editSTMT->execute();