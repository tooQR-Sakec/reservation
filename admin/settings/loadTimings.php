<?php
include('../../db.php');

$loadTimingsSQL = "SELECT * FROM settings";
$loadTimingsSTMT = $conn->prepare($loadTimingsSQL);
$loadTimingsSTMT->execute();

while ($rows = $loadTimingsSTMT->fetchObject()) {
	$parameter = $rows->parameter;
	$data[$parameter] = $rows->value;
}

if (isset($data)) {
	echo json_encode($data, true);
}
