<?php
ob_start();
session_start();
if (isset($_SESSION['admin'])) {
    $pageTitle = "تعديل الموظف";
    include 'init.php';

    $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : header('location: users_manage.php');
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
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
            margin-top: 110px;
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

        /* User Info Card */
        .user-info-1 {
            margin-right:40px;
            margin-top:40px;
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
            width: 300px;
        }

        .user-info-1 img {
            width: 75px;
            height: 75px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .username {
            font-size: 20px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 20px;
        }

        .avar-up {
            background: linear-gradient(135deg, #0d4f8b, #1e40af);
            color: white;
            padding: 10px 20px;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-block;
            margin-bottom: 15px;
        }

        .avar-up:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(13, 79, 139, 0.3);
            color: white;
        }

        .shw-btn {
            display: none;
        }

        .shw-btn.show {
            display: inline-block;
            margin-top: 10px;
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
<body  style="margin-right: 250px; margin-left: 20px; margin-top: 110px">
    <div class="edit-page user-edit-pages deep-page">
        <div class="container cnt-spc">
            <div class="row">
                <div class="col-md-12">
                    <div class="pg-tt">
                        <h1 dir="rtl" style="display:block;text-align:right">تعديل الموظف <?php echo htmlspecialchars($userInfo['fname']); ?></h1>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="user-info-1">
                        <form class="pic" action="users_avatar_update.php?id=<?php echo $userInfo['id']; ?>" method="post" enctype="multipart/form-data">
                            <?php if (empty($userInfo['image'])): ?>
                                <img src="<?php echo $avatar; ?>default.png" alt="avatar">
                            <?php else: ?>
                                <img src="<?php echo $avatar . $userInfo['image']; ?>" alt="avatar">
                            <?php endif; ?>
                            
                            <p class="username"><?php echo htmlspecialchars($userInfo['username']); ?></p>
                            
                            <label for="avatar" class="avar-up">
                                <i class="fas fa-camera"></i> تحديث الصورة
                            </label>
                            <input type="file" id="avatar" name="avatar" class="up-ava" style="display:none;" accept="image/*">
                            <input type="submit" name="upload" value="حفظ الصورة" class="form-control btn btn-primary shw-btn" id="sb-bt">
                        </form>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="use-fl-info">
                        <form method="post" action="users_update.php" enctype="multipart/form-data">
                            <div class="row">
                                <!-- Email -->
                                <div class="col-6">
                                    <label for="email">بريد الالكتروني</label>
                                    <input type="email" name="email" id="email" placeholder="" value="<?php echo htmlspecialchars($userInfo['email']); ?>" class="form-control">
                                </div>

                                <!-- Username -->
                                <div class="col-6">
                                    <label for="username">اسم المستخدم</label>
                                    <input type="text" name="username" id="username" placeholder="" value="<?php echo htmlspecialchars($userInfo['username']); ?>" class="form-control">
                                </div>

                                <!-- Phone -->
                                <div class="col-6">
                                    <label for="phone">الجوال</label>
                                    <input type="text" name="phone" id="phone" value="<?php echo htmlspecialchars($userInfo['phone']); ?>" placeholder="" class="form-control">
                                </div>

                                <!-- Job Title -->
                                <div class="col-6">
                                    <label for="wadifa">الوظيفة</label>
                                    <input type="text" name="wadifa" id="wadifa" value="<?php echo htmlspecialchars($userInfo['wadifa']); ?>" placeholder="" class="form-control">
                                </div>

                                <!-- Salary -->
                                <div class="col-12">
                                    <label for="ratib">الراتب الاساسي</label>
                                    <input type="number" name="ratib" id="ratib" value="<?php echo htmlspecialchars($userInfo['ratib']); ?>" placeholder="" class="form-control">
                                </div>

                                <!-- Password -->
                                <div class="col-6">
                                    <label for="password">كلمة المرور الجديدة</label>
                                    <input type="password" name="npassword" placeholder="اتركها فارغة للاحتفاظ بالحالية" class="form-control">
                                </div>

                                <!-- Confirm Password -->
                                <div class="col-6">
                                    <label for="cpassword">تاكيد كلمة المرور</label>
                                    <input type="password" name="cpassword" placeholder="تاكيد كلمة المرور الجديدة" class="form-control">
                                </div>

                                <input type="hidden" name="id" value="<?php echo $userInfo['id']; ?>">

                                <!-- User Type -->
                                <div class="col-12">
                                    <label for="type">نوع الموظف</label>
                                    <select class="form-control" name="type">
                                        <option value="">اختر نوع الموظف</option>
                                        <option value="2" <?php if ($userInfo['type'] == 2) { echo 'selected'; } ?>>مدير</option>
                                        <option value="0" <?php if ($userInfo['type'] == 0) { echo 'selected'; } ?>>موظف</option>
                                    </select>
                                </div>

                                <div class="col-md-12">
                                    <div class="err-msg"></div>
                                </div>
                            </div>

                            <div class="form-actions">
                                <a href="users_manage.php" class="btn btn-secondary btn-small">
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
    <script>
        // Show save button when file is selected
        document.getElementById('avatar').addEventListener('change', function(e) {
            const saveBtn = document.getElementById('sb-bt');
            if (e.target.files.length > 0) {
                saveBtn.classList.add('show');
            } else {
                saveBtn.classList.remove('show');
            }
        });

        // Form validation
        document.querySelector('form[action="users_update.php"]').addEventListener('submit', function(e) {
            const password = document.querySelector('input[name="npassword"]').value;
            const confirmPassword = document.querySelector('input[name="cpassword"]').value;
            const errMsg = document.querySelector('.err-msg');
            
            errMsg.innerHTML = '';
            
            if (password && password !== confirmPassword) {
                e.preventDefault();
                errMsg.innerHTML = '<div class="alert alert-danger">كلمات المرور غير متطابقة</div>';
                return false;
            }
        });
    </script>
</body>
</html>

<?php
        } else {
            header('location: index.php');
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