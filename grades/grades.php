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
        <form class="form-inline mb-3" method="GET" action="grades.php">
            <input class="form-control mr-sm-2" type="search" placeholder="Tìm kiếm" aria-label="Search" name="search" value="<?php echo $search_query; ?>">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Tìm kiếm</button>
        </form>
        <button class="btn btn-primary mb-3"><a href="add_grades.php" class="text-light">Thêm Điểm</a></button>
        <table class="table table-bordered mt-3">
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

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j6f3y4Qp9F4h+6U5L0Xbg" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>