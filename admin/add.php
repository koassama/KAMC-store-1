<?php
ob_start();
session_start();
if (isset($_SESSION['admin'])) {
    $pageTitle = 'صفحة الاضافة';
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

        /* Input validation styling */
        .form-control.is-valid {
            border-color: #10b981;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%2310b981' d='m2.3 6.73.1-.04L6.6 2.52c.2-.2.2-.5 0-.7-.2-.2-.5-.2-.7 0L3.2 4.5 1.4 2.7c-.2-.2-.5-.2-.7 0-.2.2-.2.5 0 .7l2.6 3.3z'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: left 12px center;
            background-size: 16px 16px;
            padding-left: 40px;
        }

        .form-control.is-invalid {
            border-color: #dc2626;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc2626'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath d='m5.8 4.6 1.4 1.4m0-1.4L5.8 6'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: left 12px center;
            background-size: 16px 16px;
            padding-left: 40px;
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
<body style="margin-top: 40px; margin-right:130px">
    <div class="add-default-page add-post-page add-product-page" id="add-page">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <form class="add-form" method="POST" action="/KAMC-store-1-main/admin/insert.php" enctype="multipart/form-data" id="ca-form-info">
                        <h3>إضافة أجهزة جديدة
                            <a style="margin-left:5px;font-size:15px;border-radius: 10px;background:var(--mainColor, #0d4f8b);color:white;padding:8px" href="consumers.php" class="fas fa-long-arrow-alt-right"></a>
                        </h3>

                        <!-- الجهاز الأول -->
                        <div class="device-entry" data-device-number="1">
                            <h5>
                                <span class="device-counter">1</span>
                                <i class="fas fa-desktop"></i> الجهاز الأول
                            </h5>

                            <div class="row">
                                <!-- Consumer Name -->
                                <div class="form-group col-md-6">
                                    <label>اسم المستهلك</label>
                                    <input type="text" name="consumer_name[]" placeholder="اسم المستهلك" required class="form-control">
                                    <div class="invalid-feedback">اسم المستهلك مطلوب</div>
                                </div>

                                <!-- Device Name -->
                                <div class="form-group col-md-6">
                                    <label>اسم الجهاز</label>
                                    <input type="text" name="device_name[]" placeholder="اسم الجهاز" required class="form-control">
                                    <div class="invalid-feedback">اسم الجهاز مطلوب</div>
                                </div>

                                <!-- Quantity -->
                                <div class="form-group col-md-6">
                                    <label>الكمية</label>
                                    <input type="number" name="quantity[]" placeholder="الكمية" required class="form-control" min="1">
                                    <div class="invalid-feedback">الكمية مطلوبة ويجب أن تكون أكبر من 0</div>
                                </div>

                                <!-- Additional Quantity -->
                                <div class="form-group col-md-6">
                                    <label>إضافة خانة بالكمية</label>
                                    <input type="number" name="additional_quantity[]" placeholder="إضافة خانة بالكمية" required class="form-control" min="0">
                                    <div class="invalid-feedback">إضافة خانة بالكمية مطلوبة</div>
                                </div>

                                <!-- Consumer Type -->
                                <div class="form-group col-md-6">
                                    <label>نوع المستهلك</label>
                                    <input type="text" name="consumer_type[]" placeholder="نوع المستهلك" required class="form-control">
                                    <div class="invalid-feedback">نوع المستهلك مطلوب</div>
                                </div>

                                <!-- Serial Number -->
                                <div class="form-group col-md-6">
                                    <label>SR: Serial number</label>
                                    <input type="text" name="sr[]" placeholder="SR: Serial number" required class="form-control">
                                    <div class="invalid-feedback">الرقم التسلسلي مطلوب</div>
                                </div>

                                <!-- Custody Number -->
                                <div class="form-group col-md-6">
                                    <label>رقم العهدة</label>
                                    <input type="text" name="custody_number[]" placeholder="رقم العهدة" required class="form-control">
                                    <div class="invalid-feedback">رقم العهدة مطلوب</div>
                                </div>

                                <!-- Device Location -->
                                <div class="form-group col-md-6">
                                    <label>موقع الجهاز</label>
                                    <input type="text" name="device_location[]" placeholder="موقع الجهاز" required class="form-control">
                                    <div class="invalid-feedback">موقع الجهاز مطلوب</div>
                                </div>

                                <!-- Storage Type -->
                                <div class="form-group col-md-6">
                                    <label>نوع وحدة التخزين</label>
                                    <input type="text" name="storage_type[]" placeholder="نوع وحدة التخزين" required class="form-control">
                                    <div class="invalid-feedback">نوع وحدة التخزين مطلوب</div>
                                </div>

                                <!-- RAM Type -->
                                <div class="form-group col-md-6">
                                    <label>نوع RAM</label>
                                    <input type="text" name="ram_type[]" placeholder="نوع RAM" required class="form-control">
                                    <div class="invalid-feedback">نوع RAM مطلوب</div>
                                </div>

                                <!-- Remarks -->
                                <div class="form-group col-md-12">
                                    <label>ملاحظات</label>
                                    <input type="text" name="remarks[]" placeholder="ملاحظات" required class="form-control">
                                    <div class="invalid-feedback">الملاحظات مطلوبة</div>
                                </div>
                            </div>
                        </div>

                        <!-- Container for additional devices -->
                        <div id="additional-devices"></div>

                        <div class="form-actions">
                            <div class="d-flex gap-2">
                                <a href="consumers.php" class="btn btn-secondary btn-small">
                                    <i class="fas fa-arrow-right"></i> العودة
                                </a>
                                <button type="button" onclick="addNewDevice()" class="btn btn-secondary btn-small">
                                    <i class="fas fa-plus"></i> إضافة جهاز آخر
                                </button>
                            </div>
                            <button type="submit" class="btn btn-primary btn-large" id="ca-btn-option">
                                <i class="fas fa-save"></i> حفظ الأجهزة
                            </button>
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
                        <i class="fas fa-desktop"></i> الجهاز ${arabicNumber}
                    </h5>

                    <div class="row">
                        <!-- Consumer Name -->
                        <div class="form-group col-md-6">
                            <label>اسم المستهلك</label>
                            <input type="text" name="consumer_name[]" placeholder="اسم المستهلك" required class="form-control">
                            <div class="invalid-feedback">اسم المستهلك مطلوب</div>
                        </div>

                        <!-- Device Name -->
                        <div class="form-group col-md-6">
                            <label>اسم الجهاز</label>
                            <input type="text" name="device_name[]" placeholder="اسم الجهاز" required class="form-control">
                            <div class="invalid-feedback">اسم الجهاز مطلوب</div>
                        </div>

                        <!-- Quantity -->
                        <div class="form-group col-md-6">
                            <label>الكمية</label>
                            <input type="number" name="quantity[]" placeholder="الكمية" required class="form-control" min="1">
                            <div class="invalid-feedback">الكمية مطلوبة ويجب أن تكون أكبر من 0</div>
                        </div>

                        <!-- Additional Quantity -->
                        <div class="form-group col-md-6">
                            <label>إضافة خانة بالكمية</label>
                            <input type="number" name="additional_quantity[]" placeholder="إضافة خانة بالكمية" required class="form-control" min="0">
                            <div class="invalid-feedback">إضافة خانة بالكمية مطلوبة</div>
                        </div>

                        <!-- Consumer Type -->
                        <div class="form-group col-md-6">
                            <label>نوع المستهلك</label>
                            <input type="text" name="consumer_type[]" placeholder="نوع المستهلك" required class="form-control">
                            <div class="invalid-feedback">نوع المستهلك مطلوب</div>
                        </div>

                        <!-- Serial Number -->
                        <div class="form-group col-md-6">
                            <label>SR: Serial number</label>
                            <input type="text" name="sr[]" placeholder="SR: Serial number" required class="form-control">
                            <div class="invalid-feedback">الرقم التسلسلي مطلوب</div>
                        </div>

                        <!-- Custody Number -->
                        <div class="form-group col-md-6">
                            <label>رقم العهدة</label>
                            <input type="text" name="custody_number[]" placeholder="رقم العهدة" required class="form-control">
                            <div class="invalid-feedback">رقم العهدة مطلوب</div>
                        </div>

                        <!-- Device Location -->
                        <div class="form-group col-md-6">
                            <label>موقع الجهاز</label>
                            <input type="text" name="device_location[]" placeholder="موقع الجهاز" required class="form-control">
                            <div class="invalid-feedback">موقع الجهاز مطلوب</div>
                        </div>

                        <!-- Storage Type -->
                        <div class="form-group col-md-6">
                            <label>نوع وحدة التخزين</label>
                            <input type="text" name="storage_type[]" placeholder="نوع وحدة التخزين" required class="form-control">
                            <div class="invalid-feedback">نوع وحدة التخزين مطلوب</div>
                        </div>

                        <!-- RAM Type -->
                        <div class="form-group col-md-6">
                            <label>نوع RAM</label>
                            <input type="text" name="ram_type[]" placeholder="نوع RAM" required class="form-control">
                            <div class="invalid-feedback">نوع RAM مطلوب</div>
                        </div>

                        <!-- Remarks -->
                        <div class="form-group col-md-12">
                            <label>ملاحظات</label>
                            <input type="text" name="remarks[]" placeholder="ملاحظات" required class="form-control">
                            <div class="invalid-feedback">الملاحظات مطلوبة</div>
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
                        <i class="fas fa-desktop"></i> ${titleText}
                    `;
                }
            });
            
            deviceCounter = devices.length;
        }

        // Real-time validation
        document.addEventListener('input', function(e) {
            const input = e.target;
            
            // Number validation
            if (input.type === 'number') {
                const min = parseInt(input.getAttribute('min')) || 0;
                if (input.value && parseInt(input.value) >= min) {
                    input.classList.remove('is-invalid');
                    input.classList.add('is-valid');
                } else if (input.value) {
                    input.classList.remove('is-valid');
                    input.classList.add('is-invalid');
                } else {
                    input.classList.remove('is-valid', 'is-invalid');
                }
            }
            
            // Text validation
            if (input.type === 'text' && input.hasAttribute('required')) {
                if (input.value.trim()) {
                    input.classList.remove('is-invalid');
                    input.classList.add('is-valid');
                } else {
                    input.classList.remove('is-valid', 'is-invalid');
                }
            }
        });

        // Form validation
        document.getElementById('ca-form-info').addEventListener('submit', function(e) {
            const consumerNames = document.querySelectorAll('input[name="consumer_name[]"]');
            const deviceNames = document.querySelectorAll('input[name="device_name[]"]');
            const quantities = document.querySelectorAll('input[name="quantity[]"]');
            const additionalQuantities = document.querySelectorAll('input[name="additional_quantity[]"]');
            const consumerTypes = document.querySelectorAll('input[name="consumer_type[]"]');
            const serialNumbers = document.querySelectorAll('input[name="sr[]"]');
            const custodyNumbers = document.querySelectorAll('input[name="custody_number[]"]');
            const deviceLocations = document.querySelectorAll('input[name="device_location[]"]');
            const storageTypes = document.querySelectorAll('input[name="storage_type[]"]');
            const ramTypes = document.querySelectorAll('input[name="ram_type[]"]');
            const remarks = document.querySelectorAll('input[name="remarks[]"]');
            const errMsg = document.querySelector('.err-msg');
            
            errMsg.innerHTML = '';
            
            let isValid = true;
            let errorMessages = [];

            // Check each device
            consumerNames.forEach((input, index) => {
                const consumerName = input.value.trim();
                const deviceName = deviceNames[index].value.trim();
                const quantity = quantities[index].value;
                const additionalQuantity = additionalQuantities[index].value;
                const consumerType = consumerTypes[index].value.trim();
                const serialNumber = serialNumbers[index].value.trim();
                const custodyNumber = custodyNumbers[index].value.trim();
                const deviceLocation = deviceLocations[index].value.trim();
                const storageType = storageTypes[index].value.trim();
                const ramType = ramTypes[index].value.trim();
                const remark = remarks[index].value.trim();
                const deviceNum = index + 1;

                // Validate all required fields
                if (!consumerName) {
                    errorMessages.push(`اسم المستهلك مطلوب للجهاز رقم ${deviceNum}`);
                    isValid = false;
                }
                
                if (!deviceName) {
                    errorMessages.push(`اسم الجهاز مطلوب للجهاز رقم ${deviceNum}`);
                    isValid = false;
                }
                
                if (!quantity || parseInt(quantity) < 1) {
                    errorMessages.push(`الكمية مطلوبة ويجب أن تكون أكبر من 0 للجهاز رقم ${deviceNum}`);
                    isValid = false;
                }
                
                if (additionalQuantity === '' || parseInt(additionalQuantity) < 0) {
                    errorMessages.push(`إضافة خانة بالكمية مطلوبة للجهاز رقم ${deviceNum}`);
                    isValid = false;
                }
                
                if (!consumerType) {
                    errorMessages.push(`نوع المستهلك مطلوب للجهاز رقم ${deviceNum}`);
                    isValid = false;
                }
                
                if (!serialNumber) {
                    errorMessages.push(`الرقم التسلسلي مطلوب للجهاز رقم ${deviceNum}`);
                    isValid = false;
                }
                
                if (!custodyNumber) {
                    errorMessages.push(`رقم العهدة مطلوب للجهاز رقم ${deviceNum}`);
                    isValid = false;
                }
                
                if (!deviceLocation) {
                    errorMessages.push(`موقع الجهاز مطلوب للجهاز رقم ${deviceNum}`);
                    isValid = false;
                }
                
                if (!storageType) {
                    errorMessages.push(`نوع وحدة التخزين مطلوب للجهاز رقم ${deviceNum}`);
                    isValid = false;
                }
                
                if (!ramType) {
                    errorMessages.push(`نوع RAM مطلوب للجهاز رقم ${deviceNum}`);
                    isValid = false;
                }
                
                if (!remark) {
                    errorMessages.push(`الملاحظات مطلوبة للجهاز رقم ${deviceNum}`);
                    isValid = false;
                }
            });

            // Check for duplicate serial numbers
            const serialValues = Array.from(serialNumbers).map(input => input.value.trim().toLowerCase());
            const duplicateSerials = serialValues.filter((serial, index) => 
                serial && serialValues.indexOf(serial) !== index
            );
            
            if (duplicateSerials.length > 0) {
                errorMessages.push('يوجد رقم تسلسلي مكرر، يرجى التأكد من عدم تكرار الرقم التسلسلي');
                isValid = false;
            }

            // Check for duplicate custody numbers
            const custodyValues = Array.from(custodyNumbers).map(input => input.value.trim().toLowerCase());
            const duplicateCustody = custodyValues.filter((custody, index) => 
                custody && custodyValues.indexOf(custody) !== index
            );
            
            if (duplicateCustody.length > 0) {
                errorMessages.push('يوجد رقم عهدة مكرر، يرجى التأكد من عدم تكرار رقم العهدة');
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
                errMsg.innerHTML = '<div class="alert alert-danger"><ul class="mb-0">' + 
                    errorMessages.map(msg => `<li>${msg}</li>`).join('') + '</ul></div>';
                
                // Scroll to error message
                errMsg.scrollIntoView({ behavior: 'smooth', block: 'center' });
                return false;
            }
        });

        // Prevent form submission on Enter key in input fields
        document.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && e.target.tagName === 'INPUT' && e.target.type !== 'submit') {
                e.preventDefault();
            }
        });

        // Add slideOutUp animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideOutUp {
                from {
                    opacity: 1;
                    transform: translateY(0);
                }
                to {
                    opacity: 0;
                    transform: translateY(-20px);
                }
            }
        `;
        document.head.appendChild(style);
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
