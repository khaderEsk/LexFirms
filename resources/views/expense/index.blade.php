@extends('layouts.app')
@section('title', 'المصاريف الشخصية')

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
        .expenses-container {
            max-width: 1200px;
            margin: auto;
            padding: 1rem;
        }

        /* ===== MONTH SWITCHER ===== */
        .month-switcher {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .month-switcher a {
            width: 42px;
            height: 42px;
            background: var(--primary);
            color: #fff;
            border-radius: 50%;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .month-switcher span {
            font-size: 18px;
            font-weight: 600;
            color: var(--text);
        }

        /* ===== SUMMARY ===== */
        .summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .summary-card {
            background: var(--card);
            border-radius: 14px;
            padding: 1.25rem;
            box-shadow: 0 8px 20px rgba(0, 0, 0, .06);
        }

        .summary-card span {
            color: var(--muted);
            font-size: 14px;
        }

        .summary-card h3 {
            margin-top: .5rem;
            font-size: 22px;
        }

        /* ===== TABLE (DESKTOP) ===== */
        .expenses-table {
            background: var(--card);
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0, 0, 0, .06);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: var(--primary);
            color: #fff;
        }

        th,
        td {
            padding: 1rem;
            text-align: center;
            font-size: 14px;
            vertical-align: top;
        }

        .notes {
            text-align: right;
            white-space: normal;
            word-break: break-word;
            line-height: 1.6;
        }

        /* ===== MOBILE CARDS ===== */
        .expenses-cards {
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
            line-height: 1.6;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .expenses-table {
                display: none;
            }

            .expenses-cards {
                display: grid;
            }
        }

        .month-tabs {
            display: flex;
            gap: .5rem;
            flex-wrap: wrap;
            justify-content: center;
            margin-bottom: 2rem;
        }

        .month-tabs a {
            padding: .45rem .9rem;
            border-radius: 999px;
            background: #e5e7eb;
            color: #0f172a;
            text-decoration: none;
            font-size: 14px;
            transition: .2s;
        }

        .month-tabs a:hover {
            background: #80a19c;
            color: white;
        }

        .month-tabs a.active {
            background: #0e2b26;
            color: #fff;
            font-weight: 600;
        }

    </style>

    <div class="expenses-container">
        {{-- <div class="top-actions">
            <a href="javascript:void(0)" class="add-lawyer-btn" onclick="openFileModal()">
                إضافة صرف جديد +
            </a>
        </div> --}}
        <div class="month-tabs">
            @foreach ($months as $month)
                <a href="{{ route('expense.index', ['month' => $month]) }}"
                    class="{{ $selectedMonth === $month ? 'active' : '' }}">
                    {{ \Carbon\Carbon::parse($month)->translatedFormat('F Y') }}
                </a>
            @endforeach
        </div>

        <div class="summary">

            <div class="summary-card">
                <span>إجمالي الليرة</span>
                <h3>💴 {{ number_format($totalSYP) }}</h3>
            </div>

            <div class="summary-card">
                <span>عدد المصاريف</span>
                <h3>{{ $expenses->count() }}</h3>
            </div>
        </div>
        <div class="expenses-table">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>المبلغ</th>
                        <th>التاريخ</th>
                        <th>الملاحظات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($expenses as $expense)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                {{ $expense->currency === 'USD' ? 'USD' : 'SYP' }}
                                {{ number_format($expense->amount) }}
                            </td>
                            <td>{{ $expense->date }}</td>
                            <td class="notes">{{ $expense->description }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">لا توجد مصاريف لهذا الشهر</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="expenses-cards">
            @foreach ($expenses as $expense)
                <div class="expense-card">
                    <div class="expense-row">
                        <span>المبلغ</span>
                        <span>
                            {{ $expense->currency === 'USD' ? 'USD' : 'SYP' }}
                            {{ number_format($expense->amount) }}
                        </span>
                    </div>
                    <div class="expense-row"><span>التاريخ</span><span>{{ $expense->date }}</span></div>
                    <div class="expense-notes">
                        <strong>السبب</strong><br>
                        {{ $expense->description }}
                    </div>
                </div>
            @endforeach
        </div>

    </div>

    <div class="modal-overlay" id="fileModal">
        <div class="modal">
            <div class="modal-header">
                <h3>إضافة صرفية جديدة</h3>
                <span class="close-btn" onclick="closeFileModal()">✖</span>
            </div>
            <form method="POST" action="{{ route('expense.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="legal_case_id" value="">
                <div class="form-group">
                    <label>📌 سبب الصرف </label>
                    <textarea name="description" rows="3" placeholder="ادخل وصف الصرفية الذي قمت بها" required></textarea>
                </div>
                <div class="form-group">
                    <label>💵 القيمة </label>
                    <input type="number" name="amount" placeholder="ادخل قيمة الصرف" required step="0.01"
                        min="0" style="text-align: right; font-weight: bold; font-size:16px;">
                </div>
                <div class="form-group">
                    <label> 💵 نوع العملة </label>
                    <select name="currency" required>
                        <option value="USD">
                            USD دولار
                        </option>
                        <option value="SYP">
                            SYP ليرة
                        </option>
                    </select>
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
