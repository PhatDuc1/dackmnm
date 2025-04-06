<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'user') {
    header('location:access_denied.php');
    exit();
}
?>

<!doctype html>
<html lang="vi">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
    crossorigin="anonymous">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

    <title>Trang Người Dùng</title>
    <style>
        body {
            background: #f0f2f5;
            font-family: 'Roboto', sans-serif;
        }
        .navbar {
            background: linear-gradient(135deg, #0061f2 0%, #6900f2 100%);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 1rem 0;
        }
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }
        .nav-link {
            font-weight: 500;
        }
        .dashboard-container {
            max-width: 1200px;
            margin: 30px auto;
            background: #fff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }
        .welcome-section {
            text-align: center;
            margin-bottom: 40px;
            padding: 20px;
            background: linear-gradient(135deg, #f5f7ff 0%, #e9efff 100%);
            border-radius: 15px;
        }
        .welcome-section h2 {
            color: #2d3748;
            margin-bottom: 15px;
            font-weight: 700;
        }
        .welcome-section .username {
            color: #0061f2;
        }
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-top: 30px;
        }
        .feature-card {
            background: #fff;
            border: 1px solid #e0e7ff;
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            transition: all 0.3s ease;
            text-decoration: none;
            position: relative;
            overflow: hidden;
        }
        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, #0061f2, #6900f2);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            text-decoration: none;
            border-color: #b4c6ff;
        }
        .feature-card:hover::before {
            transform: scaleX(1);
        }
        .feature-card i {
            font-size: 2.5rem;
            margin-bottom: 20px;
            background: linear-gradient(135deg, #0061f2, #6900f2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            transition: all 0.3s ease;
        }
        .feature-card:hover i {
            transform: scale(1.1);
        }
        .feature-card h4 {
            color: #2d3748;
            margin-bottom: 15px;
            font-size: 1.25rem;
            font-weight: 600;
        }
        .feature-card p {
            color: #718096;
            font-size: 0.95rem;
            margin-bottom: 15px;
        }
        .badge-courses {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #0061f2;
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
        }
        .quick-actions {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
        }
        .action-btn {
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .action-btn i {
            font-size: 1.1rem;
        }
        .btn-primary {
            background: linear-gradient(135deg, #0061f2 0%, #6900f2 100%);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #0052cc 0%, #5900cc 100%);
            transform: translateY(-2px);
        }
        .notifications {
            position: fixed;
            top: 80px;
            right: 20px;
            z-index: 1000;
        }
        .footer {
            text-align: center;
            padding: 30px 0;
            color: #718096;
            margin-top: 50px;
            border-top: 1px solid #e0e7ff;
        }
        @media (max-width: 768px) {
            .dashboard-container {
                padding: 20px;
                margin: 15px;
            }
            .features-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
  </head>
  <body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-graduation-cap mr-2"></i>
                Hệ Thống Đào Tạo Chất Lượng Cao
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="notifications.php">
                            <i class="fas fa-bell"></i>
                            <span class="badge badge-light ml-1">3</span>
                        </a>
                    </li>
                    <li class="nav-item ml-3">
                        <a class="nav-link" href="view_profile.php">
                            <i class="fas fa-user-circle mr-1"></i>
                            <?php echo $_SESSION['username']; ?>
                        </a>
                    </li>
                    <li class="nav-item ml-3">
                        <a class="btn btn-light btn-sm" href="logout.php">
                            <i class="fas fa-sign-out-alt mr-1"></i>
                            Đăng Xuất
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="dashboard-container">
        <div class="welcome-section">
            <h2>
                <i class="fas fa-user-circle mr-2"></i>
                Xin chào, <span class="username"><?php echo $_SESSION['username']; ?></span>!
            </h2>
            <p class="text-muted mb-0">Chào mừng bạn đến với hệ thống quản lý đào tạo</p>
        </div>
        
        <!-- Quick Actions -->
        <div class="quick-actions">
            <a href="register_course.php" class="btn btn-success action-btn">
                <i class="fas fa-plus-circle"></i>
                Đăng ký môn học mới
            </a>
        </div>

        <!-- Feature Grid -->
        <div class="features-grid">
            <a href="view_profile.php" class="feature-card">
                <i class="fas fa-user-graduate"></i>
                <h4>Thông Tin Cá Nhân</h4>
                <p>Xem và cập nhật thông tin sinh viên của bạn</p>
            </a>
            <a href="register_course.php" class="feature-card">
                <i class="fas fa-book"></i>
                <h4>Đăng Kí Môn Học</h4>
                <p>Xem và đăng ký các môn học mới</p>
            </a>
            <a href="../grades/student_grades.php?username=<?php echo $_SESSION['username']; ?>" class="feature-card">
                <i class="fas fa-chart-line"></i>
                <h4>Xem Điểm</h4>
                <p>Kiểm tra kết quả học tập của bạn</p>
            </a>
            <a href="schedule.php" class="feature-card">
                <i class="fas fa-calendar-alt"></i>
                <h4>Lịch Thi</h4>
                <p>Xem lịch thi của bạn</p>
            </a>
            <a href="documents.php" class="feature-card">
                <i class="fas fa-file-alt"></i>
                <h4>Tài Liệu Học Tập</h4>
                <p>Truy cập tài liệu và bài giảng</p>
            </a>
            <a href="feedback.php" class="feature-card">
                <i class="fas fa-comment-alt"></i>
                <h4>Phản Hồi</h4>
                <p>Gửi phản hồi và đánh giá</p>
            </a>
        </div>

        <!-- Footer -->
        <footer class="footer">
            <p class="mb-0">© 2024 Hệ Thống Quản Lý Sinh Viên. Phát triển bởi Team IT.</p>
        </footer>
    </div>

    

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <!-- Custom JS -->
    <script>
        $(document).ready(function(){
            $('.toast').toast('show');
        });
    </script>
  </body>
</html>