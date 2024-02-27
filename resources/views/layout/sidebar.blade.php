<ul class="navbar-nav {{ Auth::user()->role == 'admin' ? 'bg-gradient-danger' : 'bg-gradient-primary' }}  sidebar sidebar-dark accordion"
    id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <div class="sidebar-brand d-flex align-items-center justify-content-center">
        <div class="sidebar-brand-icon">
            <img class="w-50" src="{{ asset('img/unj.png') }}" alt="Logo UNJ">
        </div>
        <div class="sidebar-brand-text mx-3">Stewarding Learning </div>
    </div>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ Request::is('admin/home') ? 'active' : '' }}">
        <a class="nav-link" href="{{ Auth::user()->role == 'admin' ? route('admin.home') : route('home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    @if (Auth::user()->role == 'admin' || Auth::user()->role == 'dosen')
        <hr class="sidebar-divider">
        {{-- User --}}
        <div class="sidebar-heading">
            User
        </div>
        <li class="nav-item {{ Request::is('admin/user-all') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('user.all') }}">
                <i class="fas fa-fw fa-user-alt"></i>
                <span>List All User</span></a>
        </li>
        <li class="nav-item {{ Request::is('admin/user') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('user.index') }}">
                <i class="fas fa-fw fa-users"></i>
                <span>List Active User</span></a>
        </li>
        <li class="nav-item {{ Request::is('admin/verification-list-user') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('user.list-verify') }}">
                <i class="fas fa-fw fa-user-plus"></i>
                <span>Verifikasi Akun</span></a>
        </li>
    @endif
    <hr class="sidebar-divider">
    {{-- Inventory --}}
    <div class="sidebar-heading">
        Inventory
    </div>
    @if (Auth::user()->role == 'admin' || Auth::user()->role == 'dosen')
        <li class="nav-item {{ Request::is('admin/inventory/settings') ? 'active' : '' }}">
            <a class="nav-link " href="{{ route('admin.inventory.settings') }}">
                <i class="fas fa-fw fa-cogs"></i>
                <span>Settings</span>
            </a>
        </li>
    @endif
    <li class="nav-item {{ Request::is('inventory/*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#inventory_sidebar"
            aria-expanded="true" aria-controls="inventory_sidebar">
            <i class="fas fa-fw fa-archive"></i>
            <span>Inventory</span>
        </a>
        <div id="inventory_sidebar" class="collapse {{ Request::is('inventory/*') ? 'show' : '' }}"
            aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ Request::is('inventory/inventory-ware-list') ? 'active' : '' }}"
                    href="{{ route('inventory.warelist') }}">Inventory Ware List</a>
                <a class="collapse-item {{ Request::is('inventory/inventory-chemical-list') ? 'active' : '' }}"
                    href="{{ route('inventory.chemicallist') }}">Inventory Chemical List</a>
                <a class="collapse-item {{ Request::is('inventory/weekly-breakage') ? 'active' : '' }}"
                    href="{{ route('weekly-breakage.index') }}">Weekly Breakage</a>
                <a class="collapse-item {{ Request::is('inventory/input') ? 'active' : '' }}"
                    href="{{ route('inventory.input') }}">Input Inventory</a>
            </div>
        </div>
    </li>

    <hr class="sidebar-divider">

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

    {{-- Loan --}}
    <div class="sidebar-heading">
        Warehouse Loan
    </div>
    <li class="nav-item {{ Request::is('loan/*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#loan_sidebar"
            aria-expanded="true" aria-controls="loan_sidebar">
            <i class="far fa-fw fa-edit"></i>
            <span>Loan</span>
        </a>
        <div id="loan_sidebar"
            class="collapse {{ (Request::is('loan/*') ? 'show' : '' || Request::is('loan')) ? 'show' : '' }}"
            aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ Request::is('loan') ? 'active' : '' }}"
                    href="{{ route('loan.index') }}">List Loan</a>
                <a class="collapse-item {{ Request::is('loan/borrowing-form') ? 'active' : '' }}"
                    href="{{ route('loan.borrowing_form') }}">Requisition Equipment Form</a>
                <a class="collapse-item {{ Request::is('loan/returning-form') ? 'active' : '' }}"
                    href="{{ route('loan.returning_form') }}">Return Form</a>
            </div>
        </div>
    </li>

    <hr class="sidebar-divider">

    {{-- Exercise --}}
    <div class="sidebar-heading">
        Exercise
    </div>
    <li class="nav-item">
        @if (Auth::user()->role == 'admin' || Auth::user()->role == 'dosen')
            <a class="nav-link collapsed " href="#" data-toggle="collapse" data-target="#task_sidebar_admin"
                aria-expanded="true" aria-controls="task_sidebar_admin">
                <i class="far fa-fw fa-edit"></i>
                <span>Task and Exercise</span>
            </a>
            <div id="task_sidebar_admin"
                class="collapse {{ (Request::is('admin/task/*') ? 'show' : '' || Request::is('admin/task')) ? 'show' : '' }}"
                aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item {{ Request::is('admin/task') ? 'active' : '' }}"
                        href="{{ route('task.index') }}">List Tugas</a>
                    <a class="collapse-item {{ Request::is('admin/task/create') ? 'active' : '' }}"
                        href="{{ route('task.create') }}">Input Tugas</a>
                </div>
            </div>
        @endif
        @if (Auth::user()->role == 'user')
            <a class="nav-link collapsed" href="{{ route('task-list.index') }}">
                <i class="far fa-fw fa-edit"></i>
                <span>Task and Exercise</span>
            </a>
        @endif
    </li>

    <hr class="sidebar-divider">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    <!-- Sidebar Message -->
    {{-- <div class="sidebar-card d-none d-lg-flex">
        <img class="sidebar-card-illustration mb-2" src="img/undraw_rocket.svg" alt="...">
        <p class="text-center mb-2"><strong>SB Admin Pro</strong> is packed with premium features, components,
            and more!</p>
        <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to
            Pro!</a>
    </div> --}}

</ul>
