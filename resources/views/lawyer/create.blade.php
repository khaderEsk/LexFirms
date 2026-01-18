@extends('layouts.app')
@section('title', 'المحامين')
@section('content')
    <div class="add-lawyer-container">

        <h2 class="page-title">إضافة محامي جديد</h2>

        <form action="{{ route('lawyers.store') }}" method="POST" class="lawyer-form">
            @csrf

            <div class="form-group">
                <label>الاسم والكنية</label>
                <input type="text" name="fullName" required placeholder="أدخل اسم المحامي">
            </div>

            <div class="form-group">
                <label>اسم الأب</label>
                <input type="text" name="seconedName" required placeholder="أدخل اسم الأب">
            </div>
            <div class="form-group">
                <label>ام الأم</label>
                <input type="text" name="motherName" required placeholder="أدخل اسم الأم">
            </div>

            <div class="form-group">
                <label>البريد الإلكتروني</label>
                <input type="email" name="email" required placeholder="example@law.com">
            </div>

            <div class="form-group">
                <label>رقم الهاتف</label>
                <input type="text" name="phone" required placeholder="09xxxxxxxx" value="{{ old('phone') }}"
                    onchange="try{(setCustomerValidity('')}catch(e){})">
            </div>
            <div class="form-group">
                <label>تاريخ الولادة</label>
                <input type="date" name="birthDate" placeholder="ادخل تاريخ الولادة" required>
            </div>

            <div class="form-group">
                <label>الرقم الوطني</label>
                <input type="text" name="nationalNumer" placeholder="ادخل مكان السكن" required>
            </div>
            <div class="form-group">
                <label>القيد</label>
                <input type="text" name="secretariat" placeholder="ادخل مكان السكن" required>
            </div>

            <div class="form-group">
                <label>الحالة</label>
                <select name="status" required>
                    <option value="استاذ">استاذ</option>
                    <option value="متدرب">متدرب</option>
                </select>
            </div>
            <div class="form-group">
                <label>الخبرة</label>
                <input type="date" name="joinDate"required>
            </div>

            <button type="submit" class="submit-btn">حفظ المحامي</button>
        </form>

    </div>

@endsection
