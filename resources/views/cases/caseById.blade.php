@extends('layouts.app')

@section('title', 'تفاصيل القضية رقم ')

@section('content')
    <div class="case-details">

        <div class="case-header">
            <h2>القضية رقم:</h2>
            <span class="status-badge">
                status

            </span>
        </div>

        <div class="case-info-grid">
            <div class="info-box">
                <h4>رقم الأساس</h4>
                <p>1234</p>
            </div>

            <div class="info-box">
                <h4>اسم الموكل</h4>
                <p>موكل</p>
            </div>

            <div class="info-box">
                <h4>المحامي المسؤول</h4>
                <p>محامين</p>
            </div>

            <div class="info-box">
                <h4>تاريخ التسجيل</h4>
                <p>20/02/2025</p>
            </div>

            <div class="info-box">
                <h4>المحكمة</h4>
                <p>المحكمة</p>
            </div>

            <div class="info-box">
                <h4>آخر تحديث</h4>
                <p>15/02/2525</p>
            </div>
        </div>

        <div class="case-progress">
            <h4>نسبة التقدم</h4>
            <div class="progress-bar">
                <div class="progress" style="width: 30%;"></div>
            </div>
            <span>30%</span>
        </div>

        <div class="case-description">
            <h4>تفاصيل القضية</h4>
            <p>تفاصيل القضية </p>
        </div>

    </div>

    <style>
        .case-details {
            background: #fff;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            color: #333;
            direction: rtl;
        }

        .case-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #d4af37;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .status-badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 14px;
            color: #fff;
        }

        .status-badge.active {
            background: #28a745;
        }

        .status-badge.closed {
            background: #dc3545;
        }

        .status-badge.pending {
            background: #ffc107;
            color: #000;
        }

        .case-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 15px;
        }

        .info-box {
            background: #f9f9f9;
            border-right: 3px solid #d4af37;
            padding: 15px;
            border-radius: 8px;
        }

        .info-box h4 {
            color: #0f0f0f;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .case-progress {
            margin: 25px 0;
        }

        .progress-bar {
            background: #eaeaea;
            border-radius: 20px;
            height: 10px;
            overflow: hidden;
            margin-top: 5px;
        }

        .progress {
            height: 100%;
            background: linear-gradient(90deg, #d4af37, #b88a25);
            border-radius: 20px;
        }

        .case-description {
            margin-top: 25px;
        }

        .case-description h4 {
            color: #0f0f0f;
            border-bottom: 2px solid #d4af37;
            display: inline-block;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }

        @media (max-width: 768px) {
            .case-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .info-box {
                text-align: right;
            }

            .case-details {
                padding: 15px;
            }
        }
    </style>
@endsection
