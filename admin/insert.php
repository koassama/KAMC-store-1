<?php
ob_start();
session_start();
if (isset($_SESSION['admin'])) {
    $pageTitle = 'insert post';
    include 'init.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $consumer_name = isset($_POST['consumer_name']) ? $_POST['consumer_name'] : null;
        $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : null;
        $additional_quantity = isset($_POST['additional_quantity']) ? $_POST['additional_quantity'] : null;
        $consumer_type = isset($_POST['consumer_type']) ? $_POST['consumer_type'] : null;
        $sr = isset($_POST['sr']) ? $_POST['sr'] : null;
        $custody_number = isset($_POST['custody_number']) ? $_POST['custody_number'] : null;
        $device_location = isset($_POST['device_location']) ? $_POST['device_location'] : null;
        $remarks = isset($_POST['remarks']) ? $_POST['remarks'] : null;
        $storage_type = isset($_POST['storage_type']) ? $_POST['storage_type'] : null;
        $ram_type = isset($_POST['ram_type']) ? $_POST['ram_type'] : null;
        $device_name = isset($_POST['device_name']) ? $_POST['device_name'] : null;

        $formErrors = array();
        if (empty($consumer_name)) {
            $formErrors[] = 'الاسم اجبري';
        }

        if (!empty($formErrors)) {
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>خطأ في البيانات</title>
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Almarai', sans-serif;
            background-color: #f1f4f8;
            direction: rtl;
            margin: 0;
            padding: 0;
        }
        .error-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .alert {
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        .btn {
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 600;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <?php
                    foreach ($formErrors as $error) {
                        echo '<div class="alert alert-danger text-center">' . $error . '</div>';
                    }
                    ?>
                    <div class="text-center">
                        <a href="add.php" class="btn btn-primary">العودة لصفحة الإضافة</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php
        } else {
            // Insert data into the database
            $stmt = $conn->prepare("
                INSERT INTO consumers (
                    consumer_name, quantity, additional_quantity, consumer_type,
                    sr, custody_number, device_location, remarks,
                    storage_type, ram_type, device_name, created_at
                )
                VALUES (
                    :zconsumer_name, :zquantity, :zadditional_quantity, :zconsumer_type,
                    :zsr, :zcustody_number, :zdevice_location, :zremarks,
                    :zstorage_type, :zram_type, :zdevice_name, now()
                )
            ");

            // Execute the statement with the form values
            $stmt->execute(array(
                'zconsumer_name' => $consumer_name,
                'zquantity' => $quantity,
                'zadditional_quantity' => $additional_quantity,
                'zconsumer_type' => $consumer_type,
                'zsr' => $sr,
                'zcustody_number' => $custody_number,
                'zdevice_location' => $device_location,
                'zremarks' => $remarks,
                'zstorage_type' => $storage_type,
                'zram_type' => $ram_type,
                'zdevice_name' => $device_name
            ));

            // Redirect to manage page on success
            if ($stmt) {
                header('location: manage.php');
                exit();
            } else {
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>خطأ في الحفظ</title>
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Almarai', sans-serif;
            background-color: #f1f4f8;
            direction: rtl;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="alert alert-danger text-center">
                    فشل في حفظ البيانات. يرجى المحاولة مرة أخرى.
                </div>
                <div class="text-center">
                    <a href="add.php" class="btn btn-primary">العودة لصفحة الإضافة</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php
            }
        }
    } else {
        header('location: consumers.php');
        exit();
    }
    
    include $tpl . 'footer.php';
} else {
    header('location: logout.php');
}
ob_end_flush();
?>