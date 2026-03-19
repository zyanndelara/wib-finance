@php
    $activePage = $activePage ?? '';
@endphp

<!-- Mobile Menu Toggle -->
<button class="mobile-menu-toggle" onclick="toggleSidebar()">
    <i class="fas fa-bars"></i>
</button>

<!-- Sidebar Overlay -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-logo">
        <img src="{{ asset('images/logowhite.png') }}" alt="Logo">
        <span class="app-name">When in Baguio Inc.</span>
    </div>

    <div class="sidebar-menu">
        <span class="menu-section-label">Main</span>
        <a href="{{ route('dashboard') }}" class="menu-item {{ $activePage === 'dashboard' ? 'active' : '' }}">
            <span class="menu-icon"><i class="fas fa-home"></i></span>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('remittance') }}" class="menu-item {{ $activePage === 'remittance' ? 'active' : '' }}">
            <span class="menu-icon"><i class="fas fa-file-invoice-dollar"></i></span>
            <span>Remittance</span>
        </a>
        <a href="{{ route('bank-deposit') }}" class="menu-item {{ $activePage === 'bank-deposit' ? 'active' : '' }}">
            <span class="menu-icon"><i class="fas fa-university"></i></span>
            <span>Bank &amp; Deposit</span>
        </a>

        <div class="menu-divider"></div>
        <span class="menu-section-label">Management</span>
        <a href="{{ route('merchants') }}" class="menu-item {{ $activePage === 'merchants' ? 'active' : '' }}">
            <span class="menu-icon"><i class="fas fa-store"></i></span>
            <span>Merchants</span>
        </a>
        <a href="{{ route('members.index') }}" class="menu-item {{ $activePage === 'members' ? 'active' : '' }}">
            <span class="menu-icon"><i class="fas fa-users-cog"></i></span>
            <span>Member Management</span>
        </a>
        <a href="{{ route('audit-logs') }}" class="menu-item {{ $activePage === 'audit-logs' ? 'active' : '' }}">
            <span class="menu-icon"><i class="fas fa-clipboard-list"></i></span>
            <span>Audit Logs</span>
        </a>

        <div class="menu-divider"></div>
        <span class="menu-section-label">Account</span>
        <a href="{{ route('profile') }}" class="menu-item {{ $activePage === 'profile' ? 'active' : '' }}">
            <span class="menu-icon"><i class="fas fa-user"></i></span>
            <span>Profile</span>
        </a>
    </div>

    <div class="sidebar-footer">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">
                <span class="menu-icon"><i class="fas fa-sign-out-alt"></i></span>
                <span>Logout</span>
            </button>
        </form>
    </div>
</div>