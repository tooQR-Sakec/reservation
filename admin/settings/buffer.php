<?php
include('../../db.php');

$buffer=$_POST['buffer'];

$bufferTimeSQL="UPDATE settings SET value = :buffer WHERE parameter = 'bufferTime'";
$bufferTimeSTMT=$conn->prepare($bufferTimeSQL);
$bufferTimeSTMT->bindParam(':buffer',$buffer);
$bufferTimeSTMT->execute();
