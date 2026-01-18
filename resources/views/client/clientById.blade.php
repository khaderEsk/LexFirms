@extends('layouts.app')
@section('title', 'ملف العميل')

@section('content')
    <div class="client-wrapper">

        @if (session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li><i class="fas fa-exclamation-circle"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <!-- زر التعديل -->
        <div class="action-buttons">
            <a href="{{ route('clients.edit', $client->id) }}" class="edit-btn">
                <i class="fas fa-pen"></i>
                تعديل البيانات
            </a>

            <!-- زر رفع ملف جديد -->
            <button id="openUploadModal" class="upload-btn">
                <i class="fas fa-upload"></i>
                رفع ملف جديد
            </button>
        </div>

        {{-- Header --}}
        <div class="card header-card">
            <div>
                <h1>{{ $client->name }}</h1>
                <span>رقم العميل #{{ $client->id }}</span>
            </div>
        </div>

        {{-- Info --}}
        <div class="card info-card">
            <div class="info-item">
                <small>رقم الهاتف</small>
                @if ($client->phone)
                    <strong>{{ $client->phone }}</strong>
                @else
                    <strong>الرقم غير موجود</strong>
                @endif
            </div>
            <div class="info-item">
                <small>تاريخ الإضافة</small>
                <strong>{{ $client->created_at->format('Y/m/d') }}</strong>
            </div>
        </div>


        <div class="card info-card">

            <h3>الصورة الشخصية</h3>

            @if ($client->fileId)
                <div class="files-grid">

                    @if ($client->fileId)
                        <div class="file-box">
                            <div class="file-actions">
                                <i class="fas fa-eye"></i>
                                <a href="{{ asset('storage/' . $client->fileId) }}" target="_blank" style="">عرض</a>
                            </div>
                        </div>
                        <div class="file-box">
                            <div class="file-actions">
                                <i class="fas fa-download"></i>
                                <a href="{{ asset('storage/' . $client->fileId) }}" download>تحميل</a>
                            </div>
                        </div>
                    @endif

                </div>
            @else
                <p class="empty">لا توجد صور مرفوعة</p>
            @endif
        </div>


        {{-- Files --}}
        <div class="card files-card">
            <div class="files-header">
                <h3>الملفات المرفوعة</h3>
                <span class="files-count">{{ $client->fileClient->count() }} ملف</span>
            </div>

            @if ($client->fileClient->count() > 0)
                <div class="files-grid">
                    @foreach ($client->fileClient as $file)
                        <div class="file-box">
                            <div class="file-icon">
                                @if (in_array($file->extension, ['jpg', 'jpeg', 'png', 'gif']))
                                    <i class="fas fa-image"></i>
                                @elseif(in_array($file->extension, ['pdf']))
                                    <i class="fas fa-file-pdf"></i>
                                @elseif(in_array($file->extension, ['doc', 'docx']))
                                    <i class="fas fa-file-word"></i>
                                @else
                                    <i class="fas fa-file"></i>
                                @endif
                            </div>
                            <div class="file-info">
                                <p class="file-name">{{ $file->type }}</p>
                            </div>
                            <div class="file-actions">
                                <a href="{{ asset('storage/' . $file->file) }}" target="_blank" title="عرض">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ asset('storage/' . $file->file) }}" download title="تحميل">
                                    <i class="fas fa-download"></i>
                                </a>
                                <form action="{{ route('client.files.destroy', [$file->id]) }}" method="GET"
                                    class="d-inline delete-file-form">
                                    @csrf
                                    <button type="button" class="delete-file-btn" title="حذف">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="empty">لا توجد ملفات مرفوعة</p>
            @endif
        </div>
    </div>

    <!-- Modal لرفع الملفات -->
    <div id="uploadModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>رفع ملف جديد</h3>
                <button id="closeModal" class="close-btn">&times;</button>
            </div>
            <div class="modal-body">
                <form id="uploadForm" action="{{ route('client.files.store', $client->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="file">اختر الملف</label>
                        <input type="file" name="file" id="file" class="file-input" required>
                        <small class="file-hint">الأنواع المسموحة: JPG, PNG, PDF, DOC, DOCX (الحجم الأقصى: 2MB)</small>
                    </div>
                    <div class="form-group">
                        <label for="file_type">نوع الملف *</label>
                        <select name="type" id="file_type" class="file-select" required >
                            <option value="" disabled selected>اختر نوع الملف</option>
                            <option value="قضائي">قضائي</option>
                            <option value="محكمة">حكم محكمة</option>
                        </select>
                        <small class="select-hint">يجب اختيار نوع الملف (قضائي أو حكم محكمة)</small>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="submit-btn">
                            <i class="fas fa-upload"></i>
                            رفع الملف
                        </button>
                        <button type="button" id="cancelUpload" class="cancel-btn"
                            style="background-color: red;color: white">
                            إلغاء
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // عناصر الـ Modal
        const modal = document.getElementById('uploadModal');
        const openBtn = document.getElementById('openUploadModal');
        const closeBtn = document.getElementById('closeModal');
        const cancelBtn = document.getElementById('cancelUpload');
        const fileInput = document.getElementById('file');
        const uploadForm = document.getElementById('uploadForm');

        // فتح الـ Modal
        openBtn.addEventListener('click', () => {
            modal.style.display = 'block';
        });

        // إغلاق الـ Modal
        closeBtn.addEventListener('click', () => {
            modal.style.display = 'none';
        });

        cancelBtn.addEventListener('click', () => {
            modal.style.display = 'none';
        });

        window.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });
        fileInput.addEventListener('change', function() {
            const file = this.files[0];
            const maxSize = 2 * 1024 * 1024; // 2MB

            if (file && file.size > maxSize) {
                Swal.fire({
                    icon: 'error',
                    title: 'حجم الملف كبير',
                    text: 'الحد الأقصى لحجم الملف هو 2 ميجابايت',
                });
                this.value = '';
            }
        });

        const deleteButtons = document.querySelectorAll('.delete-file-btn');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const form = this.closest('form');
                const fileName = this.closest('.file-box').querySelector('.file-name')
                    .textContent;

                Swal.fire({
                    title: 'تأكيد الحذف',
                    html: `هل تريد حذف الملف <strong>${fileName}</strong>؟`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'نعم، احذف',
                    cancelButtonText: 'إلغاء',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>

<style>
    .alert {
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .alert-success {
        background-color: #d1fae5;
        color: #065f46;
        border-right: 4px solid #10b981;
    }

    .alert-danger {
        background-color: #fee2e2;
        color: #991b1b;
        border-right: 4px solid #ef4444;
    }

    .alert i {
        font-size: 18px;
    }

    .client-wrapper {
        max-width: 900px;
        margin: auto;
        padding: 20px;
        font-family: system-ui, -apple-system;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
    }

    .edit-btn,
    .upload-btn {
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
    }

    .edit-btn {
        background: #2563eb;
        color: #fff;
    }

    .edit-btn:hover {
        background: #1d4ed8;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
    }

    .upload-btn {
        background: #10b981;
        color: #fff;
    }

    .upload-btn:hover {
        background: #059669;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    /* Cards */
    .card {
        background: #ffffff;
        border-radius: 14px;
        padding: 25px;
        margin-bottom: 20px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, .05);
    }

    /* Header */
    .header-card h1 {
        margin: 0;
        font-size: 28px;
        color: #1f2937;
    }

    .header-card span {
        color: #6b7280;
        font-size: 14px;
    }

    /* Files Section */
    .files-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .files-header h3 {
        margin: 0;
        font-size: 18px;
        color: #1f2937;
    }

    .files-count {
        background: #e5e7eb;
        color: #4b5563;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }

    .files-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
        gap: 20px;
    }

    .file-box {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 15px;
        background: #f9fafb;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        transition: all 0.3s;
        width: fit-content;
    }

    .file-box .file-actions a {
        font-weight: bold;
        color: #567ade;
    }

    .file-box .file-actions i {
        padding-top: 8px;
        color: #1a1d25;
        margin-left: -10px;
    }

    .file-box:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, .08);
        border-color: #d1d5db;
    }

    .file-icon {
        font-size: 24px;
        color: #6b7280;
        min-width: 40px;
    }

    .file-icon .fa-image {
        color: #10b981;
    }

    .file-icon .fa-file-pdf {
        color: #ef4444;
    }

    .file-icon .fa-file-word {
        color: #2563eb;
    }

    .file-icon .fa-file {
        color: #8b5cf6;
    }

    .file-info {
        flex: 1;
        min-width: 0;
    }

    .file-name {
        margin: 0 0 5px 0;
        font-size: 14px;
        font-weight: 500;
        color: #1f2937;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .file-size {
        font-size: 12px;
        color: #6b7280;
    }

    .file-actions {
        display: flex;
        gap: 10px;
    }

    .file-actions a,
    .file-actions button {
        background: none;
        border: none;
        color: #6b7280;
        font-size: 14px;
        cursor: pointer;
        padding: 5px;
        transition: color 0.2s;
    }

    .file-actions a:hover {
        color: #2563eb;
    }

    .file-actions .delete-file-btn:hover {
        color: #ef4444;
    }

    /* Modal */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
        background-color: #fff;
        margin: 5% auto;
        padding: 0;
        width: 90%;
        max-width: 500px;
        border-radius: 12px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 25px;
        border-bottom: 1px solid #e5e7eb;
    }

    .modal-header h3 {
        margin: 0;
        font-size: 18px;
        color: #1f2937;
    }

    .close-btn {
        background: none;
        border: none;
        font-size: 24px;
        color: #6b7280;
        cursor: pointer;
        padding: 0;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: background 0.2s;
    }

    .close-btn:hover {
        background: #f3f4f6;
    }

    .modal-body {
        padding: 25px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #374151;
        font-size: 14px;
    }

    .file-input {
        width: 100%;
        padding: 12px;
        border: 2px dashed #d1d5db;
        border-radius: 8px;
        background: #f9fafb;
        cursor: pointer;
        transition: border-color 0.3s;
    }

    .file-input:hover {
        border-color: #9ca3af;
    }

    .file-input:focus {
        outline: none;
        border-color: #2563eb;
    }

    .file-hint {
        display: block;
        margin-top: 5px;
        font-size: 12px;
        color: #6b7280;
    }

    textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-family: inherit;
        font-size: 14px;
        resize: vertical;
    }

    textarea:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .form-actions {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
        margin-top: 25px;
    }

    .submit-btn,
    .cancel-btn {
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        border: none;
        transition: all 0.3s;
    }

    .submit-btn {
        background: #10b981;
        color: white;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .submit-btn:hover {
        background: #059669;
        transform: translateY(-1px);
    }

    .cancel-btn {
        background: #f3f4f6;
        color: #4b5563;
    }

    .cancel-btn:hover {
        background: #e5e7eb;
    }

    /* Empty State */
    .empty {
        text-align: center;
        padding: 40px 20px;
        color: #9ca3af;
        font-size: 15px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .action-buttons {
            flex-direction: column;
        }


        .modal-content {
            margin: 10% auto;
            width: 95%;
        }
    }

    @media (max-width: 480px) {
        .client-wrapper {
            padding: 15px;
        }

        .card {
            padding: 20px;
        }

        .file-box {
            flex-direction: column;
            text-align: center;
        }
    }
</style>
