<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header('location:login.php');
    }

    include "../grades/connect.php"; // Kết nối đến cơ sở dữ liệu

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM grades WHERE id='$id'";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $mssv = $_POST['mssv'];
        $ho_ten = $_POST['ho_ten'];
        $username = $_POST['username'];
        $subject = $_POST['subject'];
        $grade = $_POST['grade'];

        $sql = "UPDATE grades SET mssv='$mssv', ho_ten='$ho_ten', username='$username', subject='$subject', grade='$grade' WHERE id='$id'";
        $result = mysqli_query($con, $sql);

        if ($result) {
            echo "<script>alert('Cập nhật điểm thành công!'); window.location.href='grades.php';</script>";
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" 
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" 
    crossorigin="anonymous">
    <title>Sửa Điểm</title>
    <style>
        body {
            background: linear-gradient(135deg, #1e3c72, #2a5298); /* Gradient giống edit_lecturer.php */
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', sans-serif;
        }
        .container {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            max-width: 600px;
            margin: 20px;
        }
        h1 {
            font-size: 2rem;
            color: #2a5298;
            margin-bottom: 30px;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-align: center;
        }
        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }
        .form-control {
            border: 2px solid #ddd;
            border-radius: 10px;
            padding: 12px;
            transition: border-color 0.3s ease;
        }
        .form-control:focus {
            border-color: #2a5298;
            box-shadow: 0 0 5px rgba(42, 82, 152, 0.3);
            outline: none;
        }
        .btn-custom {
            background: linear-gradient(45deg, #2a5298, #1e3c72);
            border: none;
            padding: 12px 24px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .btn-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(42, 82, 152, 0.4);
        }
        .btn-secondary {
            background: #6c757d;
            border: none;
            padding: 12px 24px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: transform 0.3s ease;
        }
        .btn-secondary:hover {
            transform: translateY(-3px);
            background: #5a6268;
        }
        .mb-3 {
            margin-bottom: 20px !important;
        }
        .d-flex {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }
        a.text-light {
            text-decoration: none;
            color: white;
        }
        @media (max-width: 576px) {
            .container {
                padding: 20px;
            }
            h1 {
                font-size: 1.5rem;
            }
            .d-flex {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
  </head>
  <body>
    <div class="container">
        <h1 class="text-center">Sửa Điểm</h1>
        <form method="POST" action="edit_grade.php?id=<?php echo $id; ?>">
            <div class="mb-3">
                <label class="form-label">MSSV</label>
                <input type="text" class="form-control" name="mssv" value="<?php echo $row['mssv']; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Họ Tên</label>
                <input type="text" class="form-control" name="ho_ten" value="<?php echo $row['ho_ten']; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Vai Trò</label>
                <input type="text" class="form-control" name="username" value="<?php echo $row['username']; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Môn Học</label>
                <input type="text" class="form-control" name="subject" value="<?php echo $row['subject']; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Điểm</label>
                <input type="text" class="form-control" name="grade" value="<?php echo $row['grade']; ?>" required>
            </div>
            <div class="d-flex">
                <button class="btn btn-custom" type="submit">Cập Nhật</button>
                <a href="grades.php" class="btn btn-secondary">Quay lại</a>
            </div>
        </form>
    </div>
  </body>
</html>