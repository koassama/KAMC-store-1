<?php
ob_start();
session_start();

if (isset($_SESSION['admin'])) {
    $page = isset($_GET['page']) ? $_GET['page'] : 'edit';

    if ($page == 'edit') {
        $pageTitle = 'صفحة تعديل الجهاز';
        include 'init.php';
        
        // Get the device ID
        $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
        
        if ($id > 0) {
            // Fetch device data
            $stmt = $conn->prepare("SELECT * FROM comming WHERE id = ? LIMIT 1");
            $stmt->execute([$id]);
            $device = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$device) {
                header('Location: comming.php?page=manage');
                exit;
            }
        } else {
            header('Location: comming.php?page=manage');
            exit;
        }
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
        }

        .btn-secondary {
            background: #6b7280;
            color: white;
        }

        .btn-success {
            background: linear-gradient(135deg, #0d4f8b, #1e40af);
            color: white;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .form-row {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .form-row .form-group {
            flex: 1;
            min-width: 250px;
        }

        .alert {
            border-radius: 12px;
            padding: 15px 20px;
            margin-bottom: 20px;
            border: none;
            font-weight: 500;
        }

        .alert-danger {
            background: #fee2e2;
            color: #dc2626;
            border-left: 4px solid #dc2626;
        }

        .alert-success {
            background: #d1fae5;
            color: #047857;
            border-left: 4px solid #10b981;
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

            .btn-large {
                width: 100%;
                min-width: auto;
            }

            .btn-small {
                width: 100%;
            }

            .form-row {
                flex-direction: column;
                gap: 0;
            }

            .form-row .form-group {
                min-width: auto;
            }
        }
    </style>
</head>
<body style=" margin-right:220px; margin-left: 20px; width: 1100px">
    <div class="add-default-page add-post-page add-product-page" id="edit-page" style="margin: 120px;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <form class="add-form" method="POST" action="edit_comming.php?page=update" id="edit-form">
                        <h3>تعديل بيانات الجهاز</h3>
                        
                        <?php
                        // Display error messages
                        if (isset($_GET['error'])) {
                            $error = $_GET['error'];
                            $errorMessages = [
                                'missing_sr' => 'يجب إدخال الرقم التسلسلي',
                                'duplicate_sr' => 'الرقم التسلسلي موجود مسبقاً',
                                'update_failed' => 'فشل في تحديث البيانات'
                            ];
                            
                            if (isset($errorMessages[$error])) {
                                echo '<div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> ' . $errorMessages[$error] . '</div>';
                            }
                        }
                        
                        // Display success message
                        if (isset($_GET['success']) && $_GET['success'] == 'updated') {
                            echo '<div class="alert alert-success"><i class="fas fa-check-circle"></i> تم تحديث البيانات بنجاح</div>';
                        }
                        ?>
                        
                        <input type="hidden" name="id" value="<?php echo $device['id']; ?>">
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="sr">الرقم التسلسلي:</label>
                                <input type="text" name="sr" id="sr" value="<?php echo htmlspecialchars($device['sr']); ?>" required class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="name">اسم الجهاز:</label>
                                <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($device['name']); ?>" class="form-control">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="location">موقع الجهاز:</label>
                                <input type="text" name="location" id="location" value="<?php echo htmlspecialchars($device['location']); ?>" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="management">الإدارة:</label>
                                <input type="text" name="management" id="management" value="<?php echo htmlspecialchars($device['Management']); ?>" class="form-control">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="maintenance">عدد مرات الصيانة:</label>
                                <input type="number" name="maintenance" id="maintenance" value="<?php echo htmlspecialchars($device['maintenance']); ?>" min="0" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="type">نوع الطلب:</label>
                                <select name="type" id="type" class="form-control">
                                    <option value="الشركة" <?php echo ($device['type'] == 'الشركة') ? 'selected' : ''; ?>>الشركة</option>
                                    <option value="صيانة" <?php echo ($device['type'] == 'صيانة') ? 'selected' : ''; ?>>صيانة</option>
                                    <option value="استبدال" <?php echo ($device['type'] == 'استبدال') ? 'selected' : ''; ?>>استبدال</option>
                                    <option value="إصلاح" <?php echo ($device['type'] == 'إصلاح') ? 'selected' : ''; ?>>إصلاح</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="type_sa">نوع الصادر:</label>
                                <select name="type_sa" id="type_sa" class="form-control">
                                    <option value="بالمنشأة" <?php echo ($device['type_sa'] == 'بالمنشأة') ? 'selected' : ''; ?>>بالمنشأة</option>
                                    <option value="خارج المنشأة" <?php echo ($device['type_sa'] == 'خارج المنشأة') ? 'selected' : ''; ?>>خارج المنشأة</option>
                                    <option value="للصيانة" <?php echo ($device['type_sa'] == 'للصيانة') ? 'selected' : ''; ?>>للصيانة</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="status">حالة الجهاز:</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="0" <?php echo ($device['status'] == 0) ? 'selected' : ''; ?>>نشط</option>
                                    <option value="1" <?php echo ($device['status'] == 1) ? 'selected' : ''; ?>>غير نشط</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="remarq">ملاحظات:</label>
                            <textarea name="remarq" id="remarq" rows="4" class="form-control" placeholder="أدخل أي ملاحظات إضافية"><?php echo htmlspecialchars($device['remarq']); ?></textarea>
                        </div>

                        <div class="form-actions">
                            <a href="comming.php?page=manage" class="btn btn-secondary btn-large">
                                <i class="fas fa-arrow-right"></i> العودة للقائمة
                            </a>

                            <button type="submit" class="btn btn-success btn-large">
                                <i class="fas fa-save"></i> حفظ التعديلات
                            </button>
                        </div>
                    </form>
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

    } elseif ($page == 'update') {
        include 'init.php';
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id']) && is_numeric($_POST['id'])) {
            $id = intval($_POST['id']);
            $sr = trim($_POST['sr']);
            $name = trim($_POST['name']);
            $location = trim($_POST['location']);
            $management = trim($_POST['management']);
            $maintenance = intval($_POST['maintenance']);
            $type = trim($_POST['type']);
            $type_sa = trim($_POST['type_sa']);
            $status = intval($_POST['status']);
            $remarq = trim($_POST['remarq']);

            // Validate required fields
            if (empty($sr)) {
                header("Location: edit_comming.php?page=edit&id=$id&error=missing_sr");
                exit;
            }

            // Check if serial number already exists (excluding current record)
            $stmt_check = $conn->prepare("SELECT id FROM comming WHERE sr = ? AND id != ? LIMIT 1");
            $stmt_check->execute([$sr, $id]);
            
            if ($stmt_check->rowCount() > 0) {
                header("Location: edit_comming.php?page=edit&id=$id&error=duplicate_sr");
                exit;
            }

            // Update the record
            $stmt_update = $conn->prepare("UPDATE comming SET 
                sr = ?, 
                name = ?, 
                location = ?, 
                Management = ?, 
                maintenance = ?, 
                type = ?, 
                type_sa = ?, 
                status = ?, 
                remarq = ? 
                WHERE id = ?");
            
            $result = $stmt_update->execute([
                $sr, 
                $name, 
                $location, 
                $management, 
                $maintenance, 
                $type, 
                $type_sa, 
                $status, 
                $remarq, 
                $id
            ]);

            if ($result) {
                header("Location: comming.php?page=manage&success=updated");
            } else {
                header("Location: edit_comming.php?page=edit&id=$id&error=update_failed");
            }
            exit;
        } else {
            header('Location: comming.php?page=manage');
            exit;
        }
    } else {
        header('location: comming.php?page=manage');
        exit;
    }
} else {
    header('location: logout.php');
}
ob_end_flush();
?>