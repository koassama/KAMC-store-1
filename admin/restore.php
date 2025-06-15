<?php
/**
 * Independent Device Restore System
 * صفحة استرجاع الأجهزة من الصيانة
 * Compatible with existing management system
 */

// Start session and check admin access
ob_start();
session_start();

if (!isset($_SESSION['admin'])) {
    header('location: logout.php');
    exit;
}

$pageTitle = 'صفحة استرجاع الأجهزة من الصيانة';
include 'init.php';

class DeviceRestoreSystem {
    private $conn;
    private $pageTitle;
    
    public function __construct($connection, $title) {
        $this->conn = $connection;
        $this->pageTitle = $title;
        
        // تمكين عرض الأخطاء للتصحيح
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
    
    /**
     * البحث عن جهاز في جدول الصيانة
     */
    public function findDeviceInMaintenance($serialNumber) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM returns WHERE serial_number = :sr LIMIT 1");
            $stmt->bindParam(':sr', $serialNumber, PDO::PARAM_STR);
            $stmt->execute();
            
            return $stmt->fetch();
        } catch (PDOException $e) {
            throw new Exception("خطأ في البحث عن الجهاز: " . $e->getMessage());
        }
    }
    
    /**
     * الحصول على جميع الأجهزة في الصيانة
     */
    public function getAllDevicesInMaintenance() {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM returns ORDER BY id DESC");
            $stmt->execute();
            
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            throw new Exception("خطأ في جلب قائمة الأجهزة: " . $e->getMessage());
        }
    }
    
    /**
     * نقل الجهاز من الصيانة إلى الواردات
     */
    public function restoreDevice($device) {
        try {
            $this->conn->beginTransaction();
            
            // إدخال الجهاز في جدول الواردات
            $insertStmt = $this->conn->prepare("
                INSERT INTO comming (sr, remarq, Management, name, maintenance, type, type_sa)
                VALUES (:sr, :remarq, :Management, :name, :maintenance, :type, :type_sa)
            ");
            
            $insertData = [
                ':sr' => $device['serial_number'],
                ':remarq' => isset($device['notes']) ? $device['notes'] : '',
                ':Management' => isset($device['department']) ? $device['department'] : '',
                ':name' => isset($device['device_name']) ? $device['device_name'] : '',
                ':maintenance' => 0,
                ':type' => 'الشركة',
                ':type_sa' => 'بالمنشأة'
            ];
            
            $insertStmt->execute($insertData);
            $newId = $this->conn->lastInsertId();
            
            // حذف الجهاز من جدول الصيانة
            $deleteStmt = $this->conn->prepare("DELETE FROM returns WHERE serial_number = :sr");
            $deleteStmt->bindParam(':sr', $device['serial_number'], PDO::PARAM_STR);
            $deleteStmt->execute();
            
            $this->conn->commit();
            
            return $newId;
        } catch (PDOException $e) {
            $this->conn->rollBack();
            throw new Exception("خطأ في استرجاع الجهاز: " . $e->getMessage());
        }
    }
    
    /**
     * معالجة طلب الاسترجاع المتعدد
     */
    public function processRestoreRequest() {
        $result = ['success' => false, 'message' => '', 'redirect' => '', 'restored_count' => 0];
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['serial_number'])) {
            return $result;
        }
        
        $serialNumbers = $_POST['serial_number'];
        $restoredDevices = [];
        $failedDevices = [];
        
        foreach ($serialNumbers as $serialNumber) {
            $serialNumber = trim($serialNumber);
            
            if (empty($serialNumber)) {
                continue;
            }
            
            try {
                // البحث عن الجهاز
                $device = $this->findDeviceInMaintenance($serialNumber);
                
                if (!$device) {
                    $failedDevices[] = "الرقم {$serialNumber} غير موجود في الصيانة";
                    continue;
                }
                
                // استرجاع الجهاز
                $newId = $this->restoreDevice($device);
                $restoredDevices[] = $serialNumber;
                
            } catch (Exception $e) {
                $failedDevices[] = "خطأ في استرجاع {$serialNumber}: " . $e->getMessage();
            }
        }
        
        $result['restored_count'] = count($restoredDevices);
        
        if (count($restoredDevices) > 0) {
            $result['success'] = true;
            $result['message'] = "تم استرجاع " . count($restoredDevices) . " جهاز بنجاح";
            $result['redirect'] = "comming.php?page=manage";
            
            if (count($failedDevices) > 0) {
                $result['message'] .= "<br>فشل في استرجاع: " . implode(", ", $failedDevices);
            }
        } else {
            $result['message'] = "لم يتم استرجاع أي جهاز";
            if (count($failedDevices) > 0) {
                $result['message'] .= "<br>" . implode("<br>", $failedDevices);
            }
        }
        
        return $result;
    }
    
    /**
     * عرض صفحة الاسترجاع مع التصميم المتوافق
     */
    public function renderPage($result = null) {
        // إذا كان الاسترجاع ناجحاً، عرض صفحة النجاح
        if ($result && $result['success'] && !empty($result['redirect'])) {
            $this->renderSuccessPage($result);
            return;
        }
        
        $alertClass = '';
        $alertMessage = '';
        
        if ($result) {
            $alertClass = $result['success'] ? 'alert-success' : 'alert-danger';
            $alertMessage = $result['message'];
        }
        
        // الحصول على قائمة الأجهزة في الصيانة
        $devicesInMaintenance = $this->getAllDevicesInMaintenance();
        
        echo $this->getPageHTML($alertClass, $alertMessage, $devicesInMaintenance);
    }
    
    /**
     * عرض صفحة النجاح مع العد التنازلي
     */
    private function renderSuccessPage($result) {
        echo "
        <!DOCTYPE html>
        <html lang='ar' dir='rtl'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>تم الاسترجاع بنجاح</title>
            <link href='https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&display=swap' rel='stylesheet'>
            <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css'>
            <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
            <style>
                body {
                    font-family: 'Almarai', sans-serif;
                    background-color: #f1f4f8;
                    direction: rtl;
                    margin: 0;
                    padding: 0;
                }
                .success-container {
                    min-height: 100vh;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    padding: 20px;
                }
                .success-card {
                    background: white;
                    padding: 40px;
                    border-radius: 20px;
                    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
                    text-align: center;
                    max-width: 500px;
                    width: 100%;
                }
                .success-icon {
                    color: #10b981;
                    font-size: 4rem;
                    margin-bottom: 20px;
                    animation: bounceIn 0.6s ease-out;
                }
                .success-title {
                    color: #1e293b;
                    font-weight: 700;
                    font-size: 24px;
                    margin-bottom: 15px;
                }
                .success-message {
                    color: #64748b;
                    margin-bottom: 30px;
                    line-height: 1.6;
                }
                .btn {
                    border-radius: 12px;
                    font-weight: 600;
                    transition: all 0.3s ease;
                    border: none;
                    padding: 12px 24px;
                    display: inline-flex;
                    align-items: center;
                    gap: 8px;
                    text-decoration: none;
                }
                .btn-primary {
                    background: linear-gradient(135deg, #0d4f8b, #1e40af);
                    color: white;
                }
                .btn-outline-primary {
                    border: 2px solid #0d4f8b;
                    color: #0d4f8b;
                    background: transparent;
                }
                .btn:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
                    text-decoration: none;
                    color: white;
                }
                .btn-outline-primary:hover {
                    background: #0d4f8b;
                    color: white;
                }
                .countdown {
                    color: #6b7280;
                    font-size: 14px;
                    margin-top: 15px;
                    padding: 10px;
                    background: #f8fafc;
                    border-radius: 8px;
                }
                .countdown-number {
                    font-weight: bold;
                    color: #0d4f8b;
                    font-size: 16px;
                }
                @keyframes bounceIn {
                    0% {
                        transform: scale(0);
                        opacity: 0;
                    }
                    50% {
                        transform: scale(1.1);
                    }
                    100% {
                        transform: scale(1);
                        opacity: 1;
                    }
                }
                @media (max-width: 576px) {
                    .success-card {
                        padding: 30px 20px;
                    }
                    .success-icon {
                        font-size: 3rem;
                    }
                    .success-title {
                        font-size: 20px;
                    }
                    .d-flex.gap-3 {
                        flex-direction: column;
                        gap: 10px !important;
                    }
                }
            </style>
            <script>
                let countdown = 5;
                function updateCountdown() {
                    const countdownElement = document.getElementById('countdown-number');
                    if (countdownElement) {
                        countdownElement.textContent = countdown;
                    }
                    countdown--;
                    if (countdown < 0) {
                        window.location.href = '{$result['redirect']}';
                    }
                }
                
                // بدء العد التنازلي عند تحميل الصفحة
                document.addEventListener('DOMContentLoaded', function() {
                    updateCountdown();
                    setInterval(updateCountdown, 1000);
                });
            </script>
        </head>
        <body>
            <div class='success-container'>
                <div class='success-card'>
                    <div class='success-icon'>
                        <i class='fas fa-check-circle'></i>
                    </div>
                    <h2 class='success-title'>تم استرجاع الأجهزة بنجاح!</h2>
                    <p class='success-message'>{$result['message']}</p>
                    <div class='d-flex justify-content-center gap-3'>
                        <a href='{$result['redirect']}' class='btn btn-primary'>
                            <i class='fas fa-list'></i> عرض قائمة الأجهزة
                        </a>
                        <a href='restore.php' class='btn btn-outline-primary'>
                            <i class='fas fa-undo'></i> استرجاع المزيد
                        </a>
                    </div>
                    <div class='countdown'>
                        <i class='fas fa-clock'></i>
                        سيتم توجيهك تلقائياً خلال <span id='countdown-number' class='countdown-number'>5</span> ثوانِ
                    </div>
                </div>
            </div>
        </body>
        </html>";
    }
    
    /**
     * HTML الصفحة مع التصميم المتوافق
     */
    private function getPageHTML($alertClass = '', $alertMessage = '', $devices = []) {
        $alert = '';
        if (!empty($alertMessage)) {
            $alert = "<div class='alert {$alertClass} text-center'><strong>{$alertMessage}</strong></div>";
        }
        
        // إنشاء جدول الأجهزة
        $devicesTable = $this->generateDevicesTable($devices);
        
        return "
        <!DOCTYPE html>
        <html lang='ar' dir='rtl'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>{$this->pageTitle}</title>
            
            <!-- Bootstrap & Font Awesome -->
            <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css'>
            <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css'>
            
            <!-- Google Fonts -->
            <link href='https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;600;700&display=swap' rel='stylesheet'>

            <style>
                body {
                    font-family: 'Almarai', sans-serif;
                    background-color: #f1f4f8;
                    direction: rtl;
                    margin: 0;
                    padding: 0;
                }

                .container-fluid {
                    padding: 30px;
                }

                .cnt-spc {
                    background: white;
                    border-radius: 20px;
                    padding: 30px;
                    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
                    margin-top: 20px;
                }

                /* Header Styles */
                .management-header {
                    margin-bottom: 30px;
                }

                .management-header h1 {
                    font-size: 28px;
                    font-weight: 700;
                    color: #1e293b;
                    margin: 0;
                }

                .management-header .tt {
                    color: #64748b;
                    font-size: 16px;
                    margin-top: 5px;
                }

                /* Table Styles */
                .default-management-table {
                    background: white;
                    border-radius: 15px;
                    overflow: hidden;
                    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
                    margin-top: 20px;
                }

                .table {
                    margin: 0;
                    border: none;
                }

                .table thead th {
                    background: linear-gradient(135deg, #f8fafc, #e2e8f0);
                    border: none;
                    padding: 20px 15px;
                    font-weight: 600;
                    color: #1e293b;
                    font-size: 14px;
                    position: sticky;
                    top: 0;
                    z-index: 10;
                }

                .table tbody td {
                    padding: 18px 15px;
                    border-top: 1px solid #f1f5f9;
                    vertical-align: middle;
                    color: #374151;
                }

                .table tbody tr {
                    transition: all 0.3s ease;
                }

                .table tbody tr:hover {
                    background-color: #f8fafc;
                    transform: scale(1.01);
                    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
                }

                .f-n {
                    font-weight: 600;
                    color: #1e293b;
                    margin: 0;
                }

                /* Form Styles */
                .add-default-page {
                    background-color: #f1f4f8;
                    min-height: 100vh;
                    padding: 40px 0;
                }

                .add-form {
                    background: white;
                    padding: 40px;
                    border-radius: 20px;
                    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
                }

                .add-form h3 {
                    color: #1e293b;
                    font-weight: 700;
                    margin-bottom: 30px;
                    text-align: center;
                    font-size: 24px;
                }

                .form-group {
                    margin-bottom: 25px;
                }

                .form-group label {
                    font-weight: 600;
                    color: #374151;
                    margin-bottom: 8px;
                    display: block;
                }

                .form-control {
                    border: 2px solid #e5e7eb;
                    border-radius: 12px;
                    padding: 12px 16px;
                    font-size: 16px;
                    transition: all 0.3s ease;
                    font-family: 'Almarai', sans-serif;
                }

                .form-control:focus {
                    border-color: #0d4f8b;
                    box-shadow: 0 0 0 3px rgba(13, 79, 139, 0.1);
                    outline: none;
                }

                .btn {
                    border-radius: 12px;
                    font-weight: 600;
                    transition: all 0.3s ease;
                    border: none;
                    margin: 5px;
                    display: inline-flex;
                    align-items: center;
                    gap: 8px;
                }

                .btn-large {
                    padding: 18px 40px;
                    font-size: 18px;
                    min-width: 200px;
                    justify-content: center;
                }

                .btn-small {
                    padding: 8px 16px;
                    font-size: 14px;
                }

                .form-actions {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    margin-top: 30px;
                    gap: 15px;
                }

                .btn-primary {
                    background: linear-gradient(135deg, #0d4f8b, #1e40af);
                    color: white;
                }

                .btn-secondary {
                    background: #6b7280;
                    color: white;
                }

                .btn:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
                }

                .alert {
                    margin: 20px 0;
                    padding: 15px;
                    border-radius: 12px;
                    font-weight: 600;
                }

                .alert-danger {
                    background-color: #fef2f2;
                    color: #dc2626;
                    border: 1px solid #fecaca;
                }

                .alert-success {
                    background-color: #f0fdf4;
                    color: #16a34a;
                    border: 1px solid #bbf7d0;
                }

                #more-serials .form-group {
                    animation: slideIn 0.3s ease;
                }

                @keyframes slideIn {
                    from {
                        opacity: 0;
                        transform: translateY(-10px);
                    }
                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }

                .section-divider {
                    border-top: 2px solid #e5e7eb;
                    margin: 40px 0;
                    padding-top: 30px;
                }

                /* Responsive Design */
                @media (max-width: 768px) {
                    .add-form {
                        padding: 25px;
                        margin: 15px;
                    }
                    
                    .form-actions {
                        flex-direction: column;
                        gap: 10px;
                    }

                    .btn-large {
                        width: 100%;
                        min-width: auto;
                    }

                    .btn-small {
                        width: 100%;
                    }
                }

                @media (max-width: 576px) {
                    .add-default-page {
                        padding: 20px 0;
                    }
                }
            </style>
        </head>
        <body style='margin-right: 250px; margin-left: 20px'>
            <div class='add-default-page' id='add-page'>
                <div class='container'>
                    <!-- قسم نموذج الاسترجاع -->
                    <div class='row justify-content-center mb-4'>
                        <div class='col-md-8'>
                            {$alert}
                            <form class='add-form' method='POST' action='' id='ca-form-info'>
                                <h3>قم بإدخال الأرقام التسلسلية لاسترجاع الأجهزة من الصيانة</h3>
                                
                                <div class='form-group'>
                                    <label for='serial_number'>الرقم التسلسلي:</label>
                                    <input type='text' name='serial_number[]' id='serial_number' 
                                           placeholder='أدخل الرقم التسلسلي للجهاز في الصيانة' 
                                           required class='form-control' autocomplete='off'>
                                </div>

                                <div id='more-serials'></div>

                                <div class='form-actions'>
                                    <button type='button' onclick='addSerialInput()' class='btn btn-secondary btn-small' style='width: 140px; height: 75px;'>
                                        <i class='fas fa-plus'></i> إضافة رقم تسلسلي آخر
                                    </button>

                                    <button type='submit' class='btn btn-primary btn-large' id='ca-btn-option' style='width: 130px; height: 75px;'>
                                        <i class='fas fa-undo'></i> استرجاع الأجهزة
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <!-- قسم قائمة الأجهزة في الصيانة -->
                    <div class='row justify-content-center'>
                        <div class='col-12'>
                            <div class='cnt-spc'>
                                <div class='management-header text-center'>
                                    <h1>قائمة الأجهزة في الصيانة</h1>
                                    <p class='tt'>اجمالي " . count($devices) . " جهاز في الصيانة</p>
                                </div>
                                {$devicesTable}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
            <script src='https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js'></script>
            
            <script>
                function addSerialInput() {
                    const container = document.getElementById('more-serials');
                    const newField = document.createElement('div');
                    newField.classList.add('form-group');
                    newField.innerHTML = `
                        <input type='text' name='serial_number[]' required class='form-control mt-2' placeholder='أدخل الرقم التسلسلي' autocomplete='off'>
                    `;
                    container.appendChild(newField);
                }
                
                // إضافة وظيفة نسخ الرقم التسلسلي عند النقر على الخلية
                document.addEventListener('DOMContentLoaded', function() {
                    const serialCells = document.querySelectorAll('.serial-cell');
                    serialCells.forEach(function(cell) {
                        cell.addEventListener('click', function() {
                            const serialNumber = this.textContent.trim();
                            const inputs = document.querySelectorAll('input[name=\"serial_number[]\"]');
                            
                            // البحث عن أول حقل فارغ
                            let emptyInput = null;
                            for (let input of inputs) {
                                if (input.value.trim() === '') {
                                    emptyInput = input;
                                    break;
                                }
                            }
                            
                            // إذا لم يتم العثور على حقل فارغ، إضافة حقل جديد
                            if (!emptyInput) {
                                addSerialInput();
                                const newInputs = document.querySelectorAll('input[name=\"serial_number[]\"]');
                                emptyInput = newInputs[newInputs.length - 1];
                            }
                            
                            if (emptyInput) {
                                emptyInput.value = serialNumber;
                                emptyInput.focus();
                            }
                        });
                    });
                });
            </script>
        </body>
        </html>";
    }
    
    /**
     * إنشاء جدول الأجهزة في الصيانة
     */
    private function generateDevicesTable($devices) {
        if (empty($devices)) {
            return "<div class='alert alert-info text-center'>لا توجد أجهزة في الصيانة حالياً</div>";
        }
        
        $tableRows = '';
        foreach ($devices as $device) {
            $deviceName = isset($device['device_name']) ? $device['device_name'] : '';
            $department = isset($device['department']) ? $device['department'] : '';
            $notes = isset($device['notes']) ? $device['notes'] : '';
            $createdAt = isset($device['created_at']) ? date('Y-m-d', strtotime($device['created_at'])) : 'غير محدد';
            
            $tableRows .= "
                <tr>
                    <td class='serial-cell' style='cursor: pointer; color: #0d4f8b; font-weight: bold;' title='اضغط لنسخ الرقم التسلسلي'>
                        <p class='f-n'>{$device['serial_number']}</p>
                    </td>
                    <td>{$deviceName}</td>
                    <td>{$department}</td>
                    <td>{$notes}</td>
                    <td>{$createdAt}</td>
                </tr>";
        }
        
        return "
            <div class='default-management-table table-responsive'>
                <table class='table' id='maintenance-table'>
                    <thead>
                        <tr>
                            <th>الرقم التسلسلي</th>
                            <th>اسم الجهاز</th>
                            <th>القسم</th>
                            <th>ملاحظات</th>
                            <th>تاريخ الإدخال</th>
                        </tr>
                    </thead>
                    <tbody>
                        {$tableRows}
                    </tbody>
                </table>
            </div>
            <div class='alert alert-info mt-3'>
                <i class='fas fa-info-circle'></i> 
                <strong>نصيحة:</strong> اضغط على أي رقم تسلسلي في الجدول لنسخه تلقائياً إلى نموذج الاسترجاع
            </div>";
    }
}

// الاستخدام
try {
    // إنشاء نظام الاسترجاع
    $restoreSystem = new DeviceRestoreSystem($conn, $pageTitle);
    
    // معالجة الطلب
    $result = $restoreSystem->processRestoreRequest();
    
    // عرض الصفحة
    $restoreSystem->renderPage($result);
    
} catch (Exception $e) {
    echo "<div class='alert alert-danger text-center'><strong>خطأ في النظام:</strong> {$e->getMessage()}</div>";
}

// Include footer if needed
if (isset($tpl)) {
    include $tpl . 'footer.php';
}

ob_end_flush();
?>