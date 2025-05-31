<?php
ob_start();
session_start();
if (isset($_SESSION['admin'])) {
    if ($_SESSION['type'] == 2) {
        $pageTitle = "اضافة موظف جديد";
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

        /* Employee Entry Styling */
        .employee-entry {
            border: 2px solid #e5e7eb;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 25px;
            background: #f8fafc;
            position: relative;
        }

        .employee-entry h5 {
            color: #1e293b;
            font-weight: 600;
            margin-bottom: 20px;
            border-bottom: 2px solid #0d4f8b;
            padding-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .employee-counter {
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

        .remove-employee-btn {
            position: absolute;
            top: 15px;
            left: 15px;
            padding: 5px 10px;
            font-size: 12px;
        }

        /* Select Styling */
        select.form-control {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: left 12px center;
            background-repeat: no-repeat;
            background-size: 16px 12px;
            padding-left: 40px;
        }

        /* Animation for new employees */
        .employee-entry.new-employee {
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

        /* Password strength indicator */
        .password-strength {
            margin-top: 5px;
            font-size: 12px;
        }

        .password-weak {
            color: #dc2626;
        }

        .password-medium {
            color: #f59e0b;
        }

        .password-strong {
            color: #10b981;
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

        /* Phone input styling */
        .phone-input-group {
            position: relative;
        }

        .phone-prefix {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7280;
            font-weight: 500;
            z-index: 1;
        }

        .phone-input {
            padding-left: 45px !important;
        }

        /* Salary input styling */
        .salary-input-group {
            position: relative;
        }

        .salary-suffix {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7280;
            font-weight: 500;
            font-size: 14px;
        }

        .salary-input {
            padding-left: 60px !important;
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

            .employee-entry {
                padding: 20px;
            }

            .remove-employee-btn {
                position: static;
                width: 100%;
                margin-top: 15px;
            }
        }
    </style>
</head>
<body style="margin-right: 220px; margin-top: 40px;">
    <div class="add-default-page add-user-page" id="add-page">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <form class="add-form" method="POST" action="users_insert.php" id="form-info">
                        <h3>اضافة موظفين جدد
                            <a style="margin-left:5px;font-size:15px;border-radius: 10px;background:var(--mainColor, #0d4f8b);color:white;padding:8px" href="users_manage.php" class="fas fa-long-arrow-alt-right"></a>
                        </h3>

                        <!-- الموظف الأول -->
                        <div class="employee-entry" data-employee-number="1">
                            <h5>
                                <span class="employee-counter">1</span>
                                <i class="fas fa-user"></i> الموظف الأول
                            </h5>

                            <div class="row">
                                <!-- Email -->
                                <div class="form-group col-md-6">
                                    <label for="email_1">البريد الإلكتروني</label>
                                    <input type="email" name="email[]" id="email_1" placeholder="example@company.com" required class="form-control">
                                    <div class="invalid-feedback">يرجى إدخال بريد إلكتروني صحيح</div>
                                </div>

                                <!-- Username -->
                                <div class="form-group col-md-6">
                                    <label for="username_1">اسم الموظف</label>
                                    <input type="text" name="username[]" id="username_1" placeholder="اسم المستخدم" required class="form-control">
                                    <div class="invalid-feedback">اسم الموظف مطلوب</div>
                                </div>

                                <!-- Phone -->
                                <div class="form-group col-md-6">
                                    <label for="phone_1">رقم الجوال</label>
                                    <div class="phone-input-group">
                                        <span class="phone-prefix">+966</span>
                                        <input type="text" name="phone[]" id="phone_1" placeholder="5xxxxxxxx" required class="form-control phone-input" pattern="5[0-9]{8}" maxlength="9">
                                    </div>
                                    <small class="form-text text-muted">مثال: 512345678</small>
                                    <div class="invalid-feedback">يرجى إدخال رقم جوال صحيح (9 أرقام تبدأ بـ 5)</div>
                                </div>

                                <!-- Job Title -->
                                <div class="form-group col-md-6">
                                    <label for="wadifa_1">المسمى الوظيفي</label>
                                    <input type="text" name="wadifa[]" id="wadifa_1" placeholder="المسمى الوظيفي" required class="form-control">
                                    <div class="invalid-feedback">المسمى الوظيفي مطلوب</div>
                                </div>

                                <!-- Salary -->
                                <div class="form-group col-md-6">
                                    <label for="ratib_1">الراتب الأساسي</label>
                                    <div class="salary-input-group">
                                        <input type="number" name="ratib[]" id="ratib_1" placeholder="0000" required class="form-control salary-input" min="1000" step="100">
                                        <span class="salary-suffix">ريال</span>
                                    </div>
                                    <small class="form-text text-muted">الحد الأدنى: 1000 ريال</small>
                                    <div class="invalid-feedback">يرجى إدخال راتب صحيح (1000 ريال أو أكثر)</div>
                                </div>

                                <!-- Employee ID -->
                                <div class="form-group col-md-6">
                                    <label for="employee_id_1">الرقم الوظيفي</label>
                                    <input type="text" name="employee_id[]" id="employee_id_1" placeholder="الرقم الوظيفي" class="form-control">
                                    <small class="form-text text-muted">اختياري</small>
                                </div>

                                <!-- Password -->
                                <div class="form-group col-md-6">
                                    <label for="password_1">كلمة المرور</label>
                                    <input type="password" name="npassword[]" id="password_1" placeholder="كلمة المرور" required class="form-control" minlength="6">
                                    <div class="password-strength" id="strength_1"></div>
                                    <small class="form-text text-muted">يجب أن تكون 6 أحرف على الأقل</small>
                                    <div class="invalid-feedback">كلمة المرور يجب أن تكون 6 أحرف على الأقل</div>
                                </div>

                                <!-- Confirm Password -->
                                <div class="form-group col-md-6">
                                    <label for="cpassword_1">تأكيد كلمة المرور</label>
                                    <input type="password" name="cpassword[]" id="cpassword_1" placeholder="تأكيد كلمة المرور" required class="form-control">
                                    <div class="invalid-feedback">كلمة المرور غير متطابقة</div>
                                </div>

                                <!-- User Type -->
                                <div class="form-group col-md-12">
                                    <label for="type_1">نوع الموظف</label>
                                    <select class="form-control" name="type[]" id="type_1" required>
                                        <option value="">اختر نوع الموظف</option>
                                        <option value="2">مدير</option>
                                        <option value="0">موظف</option>
                                    </select>
                                    <div class="invalid-feedback">يرجى اختيار نوع الموظف</div>
                                </div>
                            </div>
                        </div>

                        <!-- Container for additional employees -->
                        <div id="additional-employees"></div>

                        <div class="form-actions">
                            <div class="d-flex gap-2">
                                <a href="users_manage.php" class="btn btn-secondary btn-small">
                                    <i class="fas fa-arrow-right"></i> العودة
                                </a>
                                <button type="button" onclick="addNewEmployee()" class="btn btn-secondary btn-small">
                                    <i class="fas fa-user-plus"></i> إضافة موظف آخر
                                </button>
                            </div>
                            <button type="submit" class="btn btn-primary btn-large" id="a-btn-option">
                                <i class="fas fa-users"></i> اضافة الموظفين
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
        let employeeCounter = 1;
        const arabicNumbers = ['', 'الأول', 'الثاني', 'الثالث', 'الرابع', 'الخامس', 'السادس', 'السابع', 'الثامن', 'التاسع', 'العاشر'];

        function addNewEmployee() {
            employeeCounter++;
            const container = document.getElementById('additional-employees');
            const employeeNumber = employeeCounter;
            const arabicNumber = arabicNumbers[employeeNumber] || `رقم ${employeeNumber}`;

            const newEmployeeHTML = `
                <div class="employee-entry new-employee" data-employee-number="${employeeNumber}">
                    <button type="button" class="btn btn-danger btn-sm remove-employee-btn" onclick="removeEmployee(this)">
                        <i class="fas fa-trash"></i> حذف الموظف
                    </button>
                    
                    <h5>
                        <span class="employee-counter">${employeeNumber}</span>
                        <i class="fas fa-user"></i> الموظف ${arabicNumber}
                    </h5>

                    <div class="row">
                        <!-- Email -->
                        <div class="form-group col-md-6">
                            <label>البريد الإلكتروني</label>
                            <input type="email" name="email[]" placeholder="example@company.com" required class="form-control">
                            <div class="invalid-feedback">يرجى إدخال بريد إلكتروني صحيح</div>
                        </div>

                        <!-- Username -->
                        <div class="form-group col-md-6">
                            <label>اسم الموظف</label>
                            <input type="text" name="username[]" placeholder="اسم المستخدم" required class="form-control">
                            <div class="invalid-feedback">اسم الموظف مطلوب</div>
                        </div>

                        <!-- Phone -->
                        <div class="form-group col-md-6">
                            <label>رقم الجوال</label>
                            <div class="phone-input-group">
                                <span class="phone-prefix">+966</span>
                                <input type="text" name="phone[]" placeholder="5xxxxxxxx" required class="form-control phone-input" pattern="5[0-9]{8}" maxlength="9">
                            </div>
                            <small class="form-text text-muted">مثال: 512345678</small>
                            <div class="invalid-feedback">يرجى إدخال رقم جوال صحيح (9 أرقام تبدأ بـ 5)</div>
                        </div>

                        <!-- Job Title -->
                        <div class="form-group col-md-6">
                            <label>المسمى الوظيفي</label>
                            <input type="text" name="wadifa[]" placeholder="المسمى الوظيفي" required class="form-control">
                            <div class="invalid-feedback">المسمى الوظيفي مطلوب</div>
                        </div>

                        <!-- Salary -->
                        <div class="form-group col-md-6">
                            <label>الراتب الأساسي</label>
                            <div class="salary-input-group">
                                <input type="number" name="ratib[]" placeholder="0000" required class="form-control salary-input" min="1000" step="100">
                                <span class="salary-suffix">ريال</span>
                            </div>
                            <small class="form-text text-muted">الحد الأدنى: 1000 ريال</small>
                            <div class="invalid-feedback">يرجى إدخال راتب صحيح (1000 ريال أو أكثر)</div>
                        </div>

                        <!-- Employee ID -->
                        <div class="form-group col-md-6">
                            <label>الرقم الوظيفي</label>
                            <input type="text" name="employee_id[]" placeholder="الرقم الوظيفي" class="form-control">
                            <small class="form-text text-muted">اختياري</small>
                        </div>

                        <!-- Password -->
                        <div class="form-group col-md-6">
                            <label>كلمة المرور</label>
                            <input type="password" name="npassword[]" placeholder="كلمة المرور" required class="form-control" minlength="6">
                            <div class="password-strength" id="strength_${employeeNumber}"></div>
                            <small class="form-text text-muted">يجب أن تكون 6 أحرف على الأقل</small>
                            <div class="invalid-feedback">كلمة المرور يجب أن تكون 6 أحرف على الأقل</div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="form-group col-md-6">
                            <label>تأكيد كلمة المرور</label>
                            <input type="password" name="cpassword[]" placeholder="تأكيد كلمة المرور" required class="form-control">
                            <div class="invalid-feedback">كلمة المرور غير متطابقة</div>
                        </div>

                        <!-- User Type -->
                        <div class="form-group col-md-12">
                            <label>نوع الموظف</label>
                            <select class="form-control" name="type[]" required>
                                <option value="">اختر نوع الموظف</option>
                                <option value="2">مدير</option>
                                <option value="0">موظف</option>
                            </select>
                            <div class="invalid-feedback">يرجى اختيار نوع الموظف</div>
                        </div>
                    </div>
                </div>
            `;

            container.insertAdjacentHTML('beforeend', newEmployeeHTML);
            
            // Scroll to the new employee
            setTimeout(() => {
                const newEmployee = container.lastElementChild;
                newEmployee.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 100);
        }

        function removeEmployee(button) {
            const employeeEntry = button.closest('.employee-entry');
            employeeEntry.style.animation = 'slideOutUp 0.3s ease-out';
            setTimeout(() => {
                employeeEntry.remove();
                updateEmployeeNumbers();
            }, 300);
        }

        function updateEmployeeNumbers() {
            const employees = document.querySelectorAll('.employee-entry');
            employees.forEach((employee, index) => {
                const number = index + 1;
                const arabicNumber = arabicNumbers[number] || `رقم ${number}`;
                
                employee.setAttribute('data-employee-number', number);
                
                const counter = employee.querySelector('.employee-counter');
                const title = employee.querySelector('h5');
                
                if (counter) counter.textContent = number;
                if (title) {
                    const titleText = number === 1 ? 'الموظف الأول' : `الموظف ${arabicNumber}`;
                    title.innerHTML = `
                        <span class="employee-counter">${number}</span>
                        <i class="fas fa-user"></i> ${titleText}
                    `;
                }
            });
            
            employeeCounter = employees.length;
        }

        // Password strength checker
        function checkPasswordStrength(password) {
            let strength = 0;
            if (password.length >= 6) strength++;
            if (password.match(/[a-z]+/)) strength++;
            if (password.match(/[A-Z]+/)) strength++;
            if (password.match(/[0-9]+/)) strength++;
            if (password.match(/[^a-zA-Z0-9]+/)) strength++;
            
            return strength;
        }

        // Real-time validation
        document.addEventListener('input', function(e) {
            const input = e.target;
            
            // Email validation
            if (input.type === 'email') {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (input.value && emailRegex.test(input.value)) {
                    input.classList.remove('is-invalid');
                    input.classList.add('is-valid');
                } else if (input.value) {
                    input.classList.remove('is-valid');
                    input.classList.add('is-invalid');
                } else {
                    input.classList.remove('is-valid', 'is-invalid');
                }
            }
            
            // Phone validation
            if (input.classList.contains('phone-input')) {
                const phoneRegex = /^5[0-9]{8}$/;
                if (input.value && phoneRegex.test(input.value)) {
                    input.classList.remove('is-invalid');
                    input.classList.add('is-valid');
                } else if (input.value) {
                    input.classList.remove('is-valid');
                    input.classList.add('is-invalid');
                } else {
                    input.classList.remove('is-valid', 'is-invalid');
                }
            }
            
            // Password strength indicator
            if (input.type === 'password' && input.name === 'npassword[]') {
                const strengthIndicator = input.parentElement.querySelector('.password-strength');
                if (strengthIndicator) {
                    const strength = checkPasswordStrength(input.value);
                    let strengthText = '';
                    let strengthClass = '';
                    
                    if (input.value.length === 0) {
                        strengthText = '';
                    } else if (strength <= 2) {
                        strengthText = 'ضعيفة';
                        strengthClass = 'password-weak';
                    } else if (strength <= 3) {
                        strengthText = 'متوسطة';
                        strengthClass = 'password-medium';
                    } else {
                        strengthText = 'قوية';
                        strengthClass = 'password-strong';
                    }
                    
                    strengthIndicator.textContent = strengthText ? `قوة كلمة المرور: ${strengthText}` : '';
                    strengthIndicator.className = `password-strength ${strengthClass}`;
                }
            }
            
            // Password confirmation
            if (input.type === 'password' && input.name === 'cpassword[]') {
                const passwordInput = input.closest('.employee-entry').querySelector('input[name="npassword[]"]');
                if (passwordInput && input.value) {
                    if (input.value === passwordInput.value) {
                        input.classList.remove('is-invalid');
                        input.classList.add('is-valid');
                    } else {
                        input.classList.remove('is-valid');
                        input.classList.add('is-invalid');
                    }
                } else {
                    input.classList.remove('is-valid', 'is-invalid');
                }
            }
        });

        // Form validation
        document.getElementById('form-info').addEventListener('submit', function(e) {
            const emails = document.querySelectorAll('input[name="email[]"]');
            const usernames = document.querySelectorAll('input[name="username[]"]');
            const phones = document.querySelectorAll('input[name="phone[]"]');
            const passwords = document.querySelectorAll('input[name="npassword[]"]');
            const confirmPasswords = document.querySelectorAll('input[name="cpassword[]"]');
            const types = document.querySelectorAll('select[name="type[]"]');
            const salaries = document.querySelectorAll('input[name="ratib[]"]');
            const errMsg = document.querySelector('.err-msg');
            
            errMsg.innerHTML = '';
            
            let isValid = true;
            let errorMessages = [];
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            const phoneRegex = /^5[0-9]{8}$/;

            // Check each employee
            emails.forEach((input, index) => {
                const email = input.value.trim();
                const username = usernames[index].value.trim();
                const phone = phones[index].value.trim();
                const password = passwords[index].value;
                const confirmPassword = confirmPasswords[index].value;
                const type = types[index].value;
                const salary = salaries[index].value;
                const employeeNum = index + 1;

                // Email validation
                if (!email) {
                    errorMessages.push(`البريد الإلكتروني مطلوب للموظف رقم ${employeeNum}`);
                    isValid = false;
                } else if (!emailRegex.test(email)) {
                    errorMessages.push(`البريد الإلكتروني غير صحيح للموظف رقم ${employeeNum}`);
                    isValid = false;
                }
                
                // Username validation
                if (!username) {
                    errorMessages.push(`اسم الموظف مطلوب للموظف رقم ${employeeNum}`);
                    isValid = false;
                } else if (username.length < 2) {
                    errorMessages.push(`اسم الموظف يجب أن يكون حرفين على الأقل للموظف رقم ${employeeNum}`);
                    isValid = false;
                }
                
                // Phone validation
                if (!phone) {
                    errorMessages.push(`رقم الجوال مطلوب للموظف رقم ${employeeNum}`);
                    isValid = false;
                } else if (!phoneRegex.test(phone)) {
                    errorMessages.push(`رقم الجوال غير صحيح للموظف رقم ${employeeNum} (يجب أن يكون 9 أرقام تبدأ بـ 5)`);
                    isValid = false;
                }
                
                // Password validation
                if (!password) {
                    errorMessages.push(`كلمة المرور مطلوبة للموظف رقم ${employeeNum}`);
                    isValid = false;
                } else if (password.length < 6) {
                    errorMessages.push(`كلمة المرور يجب أن تكون 6 أحرف على الأقل للموظف رقم ${employeeNum}`);
                    isValid = false;
                }
                
                // Password confirmation
                if (password !== confirmPassword) {
                    errorMessages.push(`كلمات المرور غير متطابقة للموظف رقم ${employeeNum}`);
                    isValid = false;
                }
                
                // Salary validation
                if (!salary) {
                    errorMessages.push(`الراتب الأساسي مطلوب للموظف رقم ${employeeNum}`);
                    isValid = false;
                } else if (parseInt(salary) < 1000) {
                    errorMessages.push(`الراتب الأساسي يجب أن يكون 1000 ريال على الأقل للموظف رقم ${employeeNum}`);
                    isValid = false;
                }
                
                // Type validation
                if (!type) {
                    errorMessages.push(`نوع الموظف مطلوب للموظف رقم ${employeeNum}`);
                    isValid = false;
                }
            });

            // Check for duplicate emails
            const emailValues = Array.from(emails).map(input => input.value.trim().toLowerCase());
            const duplicateEmails = emailValues.filter((email, index) => 
                email && emailValues.indexOf(email) !== index
            );
            
            if (duplicateEmails.length > 0) {
                errorMessages.push('يوجد بريد إلكتروني مكرر، يرجى التأكد من عدم تكرار البريد الإلكتروني');
                isValid = false;
            }

            // Check for duplicate phone numbers
            const phoneValues = Array.from(phones).map(input => input.value.trim());
            const duplicatePhones = phoneValues.filter((phone, index) => 
                phone && phoneValues.indexOf(phone) !== index
            );
            
            if (duplicatePhones.length > 0) {
                errorMessages.push('يوجد رقم جوال مكرر، يرجى التأكد من عدم تكرار رقم الجوال');
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

        // Auto-format phone number
        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('phone-input')) {
                let value = e.target.value.replace(/\D/g, ''); // Remove non-digits
                if (value.length > 9) {
                    value = value.substring(0, 9);
                }
                e.target.value = value;
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
        header('location: user-manage.php');
    }
} else {
    header('location: logout.php');
}
ob_end_flush();
?>
