<?php
ob_start();
session_start();
if (isset($_SESSION['admin'])) {
    $pageTitle = 'تحديث بيانات الموظف';
    include 'init.php';
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_POST['id'];

        $stmt = $conn->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
        $stmt->execute(array($id));
        $checkIfuser = $stmt->rowCount();
        $data = $stmt->fetch();

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

        // Check password
        if (empty($npass)) {
            // Keep existing password
            $stmt = $conn->prepare("SELECT password FROM users WHERE id = ? LIMIT 1");
            $stmt->execute(array($id));
            $passs = $stmt->fetch();
            $password = $passs['password'];
        } else {
            if ($npass != $cpass) {
                $formErrors[] = 'كلمة المرور غير مطابقة';
            } else {
                $password = sha1($_POST['npassword']);
            }
        }

        // Check if email exists for other users
        if (empty($formErrors)) {
            $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ? LIMIT 1");
            $stmt->execute(array($email, $id));
            if ($stmt->rowCount() > 0) {
                $formErrors[] = 'البريد الالكتروني مستخدم من قبل موظف آخر';
            }
        }

        // Check if username exists for other users
        if (empty($formErrors)) {
            $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? AND id != ? LIMIT 1");
            $stmt->execute(array($username, $id));
            if ($stmt->rowCount() > 0) {
                $formErrors[] = 'اسم المستخدم مستخدم من قبل موظف آخر';
            }
        }

        if (!empty($formErrors)) {
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>خطأ في التحديث</title>
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
            margin: 10px 5px;
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
                <a href="users_edit.php?id=<?php echo $id; ?>" class="btn btn-primary">العودة لصفحة التعديل</a>
                <a href="users_manage.php" class="btn btn-secondary">قائمة الموظفين</a>
            </div>
        </div>
    </div>
</body>
</html>
<?php
        } else {
            // Update user data
            $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, password = ?, type = ?, phone = ?, wadifa = ?, ratib = ? WHERE id = ?");
            $stmt->execute(array($username, $email, $password, $type, $phone, $wadifa, $ratib, $id));

            if ($stmt->rowCount() > 0) {
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تم التحديث بنجاح</title>
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
            min-height: 20px;
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
<body >
    <div class="success-container">
        <div class="success-card">
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h2 class="success-title">تم التحديث بنجاح!</h2>
            <p class="success-message">تم تحديث بيانات الموظف بنجاح.</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="users_manage.php" class="btn btn-primary">
                    <i class="fas fa-list"></i> قائمة الموظفين
                </a>
                <a href="users_edit.php?id=<?php echo $id; ?>" class="btn btn-outline-primary">
                    <i class="fas fa-edit"></i> متابعة التعديل
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
    <title>لم يتم التحديث</title>
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
                <div class="alert alert-warning text-center">
                    <h4>لم يتم التحديث</h4>
                    <p>لم يتم العثور على تغييرات أو فشل في التحديث.</p>
                </div>
                <div class="text-center">
                    <a href="users_edit.php?id=<?php echo $id; ?>" class="btn btn-primary">العودة للتعديل</a>
                    <a href="users_manage.php" class="btn btn-secondary">قائمة الموظفين</a>
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
    }
    
    include $tpl . 'footer.php';
} else {
    header('location: logout.php');
}
ob_end_flush();
?>