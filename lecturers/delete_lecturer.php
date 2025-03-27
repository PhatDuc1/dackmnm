<?php
session_start();
include "../lecturers/connect.php"; // Kết nối đến cơ sở dữ liệu

if(isset($_GET['id'])) {
    $id = $_GET['id'];

    // Kiểm tra xem giảng viên có tồn tại không
    $check = mysqli_query($con, "SELECT * FROM lecturers WHERE id='$id'");
    if(mysqli_num_rows($check) > 0) {
        // Xóa giảng viên
        $sql = "DELETE FROM lecturers WHERE id='$id'";
        if(mysqli_query($con, $sql)) {
            $_SESSION['message'] = "Xóa giảng viên thành công!";
        } else {
            $_SESSION['error'] = "Lỗi khi xóa!";
        }
    } else {
        $_SESSION['error'] = "Giảng viên không tồn tại!";
    }
}

// Quay lại trang quản lý
header("Location: manage_lecturers.php");
exit();
?>
