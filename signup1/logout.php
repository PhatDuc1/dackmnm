<?php
session_start();

// Xóa remember_token trong database nếu có
if (isset($_COOKIE['remember_token'])) {
    include "connect.php";
    $token = $_COOKIE['remember_token'];
    $sql = "UPDATE users SET remember_token = NULL WHERE remember_token = '$token'";
    mysqli_query($con, $sql);
    
    // Xóa cookie bằng cách set thời gian hết hạn trong quá khứ
    setcookie('remember_token', '', time() - 3600, '/');
}

// Xóa session
session_unset();
session_destroy();

header('location:login.php');
exit();
?>