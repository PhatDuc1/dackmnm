<?php
    session_start();
    if(!isset($_SESSION['username']) || !isset($_SESSION['mssv'])){
        header('location:../signup1/login.php');
        exit();
    }

    // Lấy MSSV từ GET hoặc từ session nếu không có GET
    $mssv = isset($_GET['mssv']) ? $_GET['mssv'] : $_SESSION['mssv'];

    // Kiểm tra xem sinh viên chỉ xem được điểm của chính mình
    if($_SESSION['role'] == 'user' && $_SESSION['mssv'] != $mssv) {
        echo "<script>alert('Bạn không có quyền xem điểm của sinh viên khác!'); window.location.href='../users/user_home.php';</script>";
        exit();
    }

    include "../grades/connect.php"; // Kết nối đến cơ sở dữ liệu

    $mssv = mysqli_real_escape_string($con, $mssv);

    // Truy vấn để lấy thông tin điểm của sinh viên
    $sql = "SELECT * FROM grades WHERE mssv='$mssv'";
    $result = mysqli_query($con, $sql);

    // Truy vấn để tính điểm trung bình của sinh viên
    $avg_sql = "SELECT AVG(grade) as avg_grade FROM grades WHERE mssv='$mssv'";
    $avg_result = mysqli_query($con, $avg_sql);
    $avg_row = mysqli_fetch_assoc($avg_result);
    $avg_grade = $avg_row['avg_grade'];
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <title>Thông Tin Điểm Sinh Viên</title>
    <style>
        body {
            background: linear-gradient(135deg, #2c3e50, #3498db); /* Gradient giống manage_lecturers.php */
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
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
        .btn-custom {
            transition: all 0.3s ease;
        }
        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }
        .btn-secondary {
            background-color: #7f8c8d;
            border: none;
            padding: 10px 20px;
            border-radius: 20px;
            font-weight: bold;
            display: block;
            margin: 0 auto;
        }
        .btn-secondary:hover {
            background-color: #6c757d;
        }
        a.text-light {
            text-decoration: none;
            color: white;
        }
        .text-center h4 {
            color: #2c3e50;
            font-weight: 600;
            background: #e9ecef;
            padding: 10px;
            border-radius: 8px;
            display: inline-block;
            margin-top: 20px;
        }
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }
            h1 {
                font-size: 1.5rem;
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
        <h1 class="text-center">Thông Tin Điểm Sinh Viên</h1>
        <table class="table mt-3">
            <thead>
                <tr>
                    <th scope="col">STT</th>
                    <th scope="col">MSSV</th>
                    <th scope="col">Họ Tên</th>
                    <th scope="col">Môn Học</th>
                    <th scope="col">Điểm</th>
                    <th scope="col">Xếp Loại</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if($result){
                    $stt = 1;
                    while($row = mysqli_fetch_assoc($result)){
                        // Classify the grade
                        $grade_classification = '';
                        if ($row['grade'] >= 9) {
                            $grade_classification = 'A';
                        } elseif ($row['grade'] >= 8) {
                            $grade_classification = 'B';
                        } elseif ($row['grade'] >= 7) {
                            $grade_classification = 'C';
                        } elseif ($row['grade'] >= 4) {
                            $grade_classification = 'D';
                        } else {
                            $grade_classification = 'F';
                        }

                        echo '<tr>
                                <th scope="row">'.$stt.'</th>
                                <td>'.$row['mssv'].'</td>
                                <td>'.$row['ho_ten'].'</td>
                                <td>'.$row['subject'].'</td>
                                <td>'.$row['grade'].'</td>
                                <td>'.$grade_classification.'</td>
                              </tr>';
                        $stt++;
                    }
                }
                ?>
            </tbody>
        </table>
        <div class="text-center">
            <h4>Điểm Trung Bình: <?php echo number_format($avg_grade, 2); ?></h4>
        </div>
        <button class="btn btn-secondary btn-custom mt-3"><a href="../users/user_home.php" class="text-light"><i class="fas fa-arrow-left"></i> Quay lại</a></button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>