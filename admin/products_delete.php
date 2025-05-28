<?php
ob_start();
session_start();
if (isset($_SESSION['admin'])) {
    include 'init.php';
    
    if ($_SESSION['type'] == 2) {
        $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : header('location: products_manage.php');
        
        // Get product info before deletion
        $stmt = $conn->prepare("SELECT * FROM products WHERE id = ? LIMIT 1");
        $stmt->execute(array($id));
        $productInfo = $stmt->fetch();
        $check = $stmt->rowCount();

        if ($check > 0) {
            // Delete product image if exists
            if (!empty($productInfo['device_image']) && file_exists($images . '/' . $productInfo['device_image'])) {
                unlink($images . '/' . $productInfo['device_image']);
            }

            // Delete product from database
            $stmt = $conn->prepare("DELETE FROM products WHERE id = :zid");
            $stmt->bindParam(":zid", $id);
            $stmt->execute();
            
            // Success page
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تم حذف المنتج</title>
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
            margin-bottom: 20px;
        }
        .deleted-product-info {
            background: #f8fafc;
            padding: 20px;
            border-radius: 12px;
            margin: 20px 0;
            border: 1px solid #e2e8f0;
        }
        .deleted-product-info strong {
            color: #374151;
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
        let countdown = 4;
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
            <h2 class="success-title">تم حذف المنتج بنجاح!</h2>
            <p class="success-message">تم حذف المنتج التالي من المخزون:</p>
            
            <div class="deleted-product-info">
                <p><strong>الرقم التسلسلي:</strong> <?php echo htmlspecialchars($productInfo['sr']); ?></p>
                <p><strong>اسم الجهاز:</strong> <?php echo htmlspecialchars($productInfo['device_name']); ?></p>
                <p><strong>نوع الجهاز:</strong> <?php echo htmlspecialchars($productInfo['device_type']); ?></p>
                <p><strong>الموديل:</strong> <?php echo htmlspecialchars($productInfo['device_model']); ?></p>
                <?php if (!empty($productInfo['employee_id'])): ?>
                <p><strong>الرقم الوظيفي:</strong> <?php echo htmlspecialchars($productInfo['employee_id']); ?></p>
                <?php endif; ?>
                <?php if (!empty($productInfo['department'])): ?>
                <p><strong>الإدارة:</strong> <?php echo htmlspecialchars($productInfo['department']); ?></p>
                <?php endif; ?>
            </div>
            
            <a href="products_manage.php" class="btn btn-primary">
                <i class="fas fa-arrow-right"></i> العودة لقائمة المخزون
            </a>
            <div class="countdown">
                سيتم توجيهك تلقائياً خلال <span id="countdown-number">4</span> ثوانِ
            </div>
        </div>
    </div>
</body>
</html>
<?php
        } else {
            // Product not found
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>منتج غير موجود</title>
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
            font-size: 4rem;
            margin-bottom: 20px;
        }
        .error-title {
            color: #1e293b;
            font-weight: 700;
            font-size: 24px;
            margin-bottom: 15px;
        }
        .error-message {
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
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-card">
            <div class="error-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h2 class="error-title">منتج غير موجود</h2>
            <p class="error-message">لم يتم العثور على المنتج المطلوب حذفه.</p>
            <a href="products_manage.php" class="btn btn-primary">
                <i class="fas fa-arrow-right"></i> العودة لقائمة المخزون
            </a>
        </div>
    </div>
</body>
</html>
<?php
        }
    } else {
        // Access denied - not admin
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>غير مسموح</title>
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
        .access-denied-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .access-denied-card {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 500px;
        }
        .access-denied-icon {
            color: #f59e0b;
            font-size: 4rem;
            margin-bottom: 20px;
        }
        .access-denied-title {
            color: #1e293b;
            font-weight: 700;
            font-size: 24px;
            margin-bottom: 15px;
        }
        .access-denied-message {
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
    </style>
</head>
<body style="margin: 20px;">
    <div class="access-denied-container">
        <div class="access-denied-card">
            <div class="access-denied-icon">
                <i class="fas fa-lock"></i>
            </div>
            <h2 class="access-denied-title">غير مسموح</h2>
            <p class="access-denied-message">ليس لديك صلاحية لحذف المنتجات. يتطلب صلاحيات مدير.</p>
            <a href="products_manage.php" class="btn btn-primary">
                <i class="fas fa-arrow-right"></i> العودة لقائمة المخزون
            </a>
        </div>
    </div>
</body>
</html>
<?php
    }
} else {
    header('location: logout.php');
}
ob_end_flush();
?>