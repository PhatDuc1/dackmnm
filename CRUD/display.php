<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header('location:login.php');
    }

    include "./connect.php";

    // Lấy thống kê
    $stats_sql = "SELECT
        COUNT(*) as total_users,
        COUNT(DISTINCT mssv) as total_students
    FROM users WHERE role = 'user'";
    $stats_result = mysqli_query($con, $stats_sql);
    $stats = mysqli_fetch_assoc($stats_result);

    // Xử lý tìm kiếm an toàn
    $search_query = isset($_GET['search']) ? mysqli_real_escape_string($con, $_GET['search']) : '';

    // Xử lý phân trang
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = 10;
    $offset = ($page - 1) * $limit;

    // Truy vấn dữ liệu với prepared statement
    $sql = "SELECT id, mssv, username, email, mobile, address
            FROM users
            WHERE role = 'user' AND (mssv LIKE ? OR username LIKE ? OR email LIKE ? OR mobile LIKE ?)
            ORDER BY mssv LIMIT ? OFFSET ?";

    $stmt = mysqli_prepare($con, $sql);
    $search_pattern = "%$search_query%";
    mysqli_stmt_bind_param($stmt, "ssssii", $search_pattern, $search_pattern, $search_pattern, $search_pattern, $limit, $offset);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Đếm tổng số bản ghi
    $count_sql = "SELECT COUNT(*) as total FROM users WHERE role = 'user' AND (mssv LIKE ? OR username LIKE ? OR email LIKE ? OR mobile LIKE ?)";
    $count_stmt = mysqli_prepare($con, $count_sql);
    mysqli_stmt_bind_param($count_stmt, "ssss", $search_pattern, $search_pattern, $search_pattern, $search_pattern);
    mysqli_stmt_execute($count_stmt);
    $count_result = mysqli_stmt_get_result($count_stmt);
    $count_row = mysqli_fetch_assoc($count_result);
    $total_records = $count_row['total'];
    $total_pages = ceil($total_records / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quản Lý Sinh Viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #2c3e50, #3498db);
            font-family: 'Segoe UI', sans-serif;
            min-height: 100vh;
            padding: 20px 0;
        }
        .container {
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            margin: 20px auto;
        }
        h1 {
            color: #2c3e50;
            font-weight: bold;
            text-align: center;
            margin-bottom: 30px;
        }
        .stats-cards {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        .stats-card {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            transition: transform 0.3s;
        }
        .stats-card:hover { transform: translateY(-5px); }
        .stats-card h3 { font-size: 1rem; margin-bottom: 10px; }
        .stats-card .number { font-size: 2rem; font-weight: bold; }
        .btn-custom {
            border-radius: 20px;
            padding: 8px 20px;
            transition: all 0.3s;
        }
        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        .table {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .table th {
            background: #34495e;
            color: white;
            font-weight: 500;
            padding: 12px;
            text-align: center;
        }
        .table td {
            padding: 12px;
            text-align: center;
            vertical-align: middle;
        }
        .search-container {
            max-width: 500px;
            margin-right: 20px;
        }
        .action-buttons { display: flex; gap: 5px; justify-content: center; }
        .pagination { margin-top: 20px; justify-content: center; }
        .pagination .page-link {
            border-radius: 5px;
            margin: 0 3px;
            color: #3498db;
        }
        .pagination .active .page-link {
            background: #3498db;
            border-color: #3498db;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Quản Lý Sinh Viên</h1>

        <div class="stats-cards">
            <div class="stats-card">
                <h3>Tổng số sinh viên</h3>
                <div class="number"><?php echo $stats['total_users']; ?></div>
            </div>
            <div class="stats-card">
                <h3>Số sinh viên</h3>
                <div class="number"><?php echo $stats['total_students']; ?></div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <form method="GET" class="d-flex search-container">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" 
                           placeholder="Tìm kiếm theo MSSV, tên..." 
                           value="<?php echo htmlspecialchars($search_query); ?>">
                    <button class="btn btn-primary btn-custom" type="submit">
                        <i class="fas fa-search"></i> Tìm kiếm
                    </button>
                </div>
            </form>
            <div>
                <a href="../signup1/register.php" class="btn btn-primary btn-custom">
                    <i class="fas fa-plus"></i> Thêm
                </a>
                <a href="../signup1/admin_home.php" class="btn btn-secondary btn-custom ms-2">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>MSSV</th>
                        <th>Tên đăng nhập</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Địa chỉ</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!$result) {
                        echo '<tr><td colspan="7" class="text-center text-danger">Lỗi truy vấn</td></tr>';
                    } else if (mysqli_num_rows($result) > 0) {
                        $stt = ($page - 1) * $limit + 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<tr>
                                    <td>'.$stt.'</td>
                                    <td>'.htmlspecialchars($row['mssv']).'</td>
                                    <td>'.htmlspecialchars($row['username']).'</td>
                                    <td>'.htmlspecialchars($row['email']).'</td>
                                    <td>'.htmlspecialchars($row['mobile']).'</td>
                                    <td>'.htmlspecialchars($row['address']).'</td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="edit_user.php?id='.$row['id'].'" 
                                               class="btn btn-warning btn-sm btn-custom">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="delete_user.php?id='.$row['id'].'" 
                                               class="btn btn-danger btn-sm btn-custom"
                                               onclick="return confirm(\'Bạn có chắc chắn muốn xóa?\')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                  </tr>';
                            $stt++;
                        }
                    } else {
                        echo '<tr><td colspan="7" class="text-center">Không tìm thấy dữ liệu</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <?php if ($total_pages > 1): ?>
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <?php if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo ($page-1); ?>&search=<?php echo urlencode($search_query); ?>">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    </li>
                <?php endif; ?>

                <?php
                $start = max(1, min($page - 1, $total_pages - 2));
                $end = min($total_pages, $start + 2);
                
                for ($i = $start; $i <= $end; $i++):
                ?>
                    <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search_query); ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                <?php endfor; ?>

                <?php if ($page < $total_pages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo ($page+1); ?>&search=<?php echo urlencode($search_query); ?>">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
