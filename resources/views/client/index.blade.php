@extends('layouts.app')
@section('title', 'الموكليين')
@section('content')
    <div class="top-actions">
        @role('superAdmin|adminLawyer')
            <a href="{{ route('client.create') }}" class="add-lawyer-btn">
                إضافة موكل جديد +
            </a>
        @endrole
    </div>
    <div class="search-box">
        <input type="search" id="clientSearch" placeholder="🔍 ابحث عن موكل بالاسم أو رقم الهاتف">
    </div>
    <div class="lawyers-container">
        @foreach ($client as $item)
            <div class="lawyer-card" data-name="{{ $item->name }}" data-phone="{{ $item->phone }}">
                <div class="avatar">
                    <img src="{{ asset('images/images.png') }}" alt="" width="80" height="80"
                        style="border-radius: 50%">
                </div>
                <h3>الاسم: {{ $item->name }}</h3>
                <h3>رقم التواصل: {{ $item->phone }}</h3>

                <div class="actions">
                    <a href="{{ route('client.show', $item->id) }}" class="view-btn">عرض التفاصيل</a>
                    <a href="{{ route('clients.destroy', $item->id) }}" class="edit-btn" id="delete"
                        style="background-color: red; margin-right: 10px; color:white"
                        onclick="return confirmDelete('{{ $item->name }}')">
                        حذف
                    </a>
                </div>
            </div>
        @endforeach
    </div>

@endsection
<style>
    .search-box {
        width: 100%;
        margin: 20px auto;
        display: flex;
        justify-content: center;
    }

    .search-box input {
        width: 100%;
        max-width: 700px;
        padding: 20px 15px;
        border-radius: 25px;
        border: 1px solid #ddd;
        font-size: 16px;
        outline: none;
        transition: 0.3s;
    }

    .search-box input:focus {
        border-color: #3498db;
        box-shadow: 0 0 5px rgba(52, 152, 219, 0.3);
    }

    /* شاشات صغيرة */
    @media (max-width: 600px) {
        .search-box input {
            max-width: 100%;
            font-size: 14px;
        }
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('clientSearch').addEventListener('keyup', function() {
            let searchValue = this.value.toLowerCase();
            let cards = document.querySelectorAll('.lawyer-card');

            cards.forEach(card => {
                let name = card.dataset.name.toLowerCase();
                let phone = card.dataset.phone.toLowerCase();

                card.style.display =
                    name.includes(searchValue) || phone.includes(searchValue) ?
                    'block' :
                    'none';
            });
        });
    });

    function confirmDelete(clientName) {
        return confirm(`هل أنت متأكد من حذف الموكل: ${clientName}؟`);
    }
</script>
