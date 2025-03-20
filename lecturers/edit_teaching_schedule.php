<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header('location:login.php');
    }

    include "../lecturers/connect.php"; // Kết nối đến cơ sở dữ liệu

    // Get the schedule ID from the query string
    $id = $_GET['id'];

    // Fetch the existing schedule details
    $sql = "SELECT * FROM teaching_schedule WHERE id='$id'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);

    // Handle form submission to update the schedule
    if(isset($_POST['update_schedule'])){
        $course_code = $_POST['course_code'];
        $course_name = $_POST['course_name'];
        $day = $_POST['day'];
        $time = $_POST['time'];
        $location = $_POST['location'];

        $sql = "UPDATE teaching_schedule SET course_code='$course_code', course_name='$course_name', day='$day', time='$time', location='$location' WHERE id='$id'";
        mysqli_query($con, $sql);

        // Redirect back to lecturer_schedule.php after updating the schedule
        header('location: lecturer_schedule.php?lecturer_id='.$row['lecturer_id']);
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

    <title>Sửa Lịch Dạy Học</title>
  </head>
  <body>
    <div class="container mt-5">
        <h1 class="text-center">Sửa Lịch Dạy Học</h1>
        <form class="form-inline mb-3" method="POST" action="edit_teaching_schedule.php?id=<?php echo $id; ?>">
            <input class="form-control mr-sm-2" type="text" placeholder="Mã Môn Học" name="course_code" value="<?php echo $row['course_code']; ?>" required>
            <input class="form-control mr-sm-2" type="text" placeholder="Tên Môn Học" name="course_name" value="<?php echo $row['course_name']; ?>" required>
            <input class="form-control mr-sm-2" type="text" placeholder="Ngày" name="day" value="<?php echo $row['day']; ?>" required>
            <input class="form-control mr-sm-2" type="time" placeholder="Giờ" name="time" value="<?php echo $row['time']; ?>" required>
            <input class="form-control mr-sm-2" type="text" placeholder="Địa Điểm" name="location" value="<?php echo $row['location']; ?>" required>
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="update_schedule">Cập Nhật Lịch Dạy Học</button>
        </form>
        <button class="btn btn-secondary mt-3"><a href="lecturer_schedule.php?lecturer_id=<?php echo $row['lecturer_id']; ?>" class="text-light">Quay lại</a></button>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j6f3y4Qp9F4h+6U5L0Xbg" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>