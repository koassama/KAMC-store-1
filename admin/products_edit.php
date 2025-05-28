<?php
ob_start();
session_start();
if (isset($_SESSION['admin'])) {
    $pageTitle = "صفحة تعديل المنتجات";
    include 'init.php';

    $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : header('location: products_manage.php');
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ? LIMIT 1");
    $stmt->execute(array($id));
    $checkpost = $stmt->rowCount();
    $postinfo = $stmt->fetch();
    
    if ($checkpost > 0) {
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

        .container {
            padding: 30px;
        }

        .cnt-spc {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            margin-top: 20px;
        }

        .pg-tt h1 {
            font-size: 28px;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
            text-align: right;
        }

        /* Form Styles */
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

        /* Current Image Display */
        .current-image {
            margin-top: 15px;
            text-align: center;
        }

        .current-image img {
            max-width: 200px;
            height: auto;
            border-radius: 12px;
            border: 2px solid #e5e7eb;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .current-image p {
            margin-top: 10px;
            color: #64748b;
            font-size: 14px;
        }

        /* File Upload Styling */
        .form-control[type="file"] {
            padding: 8px 12px;
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
            .container {
                padding: 15px;
            }

            .cnt-spc {
                padding: 20px;
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
<body>
    <div class="edit-page user-edit-pages deep-page" style="width: 1000px;
    margin-right: 263px;
    margin-top: 62px;">
        <div class="container cnt-spc">
            <div class="row justify-content-end">
                <div class="col-md-12">
                    <div class="pg-tt" style="text-align:right">
                        <h1>تعديل الجهاز - <?php echo htmlspecialchars($postinfo['device_type']); ?>
                            <a style="margin-left:5px;font-size:15px;border-radius: 10px;background:var(--mainColor, #0d4f8b);color:white;padding:8px" href="products_manage.php" class="fas fa-long-arrow-alt-right"></a>
                        </h1>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="use-fl-info">
                        <form class="form" method="post" action="products_update.php" enctype="multipart/form-data" style="margin-bottom:60px">
                            <input type="hidden" name="id" value="<?php echo $postinfo['id']; ?>">
                            
                            <div class="row">
                                <!-- Serial Number -->
                                <div class="form-group col-md-6">
                                    <label for="sr">الرقم التسلسلي</label>
                                    <input type="text" value="<?php echo isset($postinfo['sr']) ? htmlspecialchars($postinfo['sr']) : ''; ?>" name="sr" id="sr" placeholder="الرقم التسلسلي" class="form-control" required>
                                </div>

                                <!-- Device Name -->
                                <div class="form-group col-md-6">
                                    <label for="device_name">اسم الجهاز</label>
                                    <input type="text" value="<?php echo isset($postinfo['device_name']) ? htmlspecialchars($postinfo['device_name']) : ''; ?>" name="device_name" id="device_name" placeholder="اسم الجهاز" class="form-control" required>
                                </div>

                                <!-- Device Type -->
                                <div class="form-group col-md-6">
                                    <label for="device_type">نوع الجهاز</label>
                                    <select class="form-control" name="device_type" id="device_type" required>
                                        <option value="">اختر نوع الجهاز</option>
                                        <option value="HP" <?php echo ($postinfo['device_type'] == 'HP') ? 'selected' : ''; ?>>HP</option>
                                        <option value="Dell" <?php echo ($postinfo['device_type'] == 'Dell') ? 'selected' : ''; ?>>Dell</option>
                                        <option value="Lenovo" <?php echo ($postinfo['device_type'] == 'Lenovo') ? 'selected' : ''; ?>>Lenovo</option>
                                        <option value="Zebra" <?php echo ($postinfo['device_type'] == 'Zebra') ? 'selected' : ''; ?>>Zebra</option>
                                        <option value="جدارية" <?php echo ($postinfo['device_type'] == 'جدارية') ? 'selected' : ''; ?>>جدارية</option>
                                        <option value="portabol" <?php echo ($postinfo['device_type'] == 'portabol') ? 'selected' : ''; ?>>Portable</option>
                                        <option value="Signature pad" <?php echo ($postinfo['device_type'] == 'Signature pad') ? 'selected' : ''; ?>>Signature pad</option>
                                    </select>
                                </div>

                                <!-- Device Type -->
                                <div class="form-group col-md-6">
                                    <label for="device_type">نوع الجهاز</label>
                                    <select class="form-control" name="device_type" id="device_type" required>
                                        <option value="">اختر نوع الجهاز</option>
                                        <option value="HP" <?php echo ($postinfo['device_type'] == 'HP') ? 'selected' : ''; ?>>HP</option>
                                        <option value="Dell" <?php echo ($postinfo['device_type'] == 'Dell') ? 'selected' : ''; ?>>Dell</option>
                                        <option value="Lenovo" <?php echo ($postinfo['device_type'] == 'Lenovo') ? 'selected' : ''; ?>>Lenovo</option>
                                        <option value="Zebra" <?php echo ($postinfo['device_type'] == 'Zebra') ? 'selected' : ''; ?>>Zebra</option>
                                        <option value="جدارية" <?php echo ($postinfo['device_type'] == 'جدارية') ? 'selected' : ''; ?>>جدارية</option>
                                        <option value="portabol" <?php echo ($postinfo['device_type'] == 'portabol') ? 'selected' : ''; ?>>Portable</option>
                                        <option value="Signature pad" <?php echo ($postinfo['device_type'] == 'Signature pad') ? 'selected' : ''; ?>>Signature pad</option>
                                    </select>
                                </div>

                                <!-- Device Model -->
                                <div class="form-group col-md-6">
                                    <label for="device_model">موديل الجهاز</label>
                                    <input type="text" value="<?php echo isset($postinfo['device_model']) ? htmlspecialchars($postinfo['device_model']) : ''; ?>" name="device_model" id="device_model" placeholder="موديل الجهاز" class="form-control">
                                </div>

                                <!-- Employee ID -->
                                <div class="form-group col-md-6">
                                    <label for="employee_id">الرقم الوظيفي</label>
                                    <input type="text" value="<?php echo isset($postinfo['employee_id']) ? htmlspecialchars($postinfo['employee_id']) : ''; ?>" name="employee_id" id="employee_id" placeholder="الرقم الوظيفي" class="form-control">
                                </div>

                                <!-- Department -->
                                <div class="form-group col-md-6">
                                    <label for="department">الإدارة</label>
                                    <input type="text" value="<?php echo isset($postinfo['department']) ? htmlspecialchars($postinfo['department']) : ''; ?>" name="department" id="department" placeholder="الإدارة" class="form-control">
                                </div>

                                <!-- Notes -->
                                <div class="form-group col-md-12">
                                    <label for="notes">ملاحظات</label>
                                    <textarea name="notes" id="notes" placeholder="ملاحظات" class="form-control"><?php echo isset($postinfo['notes']) ? htmlspecialchars($postinfo['notes']) : ''; ?></textarea>
                                </div>

                                <!-- Current Image Display -->
                                <?php if (!empty($postinfo['device_image'])): ?>
                                <div class="form-group col-md-12">
                                    <label>الصورة الحالية</label>
                                    <div class="current-image">
                                        <img src="<?php echo $images . $postinfo['device_image']; ?>" alt="صورة الجهاز الحالية">
                                        <p>الصورة الحالية للجهاز</p>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <!-- New Image Upload -->
                                <div class="form-group col-md-12">
                                    <label for="image">تحديث صورة الجهاز</label>
                                    <input type="file" name="image" id="image" class="form-control" accept="image/*">
                                    <small class="form-text text-muted">اتركها فارغة للاحتفاظ بالصورة الحالية</small>
                                </div>
                            </div>

                            <div class="form-actions">
                                <a href="products_manage.php" class="btn btn-secondary btn-small">
                                    <i class="fas fa-arrow-right"></i> العودة
                                </a>
                                <input type="submit" class="btn btn-primary btn-large" value="احفظ التغييرات">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // File size validation
        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            
            if (file && file.size > 4194304) { // 4MB
                alert('حجم الصورة كبير جداً (الحد الأقصى 4 ميجابايت)');
                this.value = '';
            }
        });
    </script>
</body>
</html>

<?php
    } else {
        header('location: products_manage.php');
    }
    
    include $tpl . 'footer.php';
} else {
    header('location: logout.php');
}
ob_end_flush();
?>