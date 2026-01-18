@extends('layouts.app')
@section('title', 'إضافة موكل')
@section('content')
    <div class="add-lawyer-container">

        <h2 class="page-title">إضافة موكل جديد</h2>

        <form action="{{ route('client.store') }}" class="lawyer-form" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label>الاسم الثلاثي</label>
                <input type="text" name="name" required placeholder="أدخل اسم الموكل" value="{{ old('name') }}">
            </div>

            <div class="form-group">
                <label>رقم الهاتف</label>
                <input type="text" name="phone" placeholder="09xxxxxxxx" value="{{ old('phone') }}"
                    onchange="try{(setCustomerValidity('')}catch(e){})">
            </div>
            <div class="form-group">
                <label for="firstImg"> للهوية الشخصية</label>
                <input type="file" name="fileId" id="fileId" class="form-control" required>
                <!-- تأكد من type="file" -->
            </div>

            <button type="submit" class="submit-btn">حفظ الموكل</button>
        </form>

    </div>

@endsection
