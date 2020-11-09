<?php
include('../../db.php');

$extendDuration = $_POST['extendDuration'];

$extendDurationSQL = "UPDATE settings SET value = :extendDuration WHERE parameter = 'extendDuration'";
$extendDurationSTMT = $conn->prepare($extendDurationSQL);
$extendDurationSTMT->bindParam(':extendDuration', $extendDuration);
$extendDurationSTMT->execute();
