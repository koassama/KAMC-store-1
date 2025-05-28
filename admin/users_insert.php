<?php
ob_start();
session_start();
if (isset($_SESSION['admin'])) {
    $pageTitle = "اضافة موظف";
    include 'init.php';
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $npass = $_POST['npassword'];
        $cpass = $_POST['cpassword'];
        $type = $_POST['type'];
        $wadifa = $_POST['wadifa'];
        $ratib = $_POST['ratib'];

        $formErrors = array();
        
        if (empty($username)) {
            $formErrors[] = 'اسم الموظف اجباري';
        }

        if (empty($email)) {
            $formErrors[] = 'بريد الالكتروني اجباري';
        }

        if (empty($phone)) {
            $formErrors[] = 'رقم الجوال اجباري';
        }

        if (empty($cpass)) {
            $formErrors[] = 'تاكيد كلمة المرور اجباري';
        }

        if (!empty($npass)) {
            if ($npass != $cpass) {
                $formErrors[] = 'كلمة المرور غير مطابقة';
            } else {
                $password = sha1($_POST['npassword']);
            }
        } else {
            $formErrors[] = 'كلمة المرور اجبارية';
        }

        if (empty($type) || $type == 'default') {
            $formErrors[] = 'نوع المستخدم اجباري';
        }

        // Check if email already exists
        if (empty($formErrors)) {
            $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
            $stmt->execute(array($email));
            if ($stmt->rowCount() > 0) {
                $formErrors[] = 'البريد الالكتروني مستخدم من قبل';
            }
        }

        // Check if username already exists
        if (empty($formErrors)) {
            $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? LIMIT 1");
            $stmt->execute(array($username));
            if ($stmt->rowCount() > 0) {
                $formErrors[] = 'اسم المستخدم مستخدم من قبل';
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
                <a href="users_add.php" class="btn btn-primary">العودة لصفحة الإضافة</a>
                <a href="users_manage.php" class="btn btn-secondary">قائمة الموظفين</a>
            </div>
        </div>
    </div>
</body>
</html>
<?php
        } else {
            // Insert new user
            $stmt = $conn->prepare("INSERT INTO users(username, password, email, type, phone, wadifa, ratib, created) VALUES(:zusername, :zpass, :zemail, :ztype, :zphone, :zwadifa, :zratib, now())");
            $stmt->execute(array(
                'zusername' => $username,
                'zpass' => $password,
                'zemail' => $email,
                'ztype' => $type,
                'zphone' => $phone,
                'zwadifa' => $wadifa,
                'zratib' => $ratib
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
                window.location.href = 'users_manage.php';
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
            <h2 class="success-title">تم إضافة الموظف بنجاح!</h2>
            <p class="success-message">تم حفظ بيانات الموظف الجديد في النظام.</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="users_manage.php" class="btn btn-primary">
                    <i class="fas fa-list"></i> عرض قائمة الموظفين
                </a>
                <a href="users_add.php" class="btn btn-outline-primary">
                    <i class="fas fa-plus"></i> إضافة موظف آخر
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
                    فشل في حفظ بيانات الموظف. يرجى المحاولة مرة أخرى.
                </div>
                <div class="text-center">
                    <a href="users_add.php" class="btn btn-primary">العودة لصفحة الإضافة</a>
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
        header('location: users_manage.php');
        exit();
    }
    
    include $tpl . 'footer.php';
} else {
    header('location: logout.php');
}
ob_end_flush();
?>