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

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 8px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.3s ease;
            gap: 6px;
            min-width: 70px;
            border: none;
            cursor: pointer;
        }

        .delete-btn {
            background: linear-gradient(135deg, #dc2626, #ef4444);
            color: white;
            box-shadow: 0 2px 8px rgba(220, 38, 38, 0.3);
        }

        .delete-btn:hover {
            background: linear-gradient(135deg, #b91c1c, #dc2626);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.4);
            text-decoration: none;
        }

        .edit-btn {
            background: linear-gradient(135deg, #f59e0b, #fbbf24);
            color: white;
            box-shadow: 0 2px 8px rgba(245, 158, 11, 0.3);
        }

        .edit-btn:hover {
            background: linear-gradient(135deg, #d97706, #f59e0b);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4);
            text-decoration: none;
        }

        .action-btn i {
            font-size: 12px;
        }

        /* Search Styles */
        .search-container {
            display: flex;
            gap: 10px;
            align-items: center;
            margin-top: 10px;
             border-radius: 19px;
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
         .btn-primary {
            background: linear-gradient(135deg, #0d4f8b, #1e40af);
            border: none;
            color: white;
            border-radius: 19px;
            
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(13, 79, 139, 0.3);
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

            .action-buttons {
                flex-direction: column;
                gap: 5px;
            }

            .action-btn {
                width: 100%;
                min-width: auto;
            }
        }

        @media (max-width: 576px) {
            .management-header {
                text-align: center;
            }

            .right-header,
            .left-header {
                text-align: center;
                margin-bottom: 20px;
            }

            .action-btn {
                font-size: 12px;
                padding: 6px 12px;
            }
            .form-control {
    display: block;
    width: 100%;
    height: calc(1.5em + .75rem + 2px);
    padding: .375rem .75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: 12px;
    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;}
        }
    </style>
</head>
<body style="margin-right: 250px; margin-left: 20px " >

<div class="default-management-list users-management">
    <div class="container-fluid cnt-spc">
        <div class="row">
            <div class="col-md-6">
                <div class="right-header management-header">
                    <div class="btns">
                        <a href="returns.php?page=add" class="add-btn"> <i class="fas fa-plus"></i> </a>
                        <form method="GET" action="reports.php" class="d-flex justify-content-end align-items-center mb-2" style="max-width: 220px;margin-top:70px;">
    <input type="hidden" name="page" value="manage">
    <input type="text" name="search" class="form-control form-control-sm"style="border-radius: 12px"; placeholder="ابحث برقم الجهاز" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
    <button type="submit" class="btn btn-primary btn-sm mx-2" >بحث</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="left-header management-header">
                    <h1>قائمة الصيانة</h1>
                    <p class="tt">اجمالي <?php echo Total($conn, 'returns ') ?> </p>
                </div>
            </div>

            <div class="col-md-12">
                <div class="management-body">
                    <div class="default-management-table table-responsive">
                        <table class="table" id="categories-table">
                            <thead>
                                <tr>
                                    <th scope="col">SR: Serial number</th>
                                    <th scope="col">اسم الجهاز</th>
                                    <th scope="col">عدد مرات الصيانة</th>
                                    <th scope="col">مصدر الجهاز</th>
                                    <th scope="col">موعد دخول الصيانة</th>
                                    <th scope="col">حدث</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach($posts as $post)
                                {
                                ?>
                                <tr>
                                    <td>
                                        <p class="f-n"><?php echo $post['serial_number']; ?></p>
                                    </td>
                                    <td>
                                        <p class="f-n"><?php echo $post['device_name']; ?></p>
                                    </td>
                                    <td>
                                        <p class="f-n"><?php echo $post['maintenance_count']; ?></p>
                                    </td>
                                    <td>
                                        <?php
                                        if ($post['type'] == 0) {
                                            echo 'الشركة ';
                                        }
                                        if ($post['type'] == 1) {
                                            echo 'المنافسة  ';
                                        }
                                        if ($post['type'] == 2) {
                                            echo 'السوق الالكتروني  ';
                                        }
                                        if ($post['type'] == 3) {
                                            echo 'الشراء المباشر  ';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <p class="f-n"><?php echo $post['created_at']; ?></p>
                                    </td>
                                    <td>
                                        <ul class="list-group list-group-horizontal">
  <li class="list-group-item p-0 border-0">
    <a href="reports.php?page=edit&id=<?= $row['id'] ?>" 
       class="btn btn-warning btn-sm text-white mx-1" 
       style="width: 100px; height: 35px; border-radius: 8px;">
      <i class="fas fa-edit text-white"></i> تعديل
    </a>
  </li>

  <li class="list-group-item p-0 border-0">
    <a href="reports.php?page=delete&id=<?= $row['id'] ?>" 
       class="btn btn-danger btn-sm text-white mx-1" 
       style="width: 100px; height: 35px; border-radius: 8px;"
       onclick="return confirm('هل أنت متأكد من الحذف؟')">
      <i class="fas fa-trash text-white"></i> حذف
    </a>
  </li>

</ul>
                                    </td>
                                </tr>
                                <?php
                                $i +=1;
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
