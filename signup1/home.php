<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header('location:login.php');
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

    <title>Welcome page</title>
  </head>
  <body>
    <h1 class="text-center mt-5">Chào mừng
    <?php echo $_SESSION['username'];?>
    </h1>
    <div class="container">
        <a href="display.php" class="btn btn-primary mt-2">Thông Tin Sinh Viên</a>
    </div>
    <!-- <div class="container">
        <a href="display.php" class="btn btn-primary mt-2">Điểm</a>
    </div>
    <div class="container">
        <a href="logout.php" class="btn btn-primary mt-2">Đăng Kí Học Phần</a>
    </div>
    <div class="container">
        <a href="logout.php" class="btn btn-primary mt-2">Xem Lịch Thi</a>
    </div> -->
    <div class="container">
        <a href="logout.php" class="btn btn-primary mt-2">Đăng xuất</a>
    </div>
  </body>
</html>