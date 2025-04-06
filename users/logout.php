<?php
session_start();

// Hủy tất cả các biến session
$_SESSION = array();

// Hủy session cookie
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-3600, '/');
}

// Hủy session
session_destroy();

// Chuyển hướng về trang đăng nhập
header('Location: ../signup1/login.php');
exit();
?>