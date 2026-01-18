@extends('layouts.app')
@section('title', 'المحامين')
@section('content')
    <div class="top-actions">
        @role('superAdmin|admin')
            <a href="{{ route('lawyers.create') }}" class="add-lawyer-btn">
                إضافة محامي جديد +
            </a>
        @endrole
    </div>
    <div class="lawyers-container">
        @foreach ($lawyers as $item)
            <div class="lawyer-card">
                <div class="avatar">Lex</div>
                <h3>{{ $item->fullName }}</h3>
                <p>البريد: {{ $item->user->email }}</p>
                <p>الهاتف: {{ $item->phone }}</p>
                <p>الحالة: {{ $item->status }}</p>
                <div class="actions">

                    <a href="{{ route('lawyer.info', $item->id) }}">عرض التفاصيل</a>
                    @role('superAdmin')
                        @if ($item->user->block == 0)
                            <a href="{{ route('lawyer.block', $item->id) }}" class="edit-btn" id="delete"
                                style="background-color: red; margin-right: 10px; color:white"
                                onclick="return confirmBlock('{{ $item->fullName }}')">
                                حظر
                            </a>
                        @else
                            <a href="{{ route('lawyer.block', $item->id) }}" class="edit-btn" id="delete"
                                style="background-color: green; margin-right: 10px; color:white"
                                onclick="return confirmUnBlock('{{ $item->fullName }}')">
                                فك الحظر
                            </a>
                        @endif
                    @endrole
                </div>
            </div>
        @endforeach

    </div>

@endsection


<script>
    function confirmBlock(clientName) {
        return confirm(`هل أنت متأكد من حظر المحامي: ${clientName}؟`);
    }

    function confirmUnBlock(clientName) {
        return confirm(`هل أنت متأكد من فك الحظ عن المحامي: ${clientName}؟`);
    }
</script>
