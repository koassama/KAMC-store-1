<?php
ob_start();
session_start();

if (isset($_SESSION['admin'])) {
  $page = $_GET['page'] ?? 'manage';

  if ($page === 'manage') {
    $pageTitle = 'صفحة ادارة الاجهزة الصادرة';
    include 'init.php';

    $ord = $_GET['ordering'] ?? 'ASC';
    $stmt = $conn->prepare("SELECT * FROM comming WHERE status = 0 ORDER BY id DESC");
    $stmt->execute();
    $posts = $stmt->fetchAll();
?>
<div class="content-management default-management-list users-management py-4" style="margin-right: 220px">
  <div class="container-fluid">
    <div class="row mb-3">
      <div class="col-md-6">
        <a href="comming.php?page=add" class="btn btn-success">
          <i class="fas fa-plus"></i> إضافة جهاز
        </a>
      </div>
      <div class="col-md-6 text-right">
        <h4>قائمة الاجهزة الصادرة</h4>
        <p>إجمالي: <?php echo Total_com($conn, 'comming ', "status = 0") ?></p>
      </div>
    </div>

    <div class="row mb-3">
      <div class="col-md-6">
        <a href="comming.php?page=restore" class="btn btn-outline-primary">استرجاع الجهاز من الصيانة</a>
      </div>
    </div>

    <div class="table-responsive shadow-sm bg-white p-3 rounded">
      <table class="table table-hover">
        <thead class="thead-light">
          <tr>
            <th>SR: Serial number</th>
            <th>موقع الجهاز</th>
            <th>اسم الجهاز</th>
            <th>عدد مرات الصيانة</th>
            <th>نوع الطلب</th>
            <th>نوع الصادر</th>
            <th>إجراءات</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($posts as $post): ?>
          <tr>
            <td><?php echo $post['sr']; ?></td>
            <td><?php echo $post['location']; ?></td>
            <td><?php echo $post['name']; ?></td>
            <td><?php echo $post['maintenance']; ?></td>
            <td><?php echo $post['type']; ?></td>
            <td><?php echo $post['type_sa']; ?></td>
            <td>
              <div class="btn-group btn-group-sm" role="group">
                <a href="download_word.php?id=<?php echo $post['id']; ?>" class="btn btn-info" title="تحميل">
                  <i class="fas fa-download"></i>
                </a>
                <a href="comming.php?page=edit&id=<?php echo $post['id']; ?>" class="btn btn-warning" title="تعديل">
                  <i class="fas fa-edit"></i>
                </a>
                <a href="comming.php?page=delete&id=<?php echo $post['id']; ?>" class="btn btn-danger" onclick="return confirm('هل تريد الحذف؟');" title="حذف">
                  <i class="fas fa-trash"></i>
                </a>
              </div>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php
    include $tpl . 'footer.php';
  }
  // Remaining pages remain untouched...
  // add, restore, insert, edit, update, delete handlers...
} else {
  header('location: logout.php');
}
ob_end_flush();
?>
