<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'user') {
    header('location:access_denied.php');
    exit();
}

// Ensure the correct path to connect.php
require_once 'connect.php';
$conn = $con; // Gán biến $con từ connect.php cho $conn

if (!isset($conn)) {
    die("Database connection failed. Please check the connect.php file.");
}

// Lấy danh sách môn học đã đăng ký của user
$username = $_SESSION['username'];
$registered_courses_query = "SELECT course_id FROM course_registrations WHERE username = ?";
$stmt = $conn->prepare($registered_courses_query);
$stmt->bind_param("s", $username);
$stmt->execute();
$registered_result = $stmt->get_result();

$registered_courses = array();
while ($row = $registered_result->fetch_assoc()) {
    $registered_courses[] = $row['course_id'];
}
// Get search keyword
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// Fetch courses from the database with search
if ($search !== '') {
    $query = "SELECT * FROM courses WHERE course_code LIKE ? OR course_name LIKE ?";
    $stmt = $conn->prepare($query);
    $searchTerm = "%$search%";
    $stmt->bind_param("ss", $searchTerm, $searchTerm);
} else {
    $query = "SELECT * FROM courses";
    $stmt = $conn->prepare($query);
}

$stmt->execute();
$result = $stmt->get_result();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle course registration
    $selected_courses = $_POST['courses'] ?? [];
    $username = $_SESSION['username'];

    // Validate selected courses
    if (!is_array($selected_courses) || !array_filter($selected_courses, 'is_numeric')) {
        $_SESSION['error_message'] = "Dữ liệu không hợp lệ.";
        header('location:register_course.php');
        exit();
    }

    // Verify courses exist in the database
    $placeholders = implode(',', array_fill(0, count($selected_courses), '?'));
    $stmt = $conn->prepare("SELECT id FROM courses WHERE id IN ($placeholders)");
    $stmt->bind_param(str_repeat('i', count($selected_courses)), ...$selected_courses);
    $stmt->execute();
    $result = $stmt->get_result();

    $valid_courses = [];
    while ($row = $result->fetch_assoc()) {
        $valid_courses[] = $row['id'];
    }

    // Check for duplicates and register only valid courses
    foreach ($valid_courses as $course_id) {
        // Kiểm tra xem đã đăng ký chưa
        $check_stmt = $conn->prepare("SELECT id FROM course_registrations WHERE username = ? AND course_id = ?");
        $check_stmt->bind_param("si", $username, $course_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        
        if ($check_result->num_rows == 0) {
            $stmt = $conn->prepare("INSERT INTO course_registrations (username, course_id) VALUES (?, ?)");
            $stmt->bind_param("si", $username, $course_id);
            $stmt->execute();
        }
    }

    // Thông báo thành công bằng popup và redirect
    echo "<script>
        alert('Đăng ký môn học thành công!');
        window.location.href='register_course.php';
    </script>";
    exit();
}
?>

<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Đăng Ký Môn Học</title>
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
        }
        .navbar {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            padding: 1rem 2rem;
        }
        .navbar-brand {
            color: white !important;
            font-weight: bold;
        }
        .nav-link {
            color: rgba(255,255,255,0.8) !important;
            transition: color 0.3s ease;
        }
        .nav-link:hover {
            color: white !important;
        }
        .container {
            padding: 2rem;
        }
        .card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            padding: 2rem;
            margin-bottom: 2rem;
        }
        .table {
            background: white;
            border-radius: 10px;
            overflow: hidden;
        }
        .table thead th {
            background: #2a5298;
            color: white;
            border: none;
        }
        .table td {
            vertical-align: middle;
        }
        .btn-custom {
            background: linear-gradient(45deg, #1e3c72, #2a5298);
            border: none;
            color: white;
            padding: 10px 25px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(46,91,255,0.3);
            color: white;
        }
        .checkbox-custom {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }
        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }
            .button-group {
                flex-direction: column;
            }
        }
        .badge-success {
            background-color: #28a745;
            color: white;
            padding: 8px 12px;
            border-radius: 20px;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="user_home.php">
            <i class="fas fa-graduation-cap"></i> Hệ Thống Đào Tạo
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="user_home.php">
                        <i class="fas fa-home"></i> Trang Chủ
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="view_courses.php">
                        <i class="fas fa-book"></i> Xem Môn Học
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="view_profile.php">
                        <i class="fas fa-user"></i> Hồ Sơ
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">
                        <i class="fas fa-sign-out-alt"></i> Đăng Xuất
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="card">
            <h2 class="text-center mb-4">
                <i class="fas fa-edit"></i> Đăng Ký Môn Học
            </h2>

            <?php if (isset($_SESSION['success_message'])): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle"></i>
                    <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error_message'])): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            <?php endif; ?>

    <!-- Search Form -->
    <form method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" class="form-control" name="search"
                   placeholder="Tìm kiếm theo mã môn học hoặc tên môn học..."
                   value="<?php echo htmlspecialchars($search); ?>">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search"></i> Tìm kiếm
                </button>
            </div>
        </div>
    </form>

    <!-- Course Registration Form -->
    <form method="POST">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr class="text-center">
                        <th width="5%">Chọn</th>
                        <th width="20%">Mã Môn Học</th>
                        <th width="55%">Tên Môn Học</th>
                        <th width="20%">Số Tín Chỉ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result && $result->num_rows > 0):
                        while ($row = $result->fetch_assoc()):
                    ?>
                        <tr>
                            <td class="text-center">
                                <?php if (in_array($row['id'], $registered_courses)): ?>
                                    <span class="badge badge-success">Đã đăng ký</span>
                                <?php else: ?>
                                    <input type="checkbox" class="checkbox-custom" name="courses[]" value="<?php echo $row['id']; ?>">
                                <?php endif; ?>
                            </td>
                            <td class="font-weight-bold"><?php echo htmlspecialchars($row['course_code']); ?></td>
                            <td><?php echo htmlspecialchars($row['course_name']); ?></td>
                            <td class="text-center"><?php echo htmlspecialchars($row['credits']); ?></td>
                        </tr>
                    <?php
                        endwhile;
                    else:
                    ?>
                        <tr>
                            <td colspan="4" class="text-center py-4">
                                <i class="fas fa-info-circle text-info"></i>
                                Không có môn học nào để đăng ký
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
            <div class="button-group">
                <button type="submit" class="btn btn-custom">
                    <i class="fas fa-save"></i> Đăng Ký Môn Học
                </button>
                <a href="user_home.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay Lại
                </a>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>
</html>

