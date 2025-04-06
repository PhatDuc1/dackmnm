<?php
include "connect.php";

if(isset($_POST['submit'])) {
    $mssv = mysqli_real_escape_string($con, $_POST['mssv']);
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $mobile = mysqli_real_escape_string($con, $_POST['mobile']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    
    // Kiểm tra MSSV đã tồn tại chưa
    $check_mssv = mysqli_query($con, "SELECT * FROM users WHERE mssv='$mssv'");
    if(mysqli_num_rows($check_mssv) > 0) {
        $error = "MSSV đã tồn tại trong hệ thống!";
    }
    // Kiểm tra email đã tồn tại chưa
    else {
        $check_email = mysqli_query($con, "SELECT * FROM users WHERE email='$email'");
        if(mysqli_num_rows($check_email) > 0) {
            $error = "Email đã tồn tại trong hệ thống!";
        }
        else {
            $sql = "INSERT INTO users (mssv, username, email, mobile, password, address, role) 
                    VALUES ('$mssv', '$username', '$email', '$mobile', '$password', '$address', 'user')";
            
            if(mysqli_query($con, $sql)) {
                echo "<script>
                    alert('Đăng ký tài khoản thành công!');
                    window.location.href='login.php?register=success';
                </script>";
                exit();
            } else {
                $error = "Có lỗi xảy ra. Vui lòng thử lại!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký Tài Khoản</title>
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
        .btn-register {
            background: #764ba2;
            border: none;
            border-radius: 0.5rem;
            padding: 0.75rem;
            font-weight: bold;
            width: 100%;
        }
        .btn-register:hover {
            background: #667eea;
        }
        .error-message {
            color: #dc3545;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-user-plus mr-2"></i>Đăng Ký Tài Khoản
            </div>
            <div class="card-body p-5">
                <?php if(isset($error)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="" onsubmit="return validateForm()">
                    <div class="form-group">
                        <label>Mã số sinh viên</label>
                        <input type="text" class="form-control" name="mssv" required
                               pattern="[A-Za-z0-9]+" title="MSSV chỉ được chứa chữ và số">
                    </div>

                    <div class="form-group">
                        <label>Tên đăng nhập</label>
                        <input type="text" class="form-control" name="username" required
                               minlength="3" maxlength="50">
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>

                    <div class="form-group">
                        <label>Số điện thoại</label>
                        <input type="tel" class="form-control" name="mobile" required
                               pattern="[0-9]{10}" title="Số điện thoại phải có 10 chữ số">
                    </div>

                    <div class="form-group">
                        <label>Mật khẩu</label>
                        <input type="password" class="form-control" name="password" id="password" required
                               minlength="6" maxlength="50">
                    </div>

                    <div class="form-group">
                        <label>Xác nhận mật khẩu</label>
                        <input type="password" class="form-control" id="confirm_password" required>
                    </div>

                    <div class="form-group">
                        <label>Địa chỉ</label>
                        <textarea class="form-control" name="address" required rows="3"></textarea>
                    </div>

                    <button type="submit" name="submit" class="btn btn-primary btn-register">
                        <i class="fas fa-user-plus mr-2"></i>Đăng Ký
                    </button>

                    <div class="text-center mt-4">
                        <p>Đã có tài khoản? 
                            <a href="login.php" class="text-primary">Đăng nhập</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    function validateForm() {
        var password = document.getElementById("password").value;
        var confirm_password = document.getElementById("confirm_password").value;

        if (password != confirm_password) {
            alert("Mật khẩu xác nhận không khớp!");
            return false;
        }
        return true;
    }
    </script>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>