<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>قضايا الموكلين</title>

    <style>
        .tabs {
            max-width: 1000px;
            margin: auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        /* شريط التبويبات */
        .tab-buttons {
            display: flex;
            background: #e9eef3;
            border-bottom: 2px solid #ddd;
        }

        .tab-buttons button {
            flex: 1;
            padding: 15px;
            border: none;
            background: transparent;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        .tab-buttons button.active {
            background: #007bff;
            color: white;
        }

        /* محتوى التبويبات */
        .tab-content {
            display: none;
            padding: 20px;
            animation: fadeIn 0.4s ease-in-out;
        }

        .tab-content.active {
            display: block;
        }

        /* شبكة الكروت */
        .grid {
            display: grid;
            gap: 20px;
        }

        @media (min-width: 992px) {
            .grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (min-width: 768px) and (max-width: 991px) {
            .grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 767px) {
            .grid {
                grid-template-columns: 1fr;
            }
        }

        /* تصميم الكارت */
        .card {
            background: #f9fafb;
            border-radius: 12px;
            padding: 20px;
            border: 1px solid #ddd;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            transition: 0.3s;
        }

        .card:hover {
            background: #eef5ff;
            transform: translateY(-3px);
        }

        .card h3 {
            color: #007bff;
            margin-bottom: 8px;
            font-size: 18px;
        }

        .card p {
            color: #333;
            margin: 5px 0;
            font-size: 15px;
        }

        /* شريط الحالة */
        .progress {
            background-color: #e4e8ed;
            border-radius: 10px;
            overflow: hidden;
            height: 12px;
            margin-top: 10px;
        }

        .progress-bar {
            height: 100%;
            background-color: #007bff;
            transition: width 0.4s ease;
        }

        .status-text {
            text-align: left;
            font-size: 13px;
            color: #444;
            margin-top: 4px;
        }

        @keyframes fadeIn {
            from {opacity: 0;}
            to {opacity: 1;}
        }
    </style>
</head>
<body>

<div class="tabs">
    <!-- أزرار التبويبات -->
    <div class="tab-buttons">
        <button class="active" onclick="openTab(event, 'tab1')">القضايا الجارية</button>
        <button onclick="openTab(event, 'tab2')">القضايا المغلقة</button>
        <button onclick="openTab(event, 'tab3')">القضايا المؤجلة</button>
    </div>

    <!-- تبويب 1 -->
    <div id="tab1" class="tab-content active">
        <div class="grid">
            <div class="card">
                <h3>القضية #1234</h3>
                <p><strong>رقم الأساس:</strong> 2025/01</p>
                <p><strong>الموكل:</strong> محمد العتيبي</p>
                <div class="progress"><div class="progress-bar" style="width: 70%;"></div></div>
                <div class="status-text">نسبة التقدم: 70%</div>
            </div>

            <div class="card">
                <h3>القضية #1235</h3>
                <p><strong>رقم الأساس:</strong> 2025/02</p>
                <p><strong>الموكل:</strong> أحمد المطيري</p>
                <div class="progress"><div class="progress-bar" style="width: 40%; background-color: #ffc107;"></div></div>
                <div class="status-text">نسبة التقدم: 40%</div>
            </div>

            <div class="card">
                <h3>القضية #1236</h3>
                <p><strong>رقم الأساس:</strong> 2025/03</p>
                <p><strong>الموكل:</strong> سارة الحربي</p>
                <div class="progress"><div class="progress-bar" style="width: 90%; background-color: #28a745;"></div></div>
                <div class="status-text">نسبة التقدم: 90%</div>
            </div>
        </div>
    </div>

    <!-- تبويب 2 -->
    <div id="tab2" class="tab-content">
        <div class="grid">
            <div class="card">
                <h3>القضية #1100</h3>
                <p><strong>رقم الأساس:</strong> 2024/09</p>
                <p><strong>الموكل:</strong> ناصر العبدالله</p>
                <div class="progress"><div class="progress-bar" style="width: 100%; background-color: #28a745;"></div></div>
                <div class="status-text">مغلقة (100%)</div>
            </div>
            <div class="card">
                <h3>القضية #1101</h3>
                <p><strong>رقم الأساس:</strong> 2024/10</p>
                <p><strong>الموكل:</strong> فاطمة القحطاني</p>
                <div class="progress"><div class="progress-bar" style="width: 100%; background-color: #28a745;"></div></div>
                <div class="status-text">مغلقة (100%)</div>
            </div>
            <div class="card">
                <h3>القضية #1102</h3>
                <p><strong>رقم الأساس:</strong> 2024/11</p>
                <p><strong>الموكل:</strong> خالد الحربي</p>
                <div class="progress"><div class="progress-bar" style="width: 100%; background-color: #28a745;"></div></div>
                <div class="status-text">مغلقة (100%)</div>
            </div>
        </div>
    </div>

    <!-- تبويب 3 -->
    <div id="tab3" class="tab-content">
        <div class="grid">
            <div class="card">
                <h3>القضية #1300</h3>
                <p><strong>رقم الأساس:</strong> 2025/05</p>
                <p><strong>الموكل:</strong> ليلى العبدالكريم</p>
                <div class="progress"><div class="progress-bar" style="width: 20%; background-color: #dc3545;"></div></div>
                <div class="status-text">مؤجلة (20%)</div>
            </div>
            <div class="card">
                <h3>القضية #1301</h3>
                <p><strong>رقم الأساس:</strong> 2025/06</p>
                <p><strong>الموكل:</strong> علي السبيعي</p>
                <div class="progress"><div class="progress-bar" style="width: 10%; background-color: #dc3545;"></div></div>
                <div class="status-text">مؤجلة (10%)</div>
            </div>
            <div class="card">
                <h3>القضية #1302</h3>
                <p><strong>رقم الأساس:</strong> 2025/07</p>
                <p><strong>الموكل:</strong> ريم الشمري</p>
                <div class="progress"><div class="progress-bar" style="width: 35%; background-color: #ffc107;"></div></div>
                <div class="status-text">قيد المتابعة (35%)</div>
            </div>
        </div>
    </div>
</div>

<script>
    function openTab(evt, tabId) {
        document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
        document.querySelectorAll('.tab-buttons button').forEach(btn => btn.classList.remove('active'));

        document.getElementById(tabId).classList.add('active');
        evt.currentTarget.classList.add('active');
    }
</script>

</body>
</html>
