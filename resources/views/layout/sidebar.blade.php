<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <div class="sidebar-brand d-flex align-items-center justify-content-center">
        <div class="sidebar-brand-icon">
            <img class="w-100 rounded float-left" src="{{ asset('img/logo.jpg') }}" alt="Logo Posyandu">
        </div>
        <div class="sidebar-brand-text mx-3">Posyandu </div>
    </div>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ Request::is('admin/home') ? 'active' : '' }}">
        <a class="nav-link" href="">
            <i class="fas fa-fw fa-home"></i>
            <span>Dashboard</span></a>
    </li>

    {{-- @if (Auth::user()->role == 'admin' || Auth::user()->role == 'dosen') --}}
    <hr class="sidebar-divider">
    {{-- User --}}
    <div class="sidebar-heading">
        User
    </div>
    <li class="nav-item {{ Request::is('admin/user') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('user.index') }}">
            <i class="fas fa-fw fa-user-alt"></i>
            <span>List All User</span></a>
    </li>
    {{-- <li class="nav-item {{ Request::is('admin/user') ? 'active' : '' }}">
        <a class="nav-link" href="">
            <i class="fas fa-fw fa-users"></i>
            <span>List Active User</span></a>
    </li>
    <li class="nav-item {{ Request::is('admin/verification-list-user') ? 'active' : '' }}">
        <a class="nav-link" href="">
            <i class="fas fa-fw fa-user-plus"></i>
            <span>Verifikasi Akun</span></a>
    </li> --}}
    {{-- @endif --}}
    <hr class="sidebar-divider">
    {{-- Inventory --}}
    <div class="sidebar-heading">
        Main Menu
    </div>
    <li class="nav-item {{ Request::is('admin/anggota') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('anggota.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Data Anggota</span></a>
    </li>
    <li class="nav-item {{ Request::is('admin/peralatan') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('peralatan.index') }}">
            <i class="fas fa-fw fa-medkit"></i>
            <span>Data Peralatan</span></a>
    </li>
    <li class="nav-item {{ Request::is('admin/jadwal') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('jadwal.index') }}">
            <i class="fas fa-fw fa-calendar-alt"></i>
            <span>Data Jadwal</span></a>
    </li>
    <li class="nav-item {{ Request::is('admin/pelayanan') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('pelayanan.index') }}">
            <i class="fas fa-fw fa-ambulance"></i>
            <span>Data Pelayanan</span></a>
    </li>

    {{-- <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Inventory
    </div>

    <hr class="sidebar-divider"> --}}

    {{-- Machine --}}
    {{-- <div class="sidebar-heading">
        Machine Control Report
    </div>
    @if (Auth::user()->role == 'admin' || Auth::user()->role == 'dosen')
        <li class="nav-item {{ Request::is('admin/machine/settings') ? 'active' : '' }}">
            <a class="nav-link " href="{{ route('admin.machine.settings') }}">
                <i class="fas fa-fw fa-cogs"></i>
                <span>Settings</span>
            </a>
        </li>
    @endif
    <li class="nav-item {{ Request::is('machine/*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#machine_sidebar"
            aria-expanded="true" aria-controls="machine_sidebar">
            <i class="fas fa-fw fa-list-alt"></i>
            <span>Machine</span>
        </a>
        <div id="machine_sidebar" class="collapse {{ Request::is('machine/*') ? 'show' : '' }}"
            aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ Request::is('machine/manual-pot-sink') ? 'active' : '' }}"
                    href="{{ route('manual-pot-sink.index') }}">Manual Pot Sink</a>
                <a class="collapse-item {{ Request::is('machine/high-temp-dish-machine') ? 'active' : '' }}"
                    href="{{ route('high-temp-dish-machine.index') }}">High Temp. Dish Machine</a>
                <a class="collapse-item {{ Request::is('machine/ice-machine-cleaning') ? 'active' : '' }}"
                    href="{{ route('ice-machine-cleaning.index') }}">Ice Machine Cleaning</a>
                <a class="collapse-item {{ Request::is('machine/daily-scoop') ? 'active' : '' }}"
                    href="{{ route('daily-scoop.index') }}">Daily
                    Scoop, Container <br> Cleaning &
                    Sanitation</a>
            </div>
        </div>
    </li>

    <hr class="sidebar-divider"> --}}

    <hr class="sidebar-divider">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
