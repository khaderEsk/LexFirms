@extends('layouts.app')
@section('title', 'تفاصيل القضية')

@section('content')
    <div class="case-details-container">
        @php
            $remaining = $case->remaining_balance_of_expenditure;
            $half = $case->syrian_prices / 2;
        @endphp
        <div class="case-header">
            <h2> تفاصيل القضية # <span style="color: #dc3545">{{ $case->name_case }} </span></h2>
            <div class="case-actions">
                <button class="btn btnColor add-file-btn" onclick="openExpensModal()">
                    ➕ إضافة صرفية
                </button>

                @role('superAdmin|adminLawyer')
                    <a href="{{ route('case.edit', $case->id) }}" class="action-btn">
                        تعديل تفاصيل القضية
                    </a>
                @endrole
                @role('superAdmin')
                    <a href="{{ route('expense.show', $case->id) }}" class="action-btn danger">
                        عرض صرفيات القضية
                    </a>
                    <button class="btn btnColor add-file-btn" onclick="openPaymentModal()">
                        ➕ إضافة تكلفة القضية
                    </button>
                @endrole
            </div>
            <div class="case-meta">
                <span><strong>النوع:</strong> {{ strtoupper($case->case_type) }}</span>
                <span>
                    <a href="{{ route('client.show', $case->client->id) }}">
                        <strong>موكل :</strong> {{ $case->client->name }}
                    </a>
                </span>
                <span><strong>رقم الاساس: </strong> {{ $case->base_number }}</span>
                <br>
                <span><strong>المحكمة: </strong> {{ $case->court }}</span>
                <span><strong> الدائرة: </strong> {{ $case->department }}</span>
                @role('superAdmin')
                    <span style="font-weight: bolder;color: {{ $remaining < $half ? '#d32f2f' : '#2e7d32' }};">
                        <strong> الكلفة المتبقية: </strong>
                        {{ number_format($case->remaining_balance_of_expenditure, 0) }} ل.س
                    </span>
                @endrole
            </div>
            <div class="subject"> <strong>الموضوع:</strong> {{ $case->subject }}
            </div>

            <div class="section">
                @php
                    if ($case->progress <= 33) {
                        $progressColor = '#ef4444';
                    } elseif ($case->progress <= 66) {
                        $progressColor = '#f59e0b';
                    } else {
                        $progressColor = '#22c55e';
                    }
                @endphp

                <div class="section files-section">
                    <div class="section-header files-header">
                        <a class="files-title" href="{{ route('case.report.index', $case->client->id) }}">
                            📎 عرض التقدم
                            <span style="color: {{ $progressColor }}">

                                {{ $case->progress }}%
                            </span>
                        </a>
                        @if ($case->progress < 100)
                            <button class="btn btnColor add-file-btn" onclick="openProgressModal()">
                                ➕ إضافة تقدم
                            </button>
                        @else
                            <button class="btn btn-success" disabled>
                                ✔ مكتملة 100%
                            </button>
                        @endif
                    </div>
                </div>


                <div class="section files-section">
                    <div class="section-header files-header">
                        <a class="files-title" href="{{ route('case.files.index', $case->client->id) }}">
                            📎 عرض الملفات
                        </a>

                        <button class="btn btnColor add-file-btn" onclick="openFileModal()">
                            ➕ إضافة ملف
                        </button>
                    </div>
                </div>

                <div class="section files-section">
                    <div class="section-header files-header">
                        <a class="files-title" href="{{ route('case.stages.index', $case->client->id) }}">
                            📎 عرض الخطوات
                        </a>

                        <button class="btn btnColor add-file-btn" onclick="openNoteModal()">
                            ➕ إضافة خطوة
                        </button>
                    </div>
                </div>

            </div>
            <div class="modal-overlay" id="fileModal">
                <div class="modal">
                    <div class="modal-header">
                        <h3>إضافة ملف جديدة</h3>
                        <span class="close-btn" onclick="closeFileModal()">✖</span>
                    </div>
                    <form method="POST" action="{{ route('file.case.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="legal_case_id" value="{{ $case->id }}">
                        <div class="form-group">
                            <label>📎 اختر الملف</label>
                            <input type="file" name="file" required>
                        </div>
                        <div class="modal-actions">
                            <button type="submit" class="btn btnColor">📎 حفظ الملف</button>
                            <button type="button" class="btn cancel" onclick="closeFileModal()">إلغاء</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="modal-overlay" id="noteModal">
                <div class="modal">
                    <div class="modal-header">
                        <h3>إضافة خطوة جديدة</h3>
                        <span class="close-btn" onclick="closeNoteModal()">✖</span>
                    </div>
                    <form method="POST" action="{{ route('stage.case.store') }}">
                        @csrf

                        <h3>⚖️ المحامون المسؤولون عن المهمة</h3>
                        <br>
                        <div class="form-group">
                            <div class="lawyers-grid">
                                @foreach ($lawyers as $lawyer)
                                    <label class="lawyer-card">
                                        <input type="checkbox" name="lawyer_ids[]" value="{{ $lawyer->id }}">
                                        <div class="lawyer-info">
                                            <span class="lawyer-name">{{ $lawyer->fullName }}</span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        <input type="hidden" name="legal_case_id" value="{{ $case->id }}">>
                        <div class="form-group">
                            <label>📌 وصف الخطوة</label>
                            <textarea name="subject" rows="3" placeholder="ادخل وصف الخطوة الذي قمت بها" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>📝 ملاحظة للتذكير </label>
                            <textarea name="note" rows="3" placeholder="ادخل الخطوة التالية "></textarea>
                        </div>
                        <div class="form-group">
                            <label>📅 تاريخ التذكير</label>
                            <input type="date" name="date">
                        </div>
                        <div class="modal-actions">
                            <button type="submit" class="btn btnColor">📝 حفظ المرحلة</button>
                            <button type="button" class="btn cancel" onclick="closeNoteModal()">إلغاء</button>
                        </div>
                    </form>

                </div>
            </div>

            <div class="modal-overlay" id="progressModal">
                <div class="modal">
                    <div class="modal-header">
                        <h3>تقدم جديدة</h3>
                        <span class="close-btn" onclick="closeProgressModal()">✖</span>
                    </div>
                    <form action="{{ route('case.progress.increase') }}" method="POST">
                        @csrf
                        <input type="hidden" name="legal_case_id" value="{{ $case->id }}">
                        <div class="form-group">
                            <label>📌 التقرير</label>
                            <textarea name="description" rows="3" placeholder="ادخل وصف التقرير" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>نسبة التقدم</label>
                            <input type="number" name="progress">
                        </div>
                        <div class="modal-actions">
                            <button type="submit" class="btn btnColor">📝 حفظ التقرير</button>
                            <button type="button" class="btn cancel" onclick="closProgressModal()">إلغاء</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="modal-overlay" id="expensModal">
                <div class="modal">
                    <div class="modal-header">
                        <h3>تقدم صرفية جديدة</h3>
                        <span class="close-btn" onclick="closeExpensModal()">✖</span>
                    </div>
                    <form method="POST" action="{{ route('expense.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="legal_case_id" value="{{ $case->id }}">
                        <div class="form-group">
                            <label>📌 سبب الصرف </label>
                            <textarea name="description" rows="3" placeholder="ادخل وصف الصرفية الذي قمت بها" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>💵 القيمة </label>
                            <input type="number" name="amount" placeholder="ادخل قيمة الصرف" required step="0.01"
                                min="0" style="text-align: right; font-weight: bold; font-size:16px;">
                        </div>
                        <div class="modal-actions">
                            <button type="submit" class="btn btnColor">📎 حفظ الصرف</button>
                            <button type="button" class="btn cancel" onclick="closeExpensModal()">إلغاء</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="modal-overlay" id="paymentModal">
                <div class="modal">
                    <div class="modal-header">
                        <h3>تحديث تكاليف القضية</h3>
                        <span class="close-btn" onclick="closePaymentModal()">✖</span>
                    </div>
                    <form method="POST" action="{{ route('price.case.updated', $case->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="legal_case_id" value="{{ $case->id }}">
                        <div class="form-group">
                            <label>💵 القيمة </label>
                            <input type="number" name="dollar_price" placeholder="ادخل التكلفة بالدولار" required
                                step="0.01" min="0"
                                style="text-align: right; font-weight: bold; font-size:16px;">
                        </div>
                        <div class="form-group">
                            <label>💵 قيمة الصرف </label>
                            <input type="number" name="exchange_rate" placeholder="ادخل قيمة الصرف" required
                                step="0.01" min="0"
                                style="text-align: right; font-weight: bold; font-size:16px;">
                        </div>
                        <div class="modal-actions">
                            <button type="submit" class="btn btnColor">📎 تحديث السعر</button>
                            <button type="button" class="btn cancel" onclick="closePaymentModal()">إلغاء</button>
                        </div>
                    </form>
                </div>
            </div>

        @endsection
        <style>
            /* ====== Files Section ====== */
            .files-section {
                margin-top: 20px;
            }

            .files-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 12px;
                padding: 14px 18px;
                background: #e3e8ed;
                border-radius: 12px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
                flex-wrap: wrap;
            }

            .subject {
                padding: 20px;
                background: #e3e8ed;
                border-radius: 12px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            }

            /* عنوان الملفات */
            .files-title {
                font-size: 18px;
                font-weight: 600;
                color: #1f2937;
                display: flex;
                align-items: center;
                gap: 6px;
            }

            .files-count {
                color: #6b7280;
                font-size: 15px;
            }

            /* زر إضافة ملف */
            .add-file-btn {
                padding: 8px 16px;
                font-size: 14px;
                border-radius: 999px;
                white-space: nowrap;
            }

            /* ====== Responsive (Mobile) ====== */
            @media (max-width: 768px) {
                .files-header {
                    flex-direction: column;
                    align-items: stretch;
                    text-align: center;
                }

                .files-title {
                    justify-content: center;
                    font-size: 17px;
                }

                .add-file-btn {
                    width: 100%;
                    justify-content: center;
                    font-size: 15px;
                }
            }



            body {
                background: #f4f6f9;
            }

            .case-details-container {
                width: 95%;
                max-width: 1100px;
                margin: 20px auto;
                background: #fff;
                padding: 20px;
                border-radius: 16px;
                box-shadow: 0 8px 25px rgba(0, 0, 0, .08);
            }

            .case-header h2 {
                text-align: center;
                margin-bottom: 15px;
            }

            .case-meta {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
                gap: 10px;
                background: #f9fafb;
                padding: 15px;
                border-radius: 12px;
            }

            .case-meta span {
                background: #fff;
                padding: 10px;
                border-radius: 8px;
                border: 1px solid#434141;
                font-size: 14px;
            }

            .progress-section {
                margin-top: 20px;
            }

            .progress-bar {
                height: 14px;
                background: #e5e7eb;
                border-radius: 10px;
                overflow: hidden;
            }

            .progress-fill {
                height: 14px;
                border-radius: 10px;
            }

            .actions {
                margin: 25px 0;
                display: flex;
                gap: 10px;
                flex-wrap: wrap;
                justify-content: center;
            }

            .btn {
                padding: 10px 16px;
                border-radius: 10px;
                text-decoration: none;
                font-weight: bold;
            }

            .btn.primary {
                background: linear-gradient(135deg, #2563eb, #1d4ed8);
                color: #fff;
            }

            .toggle-icon {
                color: #2563eb;
                padding: 4px 8px;
                border-radius: 50%;
            }

            .edit-btn {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 10px 20px;
                border-radius: 10px;
                font-size: 14px;
                font-weight: 500;
                text-decoration: none;
                transition: all 0.3s;
                border: none;
                cursor: pointer;
                background: #0e2b26e8;
                color: #fff;
                font-weight: bold;
            }

            .btnColor {
                background-color: #0e2b26e8;
                color: white
            }

            .list {
                list-style: none;
                padding: 0;
            }

            .list li {
                background: #e6e1e1;
                padding: 12px;
                border-radius: 8px;
                border: 1px solid #e5e7eb;
                margin-bottom: 10px;
            }

            .date {
                display: block;
                font-size: 12px;
                color: #6b7280;
                margin-top: 6px;
            }

            .empty {
                text-align: center;
                color: #6b7280;
                font-style: italic;
            }

            /* ===== Modal ===== */
            .modal-overlay {
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, 0.45);
                display: none;
                justify-content: center;
                align-items: center;
                z-index: 999;
            }

            .modal {
                background: #ffffff;
                width: 65%;
                border-radius: 14px;
                padding: 20px;
                animation: slideDown .3s ease;
                font-weight: bold;
            }

            .modal-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 15px;
            }

            .modal-header h3 {
                margin: 0;
                font-size: 18px;
            }

            .close-btn {
                cursor: pointer;
                font-size: 18px;
                color: #ef4444;
            }

            .form-group {
                margin-bottom: 14px;
            }

            .form-group label {
                display: block;
                font-size: 14px;
                margin-bottom: 6px;
                color: #374151;
                width: 75px;
            }

            .form-group input,
            .form-group textarea {
                width: 100%;
                padding: 9px;
                border-radius: 8px;
                border: 1px solid #d1d5db;
                font-size: 20px;
            }

            .form-group input:focus,
            .form-group textarea:focus {
                outline: none;
                border-color: #2563eb;
            }

            .modal-actions {
                display: flex;
                gap: 10px;
                margin-top: 15px;
            }

            .btn.cancel {
                background: #e5e7eb;
                color: #374151;
            }

            .toggle-switch {
                position: relative;
                display: inline-block;
                width: 55px;
                height: 17px;
                top: -11px;
            }

            .toggle-switch input {
                opacity: 0;
                width: 0;
                height: 0;
            }

            .slider {
                position: absolute;
                cursor: pointer;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: #dc3545;
                transition: 0.4s;
                border-radius: 34px;
            }

            .slider:before {
                position: absolute;
                content: "";
                height: 11px;
                width: 11px;
                left: 3px;
                bottom: 3px;
                background-color: white;
                transition: 0.4s;
                border-radius: 50%;
            }

            input:checked+.slider {
                background-color: #28a745;
            }

            input:checked+.slider:before {
                transform: translateX(35px);
            }

            /* Disabled */
            input:disabled+.slider {
                cursor: not-allowed;
                opacity: 0.6;
            }

            .stage-card {
                background: #ffffff;
                border-radius: 16px;
                padding: 16px;
                border: 1px solid #e5e7eb;
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
                display: flex;
                flex-direction: column;
                gap: 14px;
            }

            /* Top */
            .stage-top {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                gap: 10px;
            }

            .stage-subject {
                font-weight: bold;
                color: #1f2937;
                font-size: 15px;
            }

            .stage-created {
                font-size: 12px;
                color: #6b7280;
                white-space: nowrap;
            }

            /* Note */
            .stage-note {
                background: #f9fafb;
                padding: 12px;
                border-radius: 12px;
                font-size: 14px;
                color: #374151;
                line-height: 1.7;
                border-right: 4px solid #2563eb;
            }

            /* Info */
            .stage-info {
                display: flex;
                flex-wrap: wrap;
                gap: 12px;
            }

            .info-item {
                background: #f3f4f6;
                padding: 8px 12px;
                border-radius: 10px;
                font-size: 13px;
                color: #374151;
                display: flex;
                align-items: center;
                gap: 6px;
            }

            .info-item strong {
                color: #111827;
            }

            .icon {
                font-size: 14px;
            }

            .form-title {
                font-weight: 700;
                margin-bottom: 12px;
                display: block;
            }

            /* الشبكة */
            .lawyers-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
                gap: 10px;
            }

            /* البطاقة */
            .lawyer-card {
                background: #ffffff;
                border-radius: 16px;
                padding: 14px;
                border: 2px solid transparent;
                box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
                cursor: pointer;
                transition: all 0.25s ease;
                position: relative;
            }

            .lawyer-card input {
                display: none;
            }

            /* المحتوى */
            .lawyer-content {
                display: flex;
                align-items: center;
                gap: 12px;
            }

            /* الأفاتار */
            .avatar {
                width: 48px;
                height: 48px;
                border-radius: 50%;
                background: linear-gradient(135deg, #4caf50, #2e7d32);
                color: #fff;
                font-weight: bold;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 20px;
            }

            /* المعلومات */
            .info {
                display: flex;
                flex-direction: column;
            }

            .name {
                font-weight: 600;
                font-size: 15px;
            }

            .badge {
                margin-top: 4px;
                background: #e8f5e9;
                color: #2e7d32;
                font-size: 12px;
                padding: 2px 8px;
                border-radius: 8px;
                width: fit-content;
            }

            /* الحالة المختارة */
            .lawyer-card:has(input:checked) {
                border-color: #4caf50;
                background: #f1fff4;
                transform: translateY(-2px);
            }

            /* hover */
            .lawyer-card:hover {
                transform: translateY(-3px);
                box-shadow: 0 10px 24px rgba(0, 0, 0, 0.1);
            }

            /* 📱 موبايل */
            @media (max-width: 576px) {
                .lawyers-grid {
                    grid-template-columns: 1fr;
                }

                .avatar {
                    width: 42px;
                    height: 42px;
                    font-size: 18px;
                }

                .name {
                    font-size: 14px;
                }
            }

            /* 📱 تابلت */
            @media (max-width: 992px) {
                .lawyers-grid {
                    grid-template-columns: repeat(auto-fill, minmax(100px, 2fr));
                }
            }

            @media (min-width: 768px) {

                .form-group textarea {
                    font-weight: bold;
                }
            }

            @media (max-width: 768px) {
                .actions {
                    flex-direction: column;
                }

                .btn {
                    text-align: center;
                }

                .stage-top {
                    flex-direction: column;
                }

                .stage-created {
                    align-self: flex-start;
                }

                .stage-info {
                    flex-direction: column;
                }
            }

            /* Animation */
            @keyframes slideDown {
                from {
                    opacity: 0;
                    transform: translateY(-20px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes fade {
                from {
                    opacity: 0;
                    transform: translateY(-4px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .case-actions {
                display: flex;
                gap: 12px;
                /* مسافة بين الأزرار */
                justify-content: center;
                /* توسيط أفقي */
                flex-wrap: wrap;
                /* كسر السطر في الشاشات الصغيرة */
                margin-top: 20px;
            }

            .action-btn {
                padding: 10px 18px;
                background-color: #2563eb;
                /* أزرق */
                color: #fff;
                text-decoration: none;
                border-radius: 6px;
                font-size: 14px;
                font-weight: 500;
                transition: 0.3s;
            }

            .action-btn:hover {
                background-color: #1e40af;
            }

            .action-btn.secondary {
                background-color: #059669;
                /* أخضر */
            }

            .action-btn.secondary:hover {
                background-color: #047857;
            }

            .action-btn.danger {
                background-color: #dc2626;
                /* أحمر */
            }

            .action-btn.danger:hover {
                background-color: #b91c1c;
            }
        </style>

        @section('script')
            <script>
                function toggleSection(id) {
                    const body = document.getElementById(id);
                    const icon = document.getElementById(id + '-icon');

                    if (body.style.display === 'none') {
                        body.style.display = 'block';
                        icon.innerHTML = '▲';
                    } else {
                        body.style.display = 'none';
                        icon.innerHTML = '▼';
                    }
                }

                function openFileModal() {
                    document.getElementById('fileModal').style.display = 'flex';
                }

                function closeFileModal() {
                    document.getElementById('fileModal').style.display = 'none';
                }

                // إغلاق عند الضغط خارج النافذة
                document.getElementById('fileModal').addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeSessionModal();
                    }
                });

                function openNoteModal() {
                    document.getElementById('noteModal').style.display = 'flex';
                }

                function closeNoteModal() {
                    document.getElementById('noteModal').style.display = 'none';
                }

                // إغلاق عند الضغط خارج النافذة
                document.getElementById('noteModal').addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeSessionModal();
                    }
                });



                function openProgressModal() {
                    document.getElementById('progressModal').style.display = 'flex';
                }

                function closeProgressModal() {
                    document.getElementById('progressModal').style.display = 'none';
                }

                // إغلاق عند الضغط خارج النافذة
                document.getElementById('progressModal').addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeSessionModal();
                    }
                });


                function openExpensModal() {
                    document.getElementById('expensModal').style.display = 'flex';
                }

                function closeExpensModal() {
                    document.getElementById('expensModal').style.display = 'none';
                }

                // إغلاق عند الضغط خارج النافذة
                document.getElementById('expensModal').addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeSessionModal();
                    }
                });


                function openPaymentModal() {
                    document.getElementById('paymentModal').style.display = 'flex';
                }

                function closePaymentModal() {
                    document.getElementById('paymentModal').style.display = 'none';
                }

                // إغلاق عند الضغط خارج النافذة
                document.getElementById('paymentModal').addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeSessionModal();
                    }
                });
            </script>
        @endsection
