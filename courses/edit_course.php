<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header('location:login.php');
    }

    include "../courses/connect.php"; // Kết nối đến cơ sở dữ liệu

    // Lấy thông tin môn học cần sửa
    if (isset($_GET['id'])) {
        $id =mysqli_real_escape_string($con, $_GET['id']);
        $sql = "SELECT * FROM courses WHERE id='$id'";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);

        if (!$row) {
            echo "<script>alert('Không tìm thấy môn học!'); window.location.href='manage_courses.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Không tìm thấy ID môn học!'); window.location.href='manage_courses.php';</script>";
        exit();
    }

    // Xử lý cập nhật môn học
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $course_code = mysqli_real_escape_string($con, $_POST['course_code']);
        $course_name = mysqli_real_escape_string($con, $_POST['course_name']);
        $credits = mysqli_real_escape_string($con, $_POST['credits']);

        $sql = "UPDATE courses SET course_code='$course_code', course_name='$course_name', credits='$credits' WHERE id='$id'";
        $result = mysqli_query($con, $sql);

        if ($result) {
            echo "<script>alert('Cập nhật môn học thành công!'); window.location.href='manage_courses.php';</script>";
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
    <title>Sửa Môn Học</title>
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
        <h1 class="text-center">Sửa Môn Học</h1>
        <form method="POST" action="edit_course.php?id=<?php echo $id; ?>">
            <div class="mb-3">
                <label class="form-label">Mã Môn Học</label>
                <input type="text" class="form-control" name="course_code" value="<?php echo htmlspecialchars($row['course_code']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Tên Môn Học</label>
                <input type="text" class="form-control" name="course_name" value="<?php echo htmlspecialchars($row['course_name']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Số Tín Chỉ</label>
                <input type="number" class="form-control" name="credits" value="<?php echo htmlspecialchars($row['credits']); ?>" required>
            </div>
            <div class="d-flex">
                <button class="btn btn-custom" type="submit">Cập Nhật</button>
                <a href="manage_courses.php" class="btn btn-secondary">Quay lại</a>
            </div>
        </form>
    </div>
  </body>
</html>