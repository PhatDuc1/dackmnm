<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header('location:login.php');
    }

    include "connect.php"; // Kết nối đến cơ sở dữ liệu

    // Xử lý thêm sinh viên
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $student_id = $_POST['student_id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];

        $sql = "INSERT INTO students (student_id, name, email, phone, address) VALUES ('$student_id', '$name', '$email', '$phone', '$address')";
        $result = mysqli_query($con, $sql);

        if ($result) {
            echo "<script>alert('Thêm sinh viên thành công!'); window.location.href='display.php';</script>";
        } else {
            echo "<script>alert('Có lỗi xảy ra: " . mysqli_error($con) . "');</script>";
        }
    }
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" 
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" 
    crossorigin="anonymous">

    <title>Thêm Sinh Viên</title>
  </head>
  <body>
    <div class="container mt-5">
        <h1 class="text-center">Thêm Sinh Viên</h1>
        <form method="POST" action="add_student.php" class="mb-4">
            <div class="form-group">
                <label for="student_id">Mã Sinh Viên</label>
                <input type="text" class="form-control" id="student_id" name="student_id" required>
            </div>
            <div class="form-group">
                <label for="name">Tên</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="phone">Số Điện Thoại</label>
                <input type="text" class="form-control" id="phone" name="phone" required>
            </div>
            <div class="form-group">
                <label for="address">Địa Chỉ</label>
                <input type="text" class="form-control" id="address" name="address" required>
            </div>
            <button type="submit" class="btn btn-primary">Thêm Sinh Viên</button>
        </form>
        <button class="btn btn-secondary mt-3"><a href="display.php" class="text-light">Quay lại</a></button>
    </div>
  </body>
</html>