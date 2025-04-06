<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header('location:login.php');
    }

    include "../grades/connect.php"; // Kết nối đến cơ sở dữ liệu

    // Check if search query is set
    $search_query = "";
    if(isset($_GET['search'])){
        $search_query = $_GET['search'];
    }

    // Truy vấn để lấy thông tin điểm của sinh viên
    $username = $_SESSION['username'];
    $sql = "SELECT * FROM grades WHERE username='$username' AND (mssv LIKE '%$search_query%' OR ho_ten LIKE '%$search_query%' OR subject LIKE '%$search_query%')";
    $result = mysqli_query($con, $sql);
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
    <title>Thông Tin Điểm</title>
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
        .search-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 5px;
            margin-bottom: 25px;
        }
        .search-container .form-control {
            border-radius: 20px 0 0 20px;
            border: 1px solid #ddd;
            padding: 10px;
            width: 300px;
        }
        .search-container .btn-primary {
            border-radius: 0 20px 20px 0;
            margin-left: -1px;
            background-color: #3498db;
            border: none;
            font-weight: bold;
        }
        .search-container .btn-primary:hover {
            background-color: #2980b9;
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
        .btn-warning {
            background-color: #f1c40f;
            border: none;
            color: #fff;
            padding: 8px 15px;
            border-radius: 20px;
        }
        .btn-warning:hover {
            background-color: #d4ac0d;
        }
        .btn-danger {
            background-color: #e74c3c;
            border: none;
            padding: 8px 15px;
            border-radius: 20px;
        }
        .btn-danger:hover {
            background-color: #c0392b;
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
            .search-container .form-control {
                width: 100%;
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
        <h1>Thông Tin Điểm</h1>
        <div class="search-container">
            <form class="d-flex" method="GET" action="grades.php">
                <input class="form-control" type="search" placeholder="Tìm kiếm" aria-label="Search" name="search" value="<?php echo $search_query; ?>">
                <button class="btn btn-primary btn-custom" type="submit">Tìm kiếm</button>
            </form>
        </div>
        <div class="button-group">
            <button class="btn btn-primary btn-custom"><a href="add_grades.php" class="text-light text-decoration-none">Thêm Điểm</a></button>
            <button class="btn btn-secondary btn-custom"><a href="../signup1/admin_home.php" class="text-light text-decoration-none"><i class="fas fa-arrow-left"></i> Quay lại</a></button>
        </div>
        <table class="table mt-3">
            <thead>
                <tr>
                    <th scope="col">STT</th>
                    <th scope="col">MSSV</th>
                    <th scope="col">Họ Tên</th>
                    <th scope="col">Môn Học</th>
                    <th scope="col">Điểm</th>
                    <th scope="col">Xếp Loại</th>
                    <th scope="col">Hành Động</th>
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
                                <td><a href="student_grades.php?mssv='.$row['mssv'].'">'.$row['mssv'].'</a></td>
                                <td>'.$row['ho_ten'].'</td>
                                <td>'.$row['subject'].'</td>
                                <td>'.$row['grade'].'</td>
                                <td>'.$grade_classification.'</td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="edit_grade.php?id='.$row['id'].'" class="btn btn-warning btn-sm btn-custom">Sửa</a>
                                        <a href="delete_grade.php?id='.$row['id'].'" class="btn btn-danger btn-sm btn-custom" onclick="return confirm(\'Bạn có chắc chắn muốn xóa?\')"><i class="fas fa-trash"></i> Xóa</a>
                                    </div>
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