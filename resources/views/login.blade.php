<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - LEX Law Firm</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- الخطوط -->
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500&family=Tajawal:wght@400;500&display=swap"
        rel="stylesheet">
    <!-- أيقونات -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- ملفات CSS -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
</head>

<body>
    <div class="login-box">
        <div class="logo-container">
            <img src="{{ asset('images/logo2.jpeg') }}" alt="LEX Law Firm Logo" onerror="this.style.display='none'">
        </div>

        <h2>تسجيل الدخول</h2>

        <!-- رسائل الخطأ -->


        <form>
            <div class="input-group">
                <label for="email">اسم المستخدم</label>
                <input type="text" id="userName" name="userName" required placeholder="أدخل اسم المستخدم الخاص بك "
                    autofocus>
            </div>

            <div class="input-group">
                <label for="password">كلمة المرور</label>
                <input type="password" id="password" name="password" required placeholder="أدخل كلمة المرور">

                <i class="fas fa-eye toggle-password" id="togglePassword"></i>
            </div>


            <button type="submit" class="btn" id="loginBtn">
                <span id="btnText" style="color: white">تسجيل الدخول</span>
                <div id="btn" style="display: none;">
                    <i class="fas fa-spinner fa-spin"></i> جاري التحقق...
                </div>
            </button>
        </form>
    </div>

    <script src="js/password-toggle.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#loginBtn').click(function(e) {
                e.preventDefault();
                let userName = $('#userName').val();
                let password = $('#password').val();
                if (password == '' || userName == '') {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please enter userName and password',
                        icon: 'error',
                        confirmButtonText: 'Ok!'
                    })
                } else {
                    $.ajax({
                        method: 'post',
                        url: "/login",
                        data: {
                            userName: userName,
                            password: password,

                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.data == 1) {
                                window.location.href = '/causes-day'
                            } else if (response.data == 0) {
                                alert("كلمة السر او اسم المستخدم غير صحيح");
                            }
                        }
                    })
                }
            });
        });
    </script>
</body>

</html>
