<?php
ob_start();
session_start();
if (isset($_SESSION['admin'])) {
    $pageTitle = 'ادخال البيانات';
    include 'init.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $sr = $_POST['sr'];
        $device_name = $_POST['device_name'];
        $device_type = $_POST['device_type'];
        $device_model = $_POST['device_model'];
        $notes = $_POST['notes'];
        $employee_id = $_POST['employee_id'];
        $department = $_POST['department'];

        // Handle image upload
        $imageName = $_FILES['image']['name'];
        $imageSize = $_FILES['image']['size'];
        $imageTmp = $_FILES['image']['tmp_name'];
        $imageType = $_FILES['image']['type'];

        $imageAllowedExtension = array("jpeg", "jpg", "png");
        $Infunc = explode('.', $imageName);
        $imageExtension = strtolower(end($Infunc));

        $formErrors = array();

        // Validation
        if (empty($sr)) {
            $formErrors[] = "حقل الرقم التسلسلي فارغ";
        }

        if (!empty($sr) && Total_Prod($conn, 'products', "sr = '$sr'") > 0) {
            $formErrors[] = 'الرقم التسلسلي موجود مسبقاً';
        }

        if (empty($device_name)) {
            $formErrors[] = "حقل اسم الجهاز فارغ";
        }

        if (!empty($device_name) && Total_Prod($conn, 'products', "device_name = '$device_name'") > 0) {
            $formErrors[] = 'اسم الجهاز موجود مسبقاً';
        }

        if (empty($device_type)) {
            $formErrors[] = "حقل نوع الجهاز فارغ";
        }

        // Image validation
        if (!empty($imageName)) {
            if (!in_array($imageExtension, $imageAllowedExtension)) {
                $formErrors[] = 'نطاق الصورة غير مسموح به (يُسمح فقط بـ JPG, JPEG, PNG)';
            }
            
            if ($imageSize > 4194304) { // 4MB
                $formErrors[] = 'حجم الصورة كبير جداً (الحد الأقصى 4 ميجابايت)';
            }
        }

        if (!empty($formErrors)) {
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>خطأ في البيانات</title>
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Almarai', sans-serif;
            background-color: #f1f4f8;
            direction: rtl;
            margin: 0;
            padding: 0;
        }
        .error-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .error-card {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 600px;
        }
        .error-icon {
            color: #ef4444;
            font-size: 3rem;
            margin-bottom: 20px;
        }
        .alert {
            border-radius: 15px;
            padding: 15px;
            margin-bottom: 10px;
        }
        .btn {
            border-radius: 10px;
            padding: 12px 24px;
            font-weight: 600;
            margin-top: 20px;
            transition: all 0.3s ease;
        }
        .btn:hover {
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-card">
            <div class="error-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h3 class="mb-4">يوجد أخطاء في البيانات</h3>
            <?php
            foreach ($formErrors as $error) {
                echo '<div class="alert alert-danger">' . $error . '</div>';
            }
            ?>
            <div class="d-flex justify-content-center gap-3 mt-4">
                <a href="products_add.php" class="btn btn-primary">العودة لصفحة الإضافة</a>
                <a href="products_manage.php" class="btn btn-secondary">قائمة المنتجات</a>
            </div>
        </div>
    </div>
</body>
</html>
<?php
        } else {
            // Process image upload
            $image = '';
            if (!empty($imageName)) {
                $image = rand(0, 100000) . '_' . $imageName;
                move_uploaded_file($imageTmp, $images . '/' . $image);
            }

            // Insert into database
            $stmt = $conn->prepare("
                INSERT INTO products (
                    sr, device_name, device_type, device_model, notes, 
                    device_image, employee_id, department, created_at
                )
                VALUES (
                    :sr, :device_name, :device_type, :device_model, :notes,
                    :device_image, :employee_id, :department, NOW()
                )
            ");

            $stmt->execute(array(
                ':sr' => $sr,
                ':device_name' => $device_name,
                ':device_type' => $device_type,
                ':device_model' => $device_model,
                ':notes' => $notes,
                ':device_image' => $image,
                ':employee_id' => $employee_id,
                ':department' => $department
            ));

            if ($stmt) {
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تم الإضافة بنجاح</title>
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Almarai', sans-serif;
            background-color: #f1f4f8;
            direction: rtl;
        }
        .success-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .success-card {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 500px;
        }
        .success-icon {
            color: #10b981;
            font-size: 4rem;
            margin-bottom: 20px;
        }
        .success-title {
            color: #1e293b;
            font-weight: 700;
            font-size: 24px;
            margin-bottom: 15px;
        }
        .success-message {
            color: #64748b;
            margin-bottom: 30px;
        }
        .btn {
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            padding: 12px 24px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-primary {
            background: linear-gradient(135deg, #0d4f8b, #1e40af);
            color: white;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        .countdown {
            color: #6b7280;
            font-size: 14px;
            margin-top: 15px;
        }
    </style>
    <script>
        let countdown = 3;
        function updateCountdown() {
            document.getElementById('countdown-number').textContent = countdown;
            countdown--;
            if (countdown < 0) {
                window.location.href = 'products_manage.php';
            }
        }
        setInterval(updateCountdown, 1000);
    </script>
</head>
<body>
    <div class="success-container">
        <div class="success-card">
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h2 class="success-title">تم إضافة الجهاز بنجاح!</h2>
            <p class="success-message">تم حفظ بيانات الجهاز الجديد في المخزون.</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="products_manage.php" class="btn btn-primary">
                    <i class="fas fa-list"></i> عرض قائمة المخزون
                </a>
                <a href="products_add.php" class="btn btn-outline-primary">
                    <i class="fas fa-plus"></i> إضافة جهاز آخر
                </a>
            </div>
            <div class="countdown">
                سيتم توجيهك تلقائياً خلال <span id="countdown-number">3</span> ثوانِ
            </div>
        </div>
    </div>
</body>
</html>
<?php
            } else {
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>خطأ في الحفظ</title>
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Almarai', sans-serif;
            background-color: #f1f4f8;
            direction: rtl;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="alert alert-danger text-center">
                    فشل في حفظ بيانات الجهاز. يرجى المحاولة مرة أخرى.
                </div>
                <div class="text-center">
                    <a href="products_add.php" class="btn btn-primary">العودة لصفحة الإضافة</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php
            }
        }
    } else {
        header('location: products_manage.php');
        exit();
    }
    
    include $tpl . 'footer.php';
} else {
    header('location: logout.php');
}
ob_end_flush();
?>