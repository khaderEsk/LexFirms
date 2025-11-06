<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'لوحة التحكم')</title>

    <style>
        body {
            margin: 0;
            font-family: "Tajawal", sans-serif;
            background-color: #f5f6fa;
            overflow-x: hidden;
        }

        .main-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background: #0e2b26;
            color: #d4af37;
            flex-shrink: 0;
            position: fixed;
            right: 0;
            top: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px 0;
            transition: transform 0.3s ease;
        }

        .sidebar.hidden {
            transform: translateX(100%);
        }

        .sidebar .logo img {
            width: 120px;
            margin-bottom: 20px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            width: 100%;
        }

        .sidebar li a {
            display: block;
            padding: 15px 25px;
            color: #d4af37;
            text-decoration: none;
            font-size: 15px;
            transition: 0.3s;
        }

        .sidebar li a:hover,
        .sidebar li a.active {
            background: #1a1a1a;
            color: #fff;
            border-right: 4px solid #d4af37;
        }

        /* Header */
        header {
            background: white;
            color: #d4af37;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            position: sticky;
            top: 0;
            z-index: 100;
            direction: ltr
        }

        header .menu-btn {
            display: none;
            font-size: 20px;
            cursor: pointer;
            background: none;
            border: none;
            color: #d4af37;
        }

        /* Content Area */
        .content-area {
            flex: 1;
            margin-right: 250px;
            display: flex;
            flex-direction: column;
            transition: margin-right 0.3s ease;
        }

        main {
            flex: 1;
            padding: 20px;
            background: #ffffffdd;
        }
        .content {
            background-color: #0e2b26;
        }

        footer {
            background: #0e2b26e9;
            color: #d4af37;
            text-align: center;
            /* padding: 2fpx; */
            font-size: 12px;
        }

        /* 📱 للشاشات الصغيرة */
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                height: 100%;
                top: 0;
                right: 0;
                transform: translateX(100%);
                z-index: 200;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .content-area {
                margin-right: 0;
            }

            header .menu-btn {
                display: block;
            }
        }
    </style>
</head>

<body>

    <div class="main-wrapper">
        {{-- Sidebar --}}
        @include('layouts.sidebar')

        <div class="content-area">
            {{-- Header --}}
            @include('layouts.header')

            {{-- Main Content --}}
            <main>
                @yield('content')
            </main>

            {{-- Footer --}}
            @include('layouts.footer')
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const sidebar = document.querySelector('.sidebar');
            const openBtn = document.querySelector('.menu-btn');
            const closeBtn = document.querySelector('.close-btn');

            // فتح السايد بار
            openBtn.addEventListener('click', () => {
                sidebar.classList.add('active');
            });

            // إغلاق السايد بار
            closeBtn.addEventListener('click', () => {
                sidebar.classList.remove('active');
            });

            // عند الضغط خارج السايد بار يُغلق تلقائيًا
            document.addEventListener('click', (e) => {
                if (window.innerWidth <= 768 && sidebar.classList.contains('active')) {
                    if (!sidebar.contains(e.target) && !openBtn.contains(e.target)) {
                        sidebar.classList.remove('active');
                    }
                }
            });
        });
    </script>


    @stack('scripts')
</body>

</html>
