@extends('layouts.app')
@section('title', 'التقارير المالية')

@section('content')
    <style>
        :root {
            --primary: #0e2b26;
            --bg: #f8fafc;
            --card: #ffffff;
            --text: #0f172a;
            --muted: #64748b;
            --border: #e5e7eb;
        }

        /* ===== LAYOUT ===== */
        .container {
            max-width: 1200px;
            margin: auto;
            padding: 1rem;
        }

        /* ===== FILTER FORM ===== */
        .filter-form {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .filter-form select,
        .filter-form input[type="month"],
        .filter-form input[type="number"],
        .filter-form input[type="year"],
        .filter-form button {
            padding: .5rem .75rem;
            border-radius: 8px;
            border: 1px solid var(--border);
            font-size: 14px;
        }

        .filter-form button {
            background: #204f47;
            color: #fff;
            border: none;
            cursor: pointer;

        }

        /* ===== SUMMARY ===== */
        .summary {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .summary-card {
            background: var(--card);
            border-radius: 14px;
            padding: 1rem 1.5rem;
            box-shadow: 0 6px 16px rgba(0, 0, 0, .06);
        }

        .summary-card span {
            color: var(--muted);
            font-size: 14px;
        }

        .summary-card h3 {
            margin-top: .5rem;
            font-size: 22px;
        }

        /* ===== TABLE ===== */
        .table-container {
            background: var(--card);
            border-radius: 14px;
            box-shadow: 0 6px 16px rgba(0, 0, 0, .06);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 1rem;
            text-align: center;
            font-size: 14px;
        }

        thead {
            background: var(--primary);
            color: #fff;
        }

        .notes {
            text-align: right;
            white-space: normal;
            word-break: break-word;
            line-height: 1.5;
        }

        .money-icon {
            color: #16a34a;
            margin-right: 4px;
        }

        /* ===== MOBILE CARDS ===== */
        .expense-cards {
            display: none;
            gap: 1rem;
        }

        .expense-card {
            background: var(--card);
            border-radius: 14px;
            padding: 1rem;
            box-shadow: 0 6px 16px rgba(0, 0, 0, .06);
        }

        .expense-row {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            margin-bottom: .4rem;
        }

        .expense-notes {
            margin-top: .75rem;
            padding-top: .75rem;
            border-top: 1px dashed var(--border);
            line-height: 1.5;
        }

        .form-group textarea {
            font-size: 25px;
            font-weight: bold;
        }

        /* ===== RESPONSIVE ===== */
        @media(max-width: 768px) {
            .table-container {
                display: none;
            }

            .expense-cards {
                display: grid;
            }
        }
    </style>

    <div class="container">
        {{-- FILTER FORM --}}
        <form method="GET" class="filter-form">
            {{-- اختيار المحامي --}}

            {{-- اختيار الشهر --}}
            <select name="month">
                <option value="">اختر الشهر</option>
                @php
                    $months = [
                        '01' => 'يناير',
                        '02' => 'فبراير',
                        '03' => 'مارس',
                        '04' => 'أبريل',
                        '05' => 'مايو',
                        '06' => 'يونيو',
                        '07' => 'يوليو',
                        '08' => 'أغسطس',
                        '09' => 'سبتمبر',
                        '10' => 'أكتوبر',
                        '11' => 'نوفمبر',
                        '12' => 'ديسمبر',
                    ];
                @endphp
                @foreach ($months as $num => $name)
                    <option value="{{ $num }}"
                        {{ $month && date('m', strtotime($month . '-01')) == $num ? 'selected' : '' }}>
                        {{ $name }}
                    </option>
                @endforeach
            </select>
            {{-- اختيار السنة --}}
            <select name="year">
                <option value="">اختر السنة</option>
                @php
                    $currentYear = date('Y');
                    $years = range($currentYear, $currentYear - 10);
                @endphp
                @foreach ($years as $y)
                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endforeach
            </select>

            <select name="legal_case_id">
                <option value="">اختر اسم القضية</option>
                @php
                    $currentYear = date('Y');
                    $years = range($currentYear, $currentYear - 10);
                @endphp
                @foreach ($cases as $case)
                    <option value="{{ $case->id }}">{{ $case->name_case }}</option>
                @endforeach
            </select>
            <button type="submit"> 🔍 بحث </button>
        </form>
        {{-- SUMMARY --}}

        <div class="summary">
            <div class="summary-card">
                <span>إجمالي الدفعات الدولار</span>
                <h3>💵 {{ number_format($total) }}</h3>
            </div>

            <div class="summary-card">
                <span>عدد المصاريف</span>
                <h3>{{ $payments->count() }}</h3>
            </div>
        </div>
        <div class="top-actions">
            <a href="javascript:void(0)" class="add-lawyer-btn" onclick="openFileModal()">
                إضافة دفعة جديد +
            </a>
        </div>
        {{-- DESKTOP TABLE --}}
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>القضية</th>
                        <th>المبلغ</th>
                        <th>التاريخ</th>
                        <th>الملاحظة</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $payment->case->name_case }}</td>
                            <td>
                                {{ $payment->currency === '$' ? 'USD' : 'SYP' }}
                                {{ number_format($payment->amount) }}
                            </td>
                            <td>{{ $payment->created_at }}</td>
                            <td class="notes">{{ $payment->notes ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">لا توجد بيانات لهذا الفلتر</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- MOBILE CARDS --}}
        <div class="expense-cards">
            @foreach ($payments as $expense)
                <div class="expense-card">
                    <div class="expense-row"><span>المحامي</span><span>{{ $expense->lawyer->fullName ?? '-' }}</span></div>
                    <div class="expense-row">
                        <span>المبلغ</span>
                        <span>
                            {{ $expense->currency === 'USD' ? 'USD' : 'SYP' }}
                            {{ number_format($expense->amount) }}
                        </span>
                    </div>
                </div>
                <div class="expense-row"><span>التاريخ</span><span>{{ $expense->date }}</span></div>
                <div class="expense-notes">
                    <strong>الوصف</strong><br>{{ $expense->description ?? '-' }}
                </div>
            @endforeach
        </div>
    </div>


    <div class="modal-overlay" id="fileModal">
        <div class="modal">
            <div class="modal-header">
                <h3>إضافة دفعة جديدة</h3>
                <span class="close-btn" onclick="closeFileModal()">✖</span>
            </div>
            <form method="POST" action="{{ route('payment.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <select name="legal_case_id">
                        @foreach ($cases as $case)
                            <option value="{{ $case->id }}">
                                {{ $case->name_case }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>صورة الوصل أن وجد </label>
                    <input type="file" name="img" placeholder="ادخل قيمة الصرف">
                </div>
                <div class="form-group">
                    <label>💵 القيمة </label>
                    <input type="number" name="amount" placeholder="ادخل قيمة الدفعة بالدولار حصراً" required
                        step="0.01" min="0" style="text-align: right; font-weight: bold; font-size:16px;">
                </div>
                {{-- <input type="hidden" name="currency" value=""> --}}
                <div class="form-group" style="">
                    <label>📌 ملاحظة</label>
                    <textarea name="note" rows="3" placeholder="ادخل وصف الصرفية الذي قمت بها" required></textarea>
                </div>
                <div class="modal-actions">
                    <button type="submit" class="btn btnColor">📎 حفظ الصرف</button>
                    <button type="button" class="btn cancel" onclick="closeFileModal()">إلغاء</button>
                </div>
            </form>
        </div>
    </div>

@endsection




@section('script')
    <script>
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
    </script>
@endsection
