<?php
include('../db.php');

$tableID = $_POST['tableID'];
$capacity = $_POST['capacity'];
$reserved = $_POST['reserved'];

$editSQL = "UPDATE tables SET capacity = :capacity, reserved = :reserved WHERE tableID = :tableID";
$editSTMT = $conn->prepare($editSQL);
$editSTMT->bindParam(':tableID', $tableID);
$editSTMT->bindParam(':capacity', $capacity);
$editSTMT->bindParam(':reserved', $reserved);
$editSTMT->execute();