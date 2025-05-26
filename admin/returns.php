<?php
  ob_start();
  session_start();
  if (isset($_SESSION['admin']))
  {


    $page = isset($_GET['page']) ? $_GET['page'] : 'manage';


        if ($page == 'manage')
        {
          $pageTitle = 'صفحة ادارة الاجهزة الرجيع';
          include 'init.php';
          $ord = 'ASC';

          if (isset($_GET['ordering']))
          {
            $ord = $_GET['ordering'];
          }

          $stmt = $conn->prepare("SELECT * FROM returns  ORDER BY id $ord");
                    $stmt->execute();
                    $posts = $stmt->fetchAll();


            ?>
            <div class="default-management-list users-management">
              <div class="container-fluid cnt-spc">
                <div class="row">


                  <div class="col-md-6">
                    <div class="right-header management-header">
                      <div class="btns">
                        <a href="returns.php?page=add" class="add-btn"> <i class="fas fa-plus"></i> </a>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="left-header management-header">
                      <h1>قائمة الصيانة</h1>
                      <p class="tt">اجمالي <?php echo Total($conn, 'returns ') ?> </p>
                    </div>
                  </div>
                  <div class="col-md-6 srch-sp">
                    <div class="search-box">
                      <!-- <input type="search" class="form-control" name="search" id="categories-search" onkeyup="tabletwo()" autocomplete="off" placeholder="search by name"> -->
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="management-body">
                      <div class="default-management-table">
                        <table class="table" id="categories-table">
                          <thead>
                            <tr>
                              <th scope="col">SR: Serial number</th>
                              <th scope="col">اسم الجهاز</th>

                              <th scope="col">عدد مرات الصيانة </th>
                              <th scope="col">مصدر الجهاز </th>

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
                                  <p class="f-n"><?php echo $post['serial_number']; ?> </p>
                                </td>
                                <td>
                                  <p class="f-n"><?php echo $post['device_name']; ?> </p>
                                </td>
                                <td>
                                  <p class="f-n"><?php echo $post['maintenance_count']; ?> </p>
                                </td>




                                <td>
                                  <?php
                                    if ($post['type'] == 0)
                                    {
                                      echo 'الشركة ';
                                    }
                                    if ($post['type'] == 1)
                                    {
                                      echo 'المنافسة  ';
                                    }
                                    if ($post['type'] == 2)
                                    {
                                      echo 'السوق الالكتروني  ';
                                    }
                                    if ($post['type'] == 3)
                                    {
                                      echo 'الشراء المباشر  ';
                                    }
                                   ?>
                                </td>
                                <td>
                                  <p class="f-n"><?php echo $post['created_at']; ?> </p>
                                </td>
                                <td>
                                  <?php

                                    ?>
                                    <ul class="list-group">
  <li class="list-group-item">
    <a href="returns.php?page=delete&id=<?php echo $post['id']; ?>" class="text-danger" onclick="return confirm('هل تريد الحذف؟');">
      <i class="fas fa-trash"></i> حذف
    </a>
  </li>
  <li class="list-group-item">
    <a href="returns.php?page=edit&id=<?php echo $post['id']; ?>" class="text-warning">
      <i class="fas fa-edit"></i> تعديل
    </a>
  </li>
</ul>
                                    <?php

                                        ?>

                                        <?php




                                   ?>

                                </td>

                              </tr>
                              <tr>

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



            <?php


          ?>

            <?php
          include $tpl . 'footer.php';

        }elseif ($page == "add") {
      $pageTitle = 'صفحة الاضافة';
      include 'init.php';
      ?>
                    <!-- <div class="form-group col-md-6">
                      <label for="custody_number">رقم العهدة</label>
                      <input type="text" name="custody_number" id="custody_number" placeholder="رقم العهدة" class="form-control" required>
                    </div>

                    <div class="form-group col-md-6">
                      <label for="device_location">موقع الجهاز</label>
                      <input type="text" name="device_location" id="device_location" placeholder="موقع الجهاز" class="form-control">
                    </div>

                    <div class="form-group col-12">
                      <label for="remarks">ملاحظات</label>
                      <textarea name="remarks" id="remarks" class="form-control" placeholder="ملاحظات"></textarea>
                    </div>

                    <div class="form-group col-md-6">
                      <label for="storage_type">نوع وحدة التخزين</label>
                      <select class="form-control" name="storage_type" id="storage_type">
                        <option value="HDD">HDD</option>
                        <option value="SSD">SSD</option>
                        <option value="NVMe">NVMe</option>
                      </select>
                    </div>

                    <div class="form-group col-md-6">
                      <label for="ram_type">نوع RAM</label>
                      <select class="form-control" name="ram_type" id="ram_type">
                        <option value="DDR3">DDR3</option>
                        <option value="DDR4">DDR4</option>
                        <option value="DDR5">DDR5</option>
                      </select>
                    </div>

                    <div class="form-group col-md-6">
                      <label for="device_name">اسم الجهاز</label>
                      <input type="text" name="device_name" id="device_name" placeholder="اسم الجهاز" class="form-control" required>
                    </div>

                    <div class="form-group col-md-6">
                      <label for="maintenance_count">عدد مرات الصيانة</label>
                      <input type="number" name="maintenance_count" id="maintenance_count" placeholder="عدد مرات الصيانة" class="form-control">
                    </div>

                    <div class="form-group col-md-6">
                      <label for="maintenance_request_number">رقم طلب الصيانة</label>
                      <input type="text" name="maintenance_request_number" id="maintenance_request_number" placeholder="رقم طلب الصيانة" class="form-control">
                    </div>


                                        <div class="form-group col-md-6">
                                          <label for="description">للرجيع    </label>
                                          <select class="form-control" name="type">
                                            <option value="0">الشركة </option>
                                            <option value="1">المنافسة  </option>
                                            <option value="2">السوق الالكتروني  </option>
                                            <option value="3">الشراء المباشر  </option>

                                          </select>
                                        </div> -->


                  </div>

                  <?php
// تمكين عرض الأخطاء للتصحيح
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// الاتصال بقاعدة البيانات
$dsn = 'mysql:host=localhost;dbname=stor';
$user = 'root';
$pass = '';
$options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
);

try {
    $conn = new PDO($dsn, $user, $pass, $options);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // التحقق من إرسال الرقم التسلسلي
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['serial_number'])) {
        $serial_number = trim($_POST['serial_number']);

        // التحقق أولاً من عدم تكرار الرقم التسلسلي في جدول returns
        $stmt_duplicate = $conn->prepare("SELECT * FROM returns WHERE serial_number = :serial_number LIMIT 1");
        $stmt_duplicate->bindParam(':serial_number', $serial_number);
        $stmt_duplicate->execute();
        if ($stmt_duplicate->rowCount() > 0) {
            echo "<div class='alert alert-danger'>الرقم التسلسلي موجود بالفعل!</div>";
        } else {
            // التحقق من وجود الرقم التسلسلي في المخزون (من جدول comming)
            $stmt_check = $conn->prepare("SELECT * FROM comming WHERE sr = :serial_number LIMIT 1");
            $stmt_check->bindParam(':serial_number', $serial_number);
            $stmt_check->execute();

            if ($stmt_check->rowCount() > 0) {
                // الجهاز موجود في المخزون
                $device = $stmt_check->fetch(PDO::FETCH_ASSOC);

                // إدخال الجهاز الجديد في جدول returns (مع تغيير اسم العامود من sr إلى serial_number)
                $stmt_insert = $conn->prepare("
                    INSERT INTO returns (serial_number, custody_number, device_location, remarks, storage_type, ram_type, device_name, maintenance_count, maintenance_request_number, type)
                    VALUES (:serial_number, :custody_number, :device_location, :remarks, :storage_type, :ram_type, :device_name, :maintenance_count, :maintenance_request_number, :type)
                ");
                $stmt_insert->execute([
                    'serial_number'              => $device['sr'],
                    'custody_number'             => $device['custody'] ?? '',
                    'device_location'            => $device['location'] ?? '',
                    'remarks'                    => $device['remarq'] ?? '',
                    'storage_type'               => $device['storeg_type'] ?? '',
                    'ram_type'                   => 'DDR3', // القيمة الافتراضية
                    'device_name'                => $device['name'] ?? '', 
                    'maintenance_count'          => $device['maintenance'] ?? '', 
                    'maintenance_request_number' => $device['maintenance_order'] ?? '',
                    'type'                       => 0 // القيمة الافتراضية   
                ]);

                // الحصول على ID الجهاز الذي تم إدخاله
                $new_id = $conn->lastInsertId();

                // حذف الجهاز من جدول comming
                $stmt_delete = $conn->prepare("DELETE FROM comming WHERE sr = :serial_number");
                $stmt_delete->bindParam(':serial_number', $serial_number);
                $stmt_delete->execute();

                // إعادة التوجيه إلى صفحة تعديل الجهاز
                header("Location: returns.php?page=edit&id=" . $new_id);
                exit;
            } else {
                // إذا لم يتم العثور على الجهاز في المخزون
                echo "<div class='alert alert-danger'>الرقم التسلسلي غير موجود في الاجهزة الصادرة!</div>";
            }
        }
    }
} catch (PDOException $e) {
    echo "خطأ: " . $e->getMessage();
}
?>

