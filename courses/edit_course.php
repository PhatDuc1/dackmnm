<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header('location:login.php');
    }

    include "../courses/connect.php"; // Kết nối đến cơ sở dữ liệu

    // Lấy thông tin môn học cần sửa
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM courses WHERE id='$id'";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);
    }

    // Xử lý cập nhật môn học
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $course_code = $_POST['course_code'];
        $course_name = $_POST['course_name'];
        $credits = $_POST['credits'];

        $sql = "UPDATE courses SET course_code='$course_code', course_name='$course_name', credits='$credits' WHERE id='$id'";
        $result = mysqli_query($con, $sql);

        if ($result) {
            echo "<script>alert('Cập nhật môn học thành công!'); window.location.href='manage_courses.php';</script>";
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

    <title>Sửa Môn Học</title>
  </head>
  <body>
    <div class="container mt-5">
        <h1 class="text-center">Sửa Môn Học</h1>
        <form method="POST" action="edit_course.php?id=<?php echo $id; ?>" class="mb-4">
            <div class="form-group">
                <label for="course_code">Mã Môn Học</label>
                <input type="text" class="form-control" id="course_code" name="course_code" value="<?php echo $row['course_code']; ?>" required>
            </div>
            <div class="form-group">
                <label for="course_name">Tên Môn Học</label>
                <input type="text" class="form-control" id="course_name" name="course_name" value="<?php echo $row['course_name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="credits">Số Tín Chỉ</label>
                <input type="number" class="form-control" id="credits" name="credits" value="<?php echo $row['credits']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Cập Nhật</button>
        </form>
        <button class="btn btn-secondary mt-3"><a href="manage_courses.php" class="text-light">Quay lại</a></button>
    </div>
  </body>
</html>