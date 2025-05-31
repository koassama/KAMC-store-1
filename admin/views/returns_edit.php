<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل الجهاز</title>
    
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

        .edit-page {
            background-color: #f1f4f8;
            min-height: 100vh;
            padding: 40px 0;
        }

        .cnt-spc {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .pg-tt h1 {
            color: #1e293b;
            font-weight: 700;
            margin-bottom: 30px;
            font-size: 28px;
            text-align: right;
        }

        .use-fl-info {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
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

        .form-control select {
            height: 48px;
        }

        textarea.form-control {
            min-height: 100px;
            resize: vertical;
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

        .btn-primary {
            background: linear-gradient(135deg, #0d4f8b, #1e40af);
            color: white;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .row {
            margin: 0 -10px;
        }

        .col-md-6,
        .col-md-12 {
            padding: 0 10px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .cnt-spc {
                padding: 20px;
            }

            .use-fl-info {
                padding: 20px;
            }

            .pg-tt h1 {
                font-size: 22px;
                text-align: center;
            }
        }
    </style>
</head>
<body style="margin-right:500px; margin-left: 20px; margin-top: 40px; width: 1000px">

<div class="edit-page user-edit-pages deep-page">
    <div class="container cnt-spc">
        <div class="row">
            <div class="col-md-12">
                <div class="pg-tt">
                    <h1>تعديل الرجيع <?php echo $userInfo['device_name'] ?></h1>
                </div>
            </div>

            <div class="col-md-12">
                <div class="use-fl-info">
                    <form method="post" action="returns.php?page=update" enctype="multipart/form-data">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="serial_number">SR (Serial Number)</label>
                                <input value="<?php echo htmlspecialchars($userInfo['serial_number'] ?? ''); ?>" type="text" name="serial_number" id="serial_number" placeholder="SR (Serial Number)" class="form-control" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="custody_number">رقم العهدة</label>
                                <input value="<?php echo htmlspecialchars($userInfo['custody_number'] ?? ''); ?>" type="text" name="custody_number" id="custody_number" placeholder="رقم العهدة" class="form-control" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="device_location">موقع الجهاز</label>
                                <input value="<?php echo htmlspecialchars($userInfo['device_location'] ?? ''); ?>" type="text" name="device_location" id="device_location" placeholder="موقع الجهاز" class="form-control">
                            </div>

                            <div class="form-group col-12">
                                <label for="remarks">ملاحظات</label>
                                <textarea name="remarks" id="remarks" class="form-control" placeholder="ملاحظات"><?php echo htmlspecialchars($userInfo['remarks'] ?? ''); ?></textarea>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="storage_type">نوع وحدة التخزين</label>
                                <select class="form-control" name="storage_type" id="storage_type">
                                    <option value="">اختر نوع التخزين</option>
                                    <option value="SSD" <?php echo ($userInfo['storage_type'] ?? '') == 'SSD' ? 'selected' : ''; ?>>SSD</option>
                                    <option value="HDD" <?php echo ($userInfo['storage_type'] ?? '') == 'HDD' ? 'selected' : ''; ?>>HDD</option>
                                    <option value="M2" <?php echo ($userInfo['storage_type'] ?? '') == 'M2' ? 'selected' : ''; ?>>M2</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="ram_type">نوع RAM</label>
                                <input value="<?php echo htmlspecialchars($userInfo['ram_type'] ?? ''); ?>" type="text" name="ram_type" id="ram_type" placeholder="نوع RAM" class="form-control">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="device_name">اسم الجهاز</label>
                                <input value="<?php echo htmlspecialchars($userInfo['device_name'] ?? ''); ?>" type="text" name="device_name" id="device_name" placeholder="اسم الجهاز" class="form-control" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="maintenance_count">عدد مرات الصيانة</label>
                                <input value="<?php echo htmlspecialchars($userInfo['maintenance_count'] ?? ''); ?>" type="text" name="maintenance_count" id="maintenance_count" placeholder="عدد مرات الصيانة" class="form-control">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="maintenance_request_number">رقم طلب الصيانة</label>
                                <input value="<?php echo htmlspecialchars($userInfo['maintenance_request_number'] ?? ''); ?>" type="text" name="maintenance_request_number" id="maintenance_request_number" placeholder="رقم طلب الصيانة" class="form-control">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="type">مصدر الجهاز</label>
                                <select class="form-control" name="type" id="type">
                                    <option value="0" <?php echo ($userInfo['type'] ?? '') == '0' ? 'selected' : ''; ?>>الشركة</option>
                                    <option value="1" <?php echo ($userInfo['type'] ?? '') == '1' ? 'selected' : ''; ?>>المنافسة</option>
                                    <option value="2" <?php echo ($userInfo['type'] ?? '') == '2' ? 'selected' : ''; ?>>السوق الالكتروني</option>
                                    <option value="3" <?php echo ($userInfo['type'] ?? '') == '3' ? 'selected' : ''; ?>>الشراء المباشر</option>
                                </select>
                            </div>

                            <!-- Hidden ID field -->
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($userInfo['id'] ?? ''); ?>">

                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> حفظ التغييرات
                                </button>
                                <a href="returns.php" class="btn btn-secondary">
                                    <i class="fas fa-arrow-right"></i> العودة للقائمة
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>