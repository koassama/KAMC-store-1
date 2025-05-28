<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo getTitle(); ?></title>
  <link rel="icon" href="<?php echo $logo ?>logo.jpg" type="image/png">

  <!-- Bootstrap & Font Awesome -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- Custom Styles -->
  <link rel="stylesheet" href="<?php echo $css ?>chartist.css">
  <link rel="stylesheet" href="<?php echo $css ?>style.css">
  <link rel="stylesheet" href="<?php echo $css ?>jquery-ui.css">

  <!-- CKEditor -->
  <script src="https://cdn.ckeditor.com/4.6.2/standard-all/ckeditor.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

  <style>

  html, body {
  overflow-x: hidden !important;
}

.sidebar,
.user-dropdown,
.topbar,
.dropdown-menu,
img,
div {
  border: none !important;
  box-shadow: none !important;
  outline: none !important;
}

body::before,
body::after,
.sidebar::before,
.sidebar::after {
  display: none !important;
}



    body {
      padding-top: 100px;
       overflow-x: hidden;
      margin: 0;
      font-family: 'Almarai', sans-serif;
      background-color: #f1f4f8;
      direction: rtl;
    }

    .topbar {
      position: sticky;
      height: 110px;
      background-color: #0d4f8b;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0 1.5rem;
      position: fixed;
      top: 0;
      width: 100%;
      z-index: 1000;
      transition: opacity 0.4s ease, transform 0.4s ease;
      border-left: none !important;
      border-right: none !important;
      box-shadow: none !important;
    }

    .logo {
      width: 200px;
      height: auto;
      transition: opacity 0.4s ease, transform 0.4s ease;
    }

    .dropdown-toggle::after { display: none !important; }

    .user-dropdown { position: relative; }

    .user-info {
      display: flex;
      align-items: center;
      background-color: rgba(255,255,255,0.1);
      padding: 8px 15px;
      border-radius: 25px;
      cursor: pointer;
      transition: background-color 0.3s;
      border: none;
      color: white;
      text-decoration: none;
    }

    .user-info:hover {
      background-color: rgba(255,255,255,0.2);
      color: white;
      text-decoration: none;
    }

    .user-avatar {
      width: 35px;
      height: 35px;
      border-radius: 50%;
      margin-left: 10px;
      border: 2px solid rgba(255,255,255,0.3);
    }

    .user-name {
      font-weight: 600;
      margin-right: 10px;
    }

    .dropdown-menu {
      position: absolute;
      top: 100%;
      left: 0;
      background: white;
      border-radius: 8px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.15);
      min-width: 220px;
      padding: 10px 0;
      margin-top: 5px;
      display: none;
      text-align: right;
    }

    .dropdown-menu.show { display: block; }

    .dropdown-item {
      display: flex;
      align-items: center;
      padding: 12px 20px;
      color: #333;
      text-decoration: none;
      transition: background-color 0.2s;
    }

    .dropdown-item:hover {
      background-color: #f8f9fa;
      color: #333;
    }

    .dropdown-item i {
      margin-left: 10px;
      width: 16px;
    }

    .sidebar {
      width: 220px;
      background-color: #fff;
      position: fixed;
      top: 110px;
      bottom: 0;
      right: 0;
      padding: 20px 10px;
      border-left: 1px solid #e0e0e0;
      z-index: 1000;
      border-left: none !important;
      border-right: none !important;
      box-shadow: none !important;
      
    }

    * {
  outline: none;
  box-shadow: none;
}

