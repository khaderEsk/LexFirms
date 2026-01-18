@extends('layouts.app')
@section('title', 'الملفات')

@section('content')
    <div class="files-grid">
        @foreach ($case->files as $file)
            <div class="file-card">
                <div class="file-header">
                    <span class="file-icon">📎</span>

                    <a href="{{ asset('storage/' . $file->path) }}" target="_blank" class="file-name">
                        {{ $file->original_name }}
                    </a>
                </div>

                <div class="file-meta">
                    <span>📅 {{ optional($file->created_at)->format('Y-m-d') ?? 'غير محدد' }}</span>
                    <span>⏰ {{ optional($file->created_at)->format('H:i') ?? 'غير محدد' }}</span>
                </div>

                <div class="file-lawyer">
                    👨‍⚖️ المحامي:
                    <strong>{{ $file->lawyer->fullName ?? 'غير معروف' }}</strong>
                </div>

                <div class="file-actions">
                    <a href="{{ asset('storage/' . $file->path) }}" target="_blank" class="btn view-btn">
                        👁 عرض
                    </a>

                    <a href="{{ asset('storage/' . $file->path) }}" download class="btn download-btn">
                        ⬇ تحميل
                    </a>
                </div>
            </div>
        @endforeach
    </div>


@endsection
<style>
    /* ====== Files Grid ====== */
    .files-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 16px;
        margin-top: 20px;
    }

    /* ====== File Card ====== */
    .file-card {
        background: #ffffff;
        border-radius: 14px;
        padding: 16px;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
        display: flex;
        flex-direction: column;
        gap: 12px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .file-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 24px rgba(0, 0, 0, 0.1);
    }

    /* Header */
    .file-header {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .file-icon {
        font-size: 22px;
    }

    .file-name {
        font-size: 15px;
        font-weight: 600;
        color: #1f2937;
        text-decoration: none;
        word-break: break-word;
    }

    .file-name:hover {
        color: #4f46e5;
    }

    /* Meta */
    .file-meta {
        display: flex;
        justify-content: space-between;
        font-size: 13px;
        color: #6b7280;
    }

    /* Lawyer */
    .file-lawyer {
        font-size: 14px;
        color: #374151;
    }

    /* Actions */
    .file-actions {
        display: flex;
        gap: 10px;
        margin-top: auto;
    }

    .file-actions .btn {
        flex: 1;
        padding: 8px;
        border-radius: 10px;
        font-size: 14px;
        text-align: center;
        text-decoration: none;
        font-weight: 500;
    }

    /* Buttons */
    .view-btn {
        background: #eef2ff;
        color: #4338ca;
    }

    .download-btn {
        background: #ecfeff;
        color: #0369a1;
    }

    /* Mobile Enhancements */
    @media (max-width: 576px) {
        .file-meta {
            flex-direction: column;
            gap: 4px;
        }
    }
</style>
