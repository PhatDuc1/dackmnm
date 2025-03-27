<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header('location:login.php');
    }

    include "../exams/connect.php"; // Kết nối đến cơ sở dữ liệu

    // Get the exam schedule ID from the query string
    if (!isset($_GET['id'])) {
        echo "<script>alert('Không tìm thấy ID lịch thi!'); window.location.href='manage_exam_schedule.php';</script>";
        exit();
    }

    $id = mysqli_real_escape_string($con, $_GET['id']);

    // Fetch the existing exam schedule details
    $sql = "SELECT * FROM exam_schedule WHERE id='$id'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);

    if (!$row) {
        echo "<script>alert('Không tìm thấy lịch thi!'); window.location.href='manage_exam_schedule.php';</script>";
        exit();
    }

    // Handle form submission to update the exam schedule
    if(isset($_POST['update_exam'])){
        $course_code = mysqli_real_escape_string($con, $_POST['course_code']);
        $exam_date = mysqli_real_escape_string($con, $_POST['exam_date']);
        $exam_time = mysqli_real_escape_string($con, $_POST['exam_time']);
        $location = mysqli_real_escape_string($con, $_POST['location']);

        // Kiểm tra xem location có giá trị hợp lệ không
        if (empty($location)) {
            echo "<script>alert('Vui lòng chọn địa điểm!'); window.location.href='edit_exam_schedule.php?id=$id';</script>";
            exit();
        }

        $sql = "UPDATE exam_schedule SET course_code='$course_code', exam_date='$exam_date', exam_time='$exam_time', location='$location' WHERE id='$id'";
        $result = mysqli_query($con, $sql);

        if ($result) {
            echo "<script>alert('Cập nhật lịch thi thành công!'); window.location.href='manage_exam_schedule.php';</script>";
        } else {
            echo "<script>alert('Có lỗi xảy ra: " . mysqli_error($con) . "'); window.location.href='manage_exam_schedule.php';</script>";
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
    <!-- Thêm font Roboto từ Google Fonts để hỗ trợ tiếng Việt -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <title>Sửa Lịch Thi</title>
    <style>
        body {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Roboto', sans-serif;
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
            padding: 6px;
            transition: border-color 0.3s ease;
            font-family: 'Roboto', sans-serif;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"><path fill="%23333" d="M7 10l5 5 5-5z"/></svg>') no-repeat right 10px center;
            background-size: 12px;
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
        <h1 class="text-center">Sửa Lịch Thi</h1>
        <form method="POST" action="edit_exam_schedule.php?id=<?php echo $id; ?>">
            <div class="mb-3">
                <label class="form-label">Mã Môn Học</label>
                <input type="text" class="form-control" name="course_code" value="<?php echo htmlspecialchars($row['course_code']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Ngày Thi</label>
                <input type="date" class="form-control" name="exam_date" value="<?php echo htmlspecialchars($row['exam_date']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Giờ Thi</label>
                <input type="time" class="form-control" name="exam_time" value="<?php echo htmlspecialchars($row['exam_time']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Địa Điểm</label>
                <select class="form-control" name="location" required>
                    <option value="" disabled <?php if(empty($row['location'])) echo 'selected'; ?>>Chọn Địa Điểm</option>
                    <option value="Khu E" <?php if($row['location'] == 'Khu E') echo 'selected'; ?>>Khu E</option>
                    <option value="Khu A,B" <?php if($row['location'] == 'Khu A,B') echo 'selected'; ?>>Khu A,B</option>
                    <option value="Khu U" <?php if($row['location'] == 'Khu U') echo 'selected'; ?>>Khu U</option>
                </select>
            </div>
            <div class="d-flex">
                <button class="btn btn-custom" type="submit" name="update_exam">Cập Nhật Lịch Thi</button>
                <a href="manage_exam_schedule.php" class="btn btn-secondary">Quay lại</a>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j6f3y4Qp9F4h+6U5L0Xbg" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>