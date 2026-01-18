<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - LEX Law Firm</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500&family=Tajawal:wght@400;500&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">

    <style>
        .input-group {
            position: relative;
        }

        .btn.loading {
            opacity: 0.7;
            pointer-events: none;
        }
    </style>
</head>

<body>
    <div class="login-box">
        <div class="logo-container">
            <img src="{{ asset('images/logo2.jpeg') }}" alt="LEX Law Firm Logo" onerror="this.style.display='none'">
        </div>
        <h2>تسجيل الدخول</h2>
        @if ($errors->any())
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                {{ $errors->first() }}
            </div>
        @endif
        @if (session('status'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('status') }}
            </div>
        @endif
        <form action="{{ route('admin.login') }}" method="POST" id="loginForm">
            @csrf
            <div class="input-group">
                <label for="userName">اسم المستخدم</label>
                <input type="text" id="userName" name="userName" required placeholder="أدخل اسم المستخدم الخاص بك"
                    autofocus>
            </div>
            <div class="input-group">
                <label for="password">كلمة المرور</label> <!-- ✅ تم التصحيح -->
                <input type="password" id="password" name="password" required placeholder="أدخل كلمة المرور">
                <i class="fas fa-eye toggle-password" id="togglePassword"></i>
            </div>
            <button type="submit" class="btn" id="loginBtn">
                <span id="btnText" style="color: white">تسجيل الدخول</span>
                <div id="btnLoader" style="display: none;">
                    <i class="fas fa-spinner fa-spin"></i> جاري التحقق...
                </div>
            </button>
        </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const password = document.getElementById('password');

            if (togglePassword && password) {
                togglePassword.addEventListener('click', function() {
                    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                    password.setAttribute('type', type);
                    this.classList.toggle('fa-eye');
                    this.classList.toggle('fa-eye-slash');
                });
            };
            const loginBtn = document.getElementById('loginBtn');
            const btnText = document.getElementById('btnText');
            const btnLoader = document.getElementById('btnLoader');

            if (loginForm && loginBtn) {
                loginForm.addEventListener('submit', function() {
                    // إظهار حالة التحميل
                    btnText.style.display = 'none';
                    btnLoader.style.display = 'block';
                    loginBtn.classList.add('loading');

                    // منع إعادة الإرسال المتعددة
                    loginBtn.disabled = true;
                });
            }

            // إعادة تمكين الزر إذا كان هناك خطأ في التحقق
            const inputs = document.querySelectorAll('input[required]');
            inputs.forEach(input => {
                input.addEventListener('invalid', function() {
                    setTimeout(() => {
                        btnText.style.display = 'block';
                        btnLoader.style.display = 'none';
                        loginBtn.classList.remove('loading');
                        loginBtn.disabled = false;
                    }, 100);
                });
            });
        });
    </script>
</body>

</html>
