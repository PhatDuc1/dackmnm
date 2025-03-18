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
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <style>
        .custom-btn {
            border: 0.5px solid black; /* Độ đậm của viền */
            color: black; /* Màu chữ trắng */
        }
        .custom-btn:hover {
            background-color: #fff000; /* Màu nền xanh dương đậm khi hover */
        }
    </style>

    <title>HỆ THỐNG ĐÀO TẠO CHƯƠNG TRÌNH CHẤT LƯỢNG</title>
  </head>
  <body>
    <h1 class="text-center mt-5">Chào Mừng
    <?php echo $_SESSION['username'];?>
    </h1>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <a href="../CRUD/display.php" class="btn btn-block mb-3 custom-btn">
                    <i class="fas fa-user-graduate"></i> Thông Tin Sinh Viên
                </a>
                <a href="../grades/grades.php" class="btn btn-block mb-3 custom-btn">
                    <i class="fas fa-book"></i> Điểm
                </a>
                <a href="../courses/manage_courses.php" class="btn btn-block mb-3 custom-btn">
                    <i class="fas fa-clipboard-list"></i> Quản Lý Môn Học
                </a>
                <a href="exam_schedule.php" class="btn btn-block mb-3 custom-btn">
                    <i class="fas fa-calendar-alt"></i> Xem Lịch Thi
                </a>
                <a href="logout.php" class="btn btn-block custom-btn">
                    <i class="fas fa-sign-out-alt"></i> Đăng xuất
                </a>
            </div>
        </div>
    </div>
  </body>
</html>