<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'user') {
    header('location:../signup1/access_denied.php');
    exit();
}

require_once 'connect.php';
$conn = $con;

// Lấy lịch thi của các môn học đã đăng ký
$username = $_SESSION['username'];
$sql = "SELECT es.course_code, c.course_name, es.exam_date, es.exam_time, es.location
        FROM course_registrations cr
        JOIN courses c ON cr.course_id = c.id
        JOIN exam_schedule es ON c.course_code = es.course_code
        WHERE cr.username = ?
        ORDER BY es.exam_date, es.exam_time";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch Thi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
        }
        .navbar {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            padding: 1rem 2rem;
        }
        .navbar-brand {
            color: white !important;
            font-weight: bold;
        }
        .nav-link {
            color: rgba(255,255,255,0.8) !important;
            transition: color 0.3s ease;
        }
        .nav-link:hover {
            color: white !important;
        }
        .container {
            padding: 2rem;
        }
        .card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            padding: 2rem;
            margin-bottom: 2rem;
        }
        .schedule-table {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            margin-top: 20px;
        }
        .schedule-table th {
            background: #2a5298;
            color: white;
            font-weight: 500;
            text-align: center;
            padding: 15px;
        }
        .schedule-table td {
            padding: 12px;
            vertical-align: middle;
            text-align: center;
        }
        .day-header {
            background: #3498db;
            color: white;
            text-align: center;
            padding: 10px;
            margin-top: 20px;
            border-radius: 5px;
            font-weight: bold;
        }
        .time-slot {
            background: #f8f9fa;
            border-radius: 5px;
            padding: 10px;
            margin: 5px 0;
        }
        .room-badge {
            background: #2a5298;
            color: white;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="user_home.php">
            <i class="fas fa-graduation-cap"></i> Hệ Thống Đào Tạo
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="user_home.php">
                        <i class="fas fa-home"></i> Trang Chủ
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="view_profile.php">
                        <i class="fas fa-user"></i> Hồ Sơ
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">
                        <i class="fas fa-sign-out-alt"></i> Đăng Xuất
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="card">
            <h2 class="text-center mb-4">
                <i class="fas fa-calendar-alt"></i> Lịch Thi
            </h2>

            <?php
            if ($result->num_rows > 0) {
                echo '<div class="table-responsive">
                    <table class="table table-hover schedule-table">
                        <thead>
                            <tr>
                                <th>Mã Môn Học</th>
                                <th>Tên Môn Học</th>
                                <th>Ngày Thi</th>
                                <th>Giờ Thi</th>
                                <th>Phòng Thi</th>
                            </tr>
                        </thead>
                        <tbody>';
                
                while ($row = $result->fetch_assoc()) {
                    $exam_date = date('d/m/Y', strtotime($row['exam_date']));
                    echo '<tr>
                        <td>' . htmlspecialchars($row['course_code']) . '</td>
                        <td>' . htmlspecialchars($row['course_name']) . '</td>
                        <td>' . $exam_date . '</td>
                        <td>' . htmlspecialchars($row['exam_time']) . '</td>
                        <td><span class="room-badge">
                            <i class="fas fa-door-open"></i> ' . htmlspecialchars($row['location']) . '
                        </span></td>
                    </tr>';
                }
                
                echo '</tbody></table></div>';
            } else {
                echo '<div class="alert alert-info" role="alert">
                        <i class="fas fa-info-circle"></i> Bạn chưa có lịch thi nào.
                      </div>';
            }
            ?>

            <div class="text-center mt-4">
                <a href="user_home.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>
</html>