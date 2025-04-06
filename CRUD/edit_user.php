<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header('location:login.php');
    }

    include "../CRUD/connect.php"; // Kết nối đến cơ sở dữ liệu

    // Lấy thông tin người dùng cần sửa
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM users WHERE id='$id'";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);
    }

    // Xử lý cập nhật thông tin người dùng
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $mssv = $_POST['mssv'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $mobile = $_POST['mobile'];
        $address = $_POST['address'];

        $sql = "UPDATE users SET mssv='$mssv', username='$username', email='$email', mobile='$mobile', address='$address' WHERE id='$id'";
        $result = mysqli_query($con, $sql);

        if ($result) {
            echo "<script>alert('Cập nhật thông tin người dùng thành công!'); window.location.href='display.php';</script>";
        } else {
            echo "<script>alert('Có lỗi xảy ra: " . mysqli_error($con) . "');</script>";
        }
    }
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <title>Sửa Thông Tin Người Dùng</title>
    <style>
        body {
            background: linear-gradient(135deg, #2c3e50, #3498db);
            font-family: 'Roboto', sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            background: rgba(255, 255, 255, 0.95);
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
            background: linear-gradient(45deg, #e67e22, #f1c40f);
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
    <div class="container mt-5">
        <h1 class="text-center text-primary">Sửa Thông Tin Người Dùng</h1>
        <form method="POST" action="edit_user.php?id=<?php echo $id; ?>" class="mb-4">
            <div class="form-group">
                <label for="mssv">MSSV</label>
                <input type="text" class="form-control" id="mssv" name="mssv" value="<?php echo $row['mssv']; ?>" required>
            </div>
            <div class="form-group">
                <label for="username">Tên đăng nhập</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo $row['username']; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $row['email']; ?>" required>
            </div>
            <div class="form-group">
                <label for="mobile">Số Điện Thoại</label>
                <input type="text" class="form-control" id="mobile" name="mobile" value="<?php echo $row['mobile']; ?>" required>
            </div>
            <div class="form-group">
                <label for="address">Địa Chỉ</label>
                <input type="text" class="form-control" id="address" name="address" value="<?php echo $row['address']; ?>" required>
            </div>
            <button type="submit" class="btn btn-custom w-100">Cập Nhật</button>
        </form>
        <div class="text-center">
            <a href="display.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Quay lại</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>