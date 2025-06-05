<?php
ob_start();
session_start();

if (isset($_SESSION['admin'])) {
    $page = isset($_GET['page']) ? $_GET['page'] : 'manage';

    if ($page == 'manage') {
        $pageTitle = 'صفحة ادارة الاجهزة الصادرة';
        include 'init.php';
        $ord = 'ASC';
        if (isset($_GET['ordering'])) {
            $ord = $_GET['ordering'];
        }

       $search = isset($_GET['search']) ? $_GET['search'] : '';
$query = "SELECT * FROM comming WHERE status = 0";

if (!empty($search)) {
    $query .= " AND sr LIKE :search";
}

$query .= " ORDER BY id DESC";
$stmt = $conn->prepare($query);

if (!empty($search)) {
    $stmt->bindValue(':search', "%$search%");
}

$stmt->execute();
$posts = $stmt->fetchAll();

        ?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    
    <!-- Bootstrap & Font Awesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Almarai', sans-serif;
            background-color: #f1f4f8;
            direction: rtl;
            margin: 0;
            padding: 0;
        }

        .container-fluid {
            padding: 30px;
        }

        .cnt-spc {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            margin-top: 20px;
        }

        /* Header Styles */
        .management-header {
            margin-bottom: 30px;
        }

        .management-header h1 {
            font-size: 28px;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
        }

        .management-header .tt {
            color: #64748b;
            font-size: 16px;
            margin-top: 5px;
        }

        /* Button Styles */
        .add-btn {
            background: linear-gradient(135deg, #0d4f8b, #1e40af);
            color: white;
            padding: 12px 15px;
            border-radius: 12px;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            box-shadow: 0 4px 15px rgba(13, 79, 139, 0.3);
        }

        .add-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(13, 79, 139, 0.4);
            color: white;
            text-decoration: none;
        }

        .restore-btn {
                background: linear-gradient(135deg, rgb(40, 167, 46), rgb(154, 228, 175));
    color: white;
    padding: 12px 30px;
    font-size: 16px;
    font-weight: bold;
    border: none;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    transition: 0.3s ease;
    text-decoration: none;
    display: inline-block;

        }

        .restore-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
            color: white;
            text-decoration: none;
        }

        /* Table Styles */
        .default-management-table {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            margin-top: 20px;
        }

        .table {
            margin: 0;
            border: none;
        }

        .table thead th {
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
            border: none;
            padding: 20px 15px;
            font-weight: 600;
            color: #1e293b;
            font-size: 14px;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .table tbody td {
            padding: 18px 15px;
            border-top: 1px solid #f1f5f9;
            vertical-align: middle;
            color: #374151;
        }

        .table tbody tr {
            transition: all 0.3s ease;
        }

        .table tbody tr:hover {
            background-color: #f8fafc;
            transform: scale(1.01);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .f-n {
            font-weight: 600;
            color: #1e293b;
            margin: 0;
        }

        /* Action Buttons */
        .list-group {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .list-group-item {
            background: none;
            border: none;
            padding: 0;
        }

        .list-group-item a {
            display: inline-flex;
            align-items: center;
            padding: 8px 12px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 12px;
            font-weight: 500;
            transition: all 0.3s ease;
            gap: 6px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #0d4f8b, #1e40af);
            border: none;
            color: white;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(13, 79, 139, 0.3);
        }

        .text-danger {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        .text-danger:hover {
            background: #fee2e2;
            color: #b91c1c;
            transform: translateY(-2px);
            text-decoration: none;
        }

        .text-warning {
            background: #fffbeb;
            color: #d97706;
            border: 1px solid #fed7aa;
        }

        .text-warning:hover {
            background: #fef3c7;
            color: #92400e;
            transform: translateY(-2px);
            text-decoration: none;
        }

        /* Form Styles */
        .add-default-page {
            background-color: #f1f4f8;
            min-height: 100vh;
            padding: 40px 0;
        }

        .add-form {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .add-form h3 {
            color: #1e293b;
            font-weight: 700;
            margin-bottom: 30px;
            text-align: center;
            font-size: 24px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
            display: block;
        }

        .form-control {
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 16px;
            transition: all 0.3s ease;
            font-family: 'Almarai', sans-serif;
        }

        .form-control:focus {
            border-color: #0d4f8b;
            box-shadow: 0 0 0 3px rgba(13, 79, 139, 0.1);
            outline: none;
        }

        .btn {
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            margin: 5px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-large {
            padding: 18px 40px;
            font-size: 18px;
            min-width: 200px;
            justify-content: center;
        }

        .btn-small {
            padding: 8px 16px;
            font-size: 14px;
        }

        .form-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 30px;
            gap: 15px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #0d4f8b, #1e40af);
            color: white;
            border-radius: 19px;

        }

        .btn-secondary {
            background: #6b7280;
            color: white;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .btn-serach{
            width:120px;
        }

        .search-container {
    display: flex;
    gap: 10px;
    align-items: center;
    margin-top: 10px;
}

.search-container input[type="text"] {
    border: 2px solid #d1d5db;
    border-radius: 999px;
    padding: 8px 20px;
    font-size: 15px;
    outline: none;
    transition: border 0.3s ease;
    width: 240px
    
}

.search-container input[type="text"]::placeholder {
    color: #6b7280;
    font-weight: 400;
}

.search-container input[type="text"]:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(59,130,246,0.15);
}

.search-container button {
    background: linear-gradient(to left, #1e40af, #0d4f8b);
    color: white;
    padding: 8px 24px;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s ease;
}

.search-container button:hover {
    transform: translateY(-1px);
    background: linear-gradient(to left, #3b82f6, #1e40af);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}


        /* Responsive Design */
        @media (max-width: 768px) {
            .container-fluid {
                padding: 15px;
            }

            .cnt-spc {
                padding: 20px;
            }

            .management-header h1 {
                font-size: 22px;
            }

            .table-responsive {
                border-radius: 15px;
            }

            .list-group {
                flex-direction: column;
                gap: 5px;
            }

            .add-form {
                padding: 25px;
            }
        }

        @media (max-width: 576px) {
            .management-header {
                text-align: center;
            }

            .right-header,
            .left-header {
                text-align: center;
                margin-bottom: 20px;
            }

            .restore-btn {
                display: block;
                text-align: center;
                margin: 20px auto;
                width: fit-content;
            }
        }
    </style>
</head>
<body style="margin-right: 250px; margin-left: 20px">

        <div class="default-management-list users-management">
            <div class="container-fluid cnt-spc">
                <div class="row">
                    <div class="col-md-6">
                        <div class="right-header management-header">
                            <div class="btns">
                                <a href="comming.php?page=add" class="add-btn"> <i class="fas fa-plus"></i> </a>
                            
     <form method="GET" action="reports.php" class="d-flex justify-content-end align-items-center mb-2" style="max-width: 240px;margin-top:80px;">
    <input type="hidden" name="page" value="manage">
    <input type="text" name="search" class="form-control form-control-sm" placeholder="ابحث بالرقم التسلسلي" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
    <button type="submit" class="btn btn-primary btn-sm mx-2" >بحث</button>
</form>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="left-header management-header">
                            <h1>قائمة الاجهزة الصادرة</h1>
                            <p class="tt">اجمالي <?php echo Total_com($conn, 'comming ', "status = 0") ?> </p>
                        </div>
                    </div>
                    <div class="col-md-6 srch-sp">
                        <div class="search-box">
                            <!-- optional search field -->
                        </div>
                    </div>
                    <a href="restore.php" class="restore-btn"> استرجاع الجهاز من الصيانة </a>
                    <div class="col-md-12">
                        <div class="management-body">
                            <div class="default-management-table table-responsive">
                                <table class="table" id="categories-table">
                                    <thead>
                                        <tr>
                                            <th>SR: Serial number</th>
                                            <th>موقع الجهاز </th>
                                            <th>اسم الجهاز </th>
                                            <th>عدد مرات الصيانة </th>
                                            <th>نوع الطلب </th>
                                            <th>نوع الصادر </th>
                                            <th>حدث</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($posts as $post): ?>
                                            <tr>
                                                <td><p class="f-n"><?php echo $post['sr']; ?></p></td>
                                                <td><p class="f-n"><?php echo $post['location']; ?></p></td>
                                                <td><?php echo $post['name']; ?></td>
                                                <td><?php echo $post['maintenance']; ?></td>
                                                <td><?php echo $post['type']; ?></td>
                                                <td><?php echo $post['type_sa']; ?></td>
                                                <td>
    
<ul class="list-group list-group-horizontal">
  <li class="list-group-item p-0 border-0">
 <a href="edit_comming.php?page=edit&id=<?php echo $post['id']; ?>"
       class="btn btn-warning btn-sm text-white mx-1" 
       style="width: 100px; height: 35px; border-radius: 8px;">
      <i class="fas fa-edit text-white"></i> تعديل
    </a>
  </li>

  <li class="list-group-item p-0 border-0">
   <a href="comming.php?page=delete&id=<?php echo $post['id']; ?>"
       class="btn btn-danger btn-sm text-white mx-1" 
       style="width: 100px; height: 35px; border-radius: 8px;"
       onclick="return confirm('هل أنت متأكد من الحذف؟')">
      <i class="fas fa-trash text-white"></i> حذف
    </a>
  </li>

  <li class="list-group-item p-0 border-0">
   <a href="download_word.php?id=<?php echo $post['id']; ?>" 
       class="btn btn-primary btn-sm text-white mx-1" 
       style="width: 100px; height: 35px; border-radius: 8px;" 
       target="_blank">
      <i class="fas fa-print text-white"></i>  تحميل ملف word
    </a>
  </li>
   
</ul>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
        <?php
        include $tpl . 'footer.php';
    } elseif ($page == 'add') {
        $pageTitle = 'صفحة الاضافة';
        include 'init.php';
        ?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة الأجهزة</title>
    
    <!-- Bootstrap & Font Awesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Almarai', sans-serif;
            background-color: #f1f4f8;
            direction: rtl;
            margin: 0;
            padding: 0;
        }

        .add-default-page {
            background-color: #f1f4f8;
            min-height: 100vh;
            padding: 40px 0;
        }

        .add-form {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .add-form h3 {
            color: #1e293b;
            font-weight: 700;
            margin-bottom: 30px;
            text-align: center;
            font-size: 24px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
            display: block;
        }

        .form-control {
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 16px;
            transition: all 0.3s ease;
            font-family: 'Almarai', sans-serif;
        }

        .form-control:focus {
            border-color: #0d4f8b;
            box-shadow: 0 0 0 3px rgba(13, 79, 139, 0.1);
            outline: none;
        }

        .btn {
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            margin: 5px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #0d4f8b, #1e40af);
            color: white;
        }

        .btn-secondary {
            background: #6b7280;
            color: white;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .form-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 30px;
            gap: 15px;
        }

        #more-serials .form-group {
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .device-entry {
            border: 2px solid #e5e7eb;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            background: #f8fafc;
        }

        .device-entry h5 {
            color: #1e293b;
            font-weight: 600;
            margin-bottom: 15px;
            border-bottom: 2px solid #0d4f8b;
            padding-bottom: 5px;
        }

        .row {
            margin: 0;
        }

        .col-md-6 {
            padding: 0 10px;
        }

        @media (max-width: 768px) {
            .add-form {
                padding: 25px;
                margin: 15px;
            }

            .form-actions {
                flex-direction: column;
                gap: 10px;
            }

            .btn {
                width: 100%;
                min-width: auto;
            }

            .col-md-6 {
                padding: 0 5px;
            }
        }
    </style>
</head>
<body>

<div class="add-default-page add-post-page add-product-page" id="add-page" style="margin: 50px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <form class="add-form" method="POST" action="comming.php?page=insert" id="ca-form-info">
                    <h3>قم بملء المعلومات لإضافة الأجهزة</h3>
                    
                    <!-- الجهاز الأول -->
                    <div class="device-entry">
                        <h5><i class="fas fa-desktop"></i> الجهاز الأول</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="serial_number">أدخل الرقم التسلسلي الخاص في وزارة الصحة:</label>
                                    <input type="text" name="serial_number[]" id="serial_number" 
                                           placeholder="أدخل الرقم التسلسلي الخاص في وزارة الصحة" required class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="device_name">نوع الجهاز:</label>
                                    <input type="text" name="name[]" id="device_name" 
                                           placeholder="أدخل نوع الجهاز" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="custody">أدخل الرقم التسلسلي الخاص في الجهاز:</label>
                                    <input type="text" name="custody[]" id="custody" 
                                           placeholder="أدخل الرقم التسلسلي الخاص في الجهاز" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="remarq">اسم الجهاز:</label>
                                    <input type="text" name="remarq[]" id="remarq" 
                                           placeholder="أدخل اسم الجهاز" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="more-serials"></div>

                    <div class="form-actions">
                        <button type="button" onclick="addSerialInput()" class="btn btn-secondary btn-small" 
                                style="width: 140px; height: 75px;">
                            <i class="fas fa-plus"></i> إضافة جهاز آخر
                        </button>

                        <button type="submit" class="btn btn-primary btn-large" id="ca-btn-option" 
                                style="width: 130px; height: 75px;">
                            <i class="fas fa-check"></i> تأكيد
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
let deviceCounter = 1;

function addSerialInput() {
    deviceCounter++;
    const container = document.getElementById("more-serials");
    const newField = document.createElement("div");
    newField.classList.add("device-entry");
    newField.innerHTML = `
        <h5><i class="fas fa-desktop"></i> الجهاز الأول</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="serial_number">أدخل الرقم التسلسلي الخاص في وزارة الصحة:</label>
                                    <input type="text" name="serial_number[]" id="serial_number" 
                                           placeholder="أدخل الرقم التسلسلي الخاص في وزارة الصحة" required class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="device_name">نوع الجهاز:</label>
                                    <input type="text" name="name[]" id="device_name" 
                                           placeholder="أدخل نوع الجهاز" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="custody">أدخل الرقم التسلسلي الخاص في الجهاز:</label>
                                    <input type="text" name="custody[]" id="custody" 
                                           placeholder="أدخل الرقم التسلسلي الخاص في الجهاز" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="remarq">اسم الجهاز:</label>
                                    <input type="text" name="remarq[]" id="remarq" 
                                           placeholder="أدخل اسم الجهاز" class="form-control">
                                </div>
                            </div>
                        </div></div>
        <button type="button" onclick="removeDevice(this)" class="btn btn-danger btn-sm" style="float: left;">
            <i class="fas fa-trash"></i> حذف هذا الجهاز
        </button>
        <div style="clear: both;"></div>
    `;
    container.appendChild(newField);
}

function removeDevice(button) {
    button.closest('.device-entry').remove();
}

function getArabicNumber(num) {
    const arabicNumbers = ['', 'الأول', 'الثاني', 'الثالث', 'الرابع', 'الخامس', 'السادس', 'السابع', 'الثامن', 'التاسع', 'العاشر'];
    return arabicNumbers[num] || `رقم ${num}`;
}
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

      <?php
        include $tpl . 'footer.php';
    } elseif ($page == 'insert') {
        include 'init.php';
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['serial_number'])) {
            foreach ($_POST['serial_number'] as $i => $sr) {
                $sr = trim($sr);
                $name = isset($_POST['name'][$i]) ? trim($_POST['name'][$i]) : '';
                $custody = isset($_POST['custody'][$i]) ? trim($_POST['custody'][$i]) : '';
                $remarq = isset($_POST['remarq'][$i]) ? trim($_POST['remarq'][$i]) : '';

                if ($sr === '') continue;

                $stmt_check = $conn->prepare("SELECT * FROM products WHERE sr = ? LIMIT 1");
                $stmt_check->execute([$sr]);
                $device = $stmt_check->fetch(PDO::FETCH_ASSOC);

                // Use form remarq if provided, otherwise use device notes
                $finalRemarq = !empty($remarq) ? $remarq : (isset($device['notes']) ? $device['notes'] : '');

                $stmt_insert = $conn->prepare("INSERT INTO comming (sr, remarq, Management, name, custody, maintenance, type, type_sa)
                                               VALUES (?, ?, ?, ?, ?, 0, 'الشركة', 'بالمنشأة')");
                $stmt_insert->execute([
                    $sr,
                    $finalRemarq,
                    isset($device['department']) ? $device['department'] : '',
                    !empty($name) ? $name : (isset($device['name']) ? $device['name'] : ''),
                    $custody
                ]);

                if ($device) {
                    $conn->prepare("DELETE FROM products WHERE sr = ?")->execute([$sr]);
                }
            }

            header("Location: comming.php?page=manage");
            exit;
        }
    } elseif ($page == 'delete') {
        include 'init.php';
        $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
        if ($id > 0) {
            $stmt = $conn->prepare("SELECT * FROM comming WHERE id = ? LIMIT 1");
            $stmt->execute([$id]);

            if ($stmt->rowCount() > 0) {
                $stmt = $conn->prepare("DELETE FROM comming WHERE id = ?");
                $stmt->execute([$id]);
            }
        }
        header('Location: comming.php?page=manage');
        exit;
    } elseif ($page == 'edit' || $page == 'update' || $page == 'restore') {
        // other pages continue here...
    } else {
        header('location: dashboard.php');
        exit;
    }
} else {
    header('location: logout.php');
}
ob_end_flush();
?>
