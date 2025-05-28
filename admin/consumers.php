<?php
ob_start();
session_start();
if (isset($_SESSION['admin'])) {
    $pageTitle = 'صفحة ادارة المستهلكات';
    include 'init.php';
    $ord = 'ASC';

    if (isset($_GET['ordering'])) {
        $ord = $_GET['ordering'];
    }

    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $query = "SELECT * FROM consumers WHERE 1";

    if (!empty($search)) {
        $query .= " AND sr LIKE :search";
    }

    $query .= " ORDER BY id $ord";
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

        .container-fluid {
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

        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            border-radius: 12px;
        }

        .dropdown-item {
            padding: 10px 20px;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background-color: #f1f5f9;
            color: #0d4f8b;
        }
   
.search-container {
    margin-right: 220px;
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
            .container-fluid {
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
<body style="margin-right: 250px; margin-left: 20px">
    <div class="default-management-list users-management">
        <div class="container-fluid cnt-spc">
            <div class="row">
                <div class="col-md-6">
  <div class="right-header management-header" style="margin-right: 180px">
    <div class="btns">
      <a href="add.php" class="add-btn"><i class="fas fa-plus"></i></a>
      <div class="col-md-6 d-flex justify-content-end align-items-center mb-3">
        <form method="GET" action="consumers.php" class="search-container">
          <input type="text" name="search" placeholder="ابحث بالرقم التسلسلي"
            value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
          <button type="submit">بحث</button>
        </form>
      </div>
    </div>
  </div>
</div>

                <div class="col-md-6">
                    <div class="left-header management-header">
                        <h1>قائمة الاجهزة المستهلكة</h1>
                        <p class="tt">اجمالي <?php echo Total($conn, 'consumers'); ?></p>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="management-body" style="margin-top: 50px;">
                        <div class="default-management-table">
                            <table class="table" id="categories-table">
                                <thead>
                                    <tr>
                                        <th scope="col">اسم المستهلك</th>
                                        <th scope="col">الكمية</th>
                                        <th scope="col">اسم الجهاز</th>
                                        <th scope="col">SR: Serial number</th>
                                        <th scope="col">حدث</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach($posts as $post) {
                                    ?>
                                    <tr>
                                        <td>
                                            <p class="f-n"><?php echo htmlspecialchars($post['consumer_name']); ?></p>
                                        </td>
                                        <td>
                                            <p class="f-n"><?php echo htmlspecialchars($post['quantity']); ?></p>
                                        </td>
                                        <td>
                                            <?php echo htmlspecialchars($post['device_name']); ?>
                                        </td>
                                        <td>
                                            <?php echo htmlspecialchars($post['sr']); ?>
                                        </td>
                                        <td>
                                            <ul class="list-group">
                                                <li class="dropdown list-group-item">
                                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-h"></i>
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                        <a class="dropdown-item" href="edit.php?id=<?php echo $post['id']; ?>">
                                                            <i class="fas fa-edit"></i> تعديل
                                                        </a>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item text-danger" href="delete.php?id=<?php echo $post['id']; ?>" onclick="return confirm('هل أنت متأكد من الحذف؟')">
                                                            <i class="fas fa-trash"></i> حذف
                                                        </a>
                                                    </div>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <?php
                                    $i += 1;
                                    }
                                    ?>
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
