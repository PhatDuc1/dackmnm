<?php
session_start();
include "../signup1/connect.php";

$message = "";
$success_message = "";

if (isset($_GET['register']) && $_GET['register'] == 'success') {
    $success_message = "Đăng ký tài khoản thành công! Vui lòng đăng nhập.";
}

// Kiểm tra cookie remember_token
if (!isset($_SESSION['username']) && isset($_COOKIE['remember_token'])) {
    $token = $_COOKIE['remember_token'];
    $sql = "SELECT * FROM users WHERE remember_token = '$token'";
    $result = mysqli_query($con, $sql);
    
    if ($row = mysqli_fetch_assoc($result)) {
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];
        
        if ($row['role'] == 'admin') {
            header('location:admin_home.php');
        } else {
            header('location:../users/user_home.php');
        }
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $remember = isset($_POST['remember']) ? true : false;

    // Kiểm tra thông tin đăng nhập
    $sql = "SELECT * FROM users WHERE username='$username' OR mssv='$username'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($row && password_verify($password, $row['password'])) {
        // Luôn lấy username và mssv từ database để đảm bảo session có đủ thông tin
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];
        $_SESSION['mssv'] = $row['mssv'];

        // Nếu người dùng chọn "Duy trì đăng nhập"
        if ($remember) {
            // Tạo token ngẫu nhiên
            $token = bin2hex(random_bytes(32));
            
            // Lưu token vào cookie, thời hạn 30 ngày
            setcookie('remember_token', $token, time() + (30 * 24 * 60 * 60), '/');
            
            // Lưu token vào database
            $user_id = $row['id'];
            $update_token = "UPDATE users SET remember_token = '$token' WHERE id = $user_id";
            mysqli_query($con, $update_token);
        }

        // Chuyển hướng dựa trên vai trò
        if ($row['role'] == 'admin') {
            header('location:admin_home.php');
        } else {
            header('location:../users/user_home.php');
        }
        exit();
    } else {
        $message = "Tên đăng nhập hoặc mật khẩu không đúng!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', sans-serif;
        }
        .container {
            max-width: 800px;
        }
        .card {
            border: 0;
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1rem 0 rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background: #764ba2;
            color: white;
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
            border-radius: 1rem 1rem 0 0 !important;
            padding: 1.5rem;
        }
        .form-control {
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            margin-bottom: 1rem;
        }
        .btn-login {
            background: #764ba2;
            border: none;
            border-radius: 0.5rem;
            padding: 0.75rem;
            font-weight: bold;
            width: 100%;
        }
        .btn-login:hover {
            background: #667eea;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-sign-in-alt mr-2"></i>Đăng Nhập
            </div>
            <div class="card-body p-5">
                <?php if ($success_message): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> <?php echo $success_message; ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>

                <?php if ($message): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i> <?php echo $message; ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="login.php">
                    <div class="form-group">
                        <label for="username">Tên Đăng Nhập hoặc MSSV</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Nhập tên đăng nhập hoặc MSSV" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Mật Khẩu</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="remember" name="remember">
                            <label class="custom-control-label" for="remember">Duy trì đăng nhập</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-login">
                        <i class="fas fa-sign-in-alt mr-2"></i>Đăng Nhập
                    </button>

                    <div class="text-center mt-4">
                        <p>Chưa có tài khoản?
                            <a href="register.php" class="text-primary">Đăng Ký</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  </body>
</html>