html, body {
  overflow-x: hidden;
}


    .sidebar .nav-link {
      display: flex;
      align-items: center;
      font-size: 15px;
      padding: 10px;
      color: #333;
      transition: 0.3s;
      border-radius: 6px;
      margin-bottom: 5px;
    }

    .sidebar .nav-link i {
      margin-left: 8px;
      font-size: 16px;
    }

    .sidebar .nav-link:hover {
      background-color: #f5f5f5;
      color: #007bff;
    }

    .user-box {
      padding: 15px;
      background-color: #f1f1f1;
      display: flex;
      align-items: center;
    }

    .user-box img {
      border-radius: 50%;
      width: 40px;
      height: 40px;
      margin-left: 10px;
    }

    .main-content {
      margin-right: 250px;
      margin-top: 200px;
      padding: 30px;
      min-height: calc(100vh - 70px);
    }

    .page-title {
      font-size: 28px;
      font-weight: 700;
      color: #1e293b;
      margin-bottom: 30px;
    }

    .dashboard-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 25px;
      margin-top: 20px;
    }

    .dashboard-card {
      background: white;
      border-radius: 12px;
      padding: 25px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.08);
      transition: all 0.3s ease;
      cursor: pointer;
      border: 1px solid #e2e8f0;
    }

    .dashboard-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 25px rgba(0,0,0,0.15);
      border-color: #0d4f8b;
    }

    .card-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 20px;
    }

    .card-icon {
      width: 50px;
      height: 50px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 24px;
      color: white;
    }

    .card-icon.devices { background: linear-gradient(135deg, #667eea, #764ba2); }
    .card-icon.employees { background: linear-gradient(135deg, #f093fb, #f5576c); }
    .card-icon.outgoing { background: linear-gradient(135deg, #4facfe, #00f2fe); }
    .card-icon.consumables { background: linear-gradient(135deg, #43e97b, #38f9d7); }
    .card-icon.inventory { background: linear-gradient(135deg, #fa709a, #fee140); }
    .card-icon.maintenance { background: linear-gradient(135deg, #a8edea, #fed6e3); }
    .card-icon.reports { background: linear-gradient(135deg, #ff9a9e, #fecfef); }
    .card-icon.settings { background: linear-gradient(135deg, #ffecd2, #fcb69f); }

    .card-title {
      font-size: 18px;
      font-weight: 600;
      color: #1e293b;
      margin-bottom: 8px;
    }

    .card-value {
      font-size: 32px;
      font-weight: 700;
      color: #0d4f8b;
      margin-bottom: 10px;
    }

    .card-subtitle {
      font-size: 14px;
      color: #64748b;
    }

    .progress-bar-custom {
      background-color: #e2e8f0;
      border-radius: 10px;
      height: 8px;
      overflow: hidden;
      margin-top: 15px;
    }

    .progress-fill {
      height: 100%;
      background: linear-gradient(90deg, #0d4f8b, #1e40af);
      border-radius: 10px;
      transition: width 0.8s ease;
    }

    .stats-card {
      background: linear-gradient(135deg, #667eea, #764ba2);
      color: white;
      border-radius: 15px;
      padding: 30px;
      text-align: center;
      position: relative;
      overflow: hidden;
    }

    .stats-card::before {
      content: '';
      position: absolute;
      top: -50%;
      right: -50%;
      width: 200%;
      height: 200%;
      background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
      animation: pulse 3s ease-in-out infinite;
    }

    @keyframes pulse {
      0%, 100% { transform: scale(1); opacity: 0.3; }
      50% { transform: scale(1.1); opacity: 0.1; }
    }

    @media (max-width: 768px) {
      .sidebar { transform: translateX(100%); transition: transform 0.3s; }
      .sidebar.show { transform: translateX(0); }
      .main-content { margin-right: 0; }
      .dashboard-grid { grid-template-columns: 1fr; }
      .search-box { width: 200px; }
    }

    .loading {
      display: inline-block;
      width: 20px;
      height: 20px;
      border: 3px solid rgba(255,255,255,.3);
      border-radius: 50%;
      border-top-color: #fff;
      animation: spin 1s ease-in-out infinite;
    }

    @keyframes spin {
      to { transform: rotate(360deg); }
    }
  </style>
</head>
<body>

<?php
if (!isset($_SESSION['id'])) session_start();
require_once './connect.php';

$stmt = $conn->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
$stmt->execute([$_SESSION['id']]);
$admin = $stmt->fetch();

$stmt = $conn->prepare("SELECT * FROM pages WHERE id = 1");
$stmt->execute();
$page = $stmt->fetch();
?>

<!-- Sticky Topbar -->
<div class="topbar d-flex justify-content-between align-items-center px-4" style="position: fixed; top: 0; right: 0; width: 100%; z-index: 1050; background-color: #0d4f8b; height: 110px;">
  
  <!-- Logo in center -->
  <div style="position: absolute; right: 50%; transform: translateX(50%);">
    <img src="imgs\Kamc Logo Guideline-06.svg" alt="logo" class="logo">
  </div>

  <!-- User Dropdown -->
  <div class="dropdown">
    <a href="#" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
       class="d-flex align-items-center text-decoration-none dropdown-toggle user-info">
      <span class="user-name"style="margin-right: 10px;"><?php echo $admin['fname']; ?></span>
      <img src="<?php echo $admin['image'] ? $avatar . $admin['image'] : $avatar . 'default.png'; ?>" class="user-avatar" style="margin-right: 40px;">
    </a>
    <div class="dropdown-menu dropdown-menu-right text-right shadow mt-2" aria-labelledby="userDropdown">
      <div class="px-3 py-2 d-flex align-items-center border-bottom">
        <img src="<?php echo $admin['image'] ? $avatar . $admin['image'] : $avatar . 'default.png'; ?>" 
             class="rounded-circle ml-2" style="width: 40px; height: 40px;">
        <strong><?php echo $admin['fname']; ?></strong>
      </div>
      <a class="dropdown-item" href="users.php?page=edit&id=<?php echo $admin['id']; ?>">
        <i class="fas fa-user-cog ml-2"></i> إعدادات الحساب
      </a>
      <a class="dropdown-item text-danger" href="logout.php">
        <i class="fas fa-sign-out-alt ml-2"></i> تسجيل الخروج
      </a>
    </div>
  </div>

</div>



<!-- Sidebar -->
<div class="sidebar">
  <ul class="nav flex-column">
    <li class="nav-item"><a class="nav-link" href="dashboard.php"><i class="fas fa-tachometer-alt"></i> لوحة التحكم</a></li>
    <li class="nav-item"><a class="nav-link" href="users_manage.php"><i class="fas fa-users"></i> الموظفين</a></li>
    <li class="nav-item"><a class="nav-link" href="comming.php?page=manage"><i class="fas fa-upload"></i> الأجهزة الصادرة</a></li>
    <li class="nav-item"><a class="nav-link" href="consumers.php"><i class="fas fa-sync-alt"></i> المستهلكات</a></li>
    <li class="nav-item"><a class="nav-link" href="products_manage.php"><i class="fas fa-warehouse"></i> المخزون</a></li>
    <li class="nav-item"><a class="nav-link" href="returns.php?page=manage"><i class="fas fa-tools"></i> الصيانة</a></li>
    <li class="nav-item"><a class="nav-link" href="reports.php?page=manage"><i class="fas fa-chart-line"></i> التقارير</a></li>
    <hr>
    <li class="nav-item"><a class="nav-link" href="pages.php?page=manage"><i class="fas fa-cog"></i> الإعدادات</a></li>
    <li class="nav-item"><a class="nav-link" href="pages2.php?page=manage"><i class="fas fa-file-alt"></i> المحتوى</a></li>
  </ul>
</div>

<!-- Main content -->
<div class="container-fluid" style="margin-right: 240px; padding-top: 40px;">
  <div class="row justify-content-center">
    <!-- Card example -->
    <div>
      <div >
        <div >
          <img >
          <h6>
          <div >
            <div></div>
          </div>
        </div>
      </div>
    </div>
    <!-- Add more cards here -->
  </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
