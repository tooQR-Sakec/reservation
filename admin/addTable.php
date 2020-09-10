<?php
include('../db.php');

$tableID = $_POST['tableID'];
$capacity = $_POST['capacity'];

$addSQL = "INSERT INTO tables (tableID, capacity, reserved) VALUES (:tableID, :capacity, '0')";
$addSTMT = $conn->prepare($addSQL);
$addSTMT->bindParam(':tableID', $tableID);
$addSTMT->bindParam(':capacity', $capacity);
$addSTMT->execute();