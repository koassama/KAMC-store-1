<?php
ob_start();
session_start();
if (isset($_SESSION['admin'])) {
    $pageTitle = 'اضافة منتج جديد';
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

        .back-link {
            font-size: 15px;
            border-radius: 10px;
            background: var(--mainColor, #0d4f8b);
            color: white;
            padding: 8px;
            text-decoration: none;
            margin-left: 5px;
            transition: all 0.3s ease;
        }

        .back-link:hover {
            color: white;
            transform: translateY(-1px);
        }

        .err-msg {
            margin-top: 20px;
        }

        /* File Upload Styling */
        .form-control[type="file"] {
            padding: 8px 12px;
        }

        .form-control[type="file"]::-webkit-file-upload-button {
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 8px 16px;
            margin-left: 10px;
            color: #374151;
            font-family: 'Almarai', sans-serif;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .form-control[type="file"]::-webkit-file-upload-button:hover {
            background: linear-gradient(135deg, #e2e8f0, #cbd5e1);
        }

        /* Textarea Styling */
        textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }

        /* Select Styling */
        select.form-control {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: left 12px center;
            background-repeat: no-repeat;
            background-size: 16px 12px;
            padding-left: 40px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .add-form {
                padding: 25px;
                margin: 15px;
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
    </style>
</head>
<body style="margin-right: 220px">
    <div class="add-default-page add-post-page add-product-page" id="add-page">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <form class="add-form" method="POST" action="products_insert.php" enctype="multipart/form-data" id="ca-form-info">
                        <h3>اضافة منتج جديد
                            <a style="margin-left:5px;font-size:15px;border-radius: 10px;background:var(--mainColor, #0d4f8b);color:white;padding:8px" href="products_manage.php" class="fas fa-long-arrow-alt-right"></a>
                        </h3>

                        <div class="row">
                            <!-- Serial Number -->
                            <div class="form-group col-md-6">
                                <label for="sr">الرقم التسلسلي</label>
                                <input type="text" name="sr" id="sr" placeholder="أدخل الرقم التسلسلي" required class="form-control">
                            </div>

                            <!-- Device Name -->
                            <div class="form-group col-md-6">
                                <label for="device_name">اسم الجهاز</label>
                                <input type="text" name="device_name" id="device_name" placeholder="اسم الجهاز" required class="form-control">
                            </div>

                            <!-- Device Type -->
                            <div class="form-group col-md-6">
                                <label for="device_type">نوع الجهاز</label>
                                <select class="form-control" name="device_type" id="device_type" required>
                                    <option value="">اختر نوع الجهاز</option>
                                    <option value="HP">HP</option>
                                    <option value="Dell">Dell</option>
                                    <option value="Lenovo">Lenovo</option>
                                    <option value="Zebra">Zebra</option>
                                    <option value="جدارية">جدارية</option>
                                    <option value="portabol">Portable</option>
                                    <option value="Signature pad">Signature pad</option>
                                </select>
                            </div>

                            <!-- Device Model -->
                            <div class="form-group col-md-6">
                                <label for="device_model">موديل الجهاز</label>
                                <input type="text" name="device_model" id="device_model" placeholder="موديل الجهاز" class="form-control">
                            </div>

                            <!-- Employee ID -->
                            <div class="form-group col-md-6">
                                <label for="employee_id">الرقم الوظيفي</label>
                                <input type="text" name="employee_id" id="employee_id" placeholder="الرقم الوظيفي" class="form-control">
                            </div>

                            <!-- Department -->
                            <div class="form-group col-md-6">
                                <label for="department">الإدارة</label>
                                <input type="text" name="department" id="department" placeholder="الإدارة" class="form-control">
                            </div>

                            <!-- Notes -->
                            <div class="form-group col-md-12">
                                <label for="notes">ملاحظات</label>
                                <textarea name="notes" id="notes" placeholder="أدخل أي ملاحظات إضافية" class="form-control"></textarea>
                            </div>

                            <!-- Device Image -->
                            <div class="form-group col-md-12">
                                <label for="image">صورة الجهاز</label>
                                <input type="file" name="image" id="image" class="form-control" accept="image/*">
                                <small class="form-text text-muted">يُفضل رفع صورة بصيغة JPG أو PNG (الحد الأقصى 4 ميجابايت)</small>
                            </div>
                        </div>

                        <div class="form-actions">
                            <a href="products_manage.php" class="btn btn-secondary btn-small">
                                <i class="fas fa-arrow-right"></i> العودة
                            </a>
                            <input type="submit" class="btn btn-primary btn-large" id="ca-btn-option" value="إضافة المنتج">
                        </div>

                        <div class="err-msg"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Form validation
        document.getElementById('ca-form-info').addEventListener('submit', function(e) {
            const sr = document.getElementById('sr').value.trim();
            const deviceName = document.getElementById('device_name').value.trim();
            const deviceType = document.getElementById('device_type').value;
            const errMsg = document.querySelector('.err-msg');
            
            errMsg.innerHTML = '';
            
            if (!sr) {
                e.preventDefault();
                errMsg.innerHTML = '<div class="alert alert-danger">الرقم التسلسلي مطلوب</div>';
                return false;
            }
            
            if (!deviceName) {
                e.preventDefault();
                errMsg.innerHTML = '<div class="alert alert-danger">اسم الجهاز مطلوب</div>';
                return false;
            }
            
            if (!deviceType) {
                e.preventDefault();
                errMsg.innerHTML = '<div class="alert alert-danger">نوع الجهاز مطلوب</div>';
                return false;
            }
        });

        // File size validation
        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const errMsg = document.querySelector('.err-msg');
            
            if (file && file.size > 4194304) { // 4MB
                errMsg.innerHTML = '<div class="alert alert-warning">حجم الصورة كبير جداً (الحد الأقصى 4 ميجابايت)</div>';
                this.value = '';
            } else {
                errMsg.innerHTML = '';
            }
        });
    </script>
</body>
</html>

<?php
include $tpl . 'footer.php';
} else {
    header('location: logout.php');
}
ob_end_flush();
?>