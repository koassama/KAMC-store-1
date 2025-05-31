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

      $search = isset($_GET['search']) ? $_GET['search'] : '';
      $query = "SELECT * FROM returns WHERE 1";

      if (!empty($search)) {
          $query .= " AND serial_number LIKE :search";
      }

      $query .= " ORDER BY id $ord";
      $stmt = $conn->prepare($query);

      if (!empty($search)) {
          $stmt->bindValue(':search', "%$search%");
      }

      $stmt->execute();
      $posts = $stmt->fetchAll();

      // Include the modern styled returns management view
      include 'views/returns_manage.php';
      include $tpl . 'footer.php';

    } elseif ($page == "add") {
      $pageTitle = 'صفحة الاضافة';
      include 'init.php';
      include 'views/returns_add.php';
      include $tpl . 'footer.php';

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
          include 'views/returns_edit.php';
        } else {
          header('location: index.php');
        }
      } else {
        header('location: returns.php');
      }
      include $tpl . 'footer.php';

    } elseif ($page == 'update') {
      $pageTitle = 'update page';
      include 'init.php';
      include 'controllers/returns_update.php';
      include $tpl . 'footer.php';

    } elseif ($page == 'delete') {
      include 'init.php';
      include 'controllers/returns_delete.php';

    } else {
      header('location: dashboard.php');
    }

  } else {
    header('location: logout.php');
  }
  ob_end_flush();
?>