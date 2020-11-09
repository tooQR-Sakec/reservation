<?php
include('../../db.php');

$breakfast = $_POST['breakfast'];
$breakfastSQL = "UPDATE settings SET value = :breakfast WHERE parameter = 'breakfast'";
$breakfastSTMT = $conn->prepare($breakfastSQL);
$breakfastSTMT->bindParam(':breakfast', $breakfast);
$breakfastSTMT->execute();

$lunch = $_POST['lunch'];
$lunchSQL = "UPDATE settings SET value = :lunch WHERE parameter = 'lunch'";
$lunchSTMT = $conn->prepare($lunchSQL);
$lunchSTMT->bindParam(':lunch', $lunch);
$lunchSTMT->execute();

$dinner = $_POST['dinner'];
$dinnerSQL = "UPDATE settings SET value = :dinner WHERE parameter = 'dinner'";
$dinnerSTMT = $conn->prepare($dinnerSQL);
$dinnerSTMT->bindParam(':dinner', $dinner);
$dinnerSTMT->execute();
