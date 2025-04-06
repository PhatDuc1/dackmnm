<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'user') {
    header('location:access_denied.php');
    exit();
}

require_once 'connect.php';

// Lấy thông tin user từ database
$username = $_SESSION['username'];
$sql = "SELECT * FROM users WHERE username='" . mysqli_real_escape_string($con, $username) . "'";
$result = mysqli_query($con, $sql);
if (!$result) {
    die("Lỗi truy vấn: " . mysqli_error($con));
}
$user = mysqli_fetch_assoc($result);
if (!$user) {
    die("Không tìm thấy thông tin người dùng");
}
?>

<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Thông Tin Cá Nhân</title>
    <style>
        body {
            background: linear-gradient(135deg, #74ebd5, #acb6e5);
            font-family: 'Roboto', sans-serif;
        }
        .profile-container {
            max-width: 700px;
            margin: 60px auto;
            background: #ffffff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }
        .profile-container h2 {
            color: #333;
            margin-bottom: 30px;
            text-align: center;
            font-weight: bold;
        }
        .profile-info {
            margin-bottom: 20px;
        }
        .profile-info label {
            font-weight: bold;
            color: #555;
        }
        .profile-info p {
            margin-bottom: 15px;
            padding: 10px;
            background: #f9f9f9;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        .back-btn {
            display: inline-block;
            padding: 12px 25px;
            background: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background 0.3s ease;
        }
        .back-btn:hover {
            background: #0056b3;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <h2>Thông Tin Cá Nhân</h2>
        
        <div class="profile-info">
            <label>Mã số sinh viên:</label>
            <p><?php echo htmlspecialchars($user['mssv']); ?></p>

            <label>Tên đăng nhập:</label>
            <p><?php echo htmlspecialchars($user['username']); ?></p>

            <label>Email:</label>
            <p><?php echo htmlspecialchars($user['email']); ?></p>

            <label>Số điện thoại:</label>
            <p><?php echo htmlspecialchars($user['mobile']); ?></p>

            <label>Địa chỉ:</label>
            <p><?php echo htmlspecialchars($user['address']); ?></p>

            <label>Vai trò:</label>
            <p><?php echo htmlspecialchars($_SESSION['role']); ?></p>
        </div>

        <div class="text-center">
            <a href="user_home.php" class="back-btn">Quay lại trang chủ</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>