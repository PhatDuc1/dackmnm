<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header('location:login.php');
    }

    include "../CRUD/connect.php"; // Kết nối đến cơ sở dữ liệu

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "DELETE FROM students WHERE id='$id'";
        $result = mysqli_query($con, $sql);

        if ($result) {
            echo "<script>alert('Xóa sinh viên thành công!'); window.location.href='display.php';</script>";
        } else {
            echo "<script>alert('Có lỗi xảy ra: " . mysqli_error($con) . "');</script>";
        }
    }
?>