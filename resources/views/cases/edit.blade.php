@extends('layouts.app')
@section('title', 'تفاصيل القضية')

@section('content')
    <div class="add-lawyer-container" style="background-color: #ededed">
        <h2 class="page-title">تعديل قضية رقم <span style="color: red">{{ $case->base_number }}</span> </h2>
        <form action="{{ route('case.update', $case->id) }}" class="lawyer-form" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>موضوع الدعوة</label>
                <textarea name="subject" rows="7" required>{{ $case->subject }}</textarea>
                {{-- <input type="text" name="subject" value="{{ $case->subject }}" value="{{ old('subject') }}"
                    onchange="try{(setCustomerValidity('')}catch(e){})" required> --}}
            </div>
            <div class="form-group">
                <label for="court">المحكمة</label>
                <input type="text" name="court" id="court" class="form-control" value="{{ $case->court }}">
            </div>
            <div class="form-group">
                <label for="department">الدائرة</label>
                <input type="text" name="department" id="department" class="form-control"
                    value="{{ $case->department }}">
            </div>
            <div class="form-group">
                <label for="base_number">رقم الأساس</label>
                <input type="text" name="base_number" id="base_number" class="form-control"
                    value="{{ $case->base_number }}">
            </div>
            <button type="submit" class="submit-btn">تعديل القضية</button>
        </form>
    </div>
@endsection
