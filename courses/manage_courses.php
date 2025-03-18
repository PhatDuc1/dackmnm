<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header('location:login.php');
    }

    include "../courses/connect.php"; // Kết nối đến cơ sở dữ liệu

    // Truy vấn để lấy danh sách môn học
    $sql = "SELECT * FROM courses";
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

    <title>Quản Lý Môn Học</title>
  </head>
  <body>
    <div class="container mt-5">
        <h1 class="text-center">Quản Lý Môn Học</h1>
        <button class="btn btn-primary mb-3"><a href="add_course.php" class="text-light">Thêm Môn Học</a></button>
        <table class="table table-bordered">
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
                                    <a href="edit_course.php?id='.$row['id'].'" class="btn btn-warning btn-sm">Sửa</a>
                                    <a href="delete_course.php?id='.$row['id'].'" class="btn btn-danger btn-sm" onclick="return confirm(\'Bạn có chắc chắn muốn xóa?\')">Xóa</a>
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