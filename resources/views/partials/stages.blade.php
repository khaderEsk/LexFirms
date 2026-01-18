@extends('layouts.app')
@section('title', 'الخطوات')
@section('content')
    @php
        $authLawyerId = auth()->user()->lawyer->id ?? null;
    @endphp

    <div class="stages-grid">
        @if ($case->stages->count())
            @foreach ($case->stages as $stage)
                <div class="stage-card">
                    <div class="stage-created">
                        ⏰ تاريخ الإضافة: {{ $stage->created_at->format('Y-m-d') }}
                    </div>
                    <div class="stage-date">
                        📅 تاريخ الملاحظة:
                        @if ($stage->before_update_date)
                            <span class="old-value">
                                {{ \Carbon\Carbon::parse($stage->before_update_date)->format('Y-m-d') }}
                            </span>
                        @endif

                        @if ($stage->date)
                            <span class="new-value">
                                {{ \Carbon\Carbon::parse($stage->date)->format('Y-m-d') }}
                            </span>
                        @else
                            <span class="new-value">غير محدد</span>
                        @endif
                    </div>

                    <div class="stage-subject">
                        <h3>موضوع الخطوة</h3>
                        @if ($stage->before_update_subject)
                            <span class="old-value">
                                {{ $stage->before_update_subject }}
                            </span>
                        @endif

                        <span class="new-value">
                            {{ $stage->subject }}
                        </span>
                    </div>

                    <div class="stage-lawyers">
                        <h4>👨‍⚖️ المحامون المسؤولون</h4>
                        @foreach ($stage->lawyers as $lawyer)
                            <span class="lawyer-name">{{ $lawyer->fullName }}</span>
                            @if (!$loop->last)
                                ,
                            @endif
                        @endforeach
                    </div>

                    @if ($stage->note || $stage->before_update_note)
                        <div class="stage-note">
                            <h4>📝 الملاحظات</h4>

                            @if ($stage->before_update_note)
                                <span class="old-value">
                                    {{ $stage->before_update_note }}
                                </span>
                            @endif

                            @if ($stage->note)
                                <span class="new-value">
                                    {{ $stage->note }}
                                </span>
                            @endif
                        </div>
                    @endif

                    @if ($stage->lawyers->contains('id', $authLawyerId))
                        <div class="stage-actions">
                            <button class="btn btnColor add-file-btn" onclick="openNoteModal({{ $stage->id }})">
                                ✏️ تعديل خطوة
                            </button>
                        </div>
                    @endif
                </div>
                <div class="modal-overlay" id="noteModal-{{ $stage->id }}">
                    <div class="modal">
                        <div class="modal-header">
                            <h3>تعديل الخطوة </h3>
                            <span class="close-btn" onclick="closeNoteModal({{ $stage->id }})">✖</span>
                        </div>
                        <form method="POST" action="{{ route('case.stages.edit', $stage->id) }}">
                            @csrf
                            @method('PUT')
                            {{-- <input type="hidden" name="legal_case_id" value="{{ $stage->id }}">> --}}
                            <div class="form-group">
                                <label>📌 وصف الخطوة</label>
                                <textarea name="subject" rows="3" placeholder="ادخل وصف الخطوة الذي قمت بها" required>{{ $stage->subject }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>📝 ملاحظة</label>
                                <textarea name="note" rows="3" placeholder="ادخل الخطوة التالية ">{{ $stage->note }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>📅 تاريخ التذكير</label>
                                <input type="date" name="date" value="{{ $stage->date }}">
                            </div>
                            <div class="modal-actions">
                                <button type="submit" class="btn btnColor">📝 حفظ التعديل</button>
                                <button type="button" class="btn cancel"
                                    onclick="closeNoteModal({{ $stage->id }})">إلغاء</button>
                            </div>
                        </form>

                    </div>
                </div>
            @endforeach
        @else
            <p class="empty">لا توجد خطوات بعد ....</p>
        @endif
    </div>



@endsection

@section('script')
    <script>
        function openNoteModal(id) {
            document.getElementById('noteModal-' + id).style.display = 'flex';
        }

        function closeNoteModal(id) {
            document.getElementById('noteModal-' + id).style.display = 'none';
        }
    </script>
@endsection
<style>
    .old-value {
        color: #d32f2f;
        /* أحمر */
        font-size: 12px;
        /* خط صغير */
        text-decoration: line-through;
        margin-bottom: 4px;
        display: block;
    }

    .new-value {
        color: #000;
        font-size: 15px;
        font-weight: 500;
    }

    .stage-actions {
        margin-top: 10px;
    }

    .stages-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 20px;
        padding: 20px;
    }

    .stage-card {
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
        padding: 20px;
        display: flex;
        flex-direction: column;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .stage-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
    }

    .stage-created,
    .stage-date {
        font-size: 0.9rem;
        color: #555;
        margin-bottom: 8px;
    }

    .stage-subject h3 {
        font-size: 1rem;
        margin-bottom: 5px;
        color: #222;
    }

    .stage-subject p {
        font-size: 0.95rem;
        line-height: 1.5;
        color: #333;
    }

    .stage-lawyers h4 {
        font-size: 0.95rem;
        margin-bottom: 5px;
        color: #444;
    }

    .lawyer-name {
        display: inline-block;
        font-weight: 600;
        color: #1e3a8a;
    }

    .stage-note {
        margin-top: 15px;
        background-color: #f1f5f9;
        padding: 12px 15px;
        border-radius: 10px;
    }

    .stage-note h4 {
        font-size: 0.95rem;
        margin-bottom: 5px;
        color: #444;
    }

    .stage-note p {
        font-size: 0.9rem;
        color: #333;
        line-height: 1.5;
    }

    .empty {
        text-align: center;
        font-size: 1.1rem;
        color: #888;
        margin-top: 50px;
    }

    @media (max-width: 600px) {
        .stage-card {
            padding: 15px;
        }

        .stage-subject p,
        .stage-note p {
            font-size: 0.9rem;
        }
    }
</style>
