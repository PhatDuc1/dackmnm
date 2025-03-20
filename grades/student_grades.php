<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header('location:login.php');
    }

    include "../grades/connect.php"; // Kết nối đến cơ sở dữ liệu

    // Get the student's MSSV from the query string
    $mssv = $_GET['mssv'];

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
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" 
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" 
    crossorigin="anonymous">

    <title>Thông Tin Điểm Sinh Viên</title>
  </head>
  <body>
    <div class="container mt-5">
        <h1 class="text-center">Thông Tin Điểm Sinh Viên <?php echo $mssv; ?></h1>
        <table class="table table-bordered mt-3">
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
        <div class="text-center mt-3">
            <h4>Điểm Trung Bình: <?php echo number_format($avg_grade, 2); ?></h4>
        </div>
        <button class="btn btn-secondary mt-3"><a href="grades.php" class="text-light">Quay lại</a></button>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j6f3y4Qp9F4h+6U5L0Xbg" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>