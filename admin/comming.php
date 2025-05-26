<?php
ob_start();
session_start();

if (isset($_SESSION['admin'])) {
    $page = isset($_GET['page']) ? $_GET['page'] : 'manage';

    if ($page == 'manage') {
        $pageTitle = 'صفحة ادارة الاجهزة الصادرة';
        include 'init.php';
        $ord = 'ASC';
        if (isset($_GET['ordering'])) {
            $ord = $_GET['ordering'];
        }

        $stmt = $conn->prepare("SELECT * FROM comming WHERE status = 0 ORDER BY id DESC");
        $stmt->execute();
        $posts = $stmt->fetchAll();

        ?>
        <div class="default-management-list users-management">
            <div class="container-fluid cnt-spc">
                <div class="row">
                    <div class="col-md-6">
                        <div class="right-header management-header">
                            <div class="btns">
                                <a href="comming.php?page=add" class="add-btn"> <i class="fas fa-plus"></i> </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="left-header management-header">
                            <h1>قائمة الاجهزة الصادرة</h1>
                            <p class="tt">اجمالي <?php echo Total_com($conn, 'comming ', "status = 0") ?> </p>
                        </div>
                    </div>
                    <div class="col-md-6 srch-sp">
                        <div class="search-box">
                            <!-- optional search field -->
                        </div>
                    </div>
                    <a href="comming.php?page=restore" class="restore-btn"> استرجاع الجهاز من الصيانة </a>
                    <div class="col-md-12">
                        <div class="management-body">
                            <div class="default-management-table">
                                <table class="table" id="categories-table">
                                    <thead>
                                        <tr>
                                            <th>SR: Serial number</th>
                                            <th>موقع الجهاز </th>
                                            <th>اسم الجهاز </th>
                                            <th>عدد مرات الصيانة </th>
                                            <th>نوع الطلب </th>
                                            <th>نوع الصادر </th>
                                            <th>حدث</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($posts as $post): ?>
                                            <tr>
                                                <td><p class="f-n"><?php echo $post['sr']; ?></p></td>
                                                <td><p class="f-n"><?php echo $post['location']; ?></p></td>
                                                <td><?php echo $post['name']; ?></td>
                                                <td><?php echo $post['maintenance']; ?></td>
                                                <td><?php echo $post['type']; ?></td>
                                                <td><?php echo $post['type_sa']; ?></td>
                                                <td>
                                                    <ul class="list-group">
                                                        <li class="list-group-item">
                                                            <a href="download_word.php?id=<?php echo $post['id']; ?>" class="btn btn-primary">
                                                                <i class="fas fa-download"></i> تحميل ملف word
                                                            </a>
                                                        </li>
                                                        <li class="list-group-item">
                                                            <a href="comming.php?page=delete&id=<?php echo $post['id']; ?>" class="text-danger" onclick="return confirm('هل تريد الحذف؟');">
                                                                <i class="fas fa-trash"></i> حذف
                                                            </a>
                                                        </li>
                                                        <li class="list-group-item">
                                                            <a href="comming.php?page=edit&id=<?php echo $post['id']; ?>" class="text-warning">
                                                                <i class="fas fa-edit"></i> تعديل
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        include $tpl . 'footer.php';
    } elseif ($page == 'add') {
        $pageTitle = 'صفحة الاضافة';
        include 'init.php';
        ?>
        <div class="add-default-page add-post-page add-product-page" id="add-page" style="margin: 120px;">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <form class="add-form" method="POST" action="comming.php?page=insert" id="ca-form-info">
                            <h3>قم بملء المعلومات لإضافة الجهاز</h3>
                            <div class="form-group">
                                <label for="serial_number">الرقم التسلسلي:</label>
                                <input type="text" name="serial_number[]" id="serial_number" placeholder="أدخل الرقم التسلسلي للجهاز" required class="form-control">
                            </div>
                            <div id="more-serials"></div>
                            <button type="button" onclick="addSerialInput()" class="btn btn-secondary">إضافة رقم تسلسلي آخر</button>
                            <button type="submit" class="btn btn-primary" id="ca-btn-option">تأكيد</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
        function addSerialInput() {
            const container = document.getElementById("more-serials");
            const newField = document.createElement("div");
            newField.classList.add("form-group");
            newField.innerHTML = `
                <input type="text" name="serial_number[]" required class="form-control mt-2" placeholder="أدخل الرقم التسلسلي">
            `;
            container.appendChild(newField);
        }
        </script>
        <?php
        include $tpl . 'footer.php';
    } elseif ($page == 'insert') {
        include 'init.php';
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['serial_number'])) {
            foreach ($_POST['serial_number'] as $sr) {
                $sr = trim($sr);
                if ($sr === '') continue;

                $stmt_check = $conn->prepare("SELECT * FROM products WHERE sr = ? LIMIT 1");
                $stmt_check->execute([$sr]);
                $device = $stmt_check->fetch(PDO::FETCH_ASSOC);

                $stmt_insert = $conn->prepare("INSERT INTO comming (sr, remarq, Management, name, maintenance, type, type_sa)
                                               VALUES (?, ?, ?, ?, 0, 'الشركة', 'بالمنشأة')");
                $stmt_insert->execute([
                    $sr,
                    $device['notes'] ?? '',
                    $device['department'] ?? '',
                    $device['device_name'] ?? ''
                ]);

                if ($device) {
                    $conn->prepare("DELETE FROM products WHERE sr = ?")->execute([$sr]);
                }
            }
            header("Location: comming.php?page=manage");
            exit;
        }
    } else {
        header('location: dashboard.php');
        exit;
    }
} else {
    header('location: logout.php');
}
ob_end_flush();
