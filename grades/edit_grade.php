<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header('location:login.php');
    }

    include "../grades/connect.php"; // Kết nối đến cơ sở dữ liệu

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM grades WHERE id='$id'";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $mssv = $_POST['mssv'];
        $ho_ten = $_POST['ho_ten'];
        $username = $_POST['username'];
        $subject = $_POST['subject'];
        $grade = $_POST['grade'];

        $sql = "UPDATE grades SET mssv='$mssv', ho_ten='$ho_ten', username='$username', subject='$subject', grade='$grade' WHERE id='$id'";
        $result = mysqli_query($con, $sql);

        if ($result) {
            echo "<script>alert('Cập nhật điểm thành công!'); window.location.href='grades.php';</script>";
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

    <title>Sửa Điểm</title>
  </head>
  <body>
    <div class="container mt-5">
        <h1 class="text-center">Sửa Điểm</h1>
        <form method="POST" action="edit_grade.php?id=<?php echo $id; ?>">
            <div class="form-group">
                <label for="mssv">MSSV</label>
                <input type="text" class="form-control" id="mssv" name="mssv" value="<?php echo $row['mssv']; ?>" required>
            </div>
            <div class="form-group">
                <label for="ho_ten">Họ Tên</label>
                <input type="text" class="form-control" id="ho_ten" name="ho_ten" value="<?php echo $row['ho_ten']; ?>" required>
            </div>
            <div class="form-group">
                <label for="username">Vai Trò</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo $row['username']; ?>" required>
            </div>
            <div class="form-group">
                <label for="subject">Môn Học</label>
                <input type="text" class="form-control" id="subject" name="subject" value="<?php echo $row['subject']; ?>" required>
            </div>
            <div class="form-group">
                <label for="grade">Điểm</label>
                <input type="text" class="form-control" id="grade" name="grade" value="<?php echo $row['grade']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Cập Nhật</button>
        </form>
        <button class="btn btn-secondary mt-3"><a href="grades.php" class="text-light">Quay lại</a></button>
    </div>
  </body>
</html>