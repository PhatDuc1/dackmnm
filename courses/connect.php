<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quanlisinhvien";

// Tạo kết nối
$con = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
?>