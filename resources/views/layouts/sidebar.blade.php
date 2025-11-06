<div class="sidebar">
    {{-- زر الإغلاق يظهر فقط في الشاشات الصغيرة --}}
    <button class="close-btn" style="display:none">&times;</button>

    <div class="logo">
        <img src="{{ asset('images/logo1.png') }}" alt="Lex Law Firm">
    </div>

    <ul>
        <li><a href="#">لوحة التحكم</a></li>
        <li><a href="{{route('cases')}}"class="active">القضايا</a></li>
        <li><a href="#">الموكلون</a></li>
        <li><a href="#">الجلسات</a></li>
        <li><a href="#">التقارير</a></li>
        <li><a href="#">الإعدادات</a></li>
    </ul>
</div>
