<?php
session_start();
ob_start();
$noNavbar = "";
$pageTitle = 'تسجيل الدخول الى الحساب';
include 'init.php';


$stmt = $conn->prepare("SELECT * FROM pages WHERE id = 1");
$stmt ->execute();

$lg = $stmt->fetch();
if (isset($_SESSION['admin']))
{
  header('location: dashboard.php');

}

?>
<div class="account-page" id="account-page" style="margin:0px 0">
  <div class="container-fluid">
    <div class="row justify-content-center">

      <div class="col-md-6">
        <div class="login-page">

          <form style="text-align:center" class="#" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">


            <a href="index.php">
    <img src="<?php echo $logo . $lg['logo'] ?>" alt="logo" style="width:160px;margin:10px 0;margin-bottom:60px">
            </a>
            <h3 dir="rtl" style = "text-align: center; font-weight: bold"><?php echo $lg['h_title'] ?>
          </h3>
          <p dir="rtl" style = "color: rgba (0،0،0، .6)">
<?php echo $lg['h_paragraph'] ?>
          </p>
          <?php
          if ($_SERVER['REQUEST_METHOD'] == 'POST')
          {

                  $email = $_POST['email'];
                  $password = sha1($_POST['password']);

                  $stmt = $conn->prepare("SELECT  * FROM users WHERE email = ? AND password =?");
                  $stmt->execute(array($email,$password));
                  $check = $stmt->rowCount();
                  $userInfo = $stmt->fetch();
                  echo $check;
                  if ($check > 0)
                  {
                    $_SESSION['clientid'] = $userInfo['id'];

                    $_SESSION['admin'] = $userInfo['username'];
                    $_SESSION['id'] = $userInfo['id'];
                    $_SESSION['type'] = $userInfo['type'];
                    header('location: dashboard.php');

                  }else {
                    ?>
                      <p class="alert alert-danger">هذا الحساب غير مسجل في النظام لدينا او كلمة المرور خاطئة</p>
                    <?php
                  }




          }
           ?>
            <div class="form-group">
              <input type="text" name="email" class="form-control col-md-12" placeholder="البريد الالكتروني" required="required">
            </div>
            <div class="form-group">
              <input type="password" name="password" class="form-control col-md-12" placeholder="كلمة المرور" required="required">
            </div>
<?php

 ?>
            <div class="form-group">
              <input type="submit" class="btn btn-primary" value="تسجيل الدخول">

            </div>
          </form>
        </div>
      </div>
      <div class="col-md-6" style="padding:0">
        <div class="img">
                   <img src="<?php echo $images . $lg['h_image3'] ?>" style="width: 100%;height:600px" alt="">
        </div>
      </div>
    </div>
  </div>
</div>

<?php

include $tpl . 'footer.php';
ob_end_flush();
 ?>
