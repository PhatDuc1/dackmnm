<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header('location:login.php');
    }

    include "../lecturers/connect.php"; // Kết nối đến cơ sở dữ liệu

    // Handle form submission to add a new teaching schedule
    if(isset($_POST['add_schedule'])){
        $lecturer_id = $_POST['lecturer_id'];
        $course_code = $_POST['course_code'];
        $course_name = $_POST['course_name'];
        $day = $_POST['day'];
        $time = $_POST['time'];
        $location = $_POST['location'];

        $sql = "INSERT INTO teaching_schedule (lecturer_id, course_code, course_name, day, time, location) VALUES ('$lecturer_id', '$course_code', '$course_name', '$day', '$time', '$location')";
        mysqli_query($con, $sql);

        // Redirect back to lecturer_schedule.php after adding the schedule
        header('location: lecturer_schedule.php?lecturer_id='.$lecturer_id);
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

    <title>Thêm Lịch Dạy Học</title>
  </head>
  <body>
    <div class="container mt-5">
        <h1 class="text-center">Thêm Lịch Dạy Học</h1>
        <form class="form-inline mb-3" method="POST" action="add_teaching_schedule.php">
            <input type="hidden" name="lecturer_id" value="<?php echo $_GET['lecturer_id']; ?>">
            <input class="form-control mr-sm-2" type="text" placeholder="Mã Môn Học" name="course_code" required>
            <input class="form-control mr-sm-2" type="text" placeholder="Tên Môn Học" name="course_name" required>
            <input class="form-control mr-sm-2" type="text" placeholder="Ngày" name="day" required>
            <input class="form-control mr-sm-2" type="time" placeholder="Giờ" name="time" required>
            <input class="form-control mr-sm-2" type="text" placeholder="Địa Điểm" name="location" required>
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="add_schedule">Thêm Lịch Dạy Học</button>
        </form>
        <button class="btn btn-secondary mt-3"><a href="lecturer_schedule.php?lecturer_id=<?php echo $_GET['lecturer_id']; ?>" class="text-light">Quay lại</a></button>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j6f3y4Qp9F4h+6U5L0Xbg" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>