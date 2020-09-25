<?php
include('../../db.php');

$sundayStartTime=$_POST['sundayStartTime'];
$sundaySSQL="UPDATE settings SET value = :sundayStartTime WHERE parameter = 'sundayStart'";
$sundaySSTMT=$conn->prepare($sundaySSQL);
$sundaySSTMT->bindParam(':sundayStartTime', $sundayStartTime);
$sundaySSTMT->execute();

$sundayEndTime=$_POST['sundayEndTime'];
$sundayESQL="UPDATE settings SET value = :sundayEndTime WHERE parameter = 'sundayEnd'";
$sundayESTMT=$conn->prepare($sundayESQL);
$sundayESTMT->bindParam(':sundayEndTime', $sundayEndTime);
$sundayESTMT->execute();

$mondayStartTime=$_POST['mondayStartTime'];
$mondaySSQL="UPDATE settings SET value = :mondayStartTime WHERE parameter = 'mondayStart'";
$mondaySSTMT=$conn->prepare($mondaySSQL);
$mondaySSTMT->bindParam(':mondayStartTime', $mondayStartTime);
$mondaySSTMT->execute();

$mondayEndTime=$_POST['mondayEndTime'];
$mondayESQL="UPDATE settings SET value = :mondayEndTime WHERE parameter = 'mondayEnd'";
$mondayESTMT=$conn->prepare($mondayESQL);
$mondayESTMT->bindParam(':mondayEndTime', $mondayEndTime);
$mondayESTMT->execute();

$tuesdayStartTime=$_POST['tuesdayStartTime'];
$tuesdaySSQL="UPDATE settings SET value = :tuesdayStartTime WHERE parameter = 'tuesdayStart'";
$tuesdaySSTMT=$conn->prepare($tuesdaySSQL);
$tuesdaySSTMT->bindParam(':tuesdayStartTime', $tuesdayStartTime);
$tuesdaySSTMT->execute();

$tuesdayEndTime=$_POST['tuesdayEndTime'];
$tuesdayESQL="UPDATE settings SET value = :tuesdayEndTime WHERE parameter = 'tuesdayEnd'";
$tuesdayESTMT=$conn->prepare($tuesdayESQL);
$tuesdayESTMT->bindParam(':tuesdayEndTime', $tuesdayEndTime);
$tuesdayESTMT->execute();

$wednesdayStartTime=$_POST['wednesdayStartTime'];
$wednesdaySSQL="UPDATE settings SET value = :wednesdayStartTime WHERE parameter = 'wednesdayStart'";
$wednesdaySSTMT=$conn->prepare($wednesdaySSQL);
$wednesdaySSTMT->bindParam(':wednesdayStartTime', $wednesdayStartTime);
$wednesdaySSTMT->execute();

$wednesdayEndTime=$_POST['wednesdayEndTime'];
$wednesdayESQL="UPDATE settings SET value = :wednesdayEndTime WHERE parameter = 'wednesdayEnd'";
$wednesdayESTMT=$conn->prepare($wednesdayESQL);
$wednesdayESTMT->bindParam(':wednesdayEndTime', $wednesdayEndTime);
$wednesdayESTMT->execute();

$thursdayStartTime=$_POST['thursdayStartTime'];
$thursdaySSQL="UPDATE settings SET value = :thursdayStartTime WHERE parameter = 'thursdayStart'";
$thursdaySSTMT=$conn->prepare($thursdaySSQL);
$thursdaySSTMT->bindParam(':thursdayStartTime', $thursdayStartTime);
$thursdaySSTMT->execute();

$thursdayEndTime=$_POST['thursdayEndTime'];
$thursdayESQL="UPDATE settings SET value = :thursdayEndTime WHERE parameter = 'thursdayEnd'";
$thursdayESTMT=$conn->prepare($thursdayESQL);
$thursdayESTMT->bindParam(':thursdayEndTime', $thursdayEndTime);
$thursdayESTMT->execute();

$fridayStartTime=$_POST['fridayStartTime'];
$fridaySSQL="UPDATE settings SET value = :fridayStartTime WHERE parameter = 'fridayStart'";
$fridaySSTMT=$conn->prepare($fridaySSQL);
$fridaySSTMT->bindParam(':fridayStartTime', $fridayStartTime);
$fridaySSTMT->execute();

$fridayEndTime=$_POST['fridayEndTime'];
$fridayESQL="UPDATE settings SET value = :fridayEndTime WHERE parameter = 'fridayEnd'";
$fridayESTMT=$conn->prepare($fridayESQL);
$fridayESTMT->bindParam(':fridayEndTime', $fridayEndTime);
$fridayESTMT->execute();

$saturdayStartTime=$_POST['saturdayStartTime'];
$saturdaySSQL="UPDATE settings SET value = :saturdayStartTime WHERE parameter = 'saturdayStart'";
$saturdaySSTMT=$conn->prepare($saturdaySSQL);
$saturdaySSTMT->bindParam(':saturdayStartTime', $saturdayStartTime);
$saturdaySSTMT->execute();

$saturdayEndTime=$_POST['saturdayEndTime'];
$saturdayESQL="UPDATE settings SET value = :saturdayEndTime WHERE parameter = 'saturdayEnd'";
$saturdayESTMT=$conn->prepare($saturdayESQL);
$saturdayESTMT->bindParam(':saturdayEndTime', $saturdayEndTime);
$saturdayESTMT->execute();



