<?php
ob_start();
session_start();
if (isset($_SESSION['admin'])) {
    $pageTitle = 'صفحة الموظفين';
    include 'init.php';
    $ord = 'ASC';

    if (isset($_GET['ordering'])) {
        $ord = $_GET['ordering'];
    }

    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $query = "SELECT * FROM users WHERE 1";

    if (!empty($search)) {
        $query .= " AND fname LIKE :search";
    }

    $query .= " ORDER BY id $ord";
    $stmt = $conn->prepare($query);

    if (!empty($search)) {
        $stmt->bindValue(':search', "%$search%");
    }

    $stmt->execute();
    $users = $stmt->fetchAll();
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

        /* Header Styles */
        .management-header {
            margin-bottom: 30px;
        }

        .management-header h1 {
            font-size: 28px;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
        }

        /* Button Styles */
        .add-btn {
            background: linear-gradient(135deg, #0d4f8b, #1e40af);
            color: white;
            padding: 12px 15px;
            border-radius: 12px;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            box-shadow: 0 4px 15px rgba(13, 79, 139, 0.3);
        }

        .add-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(13, 79, 139, 0.4);
            color: white;
            text-decoration: none;
        }

        /* Table Styles */
        .default-management-table {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            margin-top: 20px;
        }

        .table {
            margin: 0;
            border: none;
        }

        .table thead th {
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
            border: none;
            padding: 20px 15px;
            font-weight: 600;
            color: #1e293b;
            font-size: 14px;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .table tbody td {
            padding: 18px 15px;
            border-top: 1px solid #f1f5f9;
            vertical-align: middle;
            color: #374151;
        }

        .table tbody tr {
            transition: all 0.3s ease;
        }

        .table tbody tr:hover {
            background-color: #f8fafc;
            transform: scale(1.01);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .f-n {
            font-weight: 600;
            color: #1e293b;
            margin: 0;
        }

        .u-s, .e-m {
            color: #64748b;
            margin: 0;
        }

        /* Avatar Styles */
        .avatar img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #e5e7eb;
        }

        /* Type Badges */
        .type {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-align: center;
            color: white;
        }

        .e-ty {
            background: linear-gradient(135deg, #10b981, #34d399);
        }

        .a-ty {
            background: linear-gradient(135deg, #f59e0b, #fbbf24);
        }

        /* Dropdown Styles */
        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            border-radius: 12px;
        }

        .dropdown-item {
            padding: 12px 20px;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .dropdown-item:hover {
            background-color: #f1f5f9;
            color: #0d4f8b;
        }

        .dropdown-item svg {
            width: 16px;
            height: 16px;
        }

        /* Form Styles */
        .btn-primary {
            background: linear-gradient(135deg, #0d4f8b, #1e40af);
            border: none;
            color: white;
            border-radius: 12px;
            padding: 8px 16px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(13, 79, 139, 0.3);
        }

        .form-control {
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 8px 12px;
            transition: all 0.3s ease;
            font-family: 'Almarai', sans-serif;
        }

        .form-control:focus {
            border-color: #0d4f8b;
            box-shadow: 0 0 0 3px rgba(13, 79, 139, 0.1);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }

            .cnt-spc {
                padding: 20px;
            }

            .management-header h1 {
                font-size: 22px;
            }

            .table-responsive {
                border-radius: 15px;
            }
        }
    </style>
</head>
<body style="margin-right: 250px; margin-left: 20px; margin-top: 40px">
    <div class="default-management-list users-management">
        <div class="container cnt-spc">
            <div class="row">
                <div class="col-md-6">
                    <div class="right-header management-header">
                        <?php if($_SESSION['type'] == 2): ?>
                        <div class="btns">
                            <a href="users_add.php" id="open-add-page" class="add-btn">
                                <i class="fas fa-plus"></i>
                            </a>
                        </div>
                        <form method="GET" action="users_manage.php" class="d-flex w-100 mt-3" style="max-width: 300px;">
                            <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="ابحث باسم الموظف" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                            <button type="submit" class="btn btn-primary btn-sm">بحث</button>
                        </form>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="left-header management-header">
                        <h1>قائمة الموظفين</h1>
                        <p class="text-muted">إجمالي <?php echo count($users); ?> موظف</p>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="management-body">
                        <div class="default-management-table">
                            <table class="table" id="users-table" style="margin-top:60px">
                                <thead>
                                    <tr>
                                        <th scope="col">رقم</th>
                                        <th scope="col">الصورة</th>
                                        <th scope="col">اسم الكامل</th>
                                        <th scope="col">اسم الموظف</th>
                                        <th scope="col">بريد الالكتروني</th>
                                        <th scope="col">رقم الهاتف</th>
                                        <th scope="col">نوع</th>
                                        <th scope="col">العمليات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($users as $user): ?>
                                    <tr>
                                        <td>
                                            <p><?php echo $user['id']; ?></p>
                                        </td>
                                        <td>
                                            <div class="avatar">
                                                <?php if (empty($user['image'])): ?>
                                                    <img src="<?php echo $avatar; ?>default.png" alt="avatar">
                                                <?php else: ?>
                                                    <img src="<?php echo $avatar . $user['image']; ?>" alt="avatar">
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="f-n"><?php echo htmlspecialchars($user['fname']); ?></p>
                                        </td>
                                        <td>
                                            <p class="u-s"><?php echo htmlspecialchars($user['username']); ?></p>
                                        </td>
                                        <td>
                                            <p class="e-m"><?php echo htmlspecialchars($user['email']); ?></p>
                                        </td>
                                        <td>
                                            <p class="e-m"><?php echo htmlspecialchars($user['phone']); ?></p>
                                        </td>
                                        <td>
                                            <?php if ($user['type'] == 0): ?>
                                                <span class="type" style="background:grey">موظف</span>
                                            <?php elseif ($user['type'] == 1): ?>
                                                <span class="type e-ty">مساعد</span>
                                            <?php elseif ($user['type'] == 2): ?>
                                                <span class="type a-ty">مدير</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($_SESSION['type'] == 2): ?>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    <i class="fas fa-ellipsis-h"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" href="users_edit.php?id=<?php echo $user['id']; ?>">
                                                            <i class="fas fa-edit"></i> تعديل الحساب
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item text-danger" href="users_delete.php?id=<?php echo $user['id']; ?>" onclick="return confirm('هل أنت متأكد من حذف هذا الموظف؟')">
                                                            <i class="fas fa-trash"></i> حذف الموظف
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <?php elseif ($_SESSION['id'] == $user['id']): ?>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    <i class="fas fa-ellipsis-h"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" href="users_edit.php?id=<?php echo $user['id']; ?>">
                                                            <i class="fas fa-edit"></i> تعديل الحساب
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item text-danger" href="users_delete.php?id=<?php echo $user['id']; ?>" onclick="return confirm('هل أنت متأكد من حذف حسابك؟')">
                                                            <i class="fas fa-trash"></i> حذف الحساب
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <?php else: ?>
                                            <span class="text-muted small">ليس لديك صلاحية</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
include $tpl . 'footer.php';
} else {
    header('location: logout.php');
}
ob_end_flush();
?>