<?php

function dayOfTheWeek($startDay) //to determine day of the week
{
	switch ($startDay) {
		case 1:
			$startTimeDay = "monday";
			break;
		case 2:
			$startTimeDay = "tuesday";
			break;
		case 3:
			$startTimeDay = "wednesday";
			break;
		case 4:
			$startTimeDay = "thursday";
			break;
		case 5:
			$startTimeDay = "friday";
			break;
		case 6:
			$startTimeDay = "saturday";
			break;
		case 7:
			$startTimeDay = "sunday";
			break;
	}
	return $startTimeDay;
}

function reserveTable($conn, $guestName, $guestMobile, $guestCapacity, $guestStartTime, $guestEndTime, $roomID)
{
	// buffer timing
	$bufferSQL = "SELECT value FROM settings WHERE parameter = 'bufferTime'";
	$bufferSTMT = $conn->prepare($bufferSQL);
	$bufferSTMT->execute();
	$bufferTime = $bufferSTMT->fetchObject()->value;
	$startTime  = $guestStartTime - $bufferTime;
	$endTime  = $guestEndTime + $bufferTime;

	//start time day
	$startDay = date('N', $guestStartTime);
	$startDayParam = dayOfTheWeek($startDay) . "Start";
	// end time day
	$endDay = date('N', $guestEndTime);
	$endDayParam = dayOfTheWeek($endDay) . "End";

	// check Hotel start timing
	$startTimeSQL = "SELECT value FROM settings WHERE parameter = :startTime";
	$startTimeSTMT = $conn->prepare($startTimeSQL);
	$startTimeSTMT->bindParam(':startTime', $startDayParam);
	$startTimeSTMT->execute();
	$restaurantStart = explode(":", $startTimeSTMT->fetchObject()->value);
	$restaurantStartSeconds = $restaurantStart[0] * 3600 + $restaurantStart[1] * 60;
	$startTimeSeconds = date("H", $startTime) * 3600 + date("i", $startTime) * 60;
	// check Hotel end timing
	$endTimeSQL = "SELECT value FROM settings WHERE parameter = :endTime";
	$endTimeSTMT = $conn->prepare($endTimeSQL);
	$endTimeSTMT->bindParam(':endTime', $endDayParam);
	$endTimeSTMT->execute();
	$restaurantEnd = explode(":", $endTimeSTMT->fetchObject()->value);
	$restaurantEndSeconds = $restaurantEnd[0] * 3600 + $restaurantStart[1] * 60;
	$endTimeSeconds = date("H", $endTime) * 3600 + date("i", $endTime) * 60;
	if ($restaurantStartSeconds > $restaurantEndSeconds) {
		if ($startTimeSeconds < $restaurantEndSeconds) {
			$startTimeSeconds += 86400;
		}
		if ($endTimeSeconds < $restaurantEndSeconds) {
			$endTimeSeconds += 86400;
		}
		$restaurantEndSeconds += 86400;
	}
	if (($startTimeSeconds < $restaurantStartSeconds) || ($restaurantEndSeconds < $startTimeSeconds) || ($restaurantEndSeconds < $endTimeSeconds) || ($endTimeSeconds < $restaurantStartSeconds)) {
		echo "Closed";
		exit;
	}

	// query to directly get table
	$getTableSQL = "DECLARE @startTime BIGINT = :startTime,
		@endTime BIGINT = :endTime;
		SELECT TOP 1 tables.tableID, tables.capacity
		FROM tables
		WHERE (tables.blocked = 0) AND capacity = :guestCapacity
		AND tables.tableID NOT IN (
			SELECT reserved.tableID
			FROM reserved
			WHERE ((reserved.startTime < @endTime AND @endTime < reserved.endTime)
				OR (@startTime < reserved.endTime AND reserved.endTime < @endTime))
				AND (status = 'reserved' OR status = 'checkedIn')
			GROUP BY reserved.tableID)";

	$getTableSTMT = $conn->prepare($getTableSQL, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$getTableSTMT->bindParam(':startTime', $startTime);
	$getTableSTMT->bindParam(':endTime', $endTime);
	$getTableSTMT->bindParam(':guestCapacity', $guestCapacity);
	$getTableSTMT->execute();
	$tableRow = $getTableSTMT->fetchObject();

	try {
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$conn->beginTransaction();
		if (isset($tableRow->tableID)) {
			$reservedTables[] = $tableRow->tableID;
		} else {
			// query to get table count
			$getTableCountSQL = "DECLARE @startTime BIGINT = :startTime,
				@endTime BIGINT = :endTime;
				SELECT count(*) AS tableCount, capacity
				FROM tables
				WHERE tableID NOT IN (
					SELECT tableID
					FROM reserved
					WHERE ((reserved.startTime < @endTime AND @endTime < reserved.endTime)
						OR (@startTime < reserved.endTime AND reserved.endTime < @endTime))
						AND status != 'cancelled'
					GROUP BY tableID
				)
				AND blocked = '0'
				GROUP BY capacity";

			$getTableCountSTMT = $conn->prepare($getTableCountSQL);
			$getTableCountSTMT->bindParam(':startTime', $startTime);
			$getTableCountSTMT->bindParam(':endTime', $endTime);
			$getTableCountSTMT->execute();

			while ($tableRow = $getTableCountSTMT->fetchObject()) {
				$tableCount = $tableRow->tableCount;
				$capacity = $tableRow->capacity;
				$availableSlot[$capacity] = $tableCount;
			}

			if (!isset($availableSlot)) { // if table not available
				echo "full";
				exit;
			}
			$getAdjacentSQL = "DECLARE @startTime BIGINT = :startTime,
				@endTime BIGINT = :endTime;
				SELECT tableA, tableB FROM adjacent
					INNER JOIN tables ON tables.tableID = adjacent.tableA
					WHERE tables.tableID NOT IN (
						SELECT tableID
						FROM reserved
						WHERE ((reserved.startTime < @endTime AND @endTime < reserved.endTime)
							OR (@startTime < reserved.endTime AND reserved.endTime < @endTime))
							AND status != 'cancelled'
						GROUP BY tableID
					) AND blocked = '0' AND capacity = :capacity";
			$getAdjacentSTMT = $conn->prepare($getAdjacentSQL);
			$getAdjacentSTMT->bindParam(':startTime', $startTime);
			$getAdjacentSTMT->bindParam(':endTime', $endTime);

			foreach ($availableSlot as $capacity => $count) {
				$requiredCount = ceil($guestCapacity / $capacity);
				if ($requiredCount > $count) {
					$requiredCount = $count;
				}
				for ($i = 0; $i < $requiredCount; $i++) {
					$availableTables[] = $capacity;
				}
				$getAdjacentSTMT->bindParam(':capacity', $capacity);
				$getAdjacentSTMT->execute();
				while ($row = $getAdjacentSTMT->fetchObject()) {
					$adjacentTables[$row->tableA]["Capacity"] = (int)$capacity;
					$adjacentTables[$row->tableA]["Adjacent"][] = (int)$row->tableB;
				}

				// avoid table with capacity greater then guest capacity
				if ($capacity > $guestCapacity) {
					break;
				}
			}
			$toPython["capacity"] = $guestCapacity;
			$toPython["table"] = $availableTables;
			$toPython["tables"] = $adjacentTables;
			$toPython = json_encode($toPython);
			// refer reservationapi.py for input example

			$ch = curl_init('localhost:5000');
			# Setup request to send json via POST.
			curl_setopt($ch, CURLOPT_POSTFIELDS, $toPython);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
			# Return response instead of printing.
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			# Send request.
			$result = curl_exec($ch);
			curl_close($ch);

			if ($result == "False") { // if table not available
				echo "full";
				exit;
			}
			echo $result;
			$reservedTables = json_decode($result, true)[0];
			print_r($reservedTables);
		}

		$status = "reserved";
		// booking table
		$reserveTableSQL = "INSERT INTO booking (guestName, guestMobile, numberOfPeople, roomID, startTime, endTime, status) VALUES (:name, :mobile, :numberOfPeople, :roomID, :startTime, :endTime, :status)";
		$reserveTableSTMT = $conn->prepare($reserveTableSQL);
		$reserveTableSTMT->bindParam(':name', $guestName);
		$reserveTableSTMT->bindParam(':mobile', $guestMobile);
		$reserveTableSTMT->bindParam(':numberOfPeople', $guestCapacity);
		$reserveTableSTMT->bindParam(':roomID', $roomID);
		$reserveTableSTMT->bindParam(':startTime', $guestStartTime);
		$reserveTableSTMT->bindParam(':endTime', $guestEndTime);
		$reserveTableSTMT->bindParam(':status', $status);
		$reserveTableSTMT->execute();
		$bookingID = $conn->lastInsertId();

		//reserved table
		$logTableSQL = "INSERT INTO reserved (bookingID, tableID, startTime, endTime, status) VALUES (:bookingID, :tableID, :startTime, :endTime, :status)";
		$logTableSTMT = $conn->prepare($logTableSQL);
		$logTableSTMT->bindParam(':bookingID', $bookingID);
		$logTableSTMT->bindParam(':startTime', $guestStartTime);
		$logTableSTMT->bindParam(':endTime', $guestEndTime);
		$logTableSTMT->bindParam(':status', $status);

		foreach ($reservedTables as $tableID) {
			$logTableSTMT->bindParam(':tableID', $tableID);
			$logTableSTMT->execute();
		}
		$conn->commit();
	} catch (PDOException $e) {
		$conn->rollBack();
		echo "Failed " . $e->getMessage();
	}
}
