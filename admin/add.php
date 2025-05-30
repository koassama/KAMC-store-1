<?php
ob_start();
session_start();
if (isset($_SESSION['admin'])) {
    $pageTitle = 'صفحة الاضافة';
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
                padding: 0
            }

            .add-default-page {
                background-color: #f1f4f8;
                min-height: 100vh;
                padding: 40px 0
            }

            .add-form {
                background: white;
                padding: 40px;
                border-radius: 20px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1)
            }

            .add-form h3 {
                color: #1e293b;
                font-weight: 700;
                margin-bottom: 30px;
                text-align: center;
                font-size: 24px
            }

            .form-group {
                margin-bottom: 25px
            }

            .form-group label {
                font-weight: 600;
                color: #374151;
                margin-bottom: 8px;
                display: block
            }

            .form-control {
                border: 2px solid #e5e7eb;
                border-radius: 12px;
                padding: 12px 16px;
                font-size: 16px;
                transition: all 0.3s ease;
                font-family: 'Almarai', sans-serif
            }

            .form-control:focus {
                border-color: #0d4f8b;
                box-shadow: 0 0 0 3px rgba(13, 79, 139, 0.1);
                outline: none
            }

            .btn {
                border-radius: 12px;
                font-weight: 600;
                transition: all 0.3s ease;
                border: none;
                margin: 5px;
                display: inline-flex;
                align-items: center;
                gap: 8px
            }

            .btn-large {
                padding: 18px 40px;
                font-size: 18px;
                min-width: 200px;
                justify-content: center
            }

            .btn-small {
                padding: 8px 16px;
                font-size: 14px
            }

            .form-actions {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-top: 30px;
                gap: 15px
            }

            .btn-primary {
                background: linear-gradient(135deg, #0d4f8b, #1e40af);
                color: white
            }

            .btn-secondary {
                background: #6b7280;
                color: white
            }

            .btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2)
            }

            .back-link {
                font-size: 15px;
                border-radius: 10px;
                background: var(--mainColor, #0d4f8b);
                color: white;
                padding: 8px;
                text-decoration: none;
                margin-left: 5px;
                transition: all 0.3s ease
            }

            .back-link:hover {
                color: white;
                transform: translateY(-1px)
            }

            @media(max-width:768px) {
                .add-form {
                    padding: 25px;
                    margin: 15px
                }

                .form-actions {
                    flex-direction: column;
                    gap: 10px
                }

                .btn-large {
                    width: 100%;
                    min-width: auto
                }

                .btn-small {
                    width: 100%
                }
            }
        </style>
    </head>

    <body style="margin-top: 40px">
        <div class="add-default-page add-post-page add-product-page" id="add-page">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                      <form class="add-form" method="POST" action="/KAMC-store-1-main/admin/insert.php" enctype="multipart/form-data" id="ca-form-info">
                            <h3>قم بملء المعلومات لاضافة<a
                                    style="margin-left:5px;font-size:15px;border-radius: 10px;background:var(--mainColor);color:white;padding:8px"
                                    href="consumers.php" class="fas fa-long-arrow-alt-right"></a></h3>
                            <div class="row">
                                <div class="form-group col-md-6"><label for="consumer_name">اسم المستهلك</label><input
                                        type="text" name="consumer_name" required class="form-control"></div>
                                <div class="form-group col-md-6"><label for="quantity">الكمية</label><input type="number"
                                        name="quantity" required class="form-control"></div>
                                <div class="form-group col-md-6"><label for="additional_quantity">إضافة خانة
                                        بالكمية</label><input type="number" name="additional_quantity" required
                                        class="form-control"></div>
                                <div class="form-group col-md-6"><label for="consumer_type">نوع المستهلك</label><input
                                        type="text" name="consumer_type" required class="form-control"></div>
                                <div class="form-group col-md-6"><label for="sr">SR: Serial number</label><input type="text"
                                        name="sr" required class="form-control"></div>
                                <div class="form-group col-md-6"><label for="custody_number">رقم العهدة</label><input
                                        type="text" name="custody_number" required class="form-control"></div>
                                <div class="form-group col-md-6"><label for="device_location">موقع الجهاز</label><input
                                        type="text" name="device_location" required class="form-control"></div>
                                <div class="form-group col-md-6"><label for="remarks">ملاحظات</label><input type="text"
                                        name="remarks" required class="form-control"></div>
                                <div class="form-group col-md-6"><label for="storage_type">نوع وحدة التخزين</label><input
                                        type="text" name="storage_type" required class="form-control"></div>
                                <div class="form-group col-md-6"><label for="ram_type">نوع RAM</label><input type="text"
                                        name="ram_type" required class="form-control"></div>
                                <div class="form-group col-md-6"><label for="device_name">اسم الجهاز</label><input
                                        type="text" name="device_name" required class="form-control"></div>
                            </div>
                            <div class="form-actions">
                                <a href="consumers.php" class="btn btn-secondary btn-small"><i
                                        class="fas fa-arrow-right"></i> العودة</a>
                                <input type="submit" class="btn btn-primary btn-large" id="ca-btn-option" value="تاكيد">
                            </div>
                        </form>
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
