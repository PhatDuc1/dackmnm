<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header('location:login.php');
    }

    include "../exams/connect.php"; // Kết nối đến cơ sở dữ liệu

    // Get the exam schedule ID from the query string
    $id = $_GET['id'];

    // Fetch the existing exam schedule details
    $sql = "SELECT * FROM exam_schedule WHERE id='$id'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);

    // Handle form submission to update the exam schedule
    if(isset($_POST['update_exam'])){
        $course_code = $_POST['course_code'];
        $exam_date = $_POST['exam_date'];
        $exam_time = $_POST['exam_time'];
        $location = $_POST['location'];

        $sql = "UPDATE exam_schedule SET course_code='$course_code', exam_date='$exam_date', exam_time='$exam_time', location='$location' WHERE id='$id'";
        mysqli_query($con, $sql);

        // Redirect back to manage_exam_schedule.php after updating the exam
        header('location: manage_exam_schedule.php');
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

    <title>Sửa Lịch Thi</title>
  </head>
  <body>
    <div class="container mt-5">
        <h1 class="text-center">Sửa Lịch Thi</h1>
        <form class="form-inline mb-3" method="POST" action="edit_exam_schedule.php?id=<?php echo $id; ?>">
            <input class="form-control mr-sm-2" type="text" placeholder="Mã Môn Học" name="course_code" value="<?php echo $row['course_code']; ?>" required>
            <input class="form-control mr-sm-2" type="date" placeholder="Ngày Thi" name="exam_date" value="<?php echo $row['exam_date']; ?>" required>
            <input class="form-control mr-sm-2" type="time" placeholder="Giờ Thi" name="exam_time" value="<?php echo $row['exam_time']; ?>" required>
            <select class="form-control mr-sm-2" name="location" required>
                <option value="">Chọn Địa Điểm</option>
                <option value="Khu E" <?php if($row['location'] == 'Khu E') echo 'selected'; ?>>Khu E</option>
                <option value="Khu A,B" <?php if($row['location'] == 'Khu A,B') echo 'selected'; ?>>Khu A,B</option>
                <option value="Khu U" <?php if($row['location'] == 'Khu U') echo 'selected'; ?>>Khu U</option>
            </select>
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="update_exam">Cập Nhật Lịch Thi</button>
        </form>
        <button class="btn btn-secondary mt-3"><a href="manage_exam_schedule.php" class="text-light">Quay lại</a></button>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j6f3y4Qp9F4h+6U5L0Xbg" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>