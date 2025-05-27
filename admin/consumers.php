<?php
  ob_start();
  session_start();
  if (isset($_SESSION['admin']))
  {


    $page = isset($_GET['page']) ? $_GET['page'] : 'manage';


        if ($page == 'manage')
        {
          $pageTitle = 'صفحة ادارة المستهلكات';
          include 'init.php';
          $ord = 'ASC';

          if (isset($_GET['ordering']))
          {
            $ord = $_GET['ordering'];
          }

          $search = isset($_GET['search']) ? $_GET['search'] : '';
$query = "SELECT * FROM consumers WHERE 1";

if (!empty($search)) {
    $query .= " AND sr LIKE :search"; // عدلي العمود إذا تبغي البحث باسم الجهاز مثلاً
}

$query .= " ORDER BY id $ord";
$stmt = $conn->prepare($query);

if (!empty($search)) {
    $stmt->bindValue(':search', "%$search%");
}

$stmt->execute();
$posts = $stmt->fetchAll();

            ?>
            <div class="default-management-list users-management">
              <div class="container-fluid cnt-spc">
                <div class="row">


                  <div class="col-md-6">
                    <div class="right-header management-header">
                      <div class="btns">
                        <a href="consumers.php?page=add" class="add-btn"> <i class="fas fa-plus"></i> </a>
                         <div class="col-md-6 d-flex justify-content-end align-items-center mb-3">
  <form method="GET" action="consumers.php" class="d-flex w-100" style="max-width: 300px;">
    <input type="hidden" name="page" value="manage">
    <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="ابحث بالرقم التسلسلي" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
    <button type="submit" class="btn btn-primary btn-sm">بحث</button>
  </form>
</div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="left-header management-header">
                      <h1>قائمة الاجهزة المستهلكة</h1>
                      <p class="tt">اجمالي <?php echo Total($conn, 'consumers ') ?> </p>
                    </div>
                  </div>
                  <div class="col-md-6 srch-sp">
                    <div class="search-box">
                      <!-- <input type="search" class="form-control" name="search" id="categories-search" onkeyup="tabletwo()" autocomplete="off" placeholder="search by name"> -->
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="management-body"style="margin-top: 50px;">
                      <div class="default-management-table">
                        <table class="table" id="categories-table">
                          <thead>
                            <tr>
                              <th scope="col">اسم المستهلك</th>
                              <th scope="col">الكمية </th>
                              <th scope="col">اسم الجهاز </th>

                              <th scope="col">SR: Serial number </th>


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
                                  <p class="f-n"><?php echo $post['consumer_name']; ?> </p>
                                </td>
                                <td>
                                  <p class="f-n"><?php echo $post['quantity']; ?> </p>
                                </td>


                                <td>
                                  <?php
                                  echo $post['device_name'];
                                   ?>
                                </td>
                                <td>
                                  <?php
                                  echo $post['sr'];
                                   ?>
                                </td>
                                <td>
                                  <?php

                                    ?>
                                    <ul>
                                      <li class=" dropdown">
                                              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-h"></i>
                                              </a>
                                              <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="consumers.php?page=delete&id=<?php echo $post['id'] ?>">
                                                <i class="fas fa-trash"></i>

                                            حذف
                                          </a>          <a class="dropdown-item" href="consumers.php?page=edit&id=<?php echo $post['id'] ?>">
                                                          <i class="fas fa-edit"></i>

                                                      تعديل
                                                          </a>
                                              </div>
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
      <div class="add-default-page add-post-page  add-product-page " id="add-page">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-md-8">
              <form class="add-fomr" method="POST" action="consumers.php?page=insert" enctype="multipart/form-data"  id="ca-form-info"  >
                <h3>قم بلمئ المعلومات لاضافة<a style="margin-left:5px;font-size:15px;border-radius: 10px;background:var(--mainColor);color:white;padding:8px" href="consumers.php?page=manage" class="fas fa-long-arrow-alt-right"></a>  </h3>

                  <div class="row">
                    <div class="form-group col-md-6">
        <label for="consumer_name">اسم المستهلك</label>
        <input type="text" name="consumer_name" id="consumer_name" placeholder="اسم المستهلك" required class="form-control">
    </div>

    <!-- Quantity -->
    <div class="form-group col-md-6">
        <label for="quantity">الكمية</label>
        <input type="number" name="quantity" id="quantity" placeholder="الكمية" required class="form-control">
    </div>

    <!-- Additional Quantity -->
    <div class="form-group col-md-6">
        <label for="additional_quantity">إضافة خانة بالكمية</label>
        <input type="number" name="additional_quantity" id="additional_quantity" placeholder="إضافة خانة بالكمية" required class="form-control">
    </div>

    <!-- Consumer Type -->
    <div class="form-group col-md-6">
        <label for="consumer_type">نوع المستهلك</label>
        <input type="text" name="consumer_type" id="consumer_type" placeholder="نوع المستهلك" required class="form-control">
    </div>

    <!-- SR: Serial Number -->
    <div class="form-group col-md-6">
        <label for="sr">SR: Serial number</label>
        <input type="text" name="sr" id="sr" placeholder="SR: Serial number" required class="form-control">
    </div>

    <!-- Custody Number -->
    <div class="form-group col-md-6">
        <label for="custody_number">رقم العهدة</label>
        <input type="text" name="custody_number" id="custody_number" placeholder="رقم العهدة" required class="form-control">
    </div>

    <!-- Device Location -->
    <div class="form-group col-md-6">
        <label for="device_location">موقع الجهاز</label>
        <input type="text" name="device_location" id="device_location" placeholder="موقع الجهاز" required class="form-control">
    </div>

    <!-- Remarks -->
    <div class="form-group col-md-6">
        <label for="remarks">ملاحظات</label>
        <input type="text" name="remarks" id="remarks" placeholder="ملاحظات" required class="form-control">
    </div>

    <!-- Storage Type -->
    <div class="form-group col-md-6">
        <label for="storage_type">نوع وحدة التخزين</label>
        <input type="text" name="storage_type" id="storage_type" placeholder="نوع وحدة التخزين" required class="form-control">
    </div>

    <!-- RAM Type -->
    <div class="form-group col-md-6">
        <label for="ram_type">نوع RAM</label>
        <input type="text" name="ram_type" id="ram_type" placeholder="نوع RAM" required class="form-control">
    </div>

    <!-- Device Name -->
    <div class="form-group col-md-6">
        <label for="device_name">اسم الجهاز</label>
        <input type="text" name="device_name" id="device_name" placeholder="اسم الجهاز" required class="form-control">
    </div>

    <!-- Created At -->

    <!-- Submit Button -->



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
        if (empty($consumer_name))
        {
          $formErrors[] = 'الاسم اجبري';
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

  // Insert data into the database
  // Prepare the INSERT statement
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
  ));  // Debugging - print the last inserted ID or success message
  if ($stmt) {
              header('location: consumers.php?page=manage');
  } else {
      echo "Failed to insert data.";
  }
                                ?>

                                <?php
                                header('location: consumers.php?page=manage');
                              }




      }else {
        header('location: posts.php');
      }
      include $tpl . 'footer.php';

      ?>
      <?php
    }    elseif ($page == 'edit') {
          $pageTitle = "تعديل الجهاز";
          include 'init.php';

          $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : header('location: users.php');
          $stmt = $conn->prepare("SELECT * FROM consumers WHERE id = ? LIMIT 1");
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
                        <h1 dir="rtl" style="display:block;text-align:right">تعديل المستهلك <?php echo $userInfo['consumer_name'] ?></h1>
                      </div>
                    </div>

                    <div class="col-md-4">
                      <div class="row">


                      </div>

                    </div>
                    <div class="col-md-8">
                      <div class="use-fl-info">
                        <form method="post" action="consumers.php?page=update" enctype="multipart/form-data">


                                            <div class="row">
                                              <div class="form-group col-md-6">
                  <label for="consumer_name">اسم المستهلك</label>
                  <input type="text" value="<?php echo isset($userInfo['consumer_name']) ? $userInfo['consumer_name'] : ''; ?>" name="consumer_name" id="consumer_name" placeholder="اسم المستهلك" required class="form-control">
              </div>

              <!-- Quantity -->
              <div class="form-group col-md-6">
                  <label for="quantity">الكمية</label>
                  <input type="number" value="<?php echo isset($userInfo['quantity']) ? $userInfo['quantity'] : ''; ?>" name="quantity" id="quantity" placeholder="الكمية" required class="form-control">
              </div>

              <!-- Additional Quantity -->
              <div class="form-group col-md-6">
                  <label for="additional_quantity">إضافة خانة بالكمية</label>
                  <input type="number" value="<?php echo isset($userInfo['additional_quantity']) ? $userInfo['additional_quantity'] : ''; ?>" name="additional_quantity" id="additional_quantity" placeholder="إضافة خانة بالكمية" required class="form-control">
              </div>

              <!-- Consumer Type -->
              <div class="form-group col-md-6">
                  <label for="consumer_type">نوع المستهلك</label>
                  <input type="text" value="<?php echo isset($userInfo['consumer_type']) ? $userInfo['consumer_type'] : ''; ?>" name="consumer_type" id="consumer_type" placeholder="نوع المستهلك" required class="form-control">
              </div>

              <!-- SR: Serial Number -->
              <div class="form-group col-md-6">
                  <label for="sr">SR: Serial number</label>
                  <input type="text" value="<?php echo isset($userInfo['sr']) ? $userInfo['sr'] : ''; ?>" name="sr" id="sr" placeholder="SR: Serial number" required class="form-control">
              </div>

              <!-- Custody Number -->
              <div class="form-group col-md-6">
                  <label for="custody_number">رقم العهدة</label>
                  <input type="text" value="<?php echo isset($userInfo['custody_number']) ? $userInfo['custody_number'] : ''; ?>" name="custody_number" id="custody_number" placeholder="رقم العهدة" required class="form-control">
              </div>

              <!-- Device Location -->
              <div class="form-group col-md-6">
                  <label for="device_location">موقع الجهاز</label>
                  <input type="text" value="<?php echo isset($userInfo['device_location']) ? $userInfo['device_location'] : ''; ?>" name="device_location" id="device_location" placeholder="موقع الجهاز" required class="form-control">
              </div>

              <!-- Remarks -->
              <div class="form-group col-md-6">
                  <label for="remarks">ملاحظات</label>
                  <input type="text" value="<?php echo isset($userInfo['remarks']) ? $userInfo['remarks'] : ''; ?>" name="remarks" id="remarks" placeholder="ملاحظات" required class="form-control">
              </div>

              <!-- Storage Type -->
              <div class="form-group col-md-6">
                  <label for="storage_type">نوع وحدة التخزين</label>
                  <input type="text" value="<?php echo isset($userInfo['storage_type']) ? $userInfo['storage_type'] : ''; ?>" name="storage_type" id="storage_type" placeholder="نوع وحدة التخزين" required class="form-control">
              </div>

              <!-- RAM Type -->
              <div class="form-group col-md-6">
                  <label for="ram_type">نوع RAM</label>
                  <input type="text" value="<?php echo isset($userInfo['ram_type']) ? $userInfo['ram_type'] : ''; ?>" name="ram_type" id="ram_type" placeholder="نوع RAM" required class="form-control">
              </div>

              <!-- Device Name -->
              <div class="form-group col-md-12">
                  <label for="device_name">اسم الجهاز</label>
                  <input type="text" value="<?php echo isset($userInfo['device_name']) ? $userInfo['device_name'] : ''; ?>" name="device_name" id="device_name" placeholder="اسم الجهاز" required class="form-control">
              </div>

                                                                       <input type="hidden" name="id" value="<?php echo $userInfo['id']; ?>">






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

                                $stmt = $conn->prepare("SELECT * FROM consumers WHERE id = ? LIMIT 1");
                                $stmt->execute(array($id));
                                $checkIfuser = $stmt->rowCount();
                                $data = $stmt->fetch();

                                if($_SERVER['REQUEST_METHOD'] == 'POST')
                                {
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
                                if (empty($consumer_name))
                                {
                                  $formErrors[] = 'الاسم اجباري';
                                }




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
                                      $id // Pass the ID to target the specific record to be updated
                                  ));

                                  // Optional: Check if the update was successful
                                  if ($stmt->rowCount() > 0) {
                                      echo "تم التحديث بنجاح.";
                                  } else {
                                      echo "لم يتم التحديث أو لم يتم العثور على السجل.";
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
        $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : header('location: consumers.php');;
        $stmt = $conn->prepare("SELECT * FROM consumers WHERE id = ? LIMIT 1");
        $stmt->execute(array($id));
        $check = $stmt->rowCount();

        if ($check > 0 )
        {
          $stmt = $conn->prepare("DELETE FROM consumers WHERE id = :zid");
          $stmt->bindParam(":zid", $id);
          $stmt->execute();
          header('location: consumers.php');

        }
        else {
          header('location: consumers.php');
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
