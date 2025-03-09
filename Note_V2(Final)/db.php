<?php
$host = 'localhost';
$db = 'suspicious_web_db';
$user = 'root';
$pass = '';

$conn = mysqli_connect($host, $user, $pass, $db);

// ตรวจสอบการเชื่อมต่อ
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


?>