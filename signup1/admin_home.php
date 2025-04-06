<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header('location:login.php');
    }
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Hệ Thống Đào Tạo Chương Trình Chất Lượng Cao</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Mulish:wght@400;600;700&display=swap');
        
        body {
            background: linear-gradient(135deg, #1a2980, #26d0ce);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Mulish', sans-serif;
            margin: 0;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"><path fill="%23FFFFFF" d="M40,-50C51.9,-41.3,61.3,-27.8,64.7,-12.3C68.1,3.2,65.5,20.7,57.1,34.5C48.7,48.3,34.4,58.3,19.2,61.9C4,65.6,-12,62.8,-25.8,55.9C-39.7,49,-51.3,38,-57.8,24.1C-64.2,10.2,-65.4,-6.6,-60.1,-20.7C-54.8,-34.8,-43,-46.1,-30.1,-54.3C-17.1,-62.5,-3.1,-67.6,9.4,-65.1C21.9,-62.6,28.1,-58.7,40,-50Z" transform="translate(100 100)" /></svg>') no-repeat center center;
            opacity: 0.05;
            z-index: -1;
        }

        .dashboard-container {
            width: 90%;
            max-width: 800px;
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 30px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            text-align: center;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .dashboard-container h2 {
            color: #1a2980;
            margin-bottom: 35px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 3px;
            font-size: 2rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .custom-btn {
            border: none;
            background: linear-gradient(135deg, #26d0ce, #1a2980);
            color: white;
            font-size: 16px;
            font-weight: 600;
            padding: 16px 20px;
            border-radius: 15px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 20px rgba(26, 41, 128, 0.15);
            position: relative;
            overflow: hidden;
        }

        .custom-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(255,255,255,0.2), rgba(255,255,255,0));
            transform: translateX(-100%);
            transition: transform 0.6s ease-out;
        }

        .custom-btn:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 15px 30px rgba(26, 41, 128, 0.25);
            background: linear-gradient(135deg, #26d0ce, #1a2980);
        }

        .custom-btn:hover::before {
            transform: translateX(100%);
        }

        .custom-btn i {
            margin-right: 12px;
            font-size: 20px;
            transition: all 0.4s ease;
        }

        .logout-btn {
            background: linear-gradient(135deg, #FF6B6B, #FF3264);
            margin-top: 30px;
        }

        .logout-btn:hover {
            background: linear-gradient(135deg, #FF3264, #FF6B6B);
        }

        hr {
            border: none;
            height: 2px;
            background: linear-gradient(90deg, transparent, rgba(26, 41, 128, 0.2), transparent);
            margin: 35px 0;
            opacity: 0.5;
        }

        .text-primary {
            background: linear-gradient(135deg, #26d0ce, #1a2980);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: bold;
        }

        .d-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .custom-btn:hover i {
            transform: translateX(-3px) rotate(15deg);
        }

        .custom-btn:active {
            transform: scale(0.98);
        }

        @media (max-width: 768px) {
            .dashboard-container {
                padding: 30px;
                width: 95%;
            }
            
            .d-grid {
                grid-template-columns: 1fr;
            }
            
            .custom-btn {
                padding: 14px;
            }
        }
    </style>
  </head>
  <body>
    <div class="dashboard-container">
        <h2>Chào Mừng, <span class="text-primary"><?php echo $_SESSION['username']; ?></span></h2>
        <hr>
        <div class="d-grid gap-3">
            <a href="../CRUD/display.php" class="btn custom-btn"><i class="fas fa-user-graduate"></i> Quản Lí Sinh Viên</a>
            <a href="../lecturers/manage_lecturers.php" class="btn custom-btn"><i class="fas fa-chalkboard-teacher"></i> Quản Lí Giảng Viên</a>
            <a href="../grades/grades.php" class="btn custom-btn"><i class="fas fa-book"></i> Quản Lí Điểm</a>
            <a href="../courses/manage_courses.php" class="btn custom-btn"><i class="fas fa-clipboard-list"></i> Quản Lý Môn Học</a>
            <a href="../exams/manage_exam_schedule.php" class="btn custom-btn"><i class="fas fa-calendar-alt"></i> Quản Lí Lịch Thi</a>
            <a href="../courses/view_registrations.php" class="btn custom-btn"><i class="fas fa-calendar-alt"></i>Quản Lí Đăng Kí Môn Học</a>
            <a href="manage_documents.php" class="btn custom-btn"><i class="fas fa-file-alt"></i> Quản Lý Tài Liệu</a>
            <a href="logout.php" class="btn logout-btn text-white"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>