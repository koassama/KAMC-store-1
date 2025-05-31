<?php
ob_start();
session_start();
if (isset($_SESSION['admin'])) {
    $pageTitle = 'اضافة منتج جديد';
    include 'init.php';
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Almarai', sans-serif;
            background-color: #f1f4f8;
            direction: rtl;
            margin: 0;
            padding: 0;
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

        .btn-primary {
            background: linear-gradient(135deg, #0d4f8b, #1e40af);
            color: white;
        }

        .btn-secondary {
            background: #6b7280;
            color: white;
        }

        .btn-danger {
            background: #dc2626;
            color: white;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .form-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 30px;
            gap: 15px;
        }

        .back-link {
            font-size: 15px;
            border-radius: 10px;
            background: var(--mainColor, #0d4f8b);
            color: white;
            padding: 8px;
            text-decoration: none;
            margin-left: 5px;
            transition: all 0.3s ease;
        }

        .back-link:hover {
            color: white;
            transform: translateY(-1px);
        }

        .err-msg {
            margin-top: 20px;
        }

        /* Device Entry Styling */
        .device-entry {
            border: 2px solid #e5e7eb;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 25px;
            background: #f8fafc;
            position: relative;
        }

        .device-entry h5 {
            color: #1e293b;
            font-weight: 600;
            margin-bottom: 20px;
            border-bottom: 2px solid #0d4f8b;
            padding-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .device-counter {
            background: #0d4f8b;
            color: white;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: bold;
        }

        .remove-device-btn {
            position: absolute;
            top: 15px;
            left: 15px;
            padding: 5px 10px;
            font-size: 12px;
        }

        /* File Upload Styling */
        .form-control[type="file"] {
            padding: 8px 12px;
        }

        .form-control[type="file"]::-webkit-file-upload-button {
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 8px 16px;
            margin-left: 10px;
            color: #374151;
            font-family: 'Almarai', sans-serif;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .form-control[type="file"]::-webkit-file-upload-button:hover {
            background: linear-gradient(135deg, #e2e8f0, #cbd5e1);
        }

        /* Textarea Styling */
        textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }

        /* Select Styling */
        select.form-control {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: left 12px center;
            background-repeat: no-repeat;
            background-size: 16px 12px;
            padding-left: 40px;
        }

        /* Animation for new devices */
        .device-entry.new-device {
            animation: slideInDown 0.4s ease-out;
        }

        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
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

            .device-entry {
                padding: 20px;
            }

            .remove-device-btn {
                position: static;
                width: 100%;
                margin-top: 15px;
            }
        }
    </style>
</head>
<body style="margin-right: 220px; margin-top:40px">
    <div class="add-default-page add-post-page add-product-page" id="add-page">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <form class="add-form" method="POST" action="products_insert.php" enctype="multipart/form-data" id="ca-form-info">
                        <h3>اضافة منتجات جديدة
                            <a style="margin-left:5px;font-size:15px;border-radius: 10px;background:var(--mainColor, #0d4f8b);color:white;padding:8px" href="products_manage.php" class="fas fa-long-arrow-alt-right"></a>
                        </h3>

                        <!-- الجهاز الأول -->
                        <div class="device-entry" data-device-number="1">
                            <h5>
                                <span class="device-counter">1</span>
                                <i class="fas fa-laptop"></i> الجهاز الأول
                            </h5>

                            <div class="row">
                                <!-- Serial Number -->
                                <div class="form-group col-md-6">
                                    <label for="sr_1">الرقم التسلسلي</label>
                                    <input type="text" name="sr[]" id="sr_1" placeholder="أدخل الرقم التسلسلي" required class="form-control">
                                </div>

                                <!-- Device Name -->
                                <div class="form-group col-md-6">
                                    <label for="device_name_1">اسم الجهاز</label>
                                    <input type="text" name="device_name[]" id="device_name_1" placeholder="اسم الجهاز" required class="form-control">
                                </div>

                                <!-- Device Type -->
                                <div class="form-group col-md-6">
                                    <label for="device_type_1">نوع الجهاز</label>
                                    <select class="form-control" name="device_type[]" id="device_type_1" required>
                                        <option value="">اختر نوع الجهاز</option>
                                        <option value="HP">HP</option>
                                        <option value="Dell">Dell</option>
                                        <option value="Lenovo">Lenovo</option>
                                        <option value="Zebra">Zebra</option>
                                        <option value="جدارية">جدارية</option>
                                        <option value="portabol">Portable</option>
                                        <option value="Signature pad">Signature pad</option>
                                    </select>
                                </div>

                                <!-- Device Model -->
                                <div class="form-group col-md-6">
                                    <label for="device_model_1">موديل الجهاز</label>
                                    <input type="text" name="device_model[]" id="device_model_1" placeholder="موديل الجهاز" class="form-control">
                                </div>

                                <!-- Employee ID -->
                                <div class="form-group col-md-6">
                                    <label for="employee_id_1">الرقم الوظيفي</label>
                                    <input type="text" name="employee_id[]" id="employee_id_1" placeholder="الرقم الوظيفي" class="form-control">
                                </div>

                                <!-- Department -->
                                <div class="form-group col-md-6">
                                    <label for="department_1">الإدارة</label>
                                    <input type="text" name="department[]" id="department_1" placeholder="الإدارة" class="form-control">
                                </div>

                                <!-- Notes -->
                                <div class="form-group col-md-12">
                                    <label for="notes_1">ملاحظات</label>
                                    <textarea name="notes[]" id="notes_1" placeholder="أدخل أي ملاحظات إضافية" class="form-control"></textarea>
                                </div>

                                <!-- Device Image -->
                                <div class="form-group col-md-12">
                                    <label for="image_1">صورة الجهاز</label>
                                    <input type="file" name="image[]" id="image_1" class="form-control" accept="image/*">
                                    <small class="form-text text-muted">يُفضل رفع صورة بصيغة JPG أو PNG (الحد الأقصى 4 ميجابايت)</small>
                                </div>
                            </div>
                        </div>

                        <!-- Container for additional devices -->
                        <div id="additional-devices"></div>

                        <div class="form-actions">
                            <div class="d-flex gap-2">
                                <a href="products_manage.php" class="btn btn-secondary btn-small">
                                    <i class="fas fa-arrow-right"></i> العودة
                                </a>
                                <button type="button" onclick="addNewDevice()" class="btn btn-secondary btn-small">
                                    <i class="fas fa-plus"></i> إضافة جهاز آخر
                                </button>
                            </div>
                            <input type="submit" class="btn btn-primary btn-large" id="ca-btn-option" value="إضافة المنتجات">
                        </div>

                        <div class="err-msg"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let deviceCounter = 1;
        const arabicNumbers = ['', 'الأول', 'الثاني', 'الثالث', 'الرابع', 'الخامس', 'السادس', 'السابع', 'الثامن', 'التاسع', 'العاشر'];

        function addNewDevice() {
            deviceCounter++;
            const container = document.getElementById('additional-devices');
            const deviceNumber = deviceCounter;
            const arabicNumber = arabicNumbers[deviceNumber] || `رقم ${deviceNumber}`;

            const newDeviceHTML = `
                <div class="device-entry new-device" data-device-number="${deviceNumber}">
                    <button type="button" class="btn btn-danger btn-sm remove-device-btn" onclick="removeDevice(this)">
                        <i class="fas fa-trash"></i> حذف الجهاز
                    </button>
                    
                    <h5>
                        <span class="device-counter">${deviceNumber}</span>
                        <i class="fas fa-laptop"></i> الجهاز ${arabicNumber}
                    </h5>

                    <div class="row">
                        <!-- Serial Number -->
                        <div class="form-group col-md-6">
                            <label>الرقم التسلسلي</label>
                            <input type="text" name="sr[]" placeholder="أدخل الرقم التسلسلي" required class="form-control">
                        </div>

                        <!-- Device Name -->
                        <div class="form-group col-md-6">
                            <label>اسم الجهاز</label>
                            <input type="text" name="device_name[]" placeholder="اسم الجهاز" required class="form-control">
                        </div>

                        <!-- Device Type -->
                        <div class="form-group col-md-6">
                            <label>نوع الجهاز</label>
                            <select class="form-control" name="device_type[]" required>
                                <option value="">اختر نوع الجهاز</option>
                                <option value="HP">HP</option>
                                <option value="Dell">Dell</option>
                                <option value="Lenovo">Lenovo</option>
                                <option value="Zebra">Zebra</option>
                                <option value="جدارية">جدارية</option>
                                <option value="portabol">Portable</option>
                                <option value="Signature pad">Signature pad</option>
                            </select>
                        </div>

                        <!-- Device Model -->
                        <div class="form-group col-md-6">
                            <label>موديل الجهاز</label>
                            <input type="text" name="device_model[]" placeholder="موديل الجهاز" class="form-control">
                        </div>

                        <!-- Employee ID -->
                        <div class="form-group col-md-6">
                            <label>الرقم الوظيفي</label>
                            <input type="text" name="employee_id[]" placeholder="الرقم الوظيفي" class="form-control">
                        </div>

                        <!-- Department -->
                        <div class="form-group col-md-6">
                            <label>الإدارة</label>
                            <input type="text" name="department[]" placeholder="الإدارة" class="form-control">
                        </div>

                        <!-- Notes -->
                        <div class="form-group col-md-12">
                            <label>ملاحظات</label>
                            <textarea name="notes[]" placeholder="أدخل أي ملاحظات إضافية" class="form-control"></textarea>
                        </div>

                        <!-- Device Image -->
                        <div class="form-group col-md-12">
                            <label>صورة الجهاز</label>
                            <input type="file" name="image[]" class="form-control" accept="image/*">
                            <small class="form-text text-muted">يُفضل رفع صورة بصيغة JPG أو PNG (الحد الأقصى 4 ميجابايت)</small>
                        </div>
                    </div>
                </div>
            `;

            container.insertAdjacentHTML('beforeend', newDeviceHTML);
            
            // Scroll to the new device
            setTimeout(() => {
                const newDevice = container.lastElementChild;
                newDevice.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 100);
        }

        function removeDevice(button) {
            const deviceEntry = button.closest('.device-entry');
            deviceEntry.style.animation = 'slideOutUp 0.3s ease-out';
            setTimeout(() => {
                deviceEntry.remove();
                updateDeviceNumbers();
            }, 300);
        }

        function updateDeviceNumbers() {
            const devices = document.querySelectorAll('.device-entry');
            devices.forEach((device, index) => {
                const number = index + 1;
                const arabicNumber = arabicNumbers[number] || `رقم ${number}`;
                
                device.setAttribute('data-device-number', number);
                
                const counter = device.querySelector('.device-counter');
                const title = device.querySelector('h5');
                
                if (counter) counter.textContent = number;
                if (title) {
                    const titleText = number === 1 ? 'الجهاز الأول' : `الجهاز ${arabicNumber}`;
                    title.innerHTML = `
                        <span class="device-counter">${number}</span>
                        <i class="fas fa-laptop"></i> ${titleText}
                    `;
                }
            });
            
            deviceCounter = devices.length;
        }

        // Form validation
        document.getElementById('ca-form-info').addEventListener('submit', function(e) {
            const serialNumbers = document.querySelectorAll('input[name="sr[]"]');
            const deviceNames = document.querySelectorAll('input[name="device_name[]"]');
            const deviceTypes = document.querySelectorAll('select[name="device_type[]"]');
            const errMsg = document.querySelector('.err-msg');
            
            errMsg.innerHTML = '';
            
            let isValid = true;
            let errorMessages = [];

            // Check each device
            serialNumbers.forEach((input, index) => {
                const sr = input.value.trim();
                const name = deviceNames[index].value.trim();
                const type = deviceTypes[index].value;
                const deviceNum = index + 1;

                if (!sr) {
                    errorMessages.push(`الرقم التسلسلي مطلوب للجهاز رقم ${deviceNum}`);
                    isValid = false;
                }
                
                if (!name) {
                    errorMessages.push(`اسم الجهاز مطلوب للجهاز رقم ${deviceNum}`);
                    isValid = false;
                }
                
                if (!type) {
                    errorMessages.push(`نوع الجهاز مطلوب للجهاز رقم ${deviceNum}`);
                    isValid = false;
                }
            });

            if (!isValid) {
                e.preventDefault();
                errMsg.innerHTML = '<div class="alert alert-danger"><ul class="mb-0">' + 
                    errorMessages.map(msg => `<li>${msg}</li>`).join('') + '</ul></div>';
                return false;
            }
        });

        // File size validation
        document.addEventListener('change', function(e) {
            if (e.target.type === 'file' && e.target.accept === 'image/*') {
                const file = e.target.files[0];
                const errMsg = document.querySelector('.err-msg');
                
                if (file && file.size > 4194304) { // 4MB
                    errMsg.innerHTML = '<div class="alert alert-warning">حجم الصورة كبير جداً (الحد الأقصى 4 ميجابايت)</div>';
                    e.target.value = '';
                } else if (errMsg.innerHTML.includes('حجم الصورة')) {
                    errMsg.innerHTML = '';
                }
            }
        });
    </script>
</body>
</html>

<?php
include $tpl . 'footer.php';
} else {
    header('location: logout.php');
}
ob_end_flush();
?>
