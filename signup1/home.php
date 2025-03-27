<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header('location:login.php');
    }
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <title>Hệ Thống Đào Tạo Chương Trình Chất Lượng Cao</title>
    <style>
        body {
            background: linear-gradient(135deg, #1e3c72, #2a5298); /* Gradient xanh đậm */
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Roboto', sans-serif;
            margin: 0;
        }
        .dashboard-container {
            width: 100%;
            max-width: 700px;
            background: rgba(255, 255, 255, 0.95); /* Nền trắng mờ nhẹ */
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .dashboard-container h2 {
            color: #1e3c72;
            margin-bottom: 30px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .custom-btn {
            border: none;
            background: #00c4cc; /* Màu xanh ngọc */
            color: white;
            font-size: 16px;
            font-weight: 600;
            padding: 14px;
            border-radius: 10px;
            transition: all 0.4s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 10px rgba(0, 196, 204, 0.3);
        }
        .custom-btn:hover {
            background: #00a3aa;
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0, 196, 204, 0.5);
        }
        .custom-btn i {
            margin-right: 10px;
            font-size: 18px;
        }
        .logout-btn {
            background: #ff5555; /* Màu đỏ nhạt */
        }
        .logout-btn:hover {
            background: #e63939;
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(255, 85, 85, 0.5);
        }
        hr {
            border-top: 2px solid #e0e0e0;
            margin: 25px 0;
            opacity: 0.7;
        }
        .text-primary {
            color: #00c4cc !important; /* Đồng bộ với màu nút */
            font-weight: bold;
        }
        .d-grid .btn {
            margin-bottom: 20px;
        }
        /* Hiệu ứng hover cho icon */
        .custom-btn:hover i {
            transform: rotate(20deg);
            transition: transform 0.3s ease;
        }
        /* Hiệu ứng focus */
        .custom-btn:focus {
            outline: none;
            box-shadow: 0 0 0 4px rgba(0, 196, 204, 0.4);
        }
    </style>
  </head>
  <body>
    <div class="dashboard-container">
        <h2>Chào Mừng, <span class="text-primary"><?php echo $_SESSION['username']; ?></span></h2>
        <hr>
        <div class="d-grid gap-3">
            <a href="../CRUD/display.php" class="btn custom-btn"><i class="fas fa-user-graduate"></i> Quản Lí Sinh Viên</a>
            <a href="../lecturers/manage_lecturers.php" class="btn custom-btn"><i class="fas fa-chalkboard-teacher"></i> Quản Lí Giảng Viên</a>
            <a href="../grades/grades.php" class="btn custom-btn"><i class="fas fa-book"></i> Quản Lí Điểm</a>
            <a href="../courses/manage_courses.php" class="btn custom-btn"><i class="fas fa-clipboard-list"></i> Quản Lý Môn Học</a>
            <a href="../exams/manage_exam_schedule.php" class="btn custom-btn"><i class="fas fa-calendar-alt"></i> Quản Lí Lịch Thi</a>
            <a href="../courses/register_course.php" class="btn custom-btn"><i class="fas fa-calendar-alt"></i> Đăng Kí Môn Học</a>
            <a href="logout.php" class="btn logout-btn text-white"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>