<div class="sidebar">

    {{-- ================= LOGO ================= --}}
    <div class="sidebar-header">

        <div class="logo">

            <i class="bi bi-globe2"></i>

            <div class="logo-text">
                <h3>Supply Chain</h3>
                <small>Risk Monitoring System</small>
            </div>

        </div>

    </div>

    <div class="sidebar-menu">

        {{-- ================= MAIN MENU ================= --}}

        <div class="sidebar-title">
            MAIN MENU
        </div>

        <a href="{{ route('dashboard') }}"
            class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">

            <i class="bi bi-speedometer2"></i>

            Dashboard

        </a>

        <a href="{{ route('dashboard') }}">

            <i class="bi bi-globe-americas"></i>

            World Map

        </a>

        {{-- ================= COUNTRIES ================= --}}

        <div class="sidebar-title">
            COUNTRIES
        </div>

        <a href="{{ route('comparison') }}"
            class="{{ request()->routeIs('comparison') ? 'active' : '' }}">

            <i class="bi bi-bar-chart"></i>

            Country Comparison

        </a>

        <a href="{{ route('watchlists.index') }}"
            class="{{ request()->routeIs('watchlists.*') ? 'active' : '' }}">

            <i class="bi bi-star-fill"></i>

            Watchlist

        </a>

        {{-- ================= SHIPMENTS ================= --}}

        <div class="sidebar-title">
            SHIPMENTS
        </div>

        <a href="{{ route('shipments.index') }}"
            class="{{ request()->routeIs('shipments.*') ? 'active' : '' }}">

            <i class="bi bi-box-seam"></i>

            Shipment List

        </a>

        <a href="{{ route('shipment.monitoring') }}"
            class="{{ request()->routeIs('shipment.monitoring') ? 'active' : '' }}">

            <i class="bi bi-truck"></i>

            Shipment Monitoring

        </a>

       {{-- ================= ANALYTICS ================= --}}

<div class="sidebar-title">
    ANALYTICS
</div>

<a href="{{ route('weather.index') }}"
class="{{ request()->routeIs('weather.*') ? 'active' : '' }}">

    <i class="bi bi-cloud-rain"></i>

    Weather Monitoring

</a>

<a href="{{ route('economy.index') }}"
class="{{ request()->routeIs('economy.*') ? 'active' : '' }}">

    <i class="bi bi-graph-up-arrow"></i>

    Economy Intelligence

</a>

<a href="{{ route('currency.index') }}"
class="{{ request()->routeIs('currency.*') ? 'active' : '' }}">

    <i class="bi bi-cash-coin"></i>

    Currency

</a>

<a href="{{ route('news.index') }}"
class="{{ request()->routeIs('news.*') ? 'active' : '' }}">

    <i class="bi bi-newspaper"></i>

    Global News

</a>

<a href="{{ route('risk.index') }}"
   class="{{ request()->routeIs('risk.*') ? 'active' : '' }}">

    <i class="bi bi-exclamation-triangle-fill"></i>

    Risk Analytics

</a>
        {{-- ================= ADMIN ================= --}}

        <hr class="text-secondary">

        <div class="sidebar-title">
            ADMIN
        </div>

        <a href="{{ route('admin.dashboard') }}"
            class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">

            <i class="bi bi-speedometer2"></i>

            Admin Dashboard

        </a>

        <a href="{{ route('admin.users') }}"
            class="{{ request()->routeIs('admin.users*') ? 'active' : '' }}">

            <i class="bi bi-people"></i>

            Manage Users

        </a>

        <a href="{{ route('admin.ports') }}"
            class="{{ request()->routeIs('admin.ports') ? 'active' : '' }}">

            <i class="bi bi-geo-alt"></i>

            Manage Ports

        </a>

        <a href="{{ route('admin.articles') }}"
            class="{{ request()->routeIs('admin.articles*') ? 'active' : '' }}">

            <i class="bi bi-file-earmark-text"></i>

            Analysis Articles

        </a>

        {{-- ================= ACCOUNT ================= --}}

        <div class="sidebar-title">
            ACCOUNT
        </div>

        <a href="{{ route('profile.edit') }}"
            class="{{ request()->routeIs('profile.*') ? 'active' : '' }}">

            <i class="bi bi-person-circle"></i>

            Profile

        </a>

        <form method="POST" action="{{ route('logout') }}">

            @csrf

            <button class="btn btn-link text-decoration-none text-start text-light w-100 ps-3 py-2">

                <i class="bi bi-box-arrow-right"></i>

                Logout

            </button>

        </form>

    </div>

</div>

<div class="content">

  <div class="topbar">

    <div class="topbar-left">

        <h3 class="topbar-title">
            Supply Chain Risk Monitoring
        </h3>

        <small class="topbar-subtitle">
            Global Supply Chain Intelligence Platform
        </small>

    </div>

    <div class="topbar-right">

        <i class="bi bi-search"></i>

        <i class="bi bi-bell"></i>

        <div class="user-info d-flex align-items-center gap-3">

            <div class="user-avatar">
                {{ strtoupper(substr(Auth::user()->name,0,1)) }}
            </div>

            <div>

                <strong class="user-name">
                    {{ Auth::user()->name }}
                </strong>

                <br>

                <small class="user-status">
                    ● Online
                </small>

            </div>

        </div>

    </div>

</div>

    <div class="dashboard-body">

        {{ $slot }}

    </div>

</div>