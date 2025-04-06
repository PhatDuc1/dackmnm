<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header('location:login.php');
    }

    include "../grades/connect.php";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $errors = array();
        
        // Lấy và validate dữ liệu
        $mssv = mysqli_real_escape_string($con, trim($_POST['mssv']));
        $ho_ten = mysqli_real_escape_string($con, trim($_POST['ho_ten']));
        $username = mysqli_real_escape_string($con, trim($_POST['username']));
        $subject = mysqli_real_escape_string($con, trim($_POST['subject']));
        $grade = mysqli_real_escape_string($con, trim($_POST['grade']));

        // Validate họ tên
        if (empty($ho_ten)) {
            $errors[] = "Họ tên không được để trống";
        }

        // Validate điểm số
        if (!is_numeric($grade) || $grade < 0 || $grade > 10) {
            $errors[] = "Điểm phải là số từ 0 đến 10";
        }

        // Kiểm tra xem sinh viên có tồn tại
        $check_student = mysqli_query($con, "SELECT mssv FROM users WHERE mssv = '$mssv'");
        if ($check_student && mysqli_num_rows($check_student) == 0) {
            $errors[] = "<div class='alert alert-warning mt-3 animate__animated animate__fadeIn'>
                            <strong>Thông báo:</strong> Sinh viên với MSSV này không tồn tại trong hệ thống.
                         </div>";
        } elseif (!$check_student) {
            $errors[] = "<div class='alert alert-danger mt-3 animate__animated animate__fadeIn'>
                            <strong>Lỗi:</strong> Lỗi khi kiểm tra sinh viên: " . mysqli_error($con) . "
                         </div>";
        }

        // Kiểm tra xem môn học có tồn tại
        $check_subject = mysqli_query($con, "SELECT * FROM courses WHERE course_name = '$subject'"); // Changed 'subject' to 'course_name'
        if ($check_subject && mysqli_num_rows($check_subject) == 0) {
            $errors[] = "Môn học này không tồn tại trong hệ thống";
        } elseif (!$check_subject) {
            $errors[] = "Lỗi khi kiểm tra môn học: " . mysqli_error($con);
        }

        // Kiểm tra điểm trùng lặp
        $check_grade = mysqli_query($con, "SELECT * FROM grades WHERE mssv = '$mssv' AND subject = '$subject'");
        if ($check_grade && mysqli_num_rows($check_grade) > 0) {
            $errors[] = "Điểm của môn học này đã tồn tại cho sinh viên này";
        } elseif (!$check_grade) {
            $errors[] = "Lỗi khi kiểm tra điểm: " . mysqli_error($con);
        }

        if (empty($errors)) {
            $sql = "INSERT INTO grades (mssv, ho_ten, username, subject, grade) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, "ssssd", $mssv, $ho_ten, $username, $subject, $grade);
            
            if (mysqli_stmt_execute($stmt)) {
                echo "<script>
                    alert('Thêm điểm thành công!');
                    window.location.href='grades.php';
                </script>";
            } else {
                $errors[] = "Lỗi khi thêm điểm: " . mysqli_error($con);
            }
            mysqli_stmt_close($stmt);
        }

        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo $error;
            }
        }
    }

    // Lấy danh sách môn học cho dropdown
    $subjects = array();
    $result = mysqli_query($con, "SELECT course_name FROM courses"); // Changed 'subject' to 'course_name'
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $subjects[] = $row['course_name']; // Changed 'subject' to 'course_name'
        }
        mysqli_free_result($result);
    } else {
        echo "<div class='alert alert-danger mt-3'>Lỗi khi lấy danh sách môn học: " . mysqli_error($con) . "</div>";
    }
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <title>Thêm Điểm</title>
    <style>
        body {
            background: linear-gradient(135deg, #1e3c72, #2a5298); /* Gradient giống edit_lecturer.php */
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
            text-align: center;
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
        .d-flex {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }
        a.text-light {
            text-decoration: none;
            color: white;
        }
        @media (max-width: 576px) {
            .container {
                padding: 20px;
            }
            h1 {
                font-size: 1.5rem;
            }
            .d-flex {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
  </head>
  <body>
    <div class="container animate__animated animate__fadeIn">
        <h1 class="text-center animate__animated animate__bounceIn">Thêm Điểm</h1>
        <form method="POST" action="add_grades.php" id="gradeForm" novalidate>
            <div class="mb-3">
                <label class="form-label">MSSV</label>
                <input type="text" class="form-control" name="mssv" id="mssv" required
                       value="<?php echo isset($_POST['mssv']) ? htmlspecialchars($_POST['mssv']) : ''; ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Họ Tên</label>
                <input type="text" class="form-control" name="ho_ten" id="ho_ten" required
                       value="<?php echo isset($_POST['ho_ten']) ? htmlspecialchars($_POST['ho_ten']) : ''; ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Vai Trò</label>
                <input type="text" class="form-controls" name="username" id="username" required readonly
                       value="<?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : ''; ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Môn Học</label>
                <select class="form-control" name="subject" id="subject" required>
                    <option value="">Chọn môn học</option>
                    <?php if (!empty($subjects)): ?>
                        <?php foreach ($subjects as $course_name): ?>
                        <option value="<?php echo htmlspecialchars($course_name); ?>"
                                <?php echo (isset($_POST['subject']) && $_POST['subject'] == $course_name) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($course_name); ?>
                        </option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="" disabled>Không có môn học nào</option>
                    <?php endif; ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Điểm (0-10)</label>
                <input type="number" class="form-control" name="grade" id="grade" required step="0.1" min="0" max="10"
                       placeholder="Nhập điểm từ 0 đến 10"
                       value="<?php echo isset($_POST['grade']) ? htmlspecialchars($_POST['grade']) : ''; ?>">
            </div>
            <div class="d-flex">
                <button class="btn btn-custom animate__animated animate__pulse" type="submit">Thêm Điểm</button>
                <a href="grades.php" class="btn btn-secondary">Quay lại</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('gradeForm');
            const inputs = form.querySelectorAll('input[required], select[required]');
            
            // Validate form khi submit
            form.addEventListener('submit', function(e) {
                let isValid = true;

                // Validate điểm
                const grade = document.getElementById('grade');
                const gradeValue = parseFloat(grade.value);
                if (isNaN(gradeValue) || gradeValue < 0 || gradeValue > 10) {
                    showError(grade, 'Điểm phải là số từ 0 đến 10');
                    isValid = false;
                } else {
                    showSuccess(grade);
                }

                // Validate môn học
                const subject = document.getElementById('subject');
                if (!subject.value) {
                    showError(subject, 'Vui lòng chọn môn học');
                    isValid = false;
                } else {
                    showSuccess(subject);
                }

                if (!isValid) {
                    e.preventDefault();
                }
            });

            // Hiển thị lỗi
            function showError(input, message) {
                const formGroup = input.parentElement;
                const errorDiv = formGroup.querySelector('.error-message') || document.createElement('div');
                errorDiv.className = 'error-message text-danger mt-1 animate__animated animate__fadeIn';
                errorDiv.textContent = message;
                if (!formGroup.querySelector('.error-message')) {
                    formGroup.appendChild(errorDiv);
                }
                input.classList.add('is-invalid');
                input.classList.remove('is-valid');
            }

            // Hiển thị thành công
            function showSuccess(input) {
                const formGroup = input.parentElement;
                const errorDiv = formGroup.querySelector('.error-message');
                if (errorDiv) {
                    errorDiv.remove();
                }
                input.classList.remove('is-invalid');
                input.classList.add('is-valid');
            }

            // Validate realtime
            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    if (this.id === 'grade') {
                        const value = parseFloat(this.value);
                        if (isNaN(value) || value < 0 || value > 10) {
                            showError(this, 'Điểm phải là số từ 0 đến 10');
                        } else {
                            showSuccess(this);
                        }
                    } else if (this.id === 'subject' && !this.value) {
                        showError(this, 'Vui lòng chọn môn học');
                    } else {
                        showSuccess(this);
                    }
                });
            });
        });
    </script>
  </body>
</html>