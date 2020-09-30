<?php
include('../../db.php');

$tableID = $_POST['tableID'];
$capacity = $_POST['capacity'];
$adjacent = $_POST['adjacent'];
$adjacent = json_decode($adjacent, true);
print_r($adjacent);

$addSQL = "INSERT INTO tables (tableID, capacity, blocked) VALUES (:tableID, :capacity, '0')";
$addSTMT = $conn->prepare($addSQL);

$adjTableSQL = "INSERT INTO adjacent (tableA, tableB) VALUES (:tableA, :tableB)";
$adjTableSTMT = $conn->prepare($adjTableSQL);

try {
	// set the PDO error mode to exception
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$conn->beginTransaction();

	$addSTMT->bindParam(':tableID', $tableID);
	$addSTMT->bindParam(':capacity', $capacity);
	$addSTMT->execute();

	foreach($adjacent as $adjTable) {
		$adjTableSTMT->bindParam(':tableA', $tableID);
		$adjTableSTMT->bindParam(':tableB', $adjTable);
		$adjTableSTMT->execute();
		$adjTableSTMT->bindParam(':tableA', $adjTable);
		$adjTableSTMT->bindParam(':tableB', $tableID);
		$adjTableSTMT->execute();
	}
	$conn->commit();
} catch (PDOException $e) {
	$conn->rollBack();
	echo "Failed " . $e->getMessage();
}