<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header('location:login.php');
    }

    include "../CRUD/connect.php"; // Kết nối đến cơ sở dữ liệu

    // Xử lý thêm sinh viên
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $errors = array();
        
        // Lấy và validate dữ liệu
        $mssv = mysqli_real_escape_string($con, trim($_POST['mssv']));
        $username = mysqli_real_escape_string($con, trim($_POST['username']));
        $email = mysqli_real_escape_string($con, trim($_POST['email']));
        $mobile = mysqli_real_escape_string($con, trim($_POST['mobile']));
        $address = mysqli_real_escape_string($con, trim($_POST['address']));

        // Validate MSSV
        if (!preg_match("/^\d{8}$/", $mssv)) {
            $errors[] = "MSSV phải có đúng 8 chữ số";
        }

        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email không hợp lệ";
        }

        // Validate số điện thoại
        if (!preg_match("/^[0-9]{10}$/", $mobile)) {
            $errors[] = "Số điện thoại phải có 10 chữ số";
        }

        // Kiểm tra trùng lặp MSSV
        $check_mssv = mysqli_query($con, "SELECT mssv FROM users WHERE mssv = '$mssv'");
        if (mysqli_num_rows($check_mssv) > 0) {
            $errors[] = "MSSV đã tồn tại trong hệ thống";
        }

        // Kiểm tra trùng lặp email
        $check_email = mysqli_query($con, "SELECT email FROM users WHERE email = '$email'");
        if (mysqli_num_rows($check_email) > 0) {
            $errors[] = "Email đã được sử dụng";
        }

        if (empty($errors)) {
            // Tạo mật khẩu mặc định là "123456"
            $default_password = password_hash("123456", PASSWORD_DEFAULT);
            $role = 'user'; // Đặt role mặc định là user

            $sql = "INSERT INTO users (mssv, username, email, mobile, address, password, role)
                   VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, "sssssss", $mssv, $username, $email, $mobile, $address, $default_password, $role);
            
            if (mysqli_stmt_execute($stmt)) {
                echo "<script>
                    alert('Thêm người dùng thành công!');
                    window.location.href='display.php';
                </script>";
            } else {
                $errors[] = "Lỗi khi thêm người dùng: " . mysqli_error($con);
            }
            mysqli_stmt_close($stmt);
        }

        if (!empty($errors)) {
            echo "<div class='alert alert-danger mt-3'>";
            foreach ($errors as $error) {
                echo "<p class='mb-0'>$error</p>";
            }
            echo "</div>";
        }
    }
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <title>Thêm Người Dùng</title>
    <style>
        body {
            background: linear-gradient(135deg, #2c3e50, #3498db); /* Gradient xanh đậm */
            font-family: 'Roboto', sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            background: rgba(255, 255, 255, 0.95); /* Nền trắng mờ nhẹ */
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
            max-width: 600px;
            transition: transform 0.3s ease;
        }
        .container:hover {
            transform: translateY(-5px);
        }
        h1.text-primary {
            color: #3498db !important;
            font-weight: 700;
            margin-bottom: 30px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            color: #2c3e50;
            font-weight: 500;
            margin-bottom: 8px;
        }
        .form-control {
            border-radius: 10px;
            border: 1px solid #ddd;
            padding: 12px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 8px rgba(52, 152, 219, 0.4);
        }
        .btn-custom {
            background: linear-gradient(45deg, #e67e22, #f1c40f); /* Gradient cam-vàng mới */
            color: white;
            border: none;
            padding: 12px;
            border-radius: 25px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .btn-custom:hover {
            background: linear-gradient(45deg, #d35400, #f39c12);
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(230, 126, 34, 0.5);
        }
        .btn-secondary {
            background: linear-gradient(45deg, #7f8c8d, #95a5a6);
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-secondary:hover {
            background: linear-gradient(45deg, #6c757d, #839192);
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(127, 140, 141, 0.5);
        }
        a.text-light {
            color: white;
            text-decoration: none;
        }
    </style>
  </head>
  <body>
    <div class="container mt-5 animate__animated animate__fadeIn">
        <h1 class="text-center text-primary animate__animated animate__bounceIn">Thêm Người Dùng</h1>
        <form method="POST" action="add_user.php" class="mb-4" id="userForm" novalidate>
            <div class="form-group">
                <label for="mssv">MSSV</label>
                <input type="text" class="form-control" id="mssv" name="mssv" required>
            </div>
            <div class="form-group">
                <label for="username">Tên đăng nhập</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="mobile">Số điện thoại</label>
                <input type="text" class="form-control" id="mobile" name="mobile" required>
            </div>
            <div class="form-group">
                <label for="address">Địa chỉ</label>
                <input type="text" class="form-control" id="address" name="address" required>
            </div>
            <button type="submit" class="btn btn-custom w-100">Thêm Người Dùng</button>
        </form>
        <div class="text-center">
            <a href="display.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Quay lại</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('userForm');
            const inputs = form.querySelectorAll('input[required]');
            
            // Hiển thị giá trị cũ nếu có lỗi
            <?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($errors)): ?>
            document.getElementById('mssv').value = '<?php echo htmlspecialchars($mssv); ?>';
            document.getElementById('username').value = '<?php echo htmlspecialchars($username); ?>';
            document.getElementById('email').value = '<?php echo htmlspecialchars($email); ?>';
            document.getElementById('mobile').value = '<?php echo htmlspecialchars($mobile); ?>';
            document.getElementById('address').value = '<?php echo htmlspecialchars($address); ?>';
            <?php endif; ?>

            // Validate form khi submit
            form.addEventListener('submit', function(e) {
                let isValid = true;
                
                // Validate MSSV
                const mssv = document.getElementById('mssv');
                if (!/^\d{8}$/.test(mssv.value)) {
                    showError(mssv, 'MSSV phải có đúng 8 chữ số');
                    isValid = false;
                } else {
                    showSuccess(mssv);
                }

                // Validate email
                const email = document.getElementById('email');
                if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
                    showError(email, 'Email không hợp lệ');
                    isValid = false;
                } else {
                    showSuccess(email);
                }

                // Validate số điện thoại
                const mobile = document.getElementById('mobile');
                if (!/^[0-9]{10}$/.test(mobile.value)) {
                    showError(mobile, 'Số điện thoại phải có 10 chữ số');
                    isValid = false;
                } else {
                    showSuccess(mobile);
                }

                if (!isValid) {
                    e.preventDefault();
                }
            });

            // Hiển thị lỗi
            function showError(input, message) {
                const formGroup = input.parentElement;
                const errorDiv = formGroup.querySelector('.error-message') || document.createElement('div');
                errorDiv.className = 'error-message text-danger mt-1 animate__animated animate__fadeIn';
                errorDiv.textContent = message;
                if (!formGroup.querySelector('.error-message')) {
                    formGroup.appendChild(errorDiv);
                }
                input.classList.add('is-invalid');
                input.classList.remove('is-valid');
            }

            // Hiển thị thành công
            function showSuccess(input) {
                const formGroup = input.parentElement;
                const errorDiv = formGroup.querySelector('.error-message');
                if (errorDiv) {
                    errorDiv.remove();
                }
                input.classList.remove('is-invalid');
                input.classList.add('is-valid');
            }

            // Validate realtime khi nhập
            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    if (this.value.trim() !== '') {
                        if (this.id === 'mssv' && !/^\d{8}$/.test(this.value)) {
                            showError(this, 'MSSV phải có đúng 8 chữ số');
                        } else if (this.id === 'email' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.value)) {
                            showError(this, 'Email không hợp lệ');
                        } else if (this.id === 'mobile' && !/^[0-9]{10}$/.test(this.value)) {
                            showError(this, 'Số điện thoại phải có 10 chữ số');
                        } else {
                            showSuccess(this);
                        }
                    }
                });
            });
        });
    </script>
  </body>
</html>