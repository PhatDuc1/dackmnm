<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header('location:login.php');
    }

    include "../courses/connect.php";

    // Hiển thị lỗi SQL nếu có
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    // Kiểm tra kết nối
    if ($con->connect_error) {
        die("Lỗi kết nối: " . $con->connect_error);
    }

    // Khởi tạo biến result
    $result = null;
    
    try {
        // Truy vấn để lấy danh sách đăng ký môn học
        $sql = "SELECT cr.username, u.mssv, c.course_code, c.course_name
                FROM course_registrations cr
                INNER JOIN users u ON u.username = cr.username
                INNER JOIN courses c ON c.id = cr.course_id
                ORDER BY cr.username, c.course_code";
        $result = mysqli_query($con, $sql);
        
        if (!$result) {
            throw new Exception("Lỗi truy vấn: " . mysqli_error($con));
        }
        
        
        
    } catch (Exception $e) {
        echo "<div class='alert alert-danger'>Có lỗi xảy ra: " . $e->getMessage() . "</div>";
        $result = null;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Đăng Ký Môn Học</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #2c3e50, #3498db);
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 20px;
            max-width: 1200px;
        }
        h1 {
            color: #2c3e50;
            font-weight: 700;
            text-align: center;
            margin-bottom: 30px;
        }
        .table {
            background: white;
            border-radius: 8px;
            overflow: hidden;
        }
        .table th {
            background: #34495e;
            color: white;
            font-weight: 500;
            text-align: center;
        }
        .table td {
            vertical-align: middle;
            text-align: center;
        }
        .btn {
            margin: 5px;
            padding: 8px 15px;
            border-radius: 5px;
        }
        .btn i {
            margin-right: 5px;
        }
        .action-buttons {
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
        }
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }
        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Danh Sách Sinh Viên Đăng Ký Môn Học</h1>
        
        <div class="action-buttons">
            <a href="../signup1/admin_home.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên Đăng Nhập</th>
                    <th>MSSV</th>
                    <th>Mã Môn Học</th>
                    <th>Tên Môn Học</th>
                    <th>Thao Tác</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if($result && mysqli_num_rows($result) > 0){
                    $stt = 1;
                    while($row = mysqli_fetch_assoc($result)){
                        echo '<tr>
                                <td>'.$stt.'</td>
                                <td>'.$row['username'].'</td>
                                <td>'.$row['mssv'].'</td>
                                <td>'.$row['course_code'].'</td>
                                <td>'.$row['course_name'].'</td>
                                <td>
                                    <form method="POST" action="../users/unregister_course.php" style="display:inline;">
                                        <input type="hidden" name="course_code" value="'.$row['course_code'].'">
                                        <input type="hidden" name="username" value="'.$row['username'].'">
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Bạn có chắc chắn muốn xóa đăng ký này?\')">
                                            <i class="fas fa-trash"></i> Xóa
                                        </button>
                                    </form>
                                </td>
                            </tr>';
                        $stt++;
                    }
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>
</html>