<?php
//includes/database_connection.php
$host = 'localhost'; 
$username = 'root'; 
$password = '12345678'; 
$dbname = 'novus';

$conn = new mysqli($host, $username, $password, $dbname);
