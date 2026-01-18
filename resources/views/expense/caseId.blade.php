@extends('layouts.app')

@section('content')
    <div class="container">

        <h3 class="page-title">مصاريف القضية</h3>
        <div style="text-align: left; margin-bottom: 15px;">
            <a href="{{ route('cases.expenses.pdf', $case->id) }}" class="btn-pdf">
                🧾 تصدير الصرفيات PDF
            </a>
        </div>
        <div class="table-wrapper">
            <table class="expenses-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>القيمة</th>
                        <th>التاريخ</th>
                        <th>المحامي</th>
                        <th>الوصف</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($expenses as $expense)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ number_format($expense->amount, 2) }} ل.س</td>
                            <td>{{ $expense->date }}</td>
                            <td>{{ $expense->lawyer->fullName ?? '—' }}</td>
                            <td>{{ $expense->description }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty">
                                لا توجد مصاريف مسجلة
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
@endsection
<style>
    .btn-pdf {
        background-color: #dc2626;
        color: #fff;
        padding: 8px 16px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 500;
    }

    .btn-pdf:hover {
        background-color: #b91c1c;
    }

    .page-title {
        text-align: center;
        margin-bottom: 20px;
        font-weight: bold;
    }

    .table-wrapper {
        overflow-x: auto;
    }

    .expenses-table {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
    }

    .expenses-table th,
    .expenses-table td {
        padding: 12px;
        text-align: center;
        border-bottom: 1px solid #e5e7eb;
    }

    .expenses-table th {
        background-color: #0e2b26;
        color: white;
        font-weight: 600;
    }

    .expenses-table tr:hover {
        background-color: #f9fafb;
    }

    .empty {
        text-align: center;
        color: #6b7280;
        padding: 20px;
    }
</style>
