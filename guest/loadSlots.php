<?php
include('../db.php');

$loadSlotsSQL = "SELECT * FROM timetable";
$loadSlotsSTMT = $conn->prepare($loadSlotsSQL);
$loadSlotsSTMT->execute();

while($loadSlotsRow = $loadSlotsSTMT->fetchObject()) {
	$slots['slot'] = $loadSlotsRow->slot;
	$slots['time'] = $loadSlotsRow->time;
	$data[] = $slots;
}

echo json_encode($data);