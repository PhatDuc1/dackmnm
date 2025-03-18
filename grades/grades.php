<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header('location:login.php');
    }

    include "../grades/connect.php"; // Kết nối đến cơ sở dữ liệu

    // Truy vấn để lấy thông tin điểm của sinh viên
    $username = $_SESSION['username'];
    $sql = "SELECT * FROM grades WHERE username='$username'";
    $result = mysqli_query($con, $sql);
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" 
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" 
    crossorigin="anonymous">

    <title>Thông Tin Điểm</title>
  </head>
  <body>
    <div class="container mt-5">
        <h1 class="text-center">Thông Tin Điểm</h1>
        <button class="btn btn-primary mb-3"><a href="add_grades.php" class="text-light">Thêm Điểm</a></button>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th scope="col">STT</th>
                    <th scope="col">MSSV</th>
                    <th scope="col">Họ Tên</th>
                    <th scope="col">Môn Học</th>
                    <th scope="col">Điểm</th>
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
                                <td>'.$row['mssv'].'</td>
                                <td>'.$row['ho_ten'].'</td>
                                <td>'.$row['subject'].'</td>
                                <td>'.$row['grade'].'</td>
                                <td>
                                    <a href="edit_grade.php?id='.$row['id'].'" class="btn btn-warning btn-sm">Sửa</a>
                                    <a href="delete_grade.php?id='.$row['id'].'" class="btn btn-danger btn-sm" onclick="return confirm(\'Bạn có chắc chắn muốn xóa?\')">Xóa</a>
                                </td>
                              </tr>';
                        $stt++;
                    }
                }
                ?>
            </tbody>
        </table>
        <button class="btn btn-secondary mt-3"><a href="../signup1/home.php" class="text-light">Quay lại</a></button>
    </div>
  </body>
</html>