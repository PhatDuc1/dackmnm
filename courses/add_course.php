<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header('location:login.php');
    }

    include "../courses/connect.php"; // Kết nối đến cơ sở dữ liệu

    // Xử lý thêm môn học
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $course_code = $_POST['course_code'];
        $course_name = $_POST['course_name'];
        $credits = $_POST['credits'];

        $sql = "INSERT INTO courses (course_code, course_name, credits) VALUES ('$course_code', '$course_name', '$credits')";
        $result = mysqli_query($con, $sql);

        if ($result) {
            echo "<script>alert('Thêm môn học thành công!'); window.location.href='manage_courses.php';</script>";
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

    <title>Thêm Môn Học</title>
  </head>
  <body>
    <div class="container mt-5">
        <h1 class="text-center">Thêm Môn Học</h1>
        <form method="POST" action="add_course.php" class="mb-4">
            <div class="form-group">
                <label for="course_code">Mã Môn Học</label>
                <input type="text" class="form-control" id="course_code" name="course_code" required>
            </div>
            <div class="form-group">
                <label for="course_name">Tên Môn Học</label>
                <input type="text" class="form-control" id="course_name" name="course_name" required>
            </div>
            <div class="form-group">
                <label for="credits">Số Tín Chỉ</label>
                <input type="number" class="form-control" id="credits" name="credits" required>
            </div>
            <button type="submit" class="btn btn-primary">Thêm Môn Học</button>
        </form>
        <button class="btn btn-secondary mt-3"><a href="manage_courses.php" class="text-light">Quay lại</a></button>
    </div>
  </body>
</html>