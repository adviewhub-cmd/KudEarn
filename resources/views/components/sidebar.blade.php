<div class="sidebar">

    <div class="logo">

        KUD.EARN

    </div>

    <a href="{{ route('dashboard') }}"
       class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">

        <i class="bi bi-speedometer2"></i>

        Dashboard

    </a>

    <a href="{{ route('investments.index') }}">

        <i class="bi bi-graph-up"></i>

        Investments

    </a>

    <a href="{{ route('daily-tasks.index') }}">

        <i class="bi bi-check2-square"></i>

        Daily Tasks

    </a>

    <a href="{{ route('transactions.index') }}">

        <i class="bi bi-wallet2"></i>

        Wallet

    </a>

    <a href="{{ route('deposits.index') }}">

        <i class="bi bi-credit-card"></i>

        Deposits

    </a>

</div>