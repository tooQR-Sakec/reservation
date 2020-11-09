<?php
include('../../db.php');

$bufferTime = $_POST['bufferTime'];

$bufferTimeSQL = "UPDATE settings SET value = :buffer WHERE parameter = 'bufferTime'";
$bufferTimeSTMT = $conn->prepare($bufferTimeSQL);
$bufferTimeSTMT->bindParam(':buffer', $bufferTime);
$bufferTimeSTMT->execute();
