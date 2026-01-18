@extends('layouts.app')
@section('title', 'القضايا ')
@section('content')
    <div class="container">
        <div class="top-actions">
            @unlessrole('lawyer')
                <a href="{{ route('case.create') }}" class="add-lawyer-btn">
                    فتح قضية جديدة +
                </a>
            @endunlessrole
        </div>

        <div class="search-box">
            <input type="search" id="caseSearch" placeholder="🔍 ابحث عن قضية بالاسم صاحب الدعوة أو رقم الأساس ">
        </div>
        <div class="cases-grid">
            @foreach ($cases as $case)
                @php
                    if ($case->progress <= 33) {
                        $progressColor = '#ff4d4f'; // أحمر
                    } elseif ($case->progress <= 66) {
                        $progressColor = '#faad14'; // أصفر
                    } else {
                        $progressColor = '#52c41a'; // أخضر
                    }
                @endphp
                <a href="{{ route('cases.show', $case->id) }}" class="case-link">
                    <div class="case-item case-{{ strtolower($case->case_type) }}"
                        data-base-number="{{ $case->base_number }}" data-name="{{ $case->client->name }}">
                        <div class="info">
                            <span class="case-number">قضية :
                                <span class="type-{{ strtolower($case->case_type) }}">
                                    {{ $case->name_case }}/ {{ $case->client->name }} -
                                    {{ $case->second_party_name }}
                                </span>
                            </span>
                            <span class="type type-{{ strtolower($case->case_type) }}">
                                {{ strtoupper($case->case_type) }}
                            </span>
                        </div>
                        <div class="subject">{{ $case->status }}</div>
                        <div class="owner">صاحب الدعوى: {{ $case->client->name }}</div>

                        <div class="status-container">
                            <div class="status-label">نسبة تقدم القضية: {{ $case->progress }}%</div>
                            <div class="progress-bar">
                                <div class="progress-fill"
                                    style="width: {{ $case->progress }}%; background-color: {{ $progressColor }};"></div>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endsection

<style>
    .case-link {
        text-decoration: none;
        color: inherit;
    }

    /* الحاوية الرئيسية */
    .container {
        width: 95%;
        max-width: 1200px;
        margin: 30px auto;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* شبكة القضايا */
    .cases-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        /* ثلاث بطاقات في الصف */
        gap: 20px;
    }

    /* البطاقة */
    .case-item {
        background: #fff;
        padding: 18px 22px;
        border-radius: 12px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        display: flex;
        flex-direction: column;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .case-item:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    .case-ح {
        border-left: 6px solid green;
    }

    .case-ش {
        border-left: 6px solid blue;
    }

    .case-د {
        border-left: 6px solid orange;
    }

    /* معلومات البطاقة */
    .info {
        display: flex;
        justify-content: space-between;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 8px;
        color: #333;
    }

    .case-number {
        color: #222;
    }

    .type {
        background: #e6f0ff;
        padding: 3px 10px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: bold;
    }

    .type-ح {
        color: green;
    }

    .type-ش {
        color: blue;
    }

    .type-د {
        color: orange;
    }

    .subject {
        font-size: 15px;
        color: #444;
        margin-bottom: 6px;
        font-weight: 500;
    }

    .owner,
    .lawyer {
        font-size: 13px;
        color: #555;
        margin-top: 2px;
    }

    /* شريط التقدم */
    .status-container {
        margin-top: 10px;
    }

    .status-label {
        font-size: 13px;
        color: #333;
        margin-bottom: 4px;
    }

    .progress-bar {
        width: 100%;
        height: 14px;
        background: #e0e0e0;
        border-radius: 10px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        border-radius: 10px;
        transition: width 0.4s ease;
    }

    /* تجاوب مع الشاشات المتوسطة */
    @media(max-width: 992px) {
        .cases-grid {
            grid-template-columns: repeat(2, 1fr);
            /* عمودين في الصف */
        }
    }

    /* تجاوب مع الشاشات الصغيرة */
    @media(max-width: 600px) {
        .cases-grid {
            grid-template-columns: 1fr;
            /* عمود واحد في الصف */
        }

        .info {
            flex-direction: column;
            gap: 4px;
        }
    }

    .search-box {
        width: 100%;
        margin: 20px auto;
        display: flex;
        justify-content: center;
    }

    .search-box input {
        width: 100%;
        max-width: 700px;
        padding: 20px 15px;
        border-radius: 25px;
        border: 1px solid #ddd;
        font-size: 16px;
        outline: none;
        transition: 0.3s;
    }

    .search-box input:focus {
        border-color: #3498db;
        box-shadow: 0 0 5px rgba(52, 152, 219, 0.3);
    }

    /* شاشات صغيرة */
    @media (max-width: 600px) {
        .search-box input {
            max-width: 100%;
            font-size: 14px;
        }
    }
</style>
@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('caseSearch').addEventListener('keyup', function() {
                let searchValue = this.value.toLowerCase();
                let cards = document.querySelectorAll('.case-item');

                cards.forEach(card => {
                    let baseNumber = (card.dataset.baseNumber ?? '').toLowerCase();
                    let name = (card.dataset.name ?? '').toLowerCase();

                    card.style.display =
                        baseNumber.includes(searchValue) || name.includes(searchValue) ?
                        'block' :
                        'none';
                });
            });
        });
    </script>
@endsection
