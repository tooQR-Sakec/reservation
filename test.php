<?php
$table['1'] = 5;
$table['2'] = 4;

$data['capacity'] = 6;
$data['table'] = $table;

$data = json_encode($data);
echo $data;

$ch = curl_init('http://127.0.0.1:5000/');
# Setup request to send json via POST.
curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
# Return response instead of printing.
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
# Send request.
$result = curl_exec($ch);
curl_close($ch);
# Print response.
$result = json_decode($result, true);

foreach($result["table combination"] as $tableID) {
	echo $tableID;
}