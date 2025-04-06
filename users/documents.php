<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'user') {
    header('location:../signup1/access_denied.php');
    exit();
}

require_once 'connect.php';
$conn = $con;

// Lấy các môn học đã đăng ký của user
$username = $_SESSION['username'];
$sql = "SELECT c.course_code, c.course_name, d.document_name, d.file_path, d.upload_date 
        FROM course_registrations cr
        JOIN courses c ON cr.course_id = c.id
        JOIN documents d ON c.id = d.course_id
        WHERE cr.username = ?
        ORDER BY c.course_name, d.upload_date DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

// Tổ chức tài liệu theo môn học
$documents_by_course = array();
while ($row = $result->fetch_assoc()) {
    $course_code = $row['course_code'];
    if (!isset($documents_by_course[$course_code])) {
        $documents_by_course[$course_code] = array(
            'course_name' => $row['course_name'],
            'documents' => array()
        );
    }
    $documents_by_course[$course_code]['documents'][] = array(
        'name' => $row['document_name'],
        'path' => $row['file_path'],
        'date' => $row['upload_date']
    );
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tài Liệu Học Tập</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
        .course-card {
            margin-bottom: 30px;
        }
        .course-header {
            background: #2a5298;
            color: white;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .document-item {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 10px;
            transition: all 0.3s ease;
        }
        .document-item:hover {
            background: #e9ecef;
            transform: translateX(10px);
        }
        .document-title {
            font-weight: 600;
            color: #2a5298;
        }
        .document-date {
            color: #6c757d;
            font-size: 0.9em;
        }
        .download-btn {
            color: #2a5298;
            transition: all 0.3s ease;
        }
        .download-btn:hover {
            color: #1e3c72;
            transform: scale(1.1);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
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
                <i class="fas fa-book-reader"></i> Tài Liệu Học Tập
            </h2>

            <?php if (empty($documents_by_course)): ?>
                <div class="alert alert-info" role="alert">
                    <i class="fas fa-info-circle"></i> Bạn chưa có tài liệu học tập nào.
                </div>
            <?php else: ?>
                <?php foreach ($documents_by_course as $course_code => $course): ?>
                    <div class="course-card">
                        <div class="course-header">
                            <h4 class="mb-0">
                                <i class="fas fa-book"></i> 
                                <?php echo htmlspecialchars($course_code); ?> - 
                                <?php echo htmlspecialchars($course['course_name']); ?>
                            </h4>
                        </div>
                        <div class="document-list">
                            <?php foreach ($course['documents'] as $document): ?>
                                <div class="document-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="document-title">
                                            <i class="fas fa-file-alt"></i> 
                                            <?php echo htmlspecialchars($document['name']); ?>
                                        </div>
                                        <div class="document-date">
                                            <i class="fas fa-calendar-alt"></i> 
                                            <?php echo date('d/m/Y', strtotime($document['date'])); ?>
                                        </div>
                                    </div>
                                    <a href="<?php echo htmlspecialchars($document['path']); ?>" 
                                       class="download-btn" 
                                       download>
                                        <i class="fas fa-download fa-2x"></i>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <div class="text-center mt-4">
                <a href="user_home.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
