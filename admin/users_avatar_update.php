<?php
ob_start();
session_start();
if (isset($_SESSION['admin'])) {
    include 'init.php';

    $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : header('location: users_manage.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['upload'])) {
        $imageName = $_FILES['avatar']['name'];
        $imageSize = $_FILES['avatar']['size'];
        $imageTmp = $_FILES['avatar']['tmp_name'];
        $imageType = $_FILES['avatar']['type'];

        $imageAllowedExtension = array("jpeg", "jpg", "png", "gif");
        $Infunc = explode('.', $imageName);
        $imageExtension = strtolower(end($Infunc));
        $formErrors = array();

        if (empty($imageName)) {
            $formErrors[] = 'صورة الموظف اجبارية';
        }

        if (!empty($imageName) && !in_array($imageExtension, $imageAllowedExtension)) {
            $formErrors[] = 'نطاق الصورة غير مسموح';
        }

        if ($imageSize > 4194304) { // 4MB
            $formErrors[] = 'حجم الصورة كبير (الحد الأقصى 4 ميجابايت)';
        }

        if (!empty($formErrors)) {
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>خطأ في رفع الصورة</title>
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
            max-width: 500px;
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
            margin-top: 15px;
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
            <h3 class="mb-4">خطأ في رفع الصورة</h3>
            <?php
            foreach ($formErrors as $error) {
                echo '<div class="alert alert-danger">' . $error . '</div>';
            }
            ?>
            <div class="text-center">
                <a href="users_edit.php?id=<?php echo $id; ?>" class="btn btn-primary">العودة لصفحة التعديل</a>
            </div>
        </div>
    </div>
</body>
</html>
<?php
        } else {
            // Get old image to delete it
            $stmt = $conn->prepare("SELECT image FROM users WHERE id = ? LIMIT 1");
            $stmt->execute(array($id));
            $oldData = $stmt->fetch();
            $oldImage = $oldData['image'];

            // Generate new image name
            $image = rand(0, 100000) . '_' . $imageName;
            
            // Upload new image
            if (move_uploaded_file($imageTmp, $avatar . '/' . $image)) {
                // Update database
                $stmt = $conn->prepare("UPDATE users SET image = ? WHERE id = ? LIMIT 1");
                $stmt->execute(array($image, $id));

                // Delete old image if exists
                if (!empty($oldImage) && $oldImage != 'default.png' && file_exists($avatar . '/' . $oldImage)) {
                    unlink($avatar . '/' . $oldImage);
                }

?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تم تحديث الصورة</title>
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
        .new-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #10b981;
            margin: 20px auto;
            display: block;
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
        let countdown = 2;
        function updateCountdown() {
            document.getElementById('countdown-number').textContent = countdown;
            countdown--;
            if (countdown < 0) {
                window.location.href = 'users_edit.php?id=<?php echo $id; ?>';
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
            <h2 class="success-title">تم تحديث الصورة!</h2>
            <img src="<?php echo $avatar . '/' . $image; ?>" alt="صورة جديدة" class="new-avatar">
            <p class="success-message">تم رفع وحفظ الصورة الجديدة بنجاح.</p>
            <a href="users_edit.php?id=<?php echo $id; ?>" class="btn btn-primary">
                <i class="fas fa-arrow-right"></i> العودة لصفحة التعديل
            </a>
            <div class="countdown">
                سيتم توجيهك تلقائياً خلال <span id="countdown-number">2</span> ثانية
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
    <title>فشل في رفع الصورة</title>
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
                    <h4>فشل في رفع الصورة</h4>
                    <p>حدث خطأ أثناء رفع الصورة. يرجى المحاولة مرة أخرى.</p>
                </div>
                <div class="text-center">
                    <a href="users_edit.php?id=<?php echo $id; ?>" class="btn btn-primary">العودة لصفحة التعديل</a>
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
        header('location: users_edit.php?id=' . $id);
    }
    
    include $tpl . 'footer.php';
} else {
    header('location: logout.php');
}
ob_end_flush();
?>