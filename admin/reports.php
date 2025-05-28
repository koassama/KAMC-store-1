<?php
  ob_start();
  session_start();
  if (isset($_SESSION['admin']))
  {


    $page = isset($_GET['page']) ? $_GET['page'] : 'manage';


        if ($page == 'manage')
        {
          $pageTitle = 'صفحة ادارة التقارير';
          include 'init.php';
          $ord = 'ASC';
          $search = isset($_GET['search']) ? $_GET['search'] : '';
$query = "SELECT * FROM reports WHERE 1";

if (!empty($search)) {
    $query .= " AND Device_Type LIKE :search";
}
$query .= " ORDER BY id $ord";
$stmt = $conn->prepare($query);
if (!empty($search)) {
    $stmt->bindValue(':search', "%$search%");
}
$stmt->execute();
$posts = $stmt->fetchAll();
          if (isset($_GET['ordering']))
          {
            $ord = $_GET['ordering'];
          }

         


            ?>
            <div class="default-management-list users-management">
              <div class="container-fluid cnt-spc">
                <div class="row">


                  <div class="col-md-6">
                    <div class="right-header management-header">
                      <form method="GET" action="reports.php" class="d-flex justify-content-end align-items-center mb-2" style="max-width: 300px;">
    <input type="hidden" name="page" value="manage">
    <input type="text" name="search" class="form-control form-control-sm" placeholder="ابحث باسم نوع الجهاز" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
    <button type="submit" class="btn btn-primary btn-sm mx-2">بحث</button>
</form>
                      <div class="btns">
                        <a href="reports.php?page=add" class="add-btn"> <i class="fas fa-plus"></i> </a>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="left-header management-header">
                      <h1>قائمة التقارير</h1>
                      <p class="tt">اجمالي <?php echo Total_rep($conn, 'reports ', "status = 0") ?> </p>
                    </div>
                  </div>
                  <div class="col-md-6 srch-sp">
                    <div class="search-box">
                      <input type="search" class="form-control" name="search" id="categories-search" onkeyup="tabletwo()" autocomplete="off" placeholder="البحث عن طريق مصدر الجهاز او نوع العقد">
                    </div>
                    <a href="download.php" class="btn btn-success">EXPORT TO EXCEL</a>
                  </div>
                  

<div class="col-md-12">
  <div class="management-body">
    <div class="default-management-table">
      <table class="table" id="categories-table">
        <thead>
          <tr>
            <th scope="col">اسم الجهاز</th>
            <th scope="col">مصدر الجهاز</th>
            <th scope="col">نوع العقد</th>
            <th scope="col">serial number</th>
            <th scope="col">رقم العهدة</th>
            <th scope="col">الادارة</th>
            <th scope="col">نوع التقرير</th>
            <th scope="col">حدث</th>
          </tr>
        </thead>
        <tbody>
          <?php
          // تأكد من وجود بيانات في المتغير $posts
          if (!empty($posts)) {
              $i = 1; // تهيئة عداد الصفوف
              foreach ($posts as $post) {
                  ?>
                  <tr>
                    <td><?php echo $post['Device_Type']; ?></td>
                    <td><?php echo $post['Device_source']; ?></td>
                    <td><?php echo $post['type_aa']; ?></td>
                    <td><?php echo $post['sr']; ?></td>
                    <td><?php echo $post['custody']; ?></td>
                    <td><?php echo $post['Installation_Department']; ?></td>
                    <td><?php echo $post['type']; ?></td>
                    <td>
                      
                    <?php

?>
<ul class="list-group">
<li class="list-group-item">
<a href="reports.php?page=edit&id=<?php echo $post['id']; ?>" class="text-warning">
  <i class="fas fa-edit"></i> تعديل
</a>
</li>
<li class="list-group-item">
<a href="reports.php?page=delete&id=<?php echo $post['id']; ?>" class="text-danger" onclick="return confirm('هل تريد الحذف؟');">
  <i class="fas fa-trash"></i> حذف
</a>
</li>
<li class="list-group-item">
<a href="reports.php?page=print&id=<?php echo $post['id']; ?>">
  <i class="fas fa-print"></i> طباعة
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
                  $i++;
              }
          } else {
              echo '<tr><td colspan="8">لا توجد تقارير لعرضها</td></tr>';
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

          
            



<?php
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

    // ✅ تحديث السجلات الموجودة في التقارير إذا كانت موجودة في comming
    $sql_update_from_comming = "
        UPDATE reports r
        JOIN comming c ON r.sr = c.sr
        SET 
            r.Device_Type = c.name,
            r.Device_source = 'الأجهزة الصادرة',
            r.type_aa = c.type,
            r.custody = c.custody,
            r.Installation_Department = c.Management,
            r.type = c.type_sa
    ";
    $conn->exec($sql_update_from_comming);

    // ✅ إدخال الأجهزة الصادرة الجديدة فقط (غير الموجودة في التقارير)
    $sql_insert_from_comming = "
        INSERT INTO reports (Device_Type, Device_source, type_aa, sr, custody, Installation_Department, type)
        SELECT 
            name,
            'الأجهزة الصادرة',
            type,
            sr,
            custody,
            Management,
            type_sa
        FROM comming
        WHERE sr NOT IN (SELECT sr FROM reports)
    ";
    $conn->exec($sql_insert_from_comming);

    // ✅ إدخال الأجهزة الموجودة في المخزون إلى التقارير (مرة واحدة فقط)
    $sql_insert_from_products = "
        INSERT INTO reports (Device_Type, Device_source, type_aa, sr, custody, Installation_Department, type)
        SELECT 
            Device_name,
            'المخزون',
            null,
            sr,
            null,
            department,
            null
        FROM products
        WHERE sr NOT IN (SELECT sr FROM reports)
        AND sr NOT IN (SELECT sr FROM comming)
    ";
    $conn->exec($sql_insert_from_products);

    // ✅ تحديث مصدر الجهاز حسب الحالة (المخزون، الأجهزة الصادرة، الصيانة)
$sql_update_device_source = "
UPDATE reports
SET Device_source = CASE
    WHEN sr IN (SELECT sr FROM comming) THEN 'الأجهزة الصادرة'
    WHEN sr IN (SELECT sr FROM products) THEN 'المخزون'
    WHEN sr IN (SELECT sr FROM returns) THEN 'الصيانة'
    ELSE 'غير معروف'
END
";
$conn->exec($sql_update_device_source);

} catch (PDOException $e) {
    echo "خطأ: " . $e->getMessage();
}
?>



            <?php
          include $tpl . 'footer.php';

        }elseif ($page == "add") {
      $pageTitle = 'صفحة الاضافة';
      include 'init.php';
      ?>
      <div class="add-default-page add-post-page  add-product-page " id="add-page">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-md-8">
              <form class="add-fomr" method="POST" action="reports.php?page=insert" enctype="multipart/form-data"  id="ca-form-info"  >
                <h3>قم بلمئ المعلومات لاضافة تقرير جديد<a style="margin-left:5px;font-size:15px;border-radius: 10px;background:var(--mainColor);color:white;padding:8px" href="reports.php?page=manage" class="fas fa-long-arrow-alt-right"></a>  </h3>

                  <div class="row">
                    <div class="form-group col-md-12">
                      <label for="device_name">اسم الجهاز</label>

                      <input type="text" name="device_type" id="device_type" class="form-control">

                    </div>
                    <div class="form-group col-md-6">
                      <label for="device_type">serial number</label>

                      <input type="text" name="sr" id="sr" class="form-control">

                    </div>      <div class="form-group col-md-6">
                            <label for="device_type">رقم العهدة</label>

                            <input type="text" name="custody" id="custody" class="form-control">

                          </div>
                    <div class="form-group col-12">
                      <label for="device_details">تفاصيل الجهاز</label>
                      <textarea name="device_details" id="device_details" class="form-control" placeholder="تفاصيل الجهاز" ></textarea>
                    </div>

                    <div class="form-group col-md-6">
                      <label for="installation_department">الإدارة التي تم التركيب بها</label>
                      <input type="text" name="installation_department" id="installation_department" placeholder="الإدارة" class="form-control" >
                    </div>

                    <div class="form-group col-md-6">
                      <label for="installation_date">تاريخ التركيب</label>
                      <input type="date" name="installation_date" id="installation_date" class="form-control" >
                    </div>

                    <div class="form-group col-md-6">
                      <label for="dispensed_date">تاريخ الصرف</label>
                      <input type="date" name="dispensed_date" id="dispensed_date" class="form-control">
                    </div>

                    <div class="form-group col-md-6">
                      <label for="status">حالة الجهاز</label>
                      <input type="text" name="status" id="status" class="form-control">


                    </div>

                                        <div class="form-group col-md-12">
                                          <label for="description">نوع التقرير    </label>
                                          <select class="form-control" name="type">
                                            <option value="اسبوعي">اسبوعي </option>
                                            <option value="شهري">شهري  </option>
                                            <option value="سنوي">سنوي  </option>
                                          </select>
                                        </div>
                                        <div class="form-group col-md-12">
                                          <label for="description">نوع العقد  </label>
                                          <select class="form-control" name="type_aa">
                                            <option value="الشركة المشغلة ">الشركة المشغلة </option>
                                            <option value="منافسة ">منافسة </option>
                                            <option value="شراء مباشر ">شراء مباشر </option>
                                            <option value="سوق الكتروني ">سوق الكتروني </option>

                                          </select>
                                        </div>

                  </div>

                <input type="submit" class="btn btn-primary" id="ca-btn-option"  value="تاكيد">
                <div class="err-msg">

                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <?php

      include $tpl . 'footer.php';
    }elseif ($page == 'insert') {
      $pageTitle = 'insert  post';
      include 'init.php';

      if ($_SERVER['REQUEST_METHOD'] == 'POST')
      {

        $device_type = isset($_POST['device_type']) ? htmlspecialchars($_POST['device_type']) : '';
      $device_details = isset($_POST['device_details']) ? htmlspecialchars($_POST['device_details']) : '';
      $installation_department = isset($_POST['installation_department']) ? htmlspecialchars($_POST['installation_department']) : '';
      $installation_date = isset($_POST['installation_date']) ? htmlspecialchars($_POST['installation_date']) : '';
      $dispensed_date = isset($_POST['dispensed_date']) ? htmlspecialchars($_POST['dispensed_date']) : null;
      $status = isset($_POST['status']) ? htmlspecialchars($_POST['status']) : '';
      $report_type = isset($_POST['type']) ? htmlspecialchars($_POST['type']) : '';
      $sr = isset($_POST['sr']) ? htmlspecialchars($_POST['sr']) : '';
      $custody = isset($_POST['custody']) ? htmlspecialchars($_POST['custody']) : '';

      $type_aa = isset($_POST['type_aa']) ? htmlspecialchars($_POST['type_aa']) : '';


                $formErrors = array();



                                      foreach ($formErrors as $error ) {
                                        ?>
                                        <div class="container" style="margin-top:50px">
                                          <div class="row justify-content-center">
                                              <div class="col-md-4">
                                                <?php
                                                  echo '<div class="alert alert-danger" style="width: 100%;text-align:center">' . $error . '</div>';
                                                 ?>

                                              </div>
                                          </div>
                                        </div>
                                        <?php
                                      }


                          if (empty($formErrors))
                            {

  // Insert data into the database
  $stmt = $conn->prepare("INSERT INTO reports
    (sr,custody,Device_Type, Device_Details, Installation_Department,Installation_Date, Dispensed_Date, Status,type_aa, type)
    VALUES (:sr,:cu,:device_type, :device_details, :installation_department,:Installation_Date, :dispensed_date, :status,:type_aa ,:type)");

  $stmt->execute(array(
    'sr' => $sr,
    'cu' => $custody,

      'device_type' => $device_type,

      'device_details' => $device_details,
      'installation_department' => $installation_department,
      'Installation_Date' => $installation_date,
      'dispensed_date' => $dispensed_date, // يمكن أن يكون NULL
      'status' => $status,
      'type_aa' => $type_aa,

      'type' => $report_type
  ));  // Debugging - print the last inserted ID or success message
  if ($stmt) {
              header('location: reports.php?page=manage');
  } else {
      echo "Failed to insert data.";
  }
                                ?>

                                <?php
                                header('location: reports.php?page=manage');
                              }




      }else {
        header('location: posts.php');
      }
      include $tpl . 'footer.php';

      ?>
      <?php
    } elseif ($page == 'print') {
        $pageTitle = "تعديل الجهاز";
        include 'init.php';

        // التأكد من تمرير معرف صالح
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            header('location: index.php');
            exit();
        }

        $id = intval($_GET['id']);

        // جلب البيانات من قاعدة البيانات
        $stmt = $conn->prepare("SELECT * FROM reports WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC); // جلب البيانات كمصفوفة

        // التحقق مما إذا كان السجل موجودًا
        if (!$user) {
            echo "<div class='alert alert-danger'>لم يتم العثور على التقرير المطلوب.</div>";
            exit();
        }
?>

                      <div class="printpdfpage mpprvrt" id="printpdfpage" style="background:white;position:relative">

                        <div class="container" style="border-bottom: 2px solid blue;max-width:95% !important;padding:0">
                          <div class="row justify-content-end pppzrr"style="padding-bottom:30px;"  >

                      

                            <div class="col-md-6" style="padding-top: 50px;text-align:right">
                              <h4><span style="font-weight:normal" class="word">التقرير الخاص بالمنتج</span>
          </h4>

                            </div>
                          </div>


                          </div>
                        <div class="container">
                          <div class="row justify-content-center">
                            <div class="col-md-12">

                      <table style="width:80%;margin:10px auto" class="rrrsds">
                        <tr>
                          <td style="text-align:center"><?php echo $user['Device_Type'] ?></td>
                          <th style=""> <span class="word">نوع الجهاز </span>: </th>


                        </tr>
                        <tr>
                          <td style="text-align:center"><?php echo $user['custody'] ?></td>
                          <th style=""> <span class="word"> رقم العهدة </span>: </th>


                        </tr>
                        <tr>
                          <td style="text-align:center"><?php echo $user['sr'] ?></td>
                          <th style=""> <span class="word">serial number</span>: </th>


                        </tr>
                        <tr>
                          <td style="text-align:center"><?php echo $user['Installation_Date'] ?></td>
                          <th style=""> <span class="word">تاريخ التركيب </span>: </th>


                        </tr>
                        <tr>
                          <td style="text-align:center"><?php echo $user['Installation_Department'] ?></td>
                          <th style=""> <span class="word">الإدارة التي تم التركيب بها </span>: </th>


                        </tr>
                        <tr>
                          <td style="text-align:center"><?php echo $user['Status'] ?></td>
                          <th style=""> <span class="word">حالة الجهاز </span>: </th>


                        </tr>
                        <tr>
                          <td style="text-align:center"><?php echo $user['Dispensed_Date'] ?></td>
                          <th style=""> <span class="word">تاريخ الصرف </span>: </th>


                        </tr>
                        <tr>
                          <td style="text-align:center"><?php echo $user['type'] ?></td>
                          <th style=""> <span class="word">نوع التقرير  </span>: </th>


                        </tr>
                        <tr>
                          <td style="text-align:center"><?php echo $user['type_aa'] ?></td>
                          <th style=""> <span class="word">نوع العقد </span>: </th>


                        </tr>

              </table>




                            </div>

                          </div>
                        </div>


                        </div>
                      </div>
          <?php

          include $tpl . 'footer.php';
        }
        elseif ($page == 'edit') {
             $pageTitle = "تعديل الجهاز";
             include 'init.php';
             


             $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : header('location: users.php');
             $stmt = $conn->prepare("SELECT * FROM reports WHERE id = ? LIMIT 1");
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
                           <h1 dir="rtl" style="display:block;text-align:right">تعديل التقارير <?php echo $userInfo['Device_Type'] ?></h1>
                         </div>
                       </div>

                       <div class="col-md-4">
                         <div class="row">


                         </div>

                       </div>
                       <div class="col-md-8">
                         <div class="use-fl-info">
                           <form method="post" action="reports.php?page=update" enctype="multipart/form-data">


                                               <div class="row">
                                                 <div class="form-group col-md-12">
                                                   <label for="device_type">نوع الجهاز</label>
                                                   <input type="text" name="device_type" value="<?php echo htmlspecialchars($userInfo['Device_Type'] ?? ''); ?>" id="device_type" class="form-control">
                                                 </div>

                                                 <div class="form-group col-md-6">
                                                   <label for="sr">رقم الجهاز</label>
                                                   <input type="text" name="sr" value="<?php echo htmlspecialchars($userInfo['sr'] ?? ''); ?>" id="sr" class="form-control">
                                                 </div>

                                                 <div class="form-group col-md-6">
                                                   <label for="custody">رقم العهدة</label>
                                                   <input type="text" name="custody" value="<?php echo htmlspecialchars($userInfo['custody'] ?? ''); ?>" id="custody" class="form-control">
                                                 </div>

                                                 <div class="form-group col-12">
                                                   <label for="device_details">تفاصيل الجهاز</label>
                                                   <textarea name="device_details" id="device_details" class="form-control" placeholder="تفاصيل الجهاز" ><?php echo htmlspecialchars($userInfo['Device_Details'] ?? ''); ?></textarea>
                                                 </div>

                                                 <div class="form-group col-md-6">
                                                   <label for="installation_department">الإدارة التي تم التركيب بها</label>
                                                   <input type="text" name="installation_department" value="<?php echo htmlspecialchars($userInfo['Installation_Department'] ?? ''); ?>" id="installation_department" class="form-control" required>
                                                 </div>



                                                 <div class="form-group col-md-6">
                                                   <label for="dispensed_date">تاريخ الصرف</label>
                                                   <input type="date" name="dispensed_date" value="<?php echo htmlspecialchars($userInfo['Dispensed_Date'] ?? ''); ?>" id="dispensed_date" class="form-control">
                                                 </div>

                                                 <div class="form-group col-md-6">
                                                   <label for="status">حالة الجهاز</label>
                                                   <input type="text" name="status" value="<?php echo htmlspecialchars($userInfo['Status'] ?? ''); ?>" id="status" class="form-control">
                                                 </div>

                                                 <div class="form-group col-md-6">
                                                   <label for="type">نوع التقرير</label>
                                                   <select class="form-control" name="type">
                                                     <option value="اسبوعي" <?php echo ($userInfo['type'] == 'اسبوعي') ? 'selected' : ''; ?>>اسبوعي</option>
                                                     <option value="شهري" <?php echo ($userInfo['type'] == 'شهري') ? 'selected' : ''; ?>>شهري</option>
                                                     <option value="سنوي" <?php echo ($userInfo['type'] == 'سنوي') ? 'selected' : ''; ?>>سنوي</option>
                                                   </select>
                                                 </div>
                                                 <div class="form-group col-md-12">
  <label for="description">نوع العقد</label>
  <select class="form-control" name="type_aa">
    <option <?php if (trim($userInfo['type_aa']) == "الشركة المشغلة") { echo 'selected'; } ?> value="الشركة المشغلة">الشركة المشغلة</option>
    <option <?php if (trim($userInfo['type_aa']) == "منافسة") { echo 'selected'; } ?> value="منافسة">منافسة</option>
    <option <?php if (trim($userInfo['type_aa']) == "شراء مباشر") { echo 'selected'; } ?> value="شراء مباشر">شراء مباشر</option>
    <option <?php if (trim($userInfo['type_aa']) == "سوق الكتروني") { echo 'selected'; } ?> value="سوق الكتروني">سوق الكتروني</option>
  </select>
</div>

                                                 <!-- Hidden ID field -->
                                                 <input type="hidden" name="id" value="<?php echo htmlspecialchars($userInfo['id'] ?? ''); ?>">





           <button type="submit" class="btn btn-primary">حفظ</button>
         </form>
                         </div>
                       </div>

                     </div>
                   </div>
                 </div>
                 <?php





                 ?>

                 <?php
               }else {
                 header('location: index.php');
               }
                 ?>

                 <?php


             }
             else {
               header('location: users.php');
             }
             ?>


             <?php

             include $tpl . 'footer.php';
           }

        elseif ($page == 'update') {


          $pageTitle = 'update page';
          include 'init.php';
          $id = $_POST['id'];

           // ✅ التأكد من أن قيمة id موجودة وصحيحة
    if (!isset($id) || !is_numeric($id)) {
      die('معرف السجل غير صالح.');
  }
          

          // Fetch the existing record based on the ID
          $stmt = $conn->prepare("SELECT * FROM reports WHERE id = ? LIMIT 1");
          $stmt->execute(array($id));
          $checkIfuser = $stmt->rowCount();
          $data = $stmt->fetch();

          if ($_SERVER['REQUEST_METHOD'] == 'POST') {
              // Retrieve form values with fallback to current data if not submitted
              $device_type = isset($_POST['device_type']) ? $_POST['device_type'] : $data['Device_Type'];
              $sr = isset($_POST['sr']) ? $_POST['sr'] : $data['sr'];
              $custody = isset($_POST['custody']) ? $_POST['custody'] : $data['custody'];
              $device_details = isset($_POST['device_details']) ? $_POST['device_details'] : $data['Device_Details'];
              $installation_department = isset($_POST['installation_department']) ? $_POST['installation_department'] : $data['Installation_Department'];
              $dispensed_date = isset($_POST['dispensed_date']) ? $_POST['dispensed_date'] : $data['Dispensed_Date'];
              $status = isset($_POST['status']) ? $_POST['status'] : $data['Status'];
              $type = isset($_POST['type']) ? $_POST['type'] : $data['type'];
              $type_aa = isset($_POST['type_aa']) ? $_POST['type_aa'] : $data['type_aa'];

              // Form validation errors
              $formErrors = array();

              // Example validation (you can add more specific checks)
              if (empty($device_type)) {
                  $formErrors[] = 'نوع الجهاز is required.';
              }
              if (empty($sr)) {
                  $formErrors[] = 'رقم الجهاز is required.';
              }
              if (empty($custody)) {
                  $formErrors[] = 'رقم العهدة is required.';
              }

              // Show errors if any
              if (!empty($formErrors)) {
                  echo '<div class="container">';
                  foreach ($formErrors as $error) {
                      echo '<div class="alert alert-danger" style="width: 50%;">' . $error . '</div>';
                  }
                  echo '</div>';
              } else {
                  // If no errors, perform the update
                  $stmt = $conn->prepare("
                      UPDATE reports
                      SET
                          Device_Type = ?,
                          Device_Details = ?,
                          Installation_Department = ?,
                          Status = ?,
                          type = ?,
                          sr = ?,
                          custody = ?,
                          type_aa = ?
                      WHERE id = ?
                  ");

                  // Execute the query with the form values
                  $stmt->execute(array(
                      $device_type,          // Device Type
                      $device_details,       // Device Details
                      $installation_department, // Installation Department
                      $status,               // Status
                      $type,                 // Report Type
                      $sr,                   // Serial Number
                      $custody,
                      $type_aa,          // Custody Number
                      $id                    // Device ID (used for WHERE clause)
                  ));

                  // Check if the record was updated successfully
                  if ($stmt->rowCount() > 0) {
                    header('location: reports.php?status=success');
                    exit;
                  } else {
                    header('location: reports.php?status=no_changes');
                    exit;
                  }
              }
          }
          header('location: reports.php');
          exit;
          include $tpl . 'footer.php';


        }

  elseif ($page == 'delete') {
     include 'init.php';
      if ($_SESSION['type'] == 2)
      {
        $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : header('location: reports.php');;
        $stmt = $conn->prepare("SELECT * FROM reports WHERE id = ? LIMIT 1");
        $stmt->execute(array($id));
        $check = $stmt->rowCount();

        if ($check > 0 )
        {
          $stmt = $conn->prepare("DELETE FROM reports WHERE id = :zid");
          $stmt->bindParam(":zid", $id);
          $stmt->execute();
          header('location: reports.php');

        }
        else {
          header('location: reports.php');
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
