<?php
ob_start();
session_start();
if (isset($_SESSION['admin'])) {
    $pageTitle = 'صفحة ادارة المخزون';
    include 'init.php';
    $ord = 'DESC';

    if (isset($_GET['ordering'])) {
        $ord = $_GET['ordering'];
    }

    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $query = "SELECT * FROM products WHERE status = 0";
    if (!empty($search)) {
        $query .= " AND device_name LIKE :search";
    }
    $query .= " ORDER BY id DESC";
    $stmt = $conn->prepare($query);
    if (!empty($search)) {
        $stmt->bindValue(':search', "%$search%");
    }
    $stmt->execute();
    $posts = $stmt->fetchAll();
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

        .management-header .tt {
            color: #64748b;
            font-size: 16px;
            margin-top: 5px;
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

        /* Avatar/Image Styles */
        .avatar img {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            object-fit: cover;
            border: 2px solid #e5e7eb;
            transition: all 0.3s ease;
        }

        .avatar img:hover {
            transform: scale(1.1);
            border-color: #0d4f8b;
        }

        /* Action Buttons */
        .list-group {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .list-group-item {
            background: none;
            border: none;
            padding: 0;
        }

        .btn-warning {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
            border: none;
        }

        .btn-warning:hover {
            background: linear-gradient(135deg, #d97706, #b45309);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
        }

        .btn-danger {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            border: none;
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
        }

        .btn-sm {
            padding: 8px 12px;
            font-size: 12px;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
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

        /* Search Form */
        .search-form {
            display: flex;
            gap: 10px;
            align-items: center;
            margin-top: 15px;
        }
        .search-container {
    display: flex;
    gap: 10px;
    align-items: center;
    margin-top: 10px;
}

.search-container input[type="text"] {
    border: 2px solid #d1d5db;
    border-radius: 999px;
    padding: 8px 20px;
    font-size: 15px;
    outline: none;
    transition: border 0.3s ease;
    width: 240px;
}

.search-container input[type="text"]::placeholder {
    color: #6b7280;
    font-weight: 400;
}

.search-container input[type="text"]:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(59,130,246,0.15);
}

.search-container button {
    background: linear-gradient(to left, #1e40af, #0d4f8b);
    color: white;
    padding: 8px 24px;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s ease;
}

.search-container button:hover {
    transform: translateY(-1px);
    background: linear-gradient(to left, #3b82f6, #1e40af);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
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

            .list-group {
                flex-direction: column;
                gap: 5px;
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
                        <div class="btns">
                            <a href="products_add.php" id="open-add-page" class="add-btn">
                                <i class="fas fa-plus"></i>
                            </a>
                            <form method="GET" action="products_manage.php" class="search-container">
    <input type="hidden" name="page" value="manage">
    <input type="text" name="search" placeholder="ابحث بالرقم التسلسلي" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
    <button type="submit">بحث</button>
                                <?php if(!empty($search)): ?>
                                    <a href="products_manage.php" class="btn btn-secondary btn-sm">إلغاء البحث</a>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="left-header management-header">
                        <h1>قائمة المخزون</h1>
                        <p class="tt">اجمالي المخزون <?php echo Total_Prod($conn, 'products', "status = 0"); ?> منتج</p>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="management-body" style="margin-top: 50px;">
                        <div class="default-management-table">
                            <table class="table" id="categories-table">
                                <thead>
                                    <tr>
                                        <th scope="col">الرقم</th>
                                        <th scope="col">صورة الجهاز</th>
                                        <th scope="col">الرقم التسلسلي</th>
                                        <th scope="col">اسم الجهاز</th>
                                        <th scope="col">نوع الجهاز</th>
                                        <th scope="col">التاريخ</th>
                                        <th scope="col">العمليات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($posts as $post): ?>
                                    <tr>
                                        <td>
                                            <p><?php echo $post['id']; ?></p>
                                        </td>
                                        <td>
                                            <div class="avatar">
                                                <?php if (empty($post['device_image'])): ?>
                                                    <img src="<?php echo $images; ?>default.png" alt="صورة افتراضية">
                                                <?php else: ?>
                                                    <img src="<?php echo $images . $post['device_image']; ?>" alt="صورة الجهاز">
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td>
                                            <p><?php echo htmlspecialchars($post['sr']); ?></p>
                                        </td>
                                        <td>
                                            <p><?php echo htmlspecialchars($post['device_name']); ?></p>
                                        </td>
                                        <td>
                                            <p class="f-n"><?php echo htmlspecialchars($post['device_type']); ?></p>
                                        </td>
                                        <td>
                                            <?php echo date('Y-m-d', strtotime($post['created_at'])); ?>
                                        </td>
                                        <td>
                                            <ul class="list-group list-group-horizontal flex-wrap gap-2 border-0">
                                                <li class="list-group-item border-0 p-0">
                                                    <a href="products_edit.php?id=<?php echo $post['id']; ?>" class="btn btn-sm btn-warning">
                                                        <i class="fas fa-edit"></i> تعديل
                                                    </a>
                                                </li>
                                                <li class="list-group-item border-0 p-0">
                                                    <a href="products_delete.php?id=<?php echo $post['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('هل تريد الحذف؟');">
                                                        <i class="fas fa-trash"></i> حذف
                                                    </a>
                                                </li>
                                            </ul>
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
