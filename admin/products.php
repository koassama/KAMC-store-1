<?php
  ob_start();
  session_start();
  if (isset($_SESSION['admin']))
  {


    $page = isset($_GET['page']) ? $_GET['page'] : 'manage';

    if ($page == 'manage')
    {
      $pageTitle = 'صفحة ادارة المخزون';
      include 'init.php';
      $ord = 'DESC';

      if (isset($_GET['ordering']))
      {
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
                $stmt->execute();
                $posts = $stmt->fetchAll();


        ?>
        <div class="default-management-list users-management">
          <div class="container cnt-spc">
            <div class="row">


              <div class="col-md-6">
                <div class="right-header management-header">
                  <div class="btns">
                    <a href="products.php?page=add" id="open-add-page" class="add-btn"><i class="fas fa-plus"></i></a>
                  <form method="GET" action="products.php" class="d-flex justify-content-start align-items-center" style="gap: 5px;">
                   <input type="search" name="search" class="form-control form-control-sm" placeholder="ابحث باسم الجهاز"
                   value="<?php echo htmlspecialchars($search); ?>" style="max-width: 200px;">
                   <button type="submit" class="btn btn-primary btn-sm">بحث</button>
                  </form>
  >
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="left-header management-header">
                  <h1>قائمة المخزون</h1>
                  <p class="tt">اجمالي المخزون <?php echo Total_Prod($conn, 'products', "status = 0") ?>منتج</p>
                </div>
              </div>
              <div class="col-md-6 srch-sp">
                <div class="search-box">
                  <!-- <input type="search" class="form-control" name="search" id="categories-search" onkeyup="tabletwo()" autocomplete="off" placeholder="search by name"> -->
                </div>
              </div>

              <div class="col-md-12">
<div class="management-body" style="margin-top: 50px;">
                    <div class="default-management-table">
                    <table class="table" id="categories-table">
                      <thead>
                        <tr>
                          <th scope="col">id</th>
                          <th scope="col">صورة الجهاز</th>
                          <th scope="col">sr</th>
                          <th scope="col">اسم الجهاز</th>

                          <th scope="col">نوع الجهاز</th>


                          <th scope="col">التاريخ</th>

                          <th scope="col">حدث</th>

                        </tr>
                      </thead>
                      <tbody>

                        <?php
                        foreach($posts as $post)
                        {
                          ?>
                          <tr>
                            <td>
                              <p><?php echo $post['id'] ?></p>
                            </td>

                            <td>
                              <div class="avatar">
                                <?php
                                    if (empty($post['device_image']))
                                    {
                                      ?>
                                      <img src="<?php echo $images  ?>default.png" alt="" style="width:40px">

                                      <?php
                                    }
                                    if (!empty($post['device_image']))
                                    {
                                      ?>
                                      <img src="<?php echo $images . $post['device_image']  ?>" alt="" style="width:40px">

                                      <?php
                                    }
                                 ?>
                              </div>
                            </td>      <td>
                                    <p><?php echo $post['sr'] ?></p>
                                  </td>
                                  <td>
                                    <p><?php echo $post['device_name'] ?></p>
                                  </td>
                            <td>
                              <p class="f-n"><?php echo $post['device_type']; ?> </p>
                            </td>


                            <td>
                              <?php
                              echo $post['created_at'];
                               ?>
                            </td>

                            <td>
                              <?php

                                    ?>
                                    <ul class="list-group">
<li class="list-group-item">
<a href="products.php?page=delete&id=<?php echo $post['id']; ?>" class="text-danger" onclick="return confirm('هل تريد الحذف؟');">
  <i class="fas fa-trash"></i> حذف
</a>
</li>
<li class="list-group-item">
<a href="products.php?page=edit&id=<?php echo $post['id']; ?>" class="text-warning">
<i class="fas fa-edit"></i> تعديل
</a>
</li>
</ul>
                                    <?php




                               ?>

                            </td>

                          </tr>
                          <tr>

                          <?php
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
      $pageTitle = 'اضافة منتج جديد';
      include 'init.php';
      ?>
      <div class="add-default-page add-post-page  add-product-page " id="add-page">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-md-8">
              <form class="add-fomr" method="POST" action="products.php?page=insert" enctype="multipart/form-data"  id="ca-form-info"  >
                <h3>اضافة منتج جديد<a style="margin-left:5px;font-size:15px;border-radius: 10px;background:var(--mainColor);color:white;padding:8px" href="products.php?page=manage" class="fas fa-long-arrow-alt-right"></a>   </h3>
                  <div class="row">
                    <div class="form-group col-md-6">
      <label for="sr">seriel number</label>
      <input type="text" name="sr" id="sr" placeholder=" " require class="form-control" >
      </div>

       <div class="form-group col-md-6">
      <label for="device_name">اسم الجهاز</label>
      <input type="text" name="device_name" id="device_name" placeholder="اسم الجهاز" require class="form-control" >
    </div>

                    <div class="form-group col-md-6">
      <label for="device_type">نوع الجهاز</label>
      <select class="form-control" name="device_type" id="device_type" require>

                                            <option value=""> </option>
                                            <option value="HP">HP </option>
                                            <option value="Dell">Dell  </option>
                                            <option value="Lenovo ">Lenovo   </option>
                                            <option value="Zebra "> Zebra  </option>
                                            <option value="جدارية "> جدارية  </option>
                                            <option value="portabol "> portabol  </option>
                                            <option value="Signature pad "> Signature pad  </option>
                                            

                                          </select>
                                        </div>

    <div class="form-group col-md-6">
      <label for="device_model">موديل الجهاز</label>
      <input type="text" name="device_model" id="device_model" placeholder="موديل الجهاز" class="form-control" >
    </div>

    <div class="form-group col-md-12">
      <label for="notes">ملاحظات</label>
      <textarea name="notes" id="notes" placeholder="ملاحظات" class="form-control"></textarea>
    </div>

    <div class="form-group col-md-6">
      <label for="employee_id">الرقم الوظيفي</label>
      <input type="text" name="employee_id" id="employee_id" placeholder="الرقم الوظيفي" class="form-control" >
    </div>

    <div class="form-group col-md-6">
      <label for="department">الإدارة</label>
      <input type="text" name="department" id="department" placeholder="الإدارة" class="form-control" >
    </div>


                    <div class="form-group col-md-12">
                      <label for="image">صورة الجهاز</label>
                      <input type="file" name="image" id="image" class="form-control">
                    </div>
                  </div>

                <input type="submit" class="btn btn-primary" id="ca-btn-option"  value="اضف ">
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
      $pageTitle = 'ادخال البيانات';
      include 'init.php';

      if ($_SERVER['REQUEST_METHOD'] == 'POST')
      {

        $sr = $_POST['sr']; // نوع الجهاز
 
        $device_name = $_POST['device_name']; // نوع الجهاز

        $device_type = $_POST['device_type']; // نوع الجهاز
        $device_model = $_POST['device_model']; // موديل الجهاز
        $notes = $_POST['notes']; // الملاحظات
        $employee_id = $_POST['employee_id']; // الرقم الوظيفي
        $department = $_POST['department']; // الإدارة


        $imageName = $_FILES['image']['name'];
        $imageSize = $_FILES['image']['size'];
        $imageTmp = $_FILES['image']['tmp_name'];
        $imageType = $_FILES['image']['type'];




        $imageAllowedExtension = array("jpeg", "jpg", "png");
        $Infunc = explode('.', $imageName);
        $imageExtension = strtolower(end($Infunc));



        #$formErrors = array();
        #if (empty($imageName))
        #{
        #  $formErrors[] = "واجهة الجهاز اجباري";
        #}
        #if (!empty($imageName) && ! in_array($imageExtension, $imageAllowedExtension))
        #{
        #  $formErrors[] = 'نطاق الصورة غير مسموح به';
        #}

  
        $formErrors = array();

        if (empty($sr)) {
            $formErrors[] = "حقل السيريال فارغ";
        }
        
        if (!empty($sr) && Total_Prod($conn, 'products', "sr = '$sr'") > 0) {
            $formErrors[] = 'السيريال موجود';
        }
        if (empty($device_name)) {
            $formErrors[] = "حقل اسم الجهاز فارغ";
        }
        
        if (!empty($device_name) && Total_Prod($conn, 'products', "device_name = '$device_name'") > 0) {
            $formErrors[] = 'اسم الجهاز موجود';
        }
        if (empty($device_type)) {
            $formErrors[] = "حقل نوع الجهاز فارغ";
        }
        


 

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
                                $image = rand(0,100000) . '_' . $imageName;
                                move_uploaded_file($imageTmp, $images . '/' . $image);



                                $stmt = $conn->prepare("
                   INSERT INTO products (
                     sr,
                     device_name,
                       device_type,
                       device_model,
                       notes,
                       device_image,
                       employee_id,
                       department,
                       created_at
                   )
                   VALUES (
                        :sr,
                        :device_name,
                       :device_type,
                       :device_model,
                       :notes,
                       :device_image,
                       :employee_id,
                       :department,
                       NOW()
                   )
               ");

               // تنفيذ الاستعلام مع القيم
               $stmt->execute(array(
                 ':sr' => $sr,
                 ':device_name' => $device_name,

                   ':device_type' => $device_type,
                   ':device_model' => $device_model,
                   ':notes' => $notes,
                   ':device_image' => $image,
                   ':employee_id' => $employee_id,
                   ':department' => $department
               ));

                                ?>


                                                                <div class="alert alert-success" style="margin-top: 15px">
                                  تم اضافة الجهاز بنجاح
                                </div>
                                <?php
                                header('location: products.php?page=manage');
                              }




      }else {
        header('location: products.php');
      }
      include $tpl . 'footer.php';

      ?>
      <?php
    }

    elseif ($page == 'edit') {
      $pageTitle = "صفحة تعديل المنتجات";
      include 'init.php';

      $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : header('location: products.php');
      $stmt = $conn->prepare("SELECT * FROM products WHERE id= ? LIMIT 1");
      $stmt->execute(array($id));
      $checkpost = $stmt->rowCount();
      $postinfo = $stmt->fetch();
      if ($checkpost > 0)
      {


          ?>
          <div class="edit-page user-edit-pages deep-page">
            <div class="container cnt-spc">
              <div class="row justify-content-end">
                <div class="col-md-12">
                  <div class="pg-tt" style="text-align:right">
                    <h1> تعديل الجهاز - <?php echo $postinfo['device_type'] ?> <a style="margin-left:5px;font-size:15px;border-radius: 10px;background:var(--mainColor);color:white;padding:8px" href="products.php?page=manage" class="fas fa-long-arrow-alt-right"></a>  </h1>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="use-fl-info">
                    <form class="form" method="post" action="products.php?page=update&id=<?php echo $postinfo['id'] ?>" enctype="multipart/form-data" style="margin-bottom:60px">
                      <input type="hidden" name="id" value="<?php echo $postinfo['id'] ?>">
                      <div class="row">


                        <div class="form-group col-md-6">
                          <label for="device_type">seriel number</label>
                          <input type="text"
                                 value="<?php echo isset($postinfo['sr']) ? htmlspecialchars($postinfo['sr']) : ''; ?>"
                                 name="sr"
                                 id="device_type"
                                 placeholder=""
                                 class="form-control"
                                 required>
                        </div>

                        <div class="form-group col-md-6">
                          <label for="device_model">اسم الجهاز</label>
                          <input type="text"
                                 value="<?php echo isset($postinfo['device_name']) ? htmlspecialchars($postinfo['device_name']) : ''; ?>"
                                 name="device_name"
                                 id="device_model"
                                 placeholder=""
                                 class="form-control"
                                 required>
                        </div>

                        <div class="form-group col-md-6">
                          <label for="device_type">نوع الجهاز</label>
                          <input type="text"
                                 value="<?php echo isset($postinfo['device_type']) ? htmlspecialchars($postinfo['device_type']) : ''; ?>"
                                 name="device_type"
                                 id="device_type"
                                 placeholder="نوع الجهاز"
                                 class="form-control"
                                 required>
                        </div>

                        <div class="form-group col-md-6">
                          <label for="device_model">موديل الجهاز</label>
                          <input type="text"
                                 value="<?php echo isset($postinfo['device_model']) ? htmlspecialchars($postinfo['device_model']) : ''; ?>"
                                 name="device_model"
                                 id="device_model"
                                 placeholder="موديل الجهاز"
                                 class="form-control"
                                 required>
                        </div>

                        <div class="form-group col-md-12">
                          <label for="notes">ملاحظات</label>
                          <textarea name="notes"
                                    id="notes"
                                    placeholder="ملاحظات"
                                    class="form-control"><?php echo isset($postinfo['notes']) ? htmlspecialchars($postinfo['notes']) : ''; ?></textarea>
                        </div>

                        <div class="form-group col-md-6">
                          <label for="device_image">صورة الجهاز</label>
                          <input type="file"
                                 name="image"
                                 id="device_image"
                                 class="form-control">
                        </div>

                        <div class="form-group col-md-6">
                          <label for="employee_id">الرقم الوظيفي</label>
                          <input type="text"
                                 value="<?php echo isset($postinfo['employee_id']) ? htmlspecialchars($postinfo['employee_id']) : ''; ?>"
                                 name="employee_id"
                                 id="employee_id"
                                 placeholder="الرقم الوظيفي"
                                 class="form-control"
                                 >
                        </div>

                        <div class="form-group col-md-12">
                          <label for="department">الإدارة</label>
                          <input type="text"
                                 value="<?php echo isset($postinfo['department']) ? htmlspecialchars($postinfo['department']) : ''; ?>"
                                 name="department"
                                 id="department"
                                 placeholder="الإدارة"
                                 class="form-control"
                                 >
                        </div>

                        <input type="hidden" name="id" value="<?php echo $postinfo['id'] ?>">




                      </div>

                      <input type="submit" class="btn btn-primary" name="" value="احفظ التغيرات">
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php

      }
      else {
        header('location: posts.php');
      }
      ?>


      <?php

      include $tpl . 'footer.php';
    }
    elseif ($page == 'insertimage') {
      $pageTitle = 'ادخال البيانات';
      include 'init.php';

      if ($_SERVER['REQUEST_METHOD'] == 'POST')
      {


        $device_type = isset($_POST['device_type']) ? $_POST['device_type'] : '';
        $device_model = isset($_POST['device_model']) ? $_POST['device_model'] : '';
        $notes = isset($_POST['notes']) ? $_POST['notes'] : '';
        $employee_id = isset($_POST['employee_id']) ? $_POST['employee_id'] : '';
        $department = isset($_POST['department']) ? $_POST['department'] : '';



        $imageName = $_FILES['image']['name'];
        $imageSize = $_FILES['image']['size'];
        $imageTmp = $_FILES['image']['tmp_name'];
        $imageType = $_FILES['image']['type'];
        $id = $_POST['id'];



        $imageAllowedExtension = array("jpeg", "jpg", "png");
        $Infunc = explode('.', $imageName);
        $imageExtension = strtolower(end($Infunc));




        $formErrors = array();

        if (empty($imageName))
        {
          $formErrors[] = "product image is required";
        }
        if (!empty($imageName) && ! in_array($imageExtension, $imageAllowedExtension))
        {
          $formErrors[] = 'image extension not allowed';
        }


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
                                $image = rand(0,100000) . '_' . $imageName;
                                move_uploaded_file($imageTmp, $images . '/' . $image);




                                $stmt = $conn->prepare("INSERT INTO images(image,book)

                                 VALUES(:zca,:zsec )");
                                $stmt->execute(array(
                                  'zca' => $image,
                                  'zsec' => $book
                                ));
                                ?>
                                <div class="alert alert-success" style="margin-top: 15px">
                              The product has been added successfully
                                </div>
                                <?php
                                header('location:' . $_SERVER['HTTP_REFERER']);
                              }




      }else {
        header('location: products.php');
      }
      include $tpl . 'footer.php';

      ?>
      <?php
    }
    elseif ($page == 'insertvideo') {
      $pageTitle = 'ادخال البيانات';
      include 'init.php';

      if ($_SERVER['REQUEST_METHOD'] == 'POST')
      {



        $imageName = $_FILES['image']['name'];
        $imageSize = $_FILES['image']['size'];
        $imageTmp = $_FILES['image']['tmp_name'];
        $imageType = $_FILES['image']['type'];
        $book = $_POST['book'];







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
                                $image = rand(0,100000) . '_' . $imageName;
                                move_uploaded_file($imageTmp, $images . '/' . $image);




                                $stmt = $conn->prepare("INSERT INTO videos(video,book)

                                 VALUES(:zca,:zsec )");
                                $stmt->execute(array(
                                  'zca' => $image,
                                  'zsec' => $book
                                ));
                                ?>
                                <div class="alert alert-success" style="margin-top: 15px">
                              The product has been added successfully
                                </div>
                                <?php
                                header('location:' . $_SERVER['HTTP_REFERER']);
                              }




      }else {
        header('location: products.php');
      }
      include $tpl . 'footer.php';

      ?>
      <?php
    }
     elseif ($page == 'deleteimage') {
       include 'init.php';
        if ($_SESSION['type'] == 2)
        {
          $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : header('location: products.php');;
          $stmt = $conn->prepare("SELECT * FROM images WHERE id = ? LIMIT 1");
          $stmt->execute(array($id));
          $check = $stmt->rowCount();

          if ($check > 0 )
          {
            $stmt = $conn->prepare("DELETE FROM images WHERE id = :zid");
            $stmt->bindParam(":zid", $id);
            $stmt->execute();
            header('location: ' . $_SERVER['HTTP_REFERER']);

          }
          else {
            header('location: ' . $_SERVER['HTTP_REFERER']);
          }
        }
      }
      elseif ($page == 'deletevideo') {
        include 'init.php';
         if ($_SESSION['type'] == 2)
         {
           $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : header('location: products.php');;
           $stmt = $conn->prepare("SELECT * FROM videos WHERE id = ? LIMIT 1");
           $stmt->execute(array($id));
           $check = $stmt->rowCount();

           if ($check > 0 )
           {
             $stmt = $conn->prepare("DELETE FROM videos WHERE id = :zid");
             $stmt->bindParam(":zid", $id);
             $stmt->execute();
             header('location: ' . $_SERVER['HTTP_REFERER']);

           }
           else {
             header('location: ' . $_SERVER['HTTP_REFERER']);
           }
         }
       }
    elseif ($page == 'update') {


      $pageTitle = 'صفحة تحديث المعلومات';
      include 'init.php';
                      $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : header('location: products.php');;

                            $stmt = $conn->prepare("SELECT * FROM products WHERE id = ? LIMIT 1");
                            $stmt->execute(array($id));
                            $checkpst = $stmt->rowCount();


                            if ($checkpst > 0 )
                            {


                                if($_SERVER['REQUEST_METHOD'] == 'POST')
                                {

                                  $device_type = isset($_POST['device_type']) ? $_POST['device_type'] : '';
                                  $device_model = isset($_POST['device_model']) ? $_POST['device_model'] : '';
                                  $notes = isset($_POST['notes']) ? $_POST['notes'] : '';
                                  $sr = isset($_POST['sr']) ? $_POST['sr'] : '';
                                  $device_name = isset($_POST['device_name']) ? $_POST['device_name'] : '';
                                  $employee_id = isset($_POST['employee_id']) ? $_POST['employee_id'] : '';
                                  $department = isset($_POST['department']) ? $_POST['department'] : '';
                                  $imageName = $_FILES['image']['name'];
                                  $imageSize = $_FILES['image']['size'];
                                  $imageTmp = $_FILES['image']['tmp_name'];
                                  $imageType = $_FILES['image']['type'];


                                  $imageAllowedExtension = array("jpeg", "jpg", "png");
                                  $Infunc = explode('.', $imageName);
                                  $imageExtension = strtolower(end($Infunc));



                                  $formErrors = array();





                                  if (!empty($imageName) && ! in_array($imageExtension, $imageAllowedExtension))
                                  {
                                    $formErrors[] = 'نطاق الصورة غير مسموح به';
                                  }
                                  if ($imageSize > 4194304)
                                  {
                                    $formErrors[] = 'حجم الصورة كبير';
                                  }



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




                                ?>
                                  <div class="container">
                                    <a href="products.php?page=edit&id=<?php echo $id ?>">اضغط هنا للعودة الى الصفحة السابقة</a>
                                  </div>
                                <?php

                                if (empty($formErrors))
                                {
                                  if (empty($imageName))
                                  {
                                    $stmt = $conn->prepare("SELECT device_image FROM products WHERE id =? LIMIT 1");
                                    $stmt->execute(array($id));
                                    $igg = $stmt->fetch();
                                    $image = $igg['device_image'];
                                  }
                                  else {
                                    $image = rand(0,100000) . '_' . $imageName;
                                    move_uploaded_file($imageTmp, $images . '/' . $image);
                                  }




                                  $stmt = $conn->prepare("
            UPDATE products
            SET
              sr= ?,
              device_name=?,
                device_type = ?,
                device_model = ?,
                notes = ?,
                device_image = ?,
                employee_id = ?,
                department = ?,
                created_at = NOW()
            WHERE id = ?
        ");

        // Assuming $id is the ID of the device to update (should be provided)
        $stmt->execute(array(
            	$sr,
              $device_name,
            $device_type,
            $device_model,
            $notes,
            $image,
            $employee_id,
            $department,
            $id // The ID of the device to be updated
        ));
                                                                 header('location: ' . $_SERVER['HTTP_REFERER']);
                                }
                              }





                              else {
                                header('location: producs.php');
                              }
                            }
                            else {
                              header('location: products.php');
                            }
      include $tpl . 'footer.php';


    }elseif ($page == 'delete') {
     include 'init.php';
      if ($_SESSION['type'] == 2)
      {
        $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : header('location: products.php');;
        $stmt = $conn->prepare("SELECT * FROM products WHERE id = ? LIMIT 1");
        $stmt->execute(array($id));
        $check = $stmt->rowCount();

        if ($check > 0 )
        {
          $stmt = $conn->prepare("DELETE FROM products WHERE id = :zid");
          $stmt->bindParam(":zid", $id);
          $stmt->execute();
          header('location: products.php');

        }
        else {
          header('location: products.php');
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
