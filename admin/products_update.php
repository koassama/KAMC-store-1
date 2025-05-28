<?php
ob_start();
session_start();
if (isset($_SESSION['admin'])) {
    $pageTitle = 'صفحة تحديث المعلومات';
    include 'init.php';
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = isset($_POST['id']) && is_numeric($_POST['id']) ? intval($_POST['id']) : header('location: products_manage.php');

        $stmt = $conn->prepare("SELECT * FROM products WHERE id = ? LIMIT 1");
        $stmt->execute(array($id));
        $checkpst = $stmt->rowCount();

        if ($checkpst > 0) {
            $device_type = isset($_POST['device_type']) ? $_POST['device_type'] : '';
            $device_model = isset($_POST['device_model']) ? $_POST['device_model'] : '';
            $notes = isset($_POST['notes']) ? $_POST['notes'] : '';
            $sr = isset($_POST['sr']) ? $_POST['sr'] : '';
            $device_name = isset($_POST['device_name']) ? $_POST['device_name'] : '';
            $employee_id = isset($_POST['employee_id']) ? $_POST['employee_id'] : '';
            $department = isset($_POST['department']) ? $_POST['department'] : '';
            
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
                $formErrors[] = 'الرقم التسلسلي مطلوب';
            }

            if (empty($device_name)) {
                $formErrors[] = 'اسم الجهاز مطلوب';
            }

            if (empty($device_type)) {
                $formErrors[] = 'نوع الجهاز مطلوب';
            }

            // Image validation (only if new image is uploaded)
            if (!empty($imageName)) {
                if (!in_array($imageExtension, $imageAllowedExtension)) {
                    $formErrors[] = 'نطاق الصورة غير مسموح به';
                }
                if ($imageSize > 4194304) {
                    $formErrors[] = 'حجم الصورة كبير';
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
                <a href="products_edit.php?id=<?php echo $id; ?>" class="btn btn-primary">العودة لصفحة التعديل</a>
                <a href="products_manage.php" class="btn btn-secondary">قائمة المنتجات</a>
            </div>
        </div>
    </div>
</body>
</html>
<?php
            } else {
                // Handle image update
                if (empty($imageName)) {
                    // Keep existing image
                    $stmt = $conn->prepare("SELECT device_image FROM products WHERE id = ? LIMIT 1");
                    $stmt->execute(array($id));
                    $igg = $stmt->fetch();
                    $image = $igg['device_image'];
                } else {
                    // Upload new image
                    $image = rand(0, 100000) . '_' . $imageName;
                    move_uploaded_file($imageTmp, $images . '/' . $image);
                }

                // Update database
                $stmt = $conn->prepare("
                    UPDATE products
                    SET
                        sr = ?,
                        device_name = ?,
                        device_type = ?,
                        device_model = ?,
                        notes = ?,
                        device_image = ?,
                        employee_id = ?,
                        department = ?,
                        created_at = NOW()
                    WHERE id = ?
                ");

                $stmt->execute(array(
                    $sr,
                    $device_name,
                    $device_type,
                    $device_model,
                    $notes,
                    $image,
                    $employee_id,
                    $department,
                    $id
                ));

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
            <h2 class="success-title">تم التحديث بنجاح!</h2>
            <p class="success-message">تم تحديث بيانات الجهاز بنجاح.</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="products_manage.php" class="btn btn-primary">
                    <i class="fas fa-list"></i> قائمة المنتجات
                </a>
                <a href="products_edit.php?id=<?php echo $id; ?>" class="btn btn-outline-primary">
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
                    <a href="products_edit.php?id=<?php echo $id; ?>" class="btn btn-primary">العودة للتعديل</a>
                    <a href="products_manage.php" class="btn btn-secondary">قائمة المنتجات</a>
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
        }
    } else {
        header('location: products_manage.php');
    }
    
    include $tpl . 'footer.php';
} else {
    header('location: logout.php');
}
ob_end_flush();
?>