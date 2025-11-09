<div class="sidebar">
    {{-- زر الإغلاق يظهر فقط في الشاشات الصغيرة --}}
    <button class="close-btn" style="display:none">&times;</button>

    <div class="logo">
        <img src="{{ asset('images/logo1.png') }}" alt="Lex Law Firm">
    </div>

    <ul>
        <li><a href="{{ route('causes') }}">القضايا</a></li>
        <li><a href="{{ route('causeDay') }}"class="active">القضايا اليومية</a></li>
        <li><a href="#">الموكلون</a></li>
        <li><a href="{{ route('causeDay') }}">الجلسات اليومية</a></li>
        <li><a href="#">التقارير</a></li>
        <li><a href="#">الإعدادات</a></li>
    </ul>
</div>
