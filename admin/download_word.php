<?php
require_once '../vendor/autoload.php';

use PhpOffice\PhpWord\TemplateProcessor;

// إعدادات الاتصال بقاعدة البيانات
$dsn = 'mysql:host=localhost;dbname=stor';
$user = 'root';
$pass = '';
$options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
);

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // التأكد من وجود معرّف صالح في الطلب
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        die("معرّف غير صالح");
    }
    $id = intval($_GET['id']);

    // جلب بيانات السجل من جدول comming
    $stmt = $pdo->prepare("SELECT * FROM comming WHERE id = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        die("لا يوجد سجل بهذا المعرّف");
    }

    // تجهيز معالج القالب باستخدام ملف template.docx (تأكد من وجود الملف في المسار الصحيح)
    $templateProcessor = new TemplateProcessor('../template.docx');

    // ملء القالب بالقيم المأخوذة من قاعدة البيانات
    $templateProcessor->setValue('sr', $row['sr']);
    $templateProcessor->setValue('name', $row['name']);
    $templateProcessor->setValue('custody', $row['custody']);

    // حفظ الملف الناتج مؤقتاً
    $fileName = "result_{$id}.docx";
    $templateProcessor->saveAs($fileName);

    // تهيئة الرؤوس لإرسال الملف للتنزيل
    header("Content-Description: File Transfer");
    header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
    header("Content-Disposition: attachment; filename=\"" . basename($fileName) . "\"");
    header("Expires: 0");
    header("Cache-Control: must-revalidate");
    header("Pragma: public");
    header("Content-Length: " . filesize($fileName));
    readfile($fileName);

    // حذف الملف المؤقت بعد الإرسال
    unlink($fileName);
    exit;
} catch (PDOException $e) {
    echo "خطأ في قاعدة البيانات: " . $e->getMessage();
}
?>
