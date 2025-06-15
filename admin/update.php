<?php
ob_start();
session_start();
if (isset($_SESSION['admin'])) {
    $pageTitle = 'update page';
    include 'init.php';
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_POST['id'];

        $stmt = $conn->prepare("SELECT * FROM consumers WHERE id = ? LIMIT 1");
        $stmt->execute(array($id));
        $checkIfuser = $stmt->rowCount();
        $data = $stmt->fetch();

        $consumer_name = isset($_POST['consumer_name']) ? $_POST['consumer_name'] : '';
        $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : '';
        $additional_quantity = isset($_POST['additional_quantity']) ? $_POST['additional_quantity'] : '';
        $consumer_type = isset($_POST['consumer_type']) ? $_POST['consumer_type'] : '';
        $sr = isset($_POST['sr']) ? $_POST['sr'] : '';
        $custody_number = isset($_POST['custody_number']) ? $_POST['custody_number'] : '';
        $device_location = isset($_POST['device_location']) ? $_POST['device_location'] : '';
        $remarks = isset($_POST['remarks']) ? $_POST['remarks'] : '';
        $storage_type = isset($_POST['storage_type']) ? $_POST['storage_type'] : '';
        $ram_type = isset($_POST['ram_type']) ? $_POST['ram_type'] : '';
        $device_name = isset($_POST['device_name']) ? $_POST['device_name'] : '';

        $formErrors = array();
        if (empty($consumer_name)) {
            $formErrors[] = 'الاسم اجباري';
        }

        if (!empty($formErrors)) {
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>خطأ في التحديث</title>
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
                        <a href="edit.php?id=<?php echo $id; ?>" class="btn btn-primary">العودة لصفحة التعديل</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php
        } else {
            $stmt = $conn->prepare("
                UPDATE consumers
                SET
                    consumer_name = ?,
                    quantity = ?,
                    additional_quantity = ?,
                    consumer_type = ?,
                    sr = ?,
                    custody_number = ?,
                    device_location = ?,
                    remarks = ?,
                    storage_type = ?,
                    ram_type = ?,
                    device_name = ?
                WHERE id = ?
            ");

            // Execute the query with the form values
            $stmt->execute(array(
                $consumer_name,
                $quantity,
                $additional_quantity,
                $consumer_type,
                $sr,
                $custody_number,
                $device_location,
                $remarks,
                $storage_type,
                $ram_type,
                $device_name,
                $id
            ));

            // Check if the update was successful
            if ($stmt->rowCount() > 0) {
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تم التحديث بنجاح</title>
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Almarai', sans-serif;
            background-color: #f1f4f8;
            direction: rtl;
        }
        .success-container {
            min-height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .alert-success {
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
    <script>
        setTimeout(function() {
            window.location.href = 'consumers.php';
        }, 2000);
    </script>
</head>
<body>
    <div class="success-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="alert alert-success text-center">
                        <h4>تم التحديث بنجاح!</h4>
                        <p>سيتم توجيهك إلى القائمة الرئيسية خلال ثانيتين...</p>
                    </div>
                    <div class="text-center">
                        <a href="consumers.php" class="btn btn-primary">الذهاب إلى القائمة الآن</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php
            } else {
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>خطأ في التحديث</title>
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
                <div class="alert alert-warning text-center">
                    لم يتم التحديث أو لم يتم العثور على السجل.
                </div>
                <div class="text-center">
                    <a href="consumers.php" class="btn btn-primary">العودة للقائمة</a>
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
    }
    
    include $tpl . 'footer.php';
} else {
    header('location: logout.php');
}
ob_end_flush();
?>