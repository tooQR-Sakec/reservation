<?php
//DB CONNECTION====================================
$serverName = "localhost";
$username = "";
$password = "";
$database = "reservation";
// Create connection
$conn = new PDO("sqlsrv:server=$serverName; Database=$database", "", "");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
