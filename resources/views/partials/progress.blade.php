@extends('layouts.app')
@section('title', 'التقارير')
@section('content')

    <div class="reports-page">

        <h2 class="page-title">📄 التقارير</h2>

        @if ($reports->count())
            @foreach ($reports->reports as $report)
                <div class="report-card">

                    {{-- تاريخ التقرير --}}
                    <div class="report-date">
                        📅 {{ $report->created_at->format('Y-m-d') }}
                    </div>

                    {{-- وصف التقرير --}}
                    <div class="report-content">
                        <p>{{ $report->description }}</p>
                    </div>

                </div>
            @endforeach
        @else
            <p class="empty">لا توجد تقارير بعد...</p>
        @endif

    </div>

@endsection
<style>
    .reports-page {
        max-width: 900px;
        /* ممتاز للتقارير */
        margin: auto;
        padding: 20px;
    }

    /* عنوان الصفحة */
    .page-title {
        text-align: center;
        margin-bottom: 30px;
        color: #1f2937;
    }

    /* بطاقة التقرير */
    .report-card {
        background-color: #ffffff;
        border-radius: 14px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        padding: 25px;
        margin-bottom: 25px;
        transition: box-shadow 0.2s ease;
    }

    .report-card:hover {
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
    }

    /* التاريخ */
    .report-date {
        font-size: 0.9rem;
        color: #6b7280;
        margin-bottom: 15px;
        border-bottom: 1px solid #e5e7eb;
        padding-bottom: 8px;
    }

    /* محتوى التقرير */
    .report-content p {
        font-size: 1rem;
        line-height: 1.8;
        /* مهم للنص الكبير */
        color: #111827;
        white-space: pre-line;
        /* يحافظ على التنسيق */
    }

    /* لا يوجد تقارير */
    .empty {
        text-align: center;
        color: #9ca3af;
        font-size: 1.1rem;
        margin-top: 50px;
    }

    /* موبايل */
    @media (max-width: 600px) {
        .reports-page {
            padding: 15px;
        }

        .report-card {
            padding: 18px;
        }

        .report-content p {
            font-size: 0.95rem;
        }
    }
</style>
