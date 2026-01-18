@extends('layouts.app')
@section('title', 'تفاصيل القضية')

@section('content')
    <div class="add-lawyer-container" style="background-color: #ededed">
        <h2 class="page-title">فتح قضية جديدة </h2>
        <form action="{{ route('case.store') }}" class="lawyer-form" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>الموكل</label>
                <select name="client_id" required>
                    <option value="">-- اختر الموكل --</option>
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}">
                            {{ $client->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>صفة الموكل</label>
                <input type="text" name="attribute" placeholder="ادخل صفة الموكل " value="{{ old('attribute') }}"
                    onchange="try{(setCustomerValidity('')}catch(e){})" required>
            </div>
            <div class="form-group">
                <label>موضوع الدعوة</label>
                <input type="text" name="subject" placeholder="ادخل موضوع الدعوة" value="{{ old('subject') }}"
                    onchange="try{(setCustomerValidity('')}catch(e){})" required>
            </div>
            <div class="form-group">
                <label for="second_party_name"> اسم الطرف الثاني</label>
                <input type="text" name="second_party_name" id="second_party_name" class="form-control"
                    placeholder="إدخل اسم الطرف الثاني">
            </div>
            <div class="form-group">
                <label for="court">المحكمة</label>
                <input type="text" name="court" id="court" class="form-control" placeholder="ادخل اسم المكمة">
            </div>
            <div class="form-group">
                <label for="department">الدائرة</label>
                <input type="text" name="department" id="department" class="form-control" placeholder="ادخل اسم الدائرة">
            </div>
            <div class="form-group">
                <label for="base_number"> (إن وجد)رقم الأساس</label>
                <input type="text" name="base_number" id="base_number" class="form-control"
                    placeholder="ادخل رقم الأساس ">
            </div>

            <div class="form-group">
                <label>صنف</label>
                <select name="case_type" required placeholder="اختر الصنفف">
                    <option value="">-- اختر صنف --</option>
                    <option value="ش">شركات</option>
                    <option value="ح">حماية</option>
                    <option value="د">دعوة</option>
                </select>
            </div>
            <div class="form-group">
                <label>تحديد السنوية للقضية</label>
                <select name="case_year" required placeholder="اختر الصنفف">
                    <option value="2026">2026</option>
                    <option value="2025">2025</option>
                </select>
            </div>
            <button type="submit" class="submit-btn">إنشاء القضية</button>
        </form>
    </div>
@endsection
