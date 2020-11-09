<?php
include('../../db.php');

$timingsSQL = "UPDATE settings SET value = :value WHERE parameter = :parameter";
$timingsSTMT = $conn->prepare($timingsSQL);

$sundayStartTime = $_POST['sundayStartTime'];
$sundayStart = "sundayStart";
$timingsSTMT->bindParam(':value', $sundayStartTime);
$timingsSTMT->bindParam(':parameter', $sundayStart);
$timingsSTMT->execute();

$sundayEndTime = $_POST['sundayEndTime'];
$sundayEnd = "sundayEnd";
$timingsSTMT->bindParam(':value', $sundayEndTime);
$timingsSTMT->bindParam(':parameter', $sundayEnd);
$timingsSTMT->execute();

$mondayStartTime = $_POST['mondayStartTime'];
$sundayStart = "mondayStart";
$timingsSTMT->bindParam(':value', $mondayStartTime);
$timingsSTMT->bindParam(':parameter', $sundayStart);
$timingsSTMT->execute();

$mondayEndTime = $_POST['mondayEndTime'];
$mondayEnd = "mondayEnd";
$timingsSTMT->bindParam(':value', $mondayEndTime);
$timingsSTMT->bindParam(':parameter', $mondayEnd);
$timingsSTMT->execute();

$tuesdayStartTime = $_POST['tuesdayStartTime'];
$tuesdayStart = "tuesdayStart";
$timingsSTMT->bindParam(':value', $tuesdayStartTime);
$timingsSTMT->bindParam(':parameter', $tuesdayStart);
$timingsSTMT->execute();

$tuesdayEndTime = $_POST['tuesdayEndTime'];
$tuesdayEnd = "tuesdayEnd";
$timingsSTMT->bindParam(':value', $tuesdayEndTime);
$timingsSTMT->bindParam(':parameter', $tuesdayEnd);
$timingsSTMT->execute();

$wednesdayStartTime = $_POST['wednesdayStartTime'];
$wednesdayStart = "wednesdayStart";
$timingsSTMT->bindParam(':value', $wednesdayStartTime);
$timingsSTMT->bindParam(':parameter', $wednesdayStart);
$timingsSTMT->execute();

$wednesdayEndTime = $_POST['wednesdayEndTime'];
$wednesdayEnd = "wednesdayEnd";
$timingsSTMT->bindParam(':value', $wednesdayEndTime);
$timingsSTMT->bindParam(':parameter', $wednesdayEnd);
$timingsSTMT->execute();

$thursdayStartTime = $_POST['thursdayStartTime'];
$sundayStart = "thursdayStart";
$timingsSTMT->bindParam(':value', $thursdayStartTime);
$timingsSTMT->bindParam(':parameter', $sundayStart);
$timingsSTMT->execute();

$thursdayEndTime = $_POST['thursdayEndTime'];
$thursdayEnd = "thursdayEnd";
$timingsSTMT->bindParam(':value', $thursdayEndTime);
$timingsSTMT->bindParam(':parameter', $thursdayEnd);
$timingsSTMT->execute();

$fridayStartTime = $_POST['fridayStartTime'];
$fridayStart = "fridayStart";
$timingsSTMT->bindParam(':value', $fridayStartTime);
$timingsSTMT->bindParam(':parameter', $fridayStart);
$timingsSTMT->execute();

$fridayEndTime = $_POST['fridayEndTime'];
$fridayEnd = "fridayEnd";
$timingsSTMT->bindParam(':value', $fridayEndTime);
$timingsSTMT->bindParam(':parameter', $fridayEnd);
$timingsSTMT->execute();

$saturdayStartTime = $_POST['saturdayStartTime'];
$saturdayStart = "saturdayStart";
$timingsSTMT->bindParam(':value', $saturdayStartTime);
$timingsSTMT->bindParam(':parameter', $saturdayStart);
$timingsSTMT->execute();

$saturdayEndTime = $_POST['saturdayEndTime'];
$saturdayEnd = "saturdayEnd";
$timingsSTMT->bindParam(':value', $saturdayEndTime);
$timingsSTMT->bindParam(':parameter', $saturdayEnd);
$timingsSTMT->execute();
