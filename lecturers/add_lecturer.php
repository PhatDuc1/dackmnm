<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header('location:login.php');
    }

    include "../lecturers/connect.php"; // Kết nối đến cơ sở dữ liệu

    // Handle form submission to add a new lecturer
    if(isset($_POST['add_lecturer'])){
        $lecturer_id = $_POST['lecturer_id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $department = $_POST['department'];

        $sql = "INSERT INTO lecturers (lecturer_id, name, email, phone, department) VALUES ('$lecturer_id', '$name', '$email', '$phone', '$department')";
        mysqli_query($con, $sql);

        // Redirect back to manage_lecturers.php after adding the lecturer
        header('location: manage_lecturers.php');
    }
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <title>Thêm Giảng Viên</title>
    <style>
        body {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
        }
        .container {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            max-width: 600px;
            animation: fadeIn 0.5s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        h1 {
            font-size: 2rem;
            font-weight: 600;
            color: #2a5298;
            margin-bottom: 30px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .form-label {
            font-weight: 500;
            color: #333;
        }
        .form-control {
            border-radius: 10px;
            border: 1px solid #ddd;
            padding: 12px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        .form-control:focus {
            border-color: #2a5298;
            box-shadow: 0 0 8px rgba(42, 82, 152, 0.3);
        }
        .btn-custom {
            background: linear-gradient(to right, #2a5298, #1e3c72);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 10px;
            font-weight: 500;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .btn-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(42, 82, 152, 0.4);
        }
        .btn-secondary {
            background: #6c757d;
            border: none;
            padding: 12px 25px;
            border-radius: 10px;
            color: white;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .btn-secondary:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(108, 117, 125, 0.4);
        }
        .mb-3 {
            position: relative;
        }
        .form-control:valid + .form-label {
            color: #2a5298;
        }
    </style>
  </head>
  <body>
    <div class="container">
        <h1 class="text-center">Thêm Giảng Viên</h1>
        <form method="POST" action="add_lecturer.php">
            <div class="mb-3">
                <label class="form-label">Mã Giảng Viên</label>
                <input type="text" class="form-control" name="lecturer_id" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Tên</label>
                <input type="text" class="form-control" name="name" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Số Điện Thoại</label>
                <input type="text" class="form-control" name="phone" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Khoa</label>
                <input type="text" class="form-control" name="department" required>
            </div>
            <div class="d-flex justify-content-between">
                <button class="btn btn-custom" type="submit" name="add_lecturer">Thêm Giảng Viên</button>
                <a href="manage_lecturers.php" class="btn btn-secondary">Quay lại</a>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>