<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header('location:../signup1/login.php');
    }

    include "connect.php";

    // Check if search query is set
    $search_query = "";
    if(isset($_GET['search'])){
        $search_query = mysqli_real_escape_string($con, $_GET['search']);
    }

    // Truy vấn để lấy danh sách môn học
    $sql = "SELECT * FROM courses WHERE course_code LIKE '%$search_query%' OR course_name LIKE '%$search_query%'";
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
    <title>Danh Sách Môn Học</title>
    <style>
        body {
            background: linear-gradient(135deg, #2c3e50, #3498db);
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
        .btn-secondary {
            background-color: #7f8c8d;
            border: none;
            padding: 10px 20px;
            border-radius: 20px;
            font-weight: bold;
            margin-bottom: 20px;
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
        a.text-light {
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
            .table th, .table td {
                font-size: 14px;
                padding: 8px;
            }
        }
    </style>
  </head>
  <body>
    <div class="container">
        <h1>Danh Sách Môn Học</h1>
        <div class="search-container">
            <form class="d-flex" method="GET" action="view_courses.php">
                <input class="form-control" type="search" placeholder="Tìm kiếm" aria-label="Search" name="search" value="<?php echo htmlspecialchars($search_query); ?>">
                <button class="btn btn-primary" type="submit">Tìm kiếm</button>
            </form>
        </div>
        <div class="text-center">
            <button class="btn btn-secondary"><a href="../users/register_course.php" class="text-light"><i class="fas fa-arrow-left"></i> Quay lại</a></button>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">STT</th>
                    <th scope="col">Mã Môn Học</th>
                    <th scope="col">Tên Môn Học</th>
                    <th scope="col">Số Tín Chỉ</th>
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