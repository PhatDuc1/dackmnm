<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header('location:login.php');
    }

    include "../lecturers/connect.php"; // Kết nối đến cơ sở dữ liệu

    // Get the lecturer ID from the query string
    $id = $_GET['id'];

    // Fetch the existing lecturer details
    $sql = "SELECT * FROM lecturers WHERE id='$id'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);

    // Handle form submission to update the lecturer
    if(isset($_POST['update_lecturer'])){
        $lecturer_id = $_POST['lecturer_id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $department = $_POST['department'];

        $sql = "UPDATE lecturers SET lecturer_id='$lecturer_id', name='$name', email='$email', phone='$phone', department='$department' WHERE id='$id'";
        mysqli_query($con, $sql);

        // Redirect back to manage_lecturers.php after updating the lecturer
        header('location: manage_lecturers.php');
    }
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

    <title>Sửa Giảng Viên</title>
  </head>
  <body>
    <div class="container mt-5">
        <h1 class="text-center">Sửa Giảng Viên</h1>
        <form class="form-inline mb-3" method="POST" action="edit_lecturer.php?id=<?php echo $id; ?>">
            <input class="form-control mr-sm-2" type="text" placeholder="Mã Giảng Viên" name="lecturer_id" value="<?php echo $row['lecturer_id']; ?>" required>
            <input class="form-control mr-sm-2" type="text" placeholder="Tên" name="name" value="<?php echo $row['name']; ?>" required>
            <input class="form-control mr-sm-2" type="email" placeholder="Email" name="email" value="<?php echo $row['email']; ?>" required>
            <input class="form-control mr-sm-2" type="text" placeholder="Số Điện Thoại" name="phone" value="<?php echo $row['phone']; ?>" required>
            <input class="form-control mr-sm-2" type="text" placeholder="Khoa" name="department" value="<?php echo $row['department']; ?>" required>
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="update_lecturer">Cập Nhật Giảng Viên</button>
        </form>
        <button class="btn btn-secondary mt-3"><a href="manage_lecturers.php" class="text-light">Quay lại</a></button>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j6f3y4Qp9F4h+6U5L0Xbg" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>