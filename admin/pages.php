<?php
  ob_start();
  session_start();
  if (isset($_SESSION['admin']))
  {

    $page = isset($_GET['page']) ? $_GET['page'] : 'manage';

    if ($page == 'manage')
    {
      $pageTitle = 'صفحة ادارة المحتوى';
      include 'init.php';
      $ord = 'ASC';

      if (isset($_GET['ordering']))
      {
        $ord = $_GET['ordering'];
      }

      $stmt = $conn->prepare("SELECT * FROM pages ORDER BY id $ord");
                $stmt->execute();
                $posts = $stmt->fetchAll();


        ?>
        <div class="content-management default-management-list users-management">
          <div class="container cnt-spc">
            <div class="row justify-content-end">


              <div class="col-md-6">
                <div class="right-header management-header">
                  <div class="btns">
                    <!-- <a href="posts.php?page=add" id="open-add-page" class="add-btn"><i class="fas fa-plus"></i> اضافة منشور</a> -->

                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="left-header management-header">
                </div>
              </div>
              <div class="col-md-6 srch-sp">
                <div class="search-box">
                  <!-- <input type="search" class="form-control" name="search" id="categories-search" onkeyup="tabletwo()" autocomplete="off" placeholder="search by name"> -->
                </div>
              </div>
              <div class="col-md-6">

              </div>
              <?php
                $stmt = $conn->prepare("SELECT * FROM pages WHERE id =1");
                $stmt->execute();
                $ctn = $stmt->fetch();

               ?>
              <div class="col-md-8">
                <div class="management-body">
                  <div class="default-management-table pages-content">
                    <form class="" action="pages.php?page=update" method="post" style="text-align:right" enctype="multipart/form-data">
                      <h3>الشعار</h3>
                      <img src="<?php echo $logo . $ctn['logo'] ?>" alt="logo" style="width:80px;margin-bottom:20px">
                        <input type="file" name="logo" class="form-control">

                        <h3>شعار المتصفح</h3>
                        <img src="<?php echo $logo . $ctn['favicon'] ?>" alt="logo" style="width:80px;margin-bottom:20px">
                          <input type="file" name="favicon" class="form-control">




                                                                                              <h3>صورة الهيدر</h3>
                                                                                              <img src="<?php echo $images . $ctn['h_image3'] ?>" alt=""  style="width:80px;height:80px;margin:20px 0">

                                                                                                <input type="file" name="h_image3" class="form-control">
                      <input type="submit"  class="btn btn-primary" name="" value="احفظ" style="margin:10px 0" style="background:var(--mainColor) !important">

                    </form>
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

    }

    elseif ($page == 'update') {


      $pageTitle = 'صفحة حفظ التعديلات';
      include 'init.php';




                                if($_SERVER['REQUEST_METHOD'] == 'POST')
                                {









                                $formErrors = array();

                                $imageName = $_FILES['logo']['name'];
                                $imageSize = $_FILES['logo']['size'];
                                $imageTmp = $_FILES['logo']['tmp_name'];
                                $imageType = $_FILES['logo']['type'];

                                $imageName33 = $_FILES['h_image3']['name'];
                                $imageSize33 = $_FILES['h_image3']['size'];
                                $imageTmp33 = $_FILES['h_image3']['tmp_name'];
                                $imageType33 = $_FILES['h_image3']['type'];

                                $imageName3 = $_FILES['favicon']['name'];
                                $imageSize3 = $_FILES['favicon']['size'];
                                $imageTmp3 = $_FILES['favicon']['tmp_name'];
                                $imageType3 = $_FILES['favicon']['type'];







                                $formErrors = array();









                                foreach ($formErrors as $error ) {
                                  ?>
                                  <div class="container">
                                      <?php
                                        echo '<div class="alert alert-danger" style="width: 50%;">' . $error . '</div>';
                                       ?>

                                  </div>
                                  <?php
                                }
                                ?>
                                  <div class="container">
                                    <a href="pages.php?page=edit&id=<?php echo $id ?>">اضغط هنا للعودة الى الصفحة السابقة</a>
                                  </div>
                                <?php

                                if (empty($formErrors))
                                {
                                  $stmt3 =$conn->prepare("SELECT * FROM pages WHERE id = 1");
                                  $stmt3->execute();
                                  $inf = $stmt3->fetch();

                                  if (empty($imageName))
                                  {
                                    $image = $inf['logo'];
                                  }
                                  if (!empty($imageName))
                                  {
                                    $image = rand(0,100000) . '_' . $imageName;
                                    move_uploaded_file($imageTmp, $logo . '/' . $image);
                                  }







                                  if (empty($imageName33))
                                  {
                                    $image33 = $inf['h_image3'];
                                  }
                                  if (!empty($imageName33))
                                  {
                                    $image33 = rand(0,100000) . '_' . $imageName33;
                                    move_uploaded_file($imageTmp33, $images . '/' . $image33);
                                  }



                                  if (empty($imageName3))
                                  {
                                    $image3 = $inf['favicon'];
                                  }
                                  if (!empty($imageName3))
                                  {
                                    $image3 = rand(0,100000) . '_' . $imageName3;
                                    move_uploaded_file($imageTmp3, $logo . '/' . $image3);
                                  }






                                  $stmt = $conn->prepare("UPDATE pages SET   logo = ?,favicon =?, h_image3=? WHERE id=1   ");
                                  $stmt->execute(array($image,$image3,$image33));
                                  header('location: ' . $_SERVER['HTTP_REFERER']);
                                }
                              }





                              else {
                                header('location: dashboard.php');
                              }

      include $tpl . 'footer.php';


    }
    elseif ($page == 'active') {

        include 'init.php';

          $stmt = $conn->prepare("UPDATE pages SET sv = 1 WHERE id= 1 LIMIT 1  ");
          $stmt->execute();
          header('location:pages.php');

    }
    elseif ($page == 'unactive') {

        include 'init.php';

          $stmt = $conn->prepare("UPDATE pages SET sv = 0 WHERE id= 1 LIMIT 1  ");
          $stmt->execute();
          header('location:pages.php');

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
