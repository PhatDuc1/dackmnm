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
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" 
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" 
    crossorigin="anonymous">

    <title>Thông Tin Sinh Viên</title>
  </head>
  <body>
    <div class="container mt-5">
        <h1 class="text-center">Quản Lí Sinh Viên</h1>
        <form class="form-inline mb-3" method="GET" action="display.php">
            <input class="form-control mr-sm-2" type="search" placeholder="Tìm kiếm" aria-label="Search" name="search" value="<?php echo $search_query; ?>">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Tìm kiếm</button>
        </form>
        <button class="btn btn-primary mb-3"><a href="add_student.php" class="text-light">Thêm Sinh Viên</a></button>
        <table class="table table-bordered">
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
                                    <a href="edit_student.php?id='.$row['id'].'" class="btn btn-warning btn-sm">Sửa</a>
                                    <a href="delete_student.php?id='.$row['id'].'" class="btn btn-danger btn-sm" onclick="return confirm(\'Bạn có chắc chắn muốn xóa?\')">Xóa</a>
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