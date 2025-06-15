<?php
  ob_start();
  session_start();
  if (isset($_SESSION['admin']))
  {


    $page = isset($_GET['page']) ? $_GET['page'] : 'manage';


        if ($page == 'manage')
        {
          $pageTitle = 'صفحة ادارة الاجهزة الواردة';
          include 'init.php';
          $ord = 'ASC';

          if (isset($_GET['ordering']))
          {
            $ord = $_GET['ordering'];
          }

          $stmt = $conn->prepare("SELECT * FROM piece  ORDER BY id $ord");
                    $stmt->execute();
                    $posts = $stmt->fetchAll();


            ?>
            <div class="default-management-list users-management">
              <div class="container-fluid cnt-spc">
                <div class="row">


                  <div class="col-md-6">
                    <div class="right-header management-header">
                      <div class="btns">
                        <a href="piece.php?page=add" class="add-btn"> <i class="fas fa-plus"></i> </a>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="left-header management-header">
                      <h1>قائمة الاجهزة</h1>
                      <p class="tt">اجمالي <?php echo Total($conn, 'piece ') ?> </p>
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
                              <th scope="col">موقع الجهاز </th>
                              <th scope="col">اسم الجهاز </th>

                              <th scope="col">عدد مرات الصيانة </th>
                              <th scope="col">مصدر الجهاز </th>


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
                                  <p class="f-n"><?php echo $post['sr']; ?> </p>
                                </td>
                                <td>
                                  <p class="f-n"><?php echo $post['location']; ?> </p>
                                </td>


                                <td>
                                  <?php
                                  echo $post['name'];
                                   ?>
                                </td>
                                <td>
                                  <?php
                                  echo $post['maintenance'];
                                   ?>
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
                                  <?php

                                    ?>
                                    <ul>
                                      <li class=" dropdown">
                                              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-h"></i>
                                              </a>
                                              <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="piece.php?page=delete&id=<?php echo $post['id'] ?>">
                                                <i class="fas fa-trash"></i>

                                            حذف الجهاز
                                          </a>          <a class="dropdown-item" href="piece.php?page=edit&id=<?php echo $post['id'] ?>">
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
              <form class="add-fomr" method="POST" action="piece.php?page=insert" enctype="multipart/form-data"  id="ca-form-info"  >
                <h3>قم بلمئ المعلومات لاضافة<a style="margin-left:5px;font-size:15px;border-radius: 10px;background:var(--mainColor);color:white;padding:8px" href="piece.php?page=manage" class="fas fa-long-arrow-alt-right"></a>  </h3>

                  <div class="row">
                    <div class="form-group col-md-6">
                      <label for="name">SR: Serial number</label>
                      <input type="text" name="sr" id="name" placeholder=" "  required class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="job">رقم العهدة </label>
                      <input type="text" name="custody" id="custody" placeholder=" " required class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="location">موقع الجهاز </label>
                      <input type="text" name="location" id="location " placeholder=" " required  class="form-control">
                    </div>

                    <div class="form-group col-md-6">
                      <label for="description">ملاحظات </label>
                      <input type="text" name="remarq" id="remarq" placeholder=" " required  class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="description">نوع وحدة التخزين </label>
                      <input type="text" name="me_type" id="me_type" placeholder=" "  required class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                      <label dir="rtl" for="description">نوع RAMSR: Serial number</label>
                      <input type="text" name="RAMSR" id="RAMSR" placeholder=" " required  class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="description">اسم الجهاز </label>
                      <input type="text" name="name" id="name" placeholder=" "  required class="form-control">
                    </div>



                    <div class="form-group col-md-6">
                      <label for="description">عدد مرات الصيانة  </label>
                      <input type="text" name="maintenance" id="maintenance" placeholder=" " required  class="form-control">
                    </div>


                    <div class="form-group col-md-6">
                      <label for="description">رقم طلب الصيانة ان وجد   </label>
                      <input type="text" name="maintenance_order" id="maintenance_order" required placeholder=" " class="form-control">
                    </div>


                                        <div class="form-group col-md-6">
                                          <label for="description">رقم طلب الصيانة ان وجد   </label>
                                          <select class="form-control" name="type">
                                            <option value="0">الشركة </option>
                                            <option value="1">المنافسة  </option>
                                            <option value="2">السوق الالكتروني  </option>
                                            <option value="3">الشراء المباشر  </option>

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

        $sr = isset($_POST['sr']) ? $_POST['sr'] : null; // Serial number
        $custody = isset($_POST['custody']) ? $_POST['custody'] : null; // رقم العهدة
        $location = $_POST['location']; // موقع الجهاز
        $remarq = isset($_POST['remarq']) ? $_POST['remarq'] : null; // ملاحظات
        $me_type = isset($_POST['me_type']) ? $_POST['me_type'] : null; // نوع وحدة التخزين
        $RAMSR = isset($_POST['RAMSR']) ? $_POST['RAMSR'] : null; // نوع RAM
        $name = isset($_POST['name']) ? $_POST['name'] : null; // اسم الجهاز
        $maintenance = isset($_POST['maintenance']) ? $_POST['maintenance'] : null; // عدد مرات الصيانة
        $maintenance_order = isset($_POST['maintenance_order']) ? $_POST['maintenance_order'] : null; // رقم طلب الصيانة ان وجد
        $type = isset($_POST['type']) ? $_POST['type'] : null; // Type (الشركة, المنافسة, etc.)
        $formErrors = array();
        if (empty($name))
        {
          $formErrors[] = 'اسم الجهاز اجباري';
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

                                    echo $location;

                          if (empty($formErrors))
                            {

  // Insert data into the database
  $stmt = $conn->prepare("
      INSERT INTO piece (
          sr, custody, location, remarq, me_type, RAMSR, name, maintenance, maintenance_order, type
      ) VALUES (
          :zsr, :zcustody, :zlocation, :zremarq, :zme_type, :zRAMSR, :zname, :zmaintenance, :zmaintenance_order, :ztype
      )
  ");
  $stmt->execute(array(
      'zsr' => $sr,
      'zcustody' => $custody,
      'zlocation' => $location,
      'zremarq' => $remarq,
      'zme_type' => $me_type,
      'zRAMSR' => $RAMSR,
      'zname' => $name,
      'zmaintenance' => $maintenance,
      'zmaintenance_order' => $maintenance_order,
      'ztype' => $type
  ));

  // Debugging - print the last inserted ID or success message
  if ($stmt) {
              header('location: piece.php?page=manage');
  } else {
      echo "Failed to insert data.";
  }
                                ?>

                                <?php
                                header('location: piece.php?page=manage');
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
          $stmt = $conn->prepare("SELECT * FROM piece WHERE id = ? LIMIT 1");
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
                        <h1 dir="rtl" style="display:block;text-align:right">تعديل الجهاز <?php echo $userInfo['name'] ?></h1>
                      </div>
                    </div>

                    <div class="col-md-4">
                      <div class="row">


                      </div>

                    </div>
                    <div class="col-md-8">
                      <div class="use-fl-info">
                        <form method="post" action="piece.php?page=update" enctype="multipart/form-data">


                                            <div class="row">
                                              <div class="form-group col-md-6">
                                                  <label for="name">SR: Serial number</label>
                                                  <input type="text" value="<?php echo htmlspecialchars($userInfo['sr'] ?? ''); ?>" name="sr" id="name" placeholder=" " required class="form-control">
                                              </div>
                                              <div class="form-group col-md-6">
                                                  <label for="job">رقم العهدة </label>
                                                  <input type="text" value="<?php echo htmlspecialchars($userInfo['custody'] ?? ''); ?>" name="custody" id="custody" placeholder=" " required class="form-control">
                                              </div>
                                              <div class="form-group col-md-6">
                                                  <label for="location">موقع الجهاز </label>
                                                  <input type="text" value="<?php echo htmlspecialchars($userInfo['location'] ?? ''); ?>" name="location" id="location" placeholder=" " required class="form-control">
                                              </div>
                                              <div class="form-group col-md-6">
                                                  <label for="description">ملاحظات </label>
                                                  <input type="text" value="<?php echo htmlspecialchars($userInfo['remarq'] ?? ''); ?>" name="remarq" id="remarq" placeholder=" " required class="form-control">
                                              </div>
                                              <div class="form-group col-md-6">
                                                  <label for="description">نوع وحدة التخزين </label>
                                                  <input type="text" value="<?php echo htmlspecialchars($userInfo['me_type'] ?? ''); ?>" name="me_type" id="me_type" placeholder=" " required class="form-control">
                                              </div>
                                              <div class="form-group col-md-6">
                                                  <label dir="rtl" for="description">نوع RAMSR: Serial number</label>
                                                  <input type="text" value="<?php echo htmlspecialchars($userInfo['RAMSR'] ?? ''); ?>" name="RAMSR" id="RAMSR" placeholder=" " required class="form-control">
                                              </div>
                                              <div class="form-group col-md-6">
                                                  <label for="description">اسم الجهاز </label>
                                                  <input type="text" value="<?php echo htmlspecialchars($userInfo['name'] ?? ''); ?>" name="name" id="name" placeholder=" " required class="form-control">
                                              </div>
                                              <div class="form-group col-md-6">
                                                  <label for="description">عدد مرات الصيانة </label>
                                                  <input type="text" value="<?php echo htmlspecialchars($userInfo['maintenance'] ?? ''); ?>" name="maintenance" id="maintenance" placeholder=" " required class="form-control">
                                              </div>
                                              <div class="form-group col-md-6">
                                                  <label for="description">رقم طلب الصيانة ان وجد </label>
                                                  <input type="text" value="<?php echo htmlspecialchars($userInfo['maintenance_order'] ?? ''); ?>" name="maintenance_order" id="maintenance_order" placeholder=" " required class="form-control">
                                              </div>
                                              <div class="form-group col-md-6">
                                                  <label for="description">نوع الطلب </label>
                                                  <select class="form-control" name="type">
                                                      <option value="0" <?php echo (isset($userInfo['type']) && $userInfo['type'] == '0') ? 'selected' : ''; ?>>الشركة</option>
                                                      <option value="1" <?php echo (isset($userInfo['type']) && $userInfo['type'] == '1') ? 'selected' : ''; ?>>المنافسة</option>
                                                      <option value="2" <?php echo (isset($userInfo['type']) && $userInfo['type'] == '2') ? 'selected' : ''; ?>>السوق الالكتروني</option>
                                                      <option value="3" <?php echo (isset($userInfo['type']) && $userInfo['type'] == '3') ? 'selected' : ''; ?>>الشراء المباشر</option>
                                                  </select>
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

                                $stmt = $conn->prepare("SELECT * FROM piece WHERE id = ? LIMIT 1");
                                $stmt->execute(array($id));
                                $checkIfuser = $stmt->rowCount();
                                $data = $stmt->fetch();

                                if($_SERVER['REQUEST_METHOD'] == 'POST')
                                {
                                  $sr = isset($_POST['sr']) ? $_POST['sr'] : null; // Serial number
                                  $custody = isset($_POST['custody']) ? $_POST['custody'] : null; // رقم العهدة
                                  $location = $_POST['location']; // موقع الجهاز
                                  $remarq = isset($_POST['remarq']) ? $_POST['remarq'] : null; // ملاحظات
                                  $me_type = isset($_POST['me_type']) ? $_POST['me_type'] : null; // نوع وحدة التخزين
                                  $RAMSR = isset($_POST['RAMSR']) ? $_POST['RAMSR'] : null; // نوع RAM
                                  $name = isset($_POST['name']) ? $_POST['name'] : null; // اسم الجهاز
                                  $maintenance = isset($_POST['maintenance']) ? $_POST['maintenance'] : null; // عدد مرات الصيانة
                                  $maintenance_order = isset($_POST['maintenance_order']) ? $_POST['maintenance_order'] : null; // رقم طلب الصيانة ان وجد
                                  $type = isset($_POST['type']) ? $_POST['type'] : null; // Type (الشركة, المنافسة, etc.)

                                $formErrors = array();
                                if (empty($name))
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
                                      UPDATE piece
                                      SET
                                          sr = ?,
                                          custody = ?,
                                          location = ?,
                                          remarq = ?,
                                          me_type = ?,
                                          RAMSR = ?,
                                          name = ?,
                                          maintenance = ?,
                                          maintenance_order = ?,
                                          type = ?
                                      WHERE id = ?
                                  ");
                                  $stmt->execute(array(
                                      $sr,
                                      $custody,
                                      $location,
                                      $remarq,
                                      $me_type,
                                      $RAMSR,
                                      $name,
                                      $maintenance,
                                      $maintenance_order,
                                      $type,
                                      $id
                                  ));
                                  header('location: ' . $_SERVER['HTTP_REFERER']);
                                }
                              }


          include $tpl . 'footer.php';


        }

  elseif ($page == 'delete') {
     include 'init.php';
      if ($_SESSION['type'] == 2)
      {
        $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : header('location: piece.php');;
        $stmt = $conn->prepare("SELECT * FROM piece WHERE id = ? LIMIT 1");
        $stmt->execute(array($id));
        $check = $stmt->rowCount();

        if ($check > 0 )
        {
          $stmt = $conn->prepare("DELETE FROM piece WHERE id = :zid");
          $stmt->bindParam(":zid", $id);
          $stmt->execute();
          header('location: piece.php');

        }
        else {
          header('location: piece.php');
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
