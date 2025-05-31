<?php
// تمكين عرض الأخطاء للتصحيح
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// الاتصال بقاعدة البيانات
$dsn = 'mysql:host=localhost;dbname=stor';
$user = 'root';
$pass = '';
$options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
);

try {
    $conn = new PDO($dsn, $user, $pass, $options);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // التحقق من إرسال الرقم التسلسلي
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['serial_number'])) {
        $serial_number = trim($_POST['serial_number']);

        // التحقق أولاً من عدم تكرار الرقم التسلسلي في جدول returns
        $stmt_duplicate = $conn->prepare("SELECT * FROM returns WHERE serial_number = :serial_number LIMIT 1");
        $stmt_duplicate->bindParam(':serial_number', $serial_number);
        $stmt_duplicate->execute();
        if ($stmt_duplicate->rowCount() > 0) {
            $error_message = "الرقم التسلسلي موجود بالفعل في قائمة الصيانة!";
        } else {
            // التحقق من وجود الرقم التسلسلي في المخزون (من جدول comming)
            $stmt_check = $conn->prepare("SELECT * FROM comming WHERE sr = :serial_number LIMIT 1");
            $stmt_check->bindParam(':serial_number', $serial_number);
            $stmt_check->execute();

            if ($stmt_check->rowCount() > 0) {
                // الجهاز موجود في المخزون
                $device = $stmt_check->fetch(PDO::FETCH_ASSOC);

                // إدخال الجهاز الجديد في جدول returns
                $stmt_insert = $conn->prepare("
                    INSERT INTO returns (serial_number, custody_number, device_location, remarks, storage_type, ram_type, device_name, maintenance_count, maintenance_request_number, type)
                    VALUES (:serial_number, :custody_number, :device_location, :remarks, :storage_type, :ram_type, :device_name, :maintenance_count, :maintenance_request_number, :type)
                ");
                $stmt_insert->execute([
                    'serial_number'              => $device['sr'],
                    'custody_number'             => $device['custody'] ?? '',
                    'device_location'            => $device['location'] ?? '',
                    'remarks'                    => $device['remarq'] ?? '',
                    'storage_type'               => $device['storeg_type'] ?? '',
                    'ram_type'                   => 'DDR3', // القيمة الافتراضية
                    'device_name'                => $device['name'] ?? '', 
                    'maintenance_count'          => $device['maintenance'] ?? '', 
                    'maintenance_request_number' => $device['maintenance_order'] ?? '',
                    'type'                       => 0 // القيمة الافتراضية   
                ]);

                // الحصول على ID الجهاز الذي تم إدخاله
                $new_id = $conn->lastInsertId();

                // حذف الجهاز من جدول comming
                $stmt_delete = $conn->prepare("DELETE FROM comming WHERE sr = :serial_number");
                $stmt_delete->bindParam(':serial_number', $serial_number);
                $stmt_delete->execute();

                // إعادة التوجيه إلى صفحة تعديل الجهاز
                header("Location: returns.php?page=edit&id=" . $new_id);
                exit;
            } else {
                // إذا لم يتم العثور على الجهاز في المخزون
                $error_message = "الرقم التسلسلي غير موجود في الاجهزة الصادرة!";
            }
        }
    }
} catch (PDOException $e) {
    $error_message = "خطأ في قاعدة البيانات: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة جهاز للصيانة</title>
    
    <!-- Bootstrap & Font Awesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Almarai', sans-serif;
            background-color: #f1f4f8;
            direction: rtl;
            margin: 0;
            padding: 0;
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
            max-width: 600px;
            margin: 0 auto;
        }

        .add-form h3 {
            color: #1e293b;
            font-weight: 700;
            margin-bottom: 30px;
            text-align: center;
            font-size: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }

        .page-icon {
            background: linear-gradient(135deg, #0d4f8b, #1e40af);
            color: white;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            box-shadow: 0 4px 15px rgba(13, 79, 139, 0.3);
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 12px;
            display: block;
            font-size: 16px;
        }

        .form-control {
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 15px 20px;
            font-size: 16px;
            transition: all 0.3s ease;
            font-family: 'Almarai', sans-serif;
            background-color: #fafbfc;
            min-height: 54px;
        }

        .form-control:focus {
            border-color: #0d4f8b;
            box-shadow: 0 0 0 3px rgba(13, 79, 139, 0.1);
            outline: none;
            background-color: white;
        }

        .form-control::placeholder {
            color: #9ca3af;
            font-weight: 400;
        }

        /* Button Styles */
        .btn {
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            margin: 5px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 16px;
        }

        .btn-large {
            padding: 18px 40px;
            font-size: 18px;
            min-width: 200px;
            justify-content: center;
        }

        .btn-small {
            padding: 10px 20px;
            font-size: 14px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #0d4f8b, #1e40af);
            color: white;
            box-shadow: 0 4px 15px rgba(13, 79, 139, 0.3);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #6b7280, #9ca3af);
            color: white;
            box-shadow: 0 4px 15px rgba(107, 114, 128, 0.3);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            box-shadow: 0 6px 25px rgba(13, 79, 139, 0.4);
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, #9ca3af, #d1d5db);
        }

        /* Form Actions */
        .form-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 40px;
            gap: 15px;
            flex-wrap: wrap;
        }

        /* Back Link */
        .back-link {
            font-size: 15px;
            border-radius: 10px;
            background: linear-gradient(135deg, #6b7280, #9ca3af);
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .back-link:hover {
            color: white;
            transform: translateY(-2px);
            background: linear-gradient(135deg, #9ca3af, #d1d5db);
            text-decoration: none;
        }

        /* Alert Styles */
        .alert {
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 25px;
            border: none;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .alert-danger {
            background: linear-gradient(135deg, #fef2f2, #fee2e2);
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        .alert-success {
            background: linear-gradient(135deg, #f0fdf4, #dcfce7);
            color: #16a34a;
            border: 1px solid #bbf7d0;
        }

        .alert-info {
            background: linear-gradient(135deg, #eff6ff, #dbeafe);
            color: #2563eb;
            border: 1px solid #bfdbfe;
        }

        .alert i {
            font-size: 20px;
        }

        /* Input validation styling */
        .form-control.is-valid {
            border-color: #10b981;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%2310b981' d='m2.3 6.73.1-.04L6.6 2.52c.2-.2.2-.5 0-.7-.2-.2-.5-.2-.7 0L3.2 4.5 1.4 2.7c-.2-.2-.5-.2-.7 0-.2.2-.2.5 0 .7l2.6 3.3z'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: left 15px center;
            background-size: 16px 16px;
            padding-left: 45px;
        }

        .form-control.is-invalid {
            border-color: #dc2626;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc2626'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath d='m5.8 4.6 1.4 1.4m0-1.4L5.8 6'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: left 15px center;
            background-size: 16px 16px;
            padding-left: 45px;
        }

        .invalid-feedback,
        .valid-feedback {
            display: block;
            margin-top: 8px;
            font-size: 14px;
            font-weight: 500;
        }

        .invalid-feedback {
            color: #dc2626;
        }

        .valid-feedback {
            color: #10b981;
        }

        /* Info Card */
        .info-card {
            background: linear-gradient(135deg, #eff6ff, #dbeafe);
            border: 1px solid #bfdbfe;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 25px;
            color: #1e40af;
        }

        .info-card h5 {
            color: #1e40af;
            font-weight: 600;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .info-card ul {
            margin: 0;
            padding-right: 20px;
        }

        .info-card li {
            margin-bottom: 5px;
        }

        /* Loading State */
        .btn.loading {
            pointer-events: none;
            opacity: 0.8;
        }

        .btn.loading::after {
            content: '';
            width: 16px;
            height: 16px;
            border: 2px solid transparent;
            border-top: 2px solid currentColor;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-right: 8px;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Animation */
        .add-form {
            animation: slideIn 0.4s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            body {
                margin-right: 0 !important;
                margin-top: 20px !important;
            }

            .add-form {
                padding: 25px;
                margin: 15px;
            }

            .add-form h3 {
                font-size: 24px;
                flex-direction: column;
                gap: 10px;
            }

            .page-icon {
                width: 50px;
                height: 50px;
                font-size: 20px;
            }

            .form-actions {
                flex-direction: column;
                gap: 10px;
            }

            .btn-large {
                width: 100%;
                min-width: auto;
            }

            .btn-small {
                width: 100%;
            }
        }

        @media (max-width: 576px) {
            .form-control {
                padding: 12px 16px;
                font-size: 14px;
            }

            .btn {
                font-size: 14px;
            }
        }
    </style>
</head>
<body style="margin-right: 350px; margin-top: 40px;">

<div class="add-default-page add-post-page add-product-page" id="add-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <form class="add-form" method="POST" action="" id="device-form">
                    <h3>
                        <span class="page-icon">
                            <i class="fas fa-tools"></i>
                        </span>
                        إضافة جهاز للصيانة
                        <a href="returns.php" class="back-link">
                            <i class="fas fa-arrow-right"></i> العودة
                        </a>
                    </h3>

                    <!-- Error Messages -->
                    <?php if (isset($error_message)): ?>
                        <div class="alert alert-danger" role="alert">
                            <i class="fas fa-exclamation-triangle"></i>
                            <?php echo $error_message; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Info Card -->
                    <div class="info-card">
                        <h5>
                            <i class="fas fa-info-circle"></i>
                            معلومات مهمة
                        </h5>
                        <ul>
                            <li>يجب أن يكون الجهاز موجود في قائمة الأجهزة الصادرة</li>
                            <li>سيتم نقل الجهاز تلقائياً من قائمة الصادرة إلى قائمة الصيانة</li>
                            <li>يمكنك تعديل تفاصيل الجهاز بعد الإضافة</li>
                        </ul>
                    </div>

                    <div class="form-group">
                        <label for="serial_number">
                            <i class="fas fa-barcode" style="margin-left: 8px; color: #0d4f8b;"></i>
                            الرقم التسلسلي للجهاز
                        </label>
                        <input type="text" 
                               name="serial_number" 
                               id="serial_number" 
                               placeholder="أدخل الرقم التسلسلي للجهاز (مثال: 70000004821)" 
                               required 
                               class="form-control"
                               autocomplete="off">
                        <div class="invalid-feedback">
                            يرجى إدخال رقم تسلسلي صحيح
                        </div>
                        <div class="valid-feedback">
                            رقم تسلسلي صحيح
                        </div>
                    </div>

                    <div class="form-actions">
                        <div class="d-flex gap-2">
                            <a href="returns.php" class="btn btn-secondary btn-small">
                                <i class="fas fa-times"></i> إلغاء
                            </a>
                        </div>
                        <button type="submit" class="btn btn-primary btn-large" id="submit-btn">
                            <i class="fas fa-plus"></i> إضافة للصيانة
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('device-form');
        const serialInput = document.getElementById('serial_number');
        const submitBtn = document.getElementById('submit-btn');

        // Real-time validation for serial number
        serialInput.addEventListener('input', function() {
            const value = this.value.trim();
            
            if (value.length === 0) {
                this.classList.remove('is-valid', 'is-invalid');
                return;
            }

            // Basic validation - at least 3 characters
            if (value.length >= 9) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            } else {
                this.classList.remove('is-valid');
                this.classList.add('is-invalid');
            }
        });

        // Form submission with loading state
        form.addEventListener('submit', function(e) {
            const serialValue = serialInput.value.trim();
            
            if (serialValue.length < 3) {
                e.preventDefault();
                serialInput.classList.add('is-invalid');
                serialInput.focus();
                return false;
            }

            // Add loading state
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري المعالجة...';
            
            // Optional: Add timeout to prevent infinite loading
            setTimeout(() => {
                submitBtn.classList.remove('loading');
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-plus"></i> إضافة للصيانة';
            }, 30000); // 30 seconds timeout
        });

        // Auto-focus on serial number input
        serialInput.focus();

        // Prevent form submission on Enter key if validation fails
        serialInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const value = this.value.trim();
                if (value.length < 3) {
                    e.preventDefault();
                    this.classList.add('is-invalid');
                }
            }
        });

        // Auto-uppercase for serial numbers
        serialInput.addEventListener('input', function() {
            this.value = this.value.toUpperCase();
        });
    });
</script>

</body>
</html>