<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - LEX Law Firm</title>

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

        <form >

            <div class="input-group">
                <label for="email">اسم المستخدم</label>
                <input type="text" id="userName" name="userName"  required
                    placeholder="أدخل اسم المستخدم الخاص بك " autofocus>
                {{-- <i class="fas fa-envelope input-icon user-icon"></i> --}}
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

    <!-- ملفات JavaScript -->
    <script src="js/password-toggle.js"></script>
    <script src="js/form-validation.js"></script>
    <script src="js/animations.js"></script>

    <script>
        $(document).ready(function() {
            $('.addOrder').click(function(e) {
                e.preventDefault();
                let id = $(this).attr('productCartId');

                $.ajax({
                    method: 'POST',
                    url: "/add-favorite-cart",
                    data: {
                        id: id
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'Success!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                if (response.reload) {
                                    window.location.reload();
                                }
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: response.message,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: 'Error!',
                            text: xhr.responseJSON.message || 'Something went wrong',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });

            $('.deleteOrder').click(function(e) {
                e.preventDefault();
                let id = $(this).attr('productId');
                console.log(id);

                Swal.fire({
                    title: 'warning!',
                    text: 'Do want delete this order',
                    icon: 'warning',
                    confirmButtonText: 'yes!'
                }).then(result => {
                    if (result.isConfirmed) {
                        $.ajax({
                            method: 'DELETE',
                            // url: '{{ route('login') }}',
                            url: "/favorite-delete/" + id,
                            data: {
                                id: id
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                console.log(response.data);

                                if (response.data == 1) {
                                    window.location.reload();
                                }

                            }
                        })
                    }
                })
            });


            $('.emptyWishlist').click(function(e) {
                Swal.fire({
                    title: 'warning!',
                    text: 'Do want empty Wishlist?',
                    icon: 'warning',
                    confirmButtonText: 'Yes !'
                }).then(result => {
                    if (result.isConfirmed) {
                        $.ajax({
                            method: 'get',
                            url: "/empty-wishlist",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                if (response.data == 1) {
                                    window.location.reload();
                                }
                            }
                        })
                    }
                })
            });

        });
    </script>
</body>

</html>
