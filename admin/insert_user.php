<?php
    include 'connect.php';



                        if ($_SERVER['REQUEST_METHOD'] == 'POST')
                        {
                          $phone = $_POST['phone'];
                          $email = $_POST['email'];
                          $username = $_POST['username'];
                          $npass = $_POST['npassword'];
                          $cpass = $_POST['cpassword'];
                          $type = $_POST['type'];
                          $wadifa = $_POST['wadifa'];
                          $ratib = $_POST['ratib'];

                          $formErrors = array();



                          if (empty($email))
                        {
                          $formErrors[] = 'بريد الالكتروني اجباري';
                        }

                          if (empty($username))
                          {
                            $formErrors[] = 'اسم الاول اجباري';
                          }

                          if (empty($cpass))
                          {
                            $formErrors[] =  'تاكيد كلمة المرور اجباري';
                          }
                          if(!empty($npass))
                          {
                              if ($npass!=$cpass)
                              {
                                $formErrors[] = 'كلمة المرور غير متاطبقة';
                              }
                              else {
                                $password = sha1($_POST['npassword']);
                              }
                          }


                          if ($type == 'default')
                          {
                            $formErrors[] = 'نوع المستخدم اجباري';
                          }




                          foreach ($formErrors as $error ) {
                            ?>
                            <div class="container">
                              <?php
                              echo '<div class="alert alert-danger" style="text-align:right" >' . $error . '</div>';
                              ?>

                            </div>
                            <?php
                          }




                          if (empty($formErrors))
                          {
                            $stmt = $conn->prepare("INSERT INTO users(username, password,phone,email,type, created,wadifa,ratib )
                             VALUES(:zusername, :zpass, :zphone,:zemail, :ztype, now(),:z3,:z5)");
                            $stmt->execute(array(
                              'zusername' => $username,
                              'zpass' => $password,
                              'zphone' => $phone,
                              'zemail' => $email,
                              'ztype' => $type,
                              'z3' => $wadifa,
                              'z5' => $ratib


                            ));
                            ?>
                            <div class="alert alert-success" style="margin-top: 15px">
                              <p style="text-align:right">  تم اضافة الموظف بنجاح يرجى اعادة تحميل الصفحة</p>
                            </div>
                            <?php
                            header('refresh:3;url= users.php');
                          }



                        }





 ?>
