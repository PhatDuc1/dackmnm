
<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header('location:login.php');
    }

    include "../courses/connect.php"; // Kết nối đến cơ sở dữ liệu

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "DELETE FROM courses WHERE id='$id'";
        $result = mysqli_query($con, $sql);

        if ($result) {
            echo "<script>alert('Xóa điểm thành công!'); window.location.href='manage_courses.php';</script>";
        } else {
            echo "<script>alert('Có lỗi xảy ra: " . mysqli_error($con) . "');</script>";
        }
    }
?>