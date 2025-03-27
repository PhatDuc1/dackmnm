<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header('location:login.php');
    }

    include "../CRUD/connect.php"; // Kết nối đến cơ sở dữ liệu

    // Check if search query is set
    $search_query = "";
    if(isset($_GET['search'])){
        $search_query = $_GET['search'];
    }

    // Truy vấn để lấy danh sách sinh viên
    $sql = "SELECT * FROM students WHERE name LIKE '%$search_query%' OR student_id LIKE '%$search_query%'";
    $result = mysqli_query($con, $sql);
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <title>Quản Lí Sinh Viên</title>
    <style>
        body {
            background: linear-gradient(135deg, #2c3e50, #3498db); /* Gradient xanh đậm giống edit_student.php */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .container {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
            max-width: 1000px;
        }
        h1 {
            color: #2c3e50;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
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
        .btn-danger {
            background-color: #e74c3c;
            border: none;
            padding: 8px 15px;
            border-radius: 20px;
        }
        .btn-danger:hover {
            background-color: #c0392b;
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
        }
        .table th {
            background-color: #34495e;
            color: white;
            text-align: center;
        }
        .table td {
            vertical-align: middle;
            text-align: center;
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
        }
        .search-container .btn-primary:hover {
            background-color: #2980b9;
        }
        a.text-light, a.text-decoration-none {
            text-decoration: none;
            color: white;
        }
        .button-group {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
        }
    </style>
  </head>
  <body>
    <div class="container mt-5">
        <h1 class="text-center">Quản Lí Sinh Viên</h1>
        <div class="search-container">
            <form class="d-flex" method="GET" action="display.php">
                <input class="form-control" type="search" placeholder="Tìm kiếm" aria-label="Search" name="search" value="<?php echo $search_query; ?>">
                <button class="btn btn-primary btn-custom" type="submit">Tìm kiếm</button>
            </form>
        </div>
        <div class="button-group">
            <button class="btn btn-primary btn-custom"><a href="add_student.php" class="text-light text-decoration-none">Thêm Sinh Viên</a></button>
            <button class="btn btn-secondary btn-custom"><a href="../signup1/home.php" class="text-light"><i class="fas fa-arrow-left"></i> Quay lại</a></button>
        </div>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th scope="col">STT</th>
                    <th scope="col">Mã Sinh Viên</th>
                    <th scope="col">Tên</th>
                    <th scope="col">Email</th>
                    <th scope="col">Số Điện Thoại</th>
                    <th scope="col">Địa Chỉ</th>
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
                                <td>'.$row['student_id'].'</td>
                                <td>'.$row['name'].'</td>
                                <td>'.$row['email'].'</td>
                                <td>'.$row['phone'].'</td>
                                <td>'.$row['address'].'</td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="edit_student.php?id='.$row['id'].'" class="btn btn-warning btn-sm btn-custom">Sửa</a>
                                        <a href="delete_student.php?id='.$row['id'].'" class="btn btn-danger btn-sm btn-custom" onclick="return confirm(\'Bạn có chắc chắn muốn xóa?\')">Xóa</a>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>