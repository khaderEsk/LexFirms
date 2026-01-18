@extends('layouts.app')
@section('content')
    <div class="edit-lawyer-container">

        <h2 class="page-title">تعديل بيانات المحامي</h2>

        <form action="{{ route('lawyers.update', $lawyer->id) }}" method="POST" class="lawyer-form">
            @csrf

            <div class="form-group">
                <label>الاسم والكنية</label>
                <input type="text" name="fullName" required value="{{ $lawyer->fullName }}">
            </div>

            <div class="form-group">
                <label>اسم الأب</label>
                <input type="text" name="seconedName" required placeholder="أدخل اسم الأب"
                    value="{{ $lawyer->seconedName }}">
            </div>
            <div class="form-group">
                <label>ام الأم</label>
                <input type="text" name="motherName" required placeholder="أدخل اسم الأم"
                    value="{{ $lawyer->motherName }}">
            </div>

            <div class="form-group">
                <label>رقم الهاتف</label>
                <input type="text" name="phone" required placeholder="09xxxxxxxx" value="{{ $lawyer->phone }}"
                    onchange="try{(setCustomerValidity('')}catch(e){})">
            </div>
            <div class="form-group">
                <label>تاريخ الولادة</label>
                <input type="date" name="birthDate" placeholder="ادخل تاريخ الولادة" required
                    value="{{ $lawyer->birthDate }}">
            </div>

            <div class="form-group">
                <label>الرقم الوطني</label>
                <input type="text" name="nationalNumer" placeholder="ادخل مكان السكن" required
                    value="{{ $lawyer->nationalNumer }}">
            </div>
            <div class="form-group">
                <label>القيد</label>
                <input type="text" name="secretariat" placeholder="ادخل مكان السكن" required
                    value="{{ $lawyer->secretariat }}">
            </div>

            <div class="form-group">
                <label>الحالة</label>
                <select name="status" required value="{{ $lawyer->status }}">
                    <option value="استاذ">استاذ</option>
                    <option value="متدرب">متدرب</option>
                </select>
            </div>
            <div class="form-group">
                <label>الخبرة</label>
                <input type="date" name="joinDate"required value="{{ $lawyer->joinDate }}">
            </div>

            <button type="submit" class="submit-btn">تعديل المحامي</button>
    </div>
@endsection
