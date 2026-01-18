@extends('layouts.app')
@section('title', 'المهام اليومية')

@section('content')
    <div class="daily-tasks">

        <div class="page-header">
            <h2>📋 المهام اليومية</h2>
            <form method="GET">
                <input class="date-input" type="date" name="date" value="{{ $date->format('Y-m-d') }}"
                    onchange="this.form.submit()">
            </form>
        </div>

        @forelse($stages as $task)
            <div class="task-card">

                <div class="task-header">
                    <span class="task-subject">📌المهمة : {{ $task->note }}</span>
                </div>

                @if ($task->note)
                    <p class="task-note">
                        📝 {{ $task->subject }}
                    </p>
                @endif

                <div class="task-footer">
                    👤 المسؤول:
                    <strong>{{ $task->lawyer->fullName ?? 'غير معروف' }}</strong>
                </div>

            </div>
        @empty
            <div class="empty-state">
                لا توجد مهام لليوم 🎉
            </div>
        @endforelse

    </div>
@endsection

<style>
    .daily-tasks {
        max-width: 500px;
        margin: auto;
        padding: 16px;
        font-family: 'Cairo', sans-serif;
        background-color: white;
        border-radius: 20px;
    }

    /* Header */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
    }

    .page-header h2 {
        font-size: 20px;
        font-weight: bold;
    }

    .date-input {
        padding: 6px 10px;
        border-radius: 10px;
        border: 1px solid #ddd;
        font-size: 14px;
        background: #f1f1f1de;
    }

    .today {
        font-size: 14px;
        color: #777;
    }

    /* Card */
    .task-card {
        background-color: #f1f0f0;
        border-radius: 14px;
        padding: 14px;
        margin-bottom: 14px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, .08);
        transition: transform .2s;
        border: 1px solid #646262;
    }

    .task-card:hover {
        transform: translateY(-2px);
    }

    /* Header inside card */
    .task-header {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        font-size: 15px;
    }

    .task-subject {
        font-weight: bold;
        color: #333;
    }

    /* Note */
    .task-note {
        margin: 10px 0;
        font-size: 14px;
        color: #555;
        line-height: 1.6;
    }

    /* Footer */
    .task-footer {
        font-size: 13px;
        color: #444;
        border-top: 1px solid #eee;
        padding-top: 8px;
    }

    /* Empty */
    .empty-state {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 12px;
        text-align: center;
        color: #666;
    }

    /* Responsive (Desktop) */
    @media (min-width: 768px) {
        .daily-tasks {
            max-width: 700px;
        }
    }
</style>
