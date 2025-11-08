@extends('layouts.app')
@section('title', 'الصفحة الرئيسية')
@section('content')
    <div>
        <div class="tab-buttons">
            <h1>القضايا اليومية</h1>
        </div>
        <div id="tab1" class="tab-content active">
            <div class="grid" id="">
                @foreach ($causes as $cause)
                    <div class="card">
                        <h3>القضية #{{ $cause->type }}</h3>
                        <p>
                            <strong>رقم الأساس:</strong>
                            @if ($cause->type == "LS")
                                2025/01
                            @else
                                _____
                            @endif
                        </p>
                        <p><strong>الموكل:</strong>{{ $cause->nameClient }}</p>
                        <p>
                            <strong>المحكمة:</strong>
                             @if ($cause->type == "LS")
                                
                            @else
                                _____
                            @endif
                        </p>
                        <div class="progress">
                            <div class="progress-bar" style="width: 70%;"></div>
                        </div>
                        <div class="status-text">نسبة التقدم: 70%</div>
                    </div>
                @endforeach
                <div class="card">
                    <h3>القضية #1235</h3>
                    <p><strong>رقم الأساس:</strong> 2025/02</p>
                    <p><strong>الموكل:</strong> أحمد المطيري</p>
                    <div class="progress">
                        <div class="progress-bar" style="width: 40%; background-color: #ffc107;"></div>
                    </div>
                    <div class="status-text">نسبة التقدم: 40%</div>
                </div>

                <div class="card">
                    <h3>القضية #1236</h3>
                    <p><strong>رقم الأساس:</strong> 2025/03</p>
                    <p><strong>الموكل:</strong> سارة الحربي</p>
                    <div class="progress">
                        <div class="progress-bar" style="width: 90%; background-color: #28a745;"></div>
                    </div>
                    <div class="status-text">نسبة التقدم: 90%</div>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    .tabs {
        max-width: 1000px;
        margin: auto;
        background: #0e2b2664;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
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
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }
</style>
