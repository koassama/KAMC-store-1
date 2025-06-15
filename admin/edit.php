<?php
ob_start();
session_start();
if (isset($_SESSION['admin'])) {
    $pageTitle = "تعديل الجهاز";
    include 'init.php';

    $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : header('location: consumers.php');
    $stmt = $conn->prepare("SELECT * FROM consumers WHERE id = ? LIMIT 1");
    $stmt->execute(array($id));
    $checkIfuserExist = $stmt->rowCount();
    $userInfo = $stmt->fetch();
    
    if ($checkIfuserExist > 0) {
        if ($_SESSION['type'] == 2 or $_SESSION['id'] == $userInfo['id']) {
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
<body style="margin-right: 250px; margin-left: 20px; margin-top: 110px">
    <div class="edit-page user-edit-pages deep-page">
        <div class="container cnt-spc">
            <div class="row">
                <div class="col-md-12">
                    <div class="pg-tt">
                        <h1 dir="rtl" style="display:block;text-align:right">تعديل المستهلك <?php echo htmlspecialchars($userInfo['consumer_name']); ?></h1>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="use-fl-info">
                        <form method="post" action="update.php" enctype="multipart/form-data">
                            <div class="row">
                                <!-- Consumer Name -->
                                <div class="form-group col-md-6">
                                    <label for="consumer_name">اسم المستهلك</label>
                                    <input type="text" value="<?php echo isset($userInfo['consumer_name']) ? htmlspecialchars($userInfo['consumer_name']) : ''; ?>" name="consumer_name" id="consumer_name" placeholder="اسم المستهلك" required class="form-control">
                                </div>

                                <!-- Quantity -->
                                <div class="form-group col-md-6">
                                    <label for="quantity">الكمية</label>
                                    <input type="number" value="<?php echo isset($userInfo['quantity']) ? htmlspecialchars($userInfo['quantity']) : ''; ?>" name="quantity" id="quantity" placeholder="الكمية" required class="form-control">
                                </div>

                                <!-- Additional Quantity -->
                                <div class="form-group col-md-6">
                                    <label for="additional_quantity">إضافة خانة بالكمية</label>
                                    <input type="number" value="<?php echo isset($userInfo['additional_quantity']) ? htmlspecialchars($userInfo['additional_quantity']) : ''; ?>" name="additional_quantity" id="additional_quantity" placeholder="إضافة خانة بالكمية" required class="form-control">
                                </div>

                                <!-- Consumer Type -->
                                <div class="form-group col-md-6">
                                    <label for="consumer_type">نوع المستهلك</label>
                                    <input type="text" value="<?php echo isset($userInfo['consumer_type']) ? htmlspecialchars($userInfo['consumer_type']) : ''; ?>" name="consumer_type" id="consumer_type" placeholder="نوع المستهلك" required class="form-control">
                                </div>

                                <!-- SR: Serial Number -->
                                <div class="form-group col-md-6">
                                    <label for="sr">SR: Serial number</label>
                                    <input type="text" value="<?php echo isset($userInfo['sr']) ? htmlspecialchars($userInfo['sr']) : ''; ?>" name="sr" id="sr" placeholder="SR: Serial number" required class="form-control">
                                </div>

                                <!-- Custody Number -->
                                <div class="form-group col-md-6">
                                    <label for="custody_number">رقم العهدة</label>
                                    <input type="text" value="<?php echo isset($userInfo['custody_number']) ? htmlspecialchars($userInfo['custody_number']) : ''; ?>" name="custody_number" id="custody_number" placeholder="رقم العهدة" required class="form-control">
                                </div>

                                <!-- Device Location -->
                                <div class="form-group col-md-6">
                                    <label for="device_location">موقع الجهاز</label>
                                    <input type="text" value="<?php echo isset($userInfo['device_location']) ? htmlspecialchars($userInfo['device_location']) : ''; ?>" name="device_location" id="device_location" placeholder="موقع الجهاز" required class="form-control">
                                </div>

                                <!-- Remarks -->
                                <div class="form-group col-md-6">
                                    <label for="remarks">ملاحظات</label>
                                    <input type="text" value="<?php echo isset($userInfo['remarks']) ? htmlspecialchars($userInfo['remarks']) : ''; ?>" name="remarks" id="remarks" placeholder="ملاحظات" required class="form-control">
                                </div>

                                <!-- Storage Type -->
                                <div class="form-group col-md-6">
                                    <label for="storage_type">نوع وحدة التخزين</label>
                                    <input type="text" value="<?php echo isset($userInfo['storage_type']) ? htmlspecialchars($userInfo['storage_type']) : ''; ?>" name="storage_type" id="storage_type" placeholder="نوع وحدة التخزين" required class="form-control">
                                </div>

                                <!-- RAM Type -->
                                <div class="form-group col-md-6">
                                    <label for="ram_type">نوع RAM</label>
                                    <input type="text" value="<?php echo isset($userInfo['ram_type']) ? htmlspecialchars($userInfo['ram_type']) : ''; ?>" name="ram_type" id="ram_type" placeholder="نوع RAM" required class="form-control">
                                </div>

                                <!-- Device Name -->
                                <div class="form-group col-md-12">
                                    <label for="device_name">اسم الجهاز</label>
                                    <input type="text" value="<?php echo isset($userInfo['device_name']) ? htmlspecialchars($userInfo['device_name']) : ''; ?>" name="device_name" id="device_name" placeholder="اسم الجهاز" required class="form-control">
                                </div>

                                <input type="hidden" name="id" value="<?php echo $userInfo['id']; ?>">
                            </div>

                            <div class="form-actions">
                                <a href="consumers.php" class="btn btn-secondary btn-small">
                                    <i class="fas fa-arrow-right"></i> العودة
                                </a>
                                <button type="submit" class="btn btn-primary btn-large">
                                    <i class="fas fa-save"></i> حفظ التعديلات
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
        } else {
            header('location: index.php');
        }
    } else {
        header('location: consumers.php');
    }
    
    include $tpl . 'footer.php';
} else {
    header('location: logout.php');
}
ob_end_flush();
?>