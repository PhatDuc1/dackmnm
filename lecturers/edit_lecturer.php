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
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
        <title>Sửa Giảng Viên</title>
        <style>
            body {
                background: linear-gradient(135deg, #1e3c72, #2a5298);
                min-height: 100vh;
                display: flex;
                justify-content: center;
                align-items: center;
                font-family: 'Segoe UI', sans-serif;
            }
            .container {
                background: rgba(255, 255, 255, 0.95);
                padding: 40px;
                border-radius: 20px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
                max-width: 600px;
                margin: 20px;
            }
            h1 {
                font-size: 2rem;
                color: #2a5298;
                margin-bottom: 30px;
                text-transform: uppercase;
                letter-spacing: 1px;
            }
            .form-label {
                font-weight: 600;
                color: #333;
                margin-bottom: 8px;
            }
            .form-control {
                border: 2px solid #ddd;
                border-radius: 10px;
                padding: 12px;
                transition: border-color 0.3s ease;
            }
            .form-control:focus {
                border-color: #2a5298;
                box-shadow: 0 0 5px rgba(42, 82, 152, 0.3);
                outline: none;
            }
            .btn-custom {
                background: linear-gradient(45deg, #2a5298, #1e3c72);
                border: none;
                padding: 12px 24px;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 1px;
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }
            .btn-custom:hover {
                transform: translateY(-3px);
                box-shadow: 0 5px 15px rgba(42, 82, 152, 0.4);
            }
            .btn-secondary {
                background: #6c757d;
                border: none;
                padding: 12px 24px;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 1px;
                transition: transform 0.3s ease;
            }
            .btn-secondary:hover {
                transform: translateY(-3px);
                background: #5a6268;
            }
            .mb-3 {
                margin-bottom: 20px !important;
            }
            @media (max-width: 576px) {
                .container {
                    padding: 20px;
                }
                h1 {
                    font-size: 1.5rem;
                }
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1 class="text-center">Sửa Giảng Viên</h1>
            <form method="POST" action="edit_lecturer.php?id=<?php echo $id; ?>">
                <div class="mb-3">
                    <label class="form-label">Mã Giảng Viên</label>
                    <input type="text" class="form-control" name="lecturer_id" value="<?php echo $row['lecturer_id']; ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tên</label>
                    <input type="text" class="form-control" name="name" value="<?php echo $row['name']; ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" value="<?php echo $row['email']; ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Số Điện Thoại</label>
                    <input type="text" class="form-control" name="phone" value="<?php echo $row['phone']; ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Khoa</label>
                    <input type="text" class="form-control" name="department" value="<?php echo $row['department']; ?>" required>
                </div>
                <div class="d-flex justify-content-between">
                    <button class="btn btn-custom" type="submit" name="update_lecturer">Cập Nhật</button>
                    <a href="manage_lecturers.php" class="btn btn-secondary">Quay lại</a>
                </div>
            </form>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>