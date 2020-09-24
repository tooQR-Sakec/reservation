<?php
include('../../db.php');

$tableID = $_POST['tableID'];
$capacity = $_POST['capacity'];
$blocked = $_POST['blocked'];

$editSQL = "UPDATE tables SET capacity = :capacity, blocked = :blocked WHERE tableID = :tableID";
$editSTMT = $conn->prepare($editSQL);
$editSTMT->bindParam(':tableID', $tableID);
$editSTMT->bindParam(':capacity', $capacity);
$editSTMT->bindParam(':blocked', $blocked);
$editSTMT->execute();