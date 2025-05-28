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
<style>
  /* Login Page Styles */
body {
    font-family: 'Almarai', sans-serif;
    background: linear-gradient(135deg, #f1f4f8, #e2e8f0);
    direction: rtl;
    margin: 0;
    padding: 0;
    min-height: 100vh;
}

/* Account Page Container */
.account-page {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px 0;
}

.container-fluid {
    max-width: 1200px;
    margin: 0 auto;
}

/* Login Form Section */
.login-page {
    background: white;
    padding: 60px 40px;
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
    text-align: center;
    position: relative;
    overflow: hidden;
}

.login-page::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(135deg, #0d4f8b, #1e40af);
    border-radius: 20px 20px 0 0;
}

/* Logo Styling */
.login-page img {
    transition: all 0.3s ease;
    filter: drop-shadow(0 0px 0px rgba(0, 0, 0, 0.1));
}



/* Title and Paragraph */
.login-page h3 {
    color: #1e293b;
    font-weight: 700;
    font-size: 28px;
    margin-bottom: 15px;
    position: relative;
}

.login-page p {
    color: #64748b;
    font-size: 16px;
    margin-bottom: 40px;
    line-height: 1.6;
}

/* Form Groups */
.form-group {
    margin-bottom: 25px;
    position: relative;
}

/* Input Fields */
.form-control {
    width: 550px;
    padding: 16px 20px;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    font-size: 16px;
    font-family: 'Almarai', sans-serif;
    transition: all 0.3s ease;
    background: #fafbfc;
    color: #374151;
}

.form-control:focus {
    outline: none;
    border-color: #0d4f8b;
    background: white;
    box-shadow: 0 0 0 4px rgba(13, 79, 139, 0.1);
    transform: translateY(-2px);
}

.form-control::placeholder {
    color: #9ca3af;
    font-weight: 400;
}

/* Submit Button */
.btn-primary {
    background: linear-gradient(135deg, #0d4f8b, #1e40af);
    border: none;
    color: white;
    padding: 16px 40px;
    border-radius: 12px;
    font-size: 18px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    width: 550px;
    position: relative;
    overflow: hidden;
}

.btn-primary::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
}

.btn-primary:hover::before {
    left: 100%;
}

.btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(13, 79, 139, 0.4);
    background: linear-gradient(135deg, #1e40af, #3b82f6);
}

.btn-primary:active {
    transform: translateY(-1px);
    box-shadow: 0 5px 15px rgba(13, 79, 139, 0.3);
}

/* Alert Messages */
.alert {
    padding: 15px 20px;
    border-radius: 12px;
    margin-bottom: 25px;
    font-weight: 500;
    animation: slideDown 0.3s ease;
}

.alert-danger {
    background: linear-gradient(135deg, #fef2f2, #fee2e2);
    color: #dc2626;
    border: 1px solid #fecaca;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Image Section */
.img {
    border-radius: 20px;
    overflow: hidden;
    height: 600px;
    position: relative;
    box-shadow: 0 0px 0px rgba(0, 0, 0, 0.1);
}

.img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: all 0.3s ease;
}

.img::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, rgba(13, 79, 139, 0.1), rgba(30, 64, 175, 0.1));
    pointer-events: none;
}

/* Responsive Design */
@media (max-width: 768px) {
    .account-page {
        padding: 10px;
    }
    
    .login-page {
        padding: 40px 25px;
        border-radius: 15px;
        margin-bottom: 20px;
    }
    
    .login-page h3 {
        font-size: 24px;
    }
    
    .img {
        height: 300px;
        border-radius: 15px;
    }
    
    .form-control {
        padding: 14px 16px;
        font-size: 16px;
    }
    
    .btn-primary {
        padding: 14px 30px;
        font-size: 16px;
    }
}

@media (max-width: 576px) {
    .container-fluid .row {
        margin: 0;
    }
    
    .container-fluid .row > div {
        padding: 10px;
    }
    
    .login-page img {
        width: 140px !important;
        margin-bottom: 40px !important;
    }
    
    .login-page {
        padding: 30px 20px;
    }
}

/* Enhanced Visual Effects */
.login-page {
    animation: fadeInUp 0.6s ease;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.img {
    animation: fadeInRight 0.8s ease;
}

@keyframes fadeInRight {
    from {
        opacity: 0;
        transform: translateX(30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* Focus States */
.form-control:focus + .form-label,
.form-control:not(:placeholder-shown) + .form-label {
    transform: translateY(-25px) scale(0.8);
    color: #0d4f8b;
}

/* Loading State for Button */
.btn-primary.loading {
    pointer-events: none;
    opacity: 0.7;
}

.btn-primary.loading::after {
    content: '';
    width: 20px;
    height: 20px;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-top: 2px solid white;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    display: inline-block;
    margin-right: 10px;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>
<div class="account-page" id="account-page" style="margin:0px 0">
  <div class="container-fluid">
    <div class="row justify-content-center">

      <div class="col-md-6" style="width: 685px; ">
        <div class="login-page">

          <form style="text-align:center" class="#" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">


            <a href="index.php">
    <img src="<?php echo $images . $lg['h_image3'] ?>" style="width: auto;height:350px" alt="">
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
       
    </div>
  </div>
</div>

<?php

include $tpl . 'footer.php';
ob_end_flush();
 ?>
