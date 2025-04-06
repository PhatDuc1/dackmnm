<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header('location:../signup1/login.php');
        exit();
    }

    include "../courses/connect.php";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Lấy thông tin từ form
        $username = isset($_POST['username']) ? mysqli_real_escape_string($con, $_POST['username']) : $_SESSION['username'];
        $course_code = mysqli_real_escape_string($con, $_POST['course_code']);

        // Lấy course_id từ course_code
        $sql = "SELECT id FROM courses WHERE course_code = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("s", $course_code);
        $stmt->execute();
        $result = $stmt->get_result();
        $course = $result->fetch_assoc();

        if ($course) {
            $course_id = $course['id'];

            // Xóa đăng ký môn học
            $delete_sql = "DELETE FROM course_registrations WHERE username = ? AND course_id = ?";
            $delete_stmt = $con->prepare($delete_sql);
            $delete_stmt->bind_param("si", $username, $course_id);
            $success = $delete_stmt->execute();

            if ($success) {
                echo "<script>
                    alert('Hủy đăng ký môn học thành công!');
                    window.location.href='../courses/view_registrations.php';
                </script>";
            } else {
                echo "<script>
                    alert('Có lỗi xảy ra khi hủy đăng ký môn học!');
                    window.location.href='../courses/view_registrations.php';
                </script>";
            }
        } else {
            echo "<script>
                alert('Không tìm thấy môn học!');
                window.location.href='../courses/view_registrations.php';
            </script>";
        }
    } else {
        header('location:../courses/view_registrations.php');
        exit();
    }
?>