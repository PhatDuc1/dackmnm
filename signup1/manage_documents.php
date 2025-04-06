<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header('location:access_denied.php');
    exit();
}

require_once '../courses/connect.php';

// Xử lý upload file
if (isset($_POST['upload'])) {
    $course_id = mysqli_real_escape_string($con, $_POST['course_id']);
    $document_name = mysqli_real_escape_string($con, $_POST['document_name']);
    
    // Xử lý file upload
    $target_dir = "../documents/";
    $file = $_FILES['document_file'];
    $file_name = basename($file["name"]);
    $target_file = $target_dir . time() . '_' . $file_name;
    
    // Kiểm tra và tạo thư mục nếu chưa tồn tại
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    // Upload file
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        $sql = "INSERT INTO documents (course_id, document_name, file_path) VALUES (?, ?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("iss", $course_id, $document_name, $target_file);
        
        if ($stmt->execute()) {
            $success_message = "Tải lên tài liệu thành công!";
        } else {
            $error_message = "Lỗi khi lưu thông tin tài liệu!";
        }
    } else {
        $error_message = "Lỗi khi tải file lên!";
    }
}

// Xử lý xóa tài liệu
if (isset($_GET['delete'])) {
    $doc_id = mysqli_real_escape_string($con, $_GET['delete']);
    
    // Lấy đường dẫn file trước khi xóa
    $sql = "SELECT file_path FROM documents WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $doc_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $doc = $result->fetch_assoc();
    
    if ($doc) {
        // Xóa file từ thư mục
        if (file_exists($doc['file_path'])) {
            unlink($doc['file_path']);
        }
        
        // Xóa record từ database
        $sql = "DELETE FROM documents WHERE id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $doc_id);
        
        if ($stmt->execute()) {
            $success_message = "Đã xóa tài liệu thành công!";
        } else {
            $error_message = "Lỗi khi xóa tài liệu!";
        }
    }
}

// Lấy danh sách tài liệu
$sql = "SELECT d.*, c.course_code, c.course_name 
        FROM documents d 
        JOIN courses c ON d.course_id = c.id 
        ORDER BY c.course_name, d.upload_date DESC";
$result = mysqli_query($con, $sql);

// Lấy danh sách môn học cho form upload
$courses_sql = "SELECT id, course_code, course_name FROM courses ORDER BY course_name";
$courses_result = mysqli_query($con, $courses_sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Tài Liệu</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            padding: 20px 0;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .upload-form {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
        }
        .document-item {
            background: #fff;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }
        .document-item:hover {
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }
        .btn-custom {
            border-radius: 20px;
            padding: 8px 20px;
        }
        .course-header {
            background: #2a5298;
            color: white;
            padding: 10px 20px;
            border-radius: 10px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-4">
            <i class="fas fa-file-alt"></i> Quản Lý Tài Liệu Học Tập
        </h2>

        <!-- Form Upload -->
        <div class="upload-form">
            <h4 class="mb-3">
                <i class="fas fa-upload"></i> Tải Lên Tài Liệu Mới
            </h4>
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Chọn Môn Học</label>
                    <select name="course_id" class="form-control" required>
                        <option value="">-- Chọn môn học --</option>
                        <?php while ($course = mysqli_fetch_assoc($courses_result)): ?>
                            <option value="<?php echo $course['id']; ?>">
                                <?php echo htmlspecialchars($course['course_code'] . ' - ' . $course['course_name']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Tên Tài Liệu</label>
                    <input type="text" name="document_name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Chọn File</label>
                    <input type="file" name="document_file" class="form-control-file" required>
                </div>
                <button type="submit" name="upload" class="btn btn-primary btn-custom">
                    <i class="fas fa-upload"></i> Tải Lên
                </button>
                <a href="admin_home.php" class="btn btn-secondary btn-custom">
                    <i class="fas fa-arrow-left"></i> Quay Lại
                </a>
            </form>
        </div>

        <!-- Messages -->
        <?php if (isset($success_message)): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle"></i> <?php echo $success_message; ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        <?php endif; ?>

        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle"></i> <?php echo $error_message; ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        <?php endif; ?>

        <!-- Danh sách tài liệu -->
        <div class="document-list">
            <?php
            $current_course = '';
            if ($result && mysqli_num_rows($result) > 0):
                while ($doc = mysqli_fetch_assoc($result)):
                    if ($current_course != $doc['course_code']):
                        if ($current_course != '') echo '</div>';
                        $current_course = $doc['course_code'];
                        ?>
                        <div class="course-header">
                            <h5 class="mb-0">
                                <?php echo htmlspecialchars($doc['course_code'] . ' - ' . $doc['course_name']); ?>
                            </h5>
                        </div>
                        <div class="document-group">
                    <?php endif; ?>
                    
                    <div class="document-item d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1"><?php echo htmlspecialchars($doc['document_name']); ?></h5>
                            <small class="text-muted">
                                <i class="fas fa-calendar-alt"></i> 
                                Ngày tải lên: <?php echo date('d/m/Y H:i', strtotime($doc['upload_date'])); ?>
                            </small>
                        </div>
                        <div>
                            <a href="<?php echo htmlspecialchars($doc['file_path']); ?>" 
                               class="btn btn-primary btn-sm btn-custom mr-2"
                               download>
                                <i class="fas fa-download"></i> Tải xuống
                            </a>
                            <a href="?delete=<?php echo $doc['id']; ?>" 
                               class="btn btn-danger btn-sm btn-custom"
                               onclick="return confirm('Bạn có chắc chắn muốn xóa tài liệu này?')">
                                <i class="fas fa-trash"></i> Xóa
                            </a>
                        </div>
                    </div>
                <?php endwhile;
                echo '</div>';
            else: ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Chưa có tài liệu nào được tải lên.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>
</html>