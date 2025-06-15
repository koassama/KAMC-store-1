<?php
ob_start();
session_start();
if (isset($_SESSION['admin'])) {
    $pageTitle = 'الصفحة الرئيسية';
    include 'init.php';
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Almarai', sans-serif;
            background-color: #f1f4f8;
            direction: rtl;
            margin: 0;
            padding: 0;
        }

        .main-container {
            min-height: 100vh;
            padding: 40px 0;
        }

        .welcome-card {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin-bottom: 40px;
        }

        .welcome-title {
            color: #1e293b;
            font-weight: 700;
            font-size: 32px;
            margin-bottom: 15px;
        }

        .welcome-subtitle {
            color: #64748b;
            font-size: 18px;
            margin-bottom: 0;
        }

        .navigation-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 30px;
        }

        .nav-card {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            text-align: center;
            transition: all 0.3s ease;
            border: none;
            text-decoration: none;
            color: inherit;
        }

        .nav-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
            text-decoration: none;
            color: inherit;
        }

        .nav-icon {
            font-size: 3rem;
            margin-bottom: 20px;
            color: #0d4f8b;
        }

        .nav-title {
            color: #1e293b;
            font-weight: 700;
            font-size: 20px;
            margin-bottom: 10px;
        }

        .nav-description {
            color: #64748b;
            font-size: 14px;
            margin: 0;
        }

        .stats-row {
            margin-top: 40px;
        }

        .stat-card {
            background: linear-gradient(135deg, #0d4f8b, #1e40af);
            color: white;
            padding: 25px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 8px 25px rgba(13, 79, 139, 0.3);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 14px;
            opacity: 0.9;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-container {
                padding: 20px 15px;
            }

            .welcome-card {
                padding: 25px;
            }

            .welcome-title {
                font-size: 24px;
            }

            .navigation-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .nav-card {
                padding: 20px;
            }
        }
    </style>
</head>
<body style="margin-right: 250px; margin-left: 20px; margin-top: 40px" >
    <div class="main-container">
        <div class="container">
            <!-- Welcome Section -->
            <div class="welcome-card">
                <h1 class="welcome-title">مرحباً بك في نظام إدارة المستهلكات</h1>
                <p class="welcome-subtitle">إدارة شاملة لجميع الأجهزة والمعدات</p>
            </div>

            <!-- Statistics Row -->
            <div class="row stats-row">
                <div class="col-md-4 mb-3">
                    <div class="stat-card">
                        <div class="stat-number"><?php echo Total($conn, 'consumers'); ?></div>
                        <div class="stat-label">إجمالي المستهلكات</div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="stat-card">
                        <div class="stat-number">
                            <?php 
                            $today = date('Y-m-d');
                            $stmt = $conn->prepare("SELECT COUNT(*) as count FROM consumers WHERE DATE(created_at) = ?");
                            $stmt->execute([$today]);
                            $todayCount = $stmt->fetch()['count'];
                            echo $todayCount;
                            ?>
                        </div>
                        <div class="stat-label">المضافة اليوم</div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="stat-card">
                        <div class="stat-number">
                            <?php 
                            $stmt = $conn->prepare("SELECT COUNT(DISTINCT device_name) as count FROM consumers");
                            $stmt->execute();
                            $deviceTypes = $stmt->fetch()['count'];
                            echo $deviceTypes;
                            ?>
                        </div>
                        <div class="stat-label">أنواع الأجهزة</div>
                    </div>
                </div>
            </div>

            <!-- Navigation Grid -->
            <div class="navigation-grid">
                <a href="consumers.php" class="nav-card">
                    <div class="nav-icon">
                        <i class="fas fa-list"></i>
                    </div>
                    <h3 class="nav-title">عرض جميع المستهلكات</h3>
                    <p class="nav-description">استعراض وإدارة جميع الأجهزة المسجلة في النظام</p>
                </a>

                <a href="add.php" class="nav-card">
                    <div class="nav-icon">
                        <i class="fas fa-plus-circle"></i>
                    </div>
                    <h3 class="nav-title">إضافة مستهلك جديد</h3>
                    <p class="nav-description">تسجيل جهاز أو معدة جديدة في النظام</p>
                </a>

                <a href="consumers.php?search=" class="nav-card">
                    <div class="nav-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3 class="nav-title">البحث في المستهلكات</h3>
                    <p class="nav-description">البحث عن الأجهزة باستخدام الرقم التسلسلي أو المعلومات الأخرى</p>
                </a>

                <a href="#" onclick="showReports()" class="nav-card">
                    <div class="nav-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <h3 class="nav-title">التقارير والإحصائيات</h3>
                    <p class="nav-description">عرض تقارير مفصلة وإحصائيات شاملة</p>
                </a>
            </div>

            <!-- Quick Actions -->
            <div class="row mt-5">
                <div class="col-md-12">
                    <div class="welcome-card">
                        <h3 style="color: #1e293b; margin-bottom: 20px;">الإجراءات السريعة</h3>
                        <div class="d-flex justify-content-center gap-3 flex-wrap">
                            <a href="add.php" class="btn btn-primary">
                                <i class="fas fa-plus"></i> إضافة سريعة
                            </a>
                            <a href="consumers.php" class="btn btn-outline-primary">
                                <i class="fas fa-eye"></i> عرض الكل
                            </a>
                            <a href="logout.php" class="btn btn-outline-danger">
                                <i class="fas fa-sign-out-alt"></i> تسجيل الخروج
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showReports() {
            alert('التقارير والإحصائيات ستكون متاحة قريباً!');
        }
        
        // Add some interactive effects
        document.querySelectorAll('.nav-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });
    </script>
</body>
</html>

<?php
include $tpl . 'footer.php';
} else {
    header('location: login.php');
}
ob_end_flush();
?>