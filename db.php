<?php
//DB CONNECTION====================================
$servername = "localhost";
$username = "root";
$password = "";
$database = "reservation";
// Create connection
$conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
