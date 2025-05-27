<?php
ob_start();
session_start();
if (isset($_SESSION['admin'])) {
    if ($_SESSION['type'] == 2) {
        $pageTitle = "اضافة موظف جديد";
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
<body>
    <div class="add-default-page add-user-page" id="add-page">
        <div class="container cnt-spc">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <form class="add-form" method="POST" action="users_insert.php" id="form-info">
                        <h3>قم بملء المعلومات لاضافة موظف جديد
                            <a style="margin-left:5px;font-size:15px;border-radius: 10px;background:var(--mainColor);color:white;padding:8px" href="users_manage.php" class="fas fa-long-arrow-alt-right"></a>
                        </h3>

                        <div class="row">
                            <!-- Email -->
                            <div class="col-6">
                                <label for="email">بريد الالكتروني</label>
                                <input type="email" name="email" required id="email" placeholder="example@company.com" class="form-control">
                            </div>

                            <!-- Username -->
                            <div class="col-6">
                                <label for="username">اسم الموظف</label>
                                <input type="text" name="username" required id="username" placeholder="اسم المستخدم" class="form-control">
                            </div>

                            <!-- Phone -->
                            <div class="col-6">
                                <label for="phone">الجوال</label>
                                <input type="text" name="phone" required id="phone" placeholder="05xxxxxxxx" class="form-control">
                            </div>

                            <!-- Job Title -->
                            <div class="col-6">
                                <label for="wadifa">الوظيفة</label>
                                <input type="text" name="wadifa" required id="wadifa" placeholder="المسمى الوظيفي" class="form-control">
                            </div>

                            <!-- Salary -->
                            <div class="col-12">
                                <label for="ratib">الراتب الاساسي</label>
                                <input type="number" name="ratib" required id="ratib" placeholder="0000" class="form-control">
                            </div>

                            <!-- Password -->
                            <div class="col-6">
                                <label for="password">كلمة المرور</label>
                                <input type="password" name="npassword" required placeholder="كلمة المرور" class="form-control">
                            </div>

                            <!-- Confirm Password -->
                            <div class="col-6">
                                <label for="cpassword">تاكيد كلمة المرور</label>
                                <input type="password" name="cpassword" required placeholder="تاكيد كلمة المرور" class="form-control">
                            </div>

                            <!-- User Type -->
                            <div class="col-12">
                                <label for="type">نوع الموظف</label>
                                <select class="form-control" name="type" required>
                                    <option value="">اختر نوع الموظف</option>
                                    <option value="2">مدير</option>
                                    <option value="0">موظف</option>
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
                            <button type="submit" class="btn btn-primary btn-large" id="a-btn-option">
                                <i class="fas fa-user-plus"></i> اضافة هذا الموظف
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Form validation
        document.getElementById('form-info').addEventListener('submit', function(e) {
            const password = document.querySelector('input[name="npassword"]').value;
            const confirmPassword = document.querySelector('input[name="cpassword"]').value;
            const type = document.querySelector('select[name="type"]').value;
            const errMsg = document.querySelector('.err-msg');
            
            errMsg.innerHTML = '';
            
            if (password !== confirmPassword) {
                e.preventDefault();
                errMsg.innerHTML = '<div class="alert alert-danger">كلمات المرور غير متطابقة</div>';
                return false;
            }
            
            if (!type) {
                e.preventDefault();
                errMsg.innerHTML = '<div class="alert alert-danger">يرجى اختيار نوع الموظف</div>';
                return false;
            }
        });
    </script>
</body>
</html>

<?php
        include $tpl . 'footer.php';
    } else {
        header('location: user-manage.php');
    }
} else {
    header('location: logout.php');
}
ob_end_flush();
?>