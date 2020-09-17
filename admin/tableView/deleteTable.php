<?php
include('../../db.php');

$tableID = $_POST['tableID'];
echo $tableID;

$deleteSQL = "DELETE FROM tables where tableID = :tableID";
$deleteSTMT = $conn->prepare($deleteSQL);
$deleteSTMT->bindParam(':tableID', $tableID);
$deleteSTMT->execute();