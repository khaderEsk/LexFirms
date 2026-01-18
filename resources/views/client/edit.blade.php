@extends('layouts.app')
@section('title', 'تعديل العميل')

@section('content')
    <div class="client-wrapper">

        <div class="card header-card header-flex">
            <div>
                <h1>تعديل بيانات العميل</h1>
                <span>رقم العميل #{{ $client->id }}</span>
            </div>

            <a href="{{ route('client.show', $client->id) }}" class="back-btn">
                رجوع
            </a>
        </div>

        <form action="{{ route('clients.update', $client->id) }}" method="POST" enctype="multipart/form-data" class="card">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>اسم العميل</label>
                <input type="text" name="name" value="{{ old('name', $client->name) }}" required>
            </div>

            <div class="form-group">
                <label>رقم الهاتف</label>
                <input type="text" name="phone" value="{{ old('phone', $client->phone) }}" required>
            </div>

            <div class="form-group">
                <label>الصورة الشخصية</label>
                <input type="file" name="fileId" id="fileIdInput" onchange="previewFile(this)">
                @if ($client->fileId)
                    <div>
                        <img src="{{ asset('storage/' . $client->fileId) }}" id="previewImg" class="preview">
                    </div>
                @else
                    <img src="" id="previewImg" class="preview" style="display:none;">
                    <strong>لا يوجد صورة شخصية</strong>
                @endif
            </div>


            <div class="actions">
                <button type="submit" class="save-btn">
                    حفظ التعديلات
                </button>
            </div>

        </form>

    </div>
@endsection


<style>
    .client-wrapper {
        max-width: 750px;
        margin: auto;
        padding: 20px;
        font-family: system-ui, -apple-system;
    }

    .card {
        background: #fff;
        border-radius: 14px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, .05);
    }

    .header-flex {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .header-card h1 {
        margin: 0;
        font-size: 24px;
    }

    .header-card span {
        font-size: 13px;
        color: #6b7280;
    }

    /* Form */
    .form-group {
        margin-bottom: 18px;
    }

    .form-group label {
        display: block;
        font-size: 13px;
        margin-bottom: 6px;
        color: #374151;
    }

    .form-group input {
        width: 100%;
        padding: 10px 12px;
        border-radius: 10px;
        border: 1px solid #d1d5db;
        font-size: 14px;
    }

    .preview {
        margin-top: 10px;
        width: 120px;
        height: 90px;
        object-fit: cover;
        border-radius: 10px;
        border: 1px solid #e5e7eb;
    }

    /* Buttons */
    .actions {
        margin-top: 25px;
    }

    .save-btn {
        background: #2563eb;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 12px;
        cursor: pointer;
        font-size: 14px;
    }

    .save-btn:hover {
        background: #1d4ed8;
    }

    .back-btn {
        text-decoration: none;
        font-size: 13px;
        color: #2563eb;
    }
</style>


<script>
    function previewFile(input) {
        const preview = document.getElementById('previewImg');
        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    }
</script>
