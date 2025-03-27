<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header('location:login.php');
    }

    include "../courses/connect.php"; // Kết nối đến cơ sở dữ liệu

    // Lấy danh sách môn học từ bảng courses
    $sql = "SELECT * FROM courses";
    $result = mysqli_query($con, $sql);

    // Xử lý đăng ký môn học
    if (isset($_POST['register_course'])) {
        $username = mysqli_real_escape_string($con, $_SESSION['username']);
        $course_id = mysqli_real_escape_string($con, $_POST['course_id']);

        // Kiểm tra xem sinh viên đã đăng ký môn học này chưa
        $check_sql = "SELECT * FROM course_registrations WHERE username='$username' AND course_id='$course_id'";
        $check_result = mysqli_query($con, $check_sql);

        if (mysqli_num_rows($check_result) > 0) {
            echo "<script>alert('Bạn đã đăng ký môn học này rồi!');</script>";
        } else {
            // Thêm thông tin đăng ký vào bảng course_registrations
            $insert_sql = "INSERT INTO course_registrations (username, course_id) VALUES ('$username', '$course_id')";
            $insert_result = mysqli_query($con, $insert_sql);

            if ($insert_result) {
                echo "<script>alert('Đăng ký môn học thành công!');</script>";
            } else {
                echo "<script>alert('Có lỗi xảy ra: " . mysqli_error($con) . "');</script>";
            }
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
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <!-- Thêm font Roboto từ Google Fonts để hỗ trợ tiếng Việt -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <title>Đăng Ký Môn Học</title>
    <style>
        body {
            background: linear-gradient(135deg, #2c3e50, #3498db); /* Gradient giống manage_courses.php */
            min-height: 100vh;
            font-family: 'Roboto', sans-serif;
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
            max-width: 1000px;
        }
        h1 {
            color: #2c3e50;
            font-weight: 700;
            text-align: center;
            margin-bottom: 20px;
        }
        .button-group {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
        }
        .btn-custom {
            transition: all 0.3s ease;
        }
        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }
        .btn-primary {
            background-color: #3498db;
            border: none;
            padding: 10px 20px;
            border-radius: 20px;
            font-weight: bold;
        }
        .btn-primary:hover {
            background-color: #2980b9;
        }
        .btn-secondary {
            background-color: #7f8c8d;
            border: none;
            padding: 10px 20px;
            border-radius: 20px;
            font-weight: bold;
        }
        .btn-secondary:hover {
            background-color: #6c757d;
        }
        .table {
            border-radius: 5px;
            overflow: hidden;
            background: #fff;
        }
        .table th {
            background: #34495e;
            color: white;
            text-align: center;
            padding: 12px;
            font-weight: 500;
        }
        .table td {
            vertical-align: middle;
            text-align: center;
            padding: 12px;
        }
        .table tbody tr {
            border-bottom: 1px solid #e9ecef;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
        }
        a.text-light, a.text-decoration-none {
            text-decoration: none;
            color: white;
        }
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }
            h1 {
                font-size: 1.5rem;
            }
            .button-group {
                flex-direction: column;
                gap: 10px;
            }
            .table th, .table td {
                font-size: 14px;
                padding: 8px;
            }
        }
    </style>
  </head>
  <body>
    <div class="container">
        <h1>Đăng Ký Môn Học</h1>
        <div class="button-group">
            <button class="btn btn-secondary btn-custom">
                <a href="../signup1/home.php" class="text-light text-decoration-none"><i class="fas fa-arrow-left"></i> Quay lại</a>
            </button>
        </div>
        <table class="table mt-3">
            <thead>
                <tr>
                    <th scope="col">STT</th>
                    <th scope="col">Mã Môn Học</th>
                    <th scope="col">Tên Môn Học</th>
                    <th scope="col">Số Tín Chỉ</th>
                    <th scope="col">Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if($result){
                    $stt = 1;
                    while($row = mysqli_fetch_assoc($result)){
                        echo '<tr>
                                <th scope="row">'.$stt.'</th>
                                <td>'.$row['course_code'].'</td>
                                <td>'.$row['course_name'].'</td>
                                <td>'.$row['credits'].'</td>
                                <td>
                                    <form method="POST" action="register_course.php">
                                        <input type="hidden" name="course_id" value="'.$row['id'].'">
                                        <button type="submit" name="register_course" class="btn btn-primary btn-sm btn-custom">Đăng Ký</button>
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

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j6f3y4Qp9F4h+6U5L0Xbg" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>