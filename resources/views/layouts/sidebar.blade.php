<div class="sidebar">
    <button class="close-btn" style="display:none">&times;</button>
    <div class="logo">
        <img src="{{ asset('images/logo1.png') }}" alt="Lex Law Firm">
    </div>
    <h2>
        {{ auth()->user()->userName }}
    </h2>
    <ul>
        @unlessrole('accounting')
            <li><a href="{{ route('case.index') }}" class="{{ request()->routeIs('case.index') ? 'active' : '' }}">القضايا</a>
            </li>
            <li><a href="{{ route('client.index') }}"
                    class="{{ request()->routeIs('client.index') ? 'active' : '' }}">الموكلون</a></li>
            <li><a href="{{ route('stage.index') }}" class="{{ request()->routeIs('stage.index') ? 'active' : '' }}">المهام
                    اليومية</a></li>
            <li>
                <a href="{{ route('lawyer.index') }}"
                    class="{{ request()->routeIs('lawyer.index') ? 'active' : '' }}">المحامين
                </a>
            </li>
            @role('lawyer|adminLawyer')
                <li>
                    <a href="{{ route('expense.index') }}"
                        class="{{ request()->routeIs('expense.index') ? 'active' : '' }}">المصاريف الشخصية
                    </a>
                </li>
            @endrole
        @endunlessrole

        @role('superAdmin|accounting')
            <li>
                <a href="{{ route('expense.all') }}"
                    class="{{ request()->routeIs('expense.all') ? 'active' : '' }}">المصاريف
                </a>
            </li>
            <li>
                <a href="{{ route('payment.index') }}"
                    class="{{ request()->routeIs('payment.index') ? 'active' : '' }}">الدفعات
                </a>
            </li>
        @endrole
        <li style="background-color: red; border-radius: 10px; width:90%; margin-right: 5%">
            <a style="color: white" href="{{ route('logout') }}">تسجيل الخروج</a>
        </li>
    </ul>
</div>