<div class="add-default-page add-post-page add-product-page" id="add-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form class="add-form" method="POST" action="" id="ca-form-info">
                    <h3>قم بملء المعلومات لإضافة الجهاز</h3>
                    <div class="form-group">
                        <label for="serial_number">الرقم التسلسلي:</label>
                        <input type="text" name="serial_number" id="serial_number" placeholder="أدخل الرقم التسلسلي للجهاز" required class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary" id="ca-btn-option">تأكيد</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
    } elseif ($page == 'edit') {
          $pageTitle = "تعديل الجهاز";
          include 'init.php';

          $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : header('location: returns.php');
          $stmt = $conn->prepare("SELECT * FROM returns WHERE id = ? LIMIT 1");
          $stmt->execute(array($id));
          $checkIfuserExist = $stmt->rowCount();
          $userInfo = $stmt->fetch();
          if ($checkIfuserExist > 0)
          {

            if ($_SESSION['type'] == 2 or $_SESSION['id'] == $userInfo['id'])
            {

              ?>
              <div class="edit-page user-edit-pages deep-page">
                <div class="container cnt-spc">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="pg-tt">
                        <h1 dir="rtl" style="display:block;text-align:right">تعديل الرجيع <?php echo $userInfo['device_name'] ?></h1>
                      </div>
                    </div>

                    <div class="col-md-4">
                      <div class="row">
                        <!-- محتوى إضافي إن وجد -->
                      </div>
                    </div>
                    <div class="col-md-8">
                      <div class="use-fl-info">
                        <form method="post" action="returns.php?page=update" enctype="multipart/form-data">
                          <div class="row">
                            <div class="form-group col-md-12">
                              <label for="serial_number">SR (Serial Number)</label>
                              <input value="<?php echo htmlspecialchars($userInfo['serial_number'] ?? ''); ?>" type="text" name="serial_number" id="serial_number" placeholder="SR (Serial Number)" class="form-control" required>
                            </div>

                            <div class="form-group col-md-6">
                              <label for="custody_number">رقم العهدة</label>
                              <input value="<?php echo htmlspecialchars($userInfo['custody_number'] ?? ''); ?>" type="text" name="custody_number" id="custody_number" placeholder="رقم العهدة" class="form-control" required>
                            </div>

                            <div class="form-group col-md-6">
                              <label for="device_location">موقع الجهاز</label>
                              <input value="<?php echo htmlspecialchars($userInfo['device_location'] ?? ''); ?>" type="text" name="device_location" id="device_location" placeholder="موقع الجهاز" class="form-control">
                            </div>

                            <div class="form-group col-12">
                              <label for="remarks">ملاحظات</label>
                              <textarea name="remarks" id="remarks" class="form-control" placeholder="ملاحظات"><?php echo htmlspecialchars($userInfo['remarks'] ?? ''); ?></textarea>
                            </div>

                            <div class="form-group col-md-6">
                              <label for="storeg_type">نوع وحدة التخزين </label>
                              <select class="form-control" name="storeg_type" id="storeg_type">
                                <option value=""> </option>
                                <option value="SSD">SSD</option>
                                <option value="HHD">HHD</option>
                                <option value="M2 ">M2</option>
                              </select>
                            </div>

                            <div class="form-group col-md-6">
                              <label for="ram_type" dir="rtl">نوع RAM</label>
                              <input value="<?php echo htmlspecialchars($userInfo['ram_type'] ?? ''); ?>" type="text" name="ram_type" id="ram_type" placeholder=" " class="form-control">
                            </div>

                            <div class="form-group col-md-6">
                              <label for="device_name">اسم الجهاز</label>
                              <input value="<?php echo htmlspecialchars($userInfo['device_name'] ?? ''); ?>" type="text" name="device_name" id="device_name" placeholder="اسم الجهاز" class="form-control" required>
                            </div>

                            <div class="form-group col-md-6">
                              <label for="maintenance_count">عدد مرات الصيانة</label>
                              <input value="<?php echo htmlspecialchars($userInfo['maintenance_count'] ?? ''); ?>" type="text" name="maintenance_count" id="maintenance_count" placeholder="عدد مرات الصيانة" class="form-control">
                            </div>

                            <div class="form-group col-md-12">
                              <label for="maintenance_request_number">رقم طلب الصيانة</label>
                              <input value="<?php echo htmlspecialchars($userInfo['maintenance_request_number'] ?? ''); ?>" type="text" name="maintenance_request_number" id="maintenance_request_number" placeholder="رقم طلب الصيانة" class="form-control">
                            </div>

                            <!-- Hidden ID field -->
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($userInfo['id'] ?? ''); ?>">

                            <a href="returns.php" class="btn btn-primary">
                            <i class="fas fa-edit"></i> حفظ
                          </a>
                          </div>
                        </form>
                      </div>
                    </div>

                  </div>
                </div>
              </div>
              <?php
              ?>
              <?php
            } else {
              header('location: index.php');
            }
              ?>
              <?php
          } else {
            header('location: returns.php');
          }
          ?>
          <?php
          include $tpl . 'footer.php';
        }

        elseif ($page == 'update') {


          $pageTitle = 'update page';
          include 'init.php';
          $id = $_POST['id'];

                                $stmt = $conn->prepare("SELECT * FROM returns WHERE id = ? LIMIT 1");
                                $stmt->execute(array($id));
                                $checkIfuser = $stmt->rowCount();
                                $data = $stmt->fetch();

                                if($_SERVER['REQUEST_METHOD'] == 'POST')
                                {
                                  // Retrieve form values
                                  $serial_number = $_POST['serial_number'];
                                  $custody_number = $_POST['custody_number'];
                                  $device_location = $_POST['device_location'];
                                  $remarks = $_POST['remarks'];
                                  $storage_type = $_POST['storage_type'];
                                  $ram_type = $_POST['ram_type'];
                                  $device_name = $_POST['device_name'];
                                  $maintenance_count = $_POST['maintenance_count'];
                                  $maintenance_request_number = $_POST['maintenance_request_number'];
                                  $type = $_POST['type'];
                                $formErrors = array();




                                foreach ($formErrors as $error ) {
                                  ?>
                                  <div class="container">
                                      <?php
                                        echo '<div class="alert alert-danger" style="width: 50%;">' . $error . '</div>';
                                       ?>

                                  </div>
                                  <?php
                                  ?>
                                    <div class="container">
                                      <a href="users.php?page=edit&id=<?php echo $id ?>">اضغط هنا للعودة الى اخر صفحة</a>
                                    </div>
                                  <?php
                                  // header('refresh:4;url=' . $_SERVER['HTTP_REFERER']);
                                }


                                if (empty($formErrors))
                                {


                                  $stmt = $conn->prepare("
              UPDATE returns
              SET
                  serial_number = ?,
                  custody_number = ?,
                  device_location = ?,
                  remarks = ?,
                  storage_type = ?,
                  ram_type = ?,
                  device_name = ?,
                  maintenance_count = ?,
                  maintenance_request_number = ?,
                  type = ?
              WHERE id = ?
          ");

          // Execute the query with an array of values
          $stmt->execute(array(
              $serial_number,
              $custody_number,
              $device_location,
              $remarks,
              $storage_type,
              $ram_type,
              $device_name,
              $maintenance_count,
              $maintenance_request_number,
              $type,
              $id
          ));

          // Check if the record was updated successfully
          if ($stmt->rowCount() > 0) {
              echo "Record updated successfully.";
          } else {
              echo "No changes were made or an error occurred.";
          }
                                     header('location: ' . $_SERVER['HTTP_REFERER']);
                                }
                              }


          include $tpl . 'footer.php';


        }

  elseif ($page == 'delete') {
     include 'init.php';
      if ($_SESSION['type'] == 2)
      {
        $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : header('location: returns.php');;
        $stmt = $conn->prepare("SELECT * FROM returns WHERE id = ? LIMIT 1");
        $stmt->execute(array($id));
        $check = $stmt->rowCount();

        if ($check > 0 )
        {
          $stmt = $conn->prepare("DELETE FROM returns WHERE id = :zid");
          $stmt->bindParam(":zid", $id);
          $stmt->execute();
          header('location: returns.php');

        }
        else {
          header('location: returns.php');
        }
      }
    }



    else {
      header('location: dashboard.php');
    }

    ?>


    <?php


  }else {
    header('location: logout.php');
  }
  ob_end_flush();
 ?>
