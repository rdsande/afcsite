<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard') - Azam FC</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- AdminLTE CSS -->
    <link href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css" rel="stylesheet">
    
    <!-- Custom Admin Styles -->
    <style>
        .main-sidebar {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        }
        
        .nav-sidebar .nav-link {
            color: rgba(255, 255, 255, 0.9);
        }
        
        .nav-sidebar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }
        
        .nav-sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
        }
        
        .brand-link {
            background-color: rgba(0, 0, 0, 0.1);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .brand-text {
            color: white !important;
            font-weight: 600;
        }
        
        .content-wrapper {
            background-color: #f4f6f9;
        }
        
        .card {
            box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
        }
        
        .btn-primary {
            background-color: #1e3c72;
            border-color: #1e3c72;
        }
        
        .btn-primary:hover {
            background-color: #2a5298;
            border-color: #2a5298;
        }
    </style>
    
    @stack('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                        <i class="fas fa-bars"></i>
                    </a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('home') }}" class="nav-link" target="_blank">
                        <i class="fas fa-external-link-alt"></i> View Website
                    </a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- User Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fas fa-user-circle"></i>
                        <span class="d-none d-md-inline ml-1">{{ auth()->user()->name ?? 'Admin' }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <div class="dropdown-header">
                            <strong>{{ auth()->user()->name ?? 'Admin User' }}</strong>
                            <small class="text-muted d-block">{{ auth()->user()->email ?? 'admin@azamfc.com' }}</small>
                        </div>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('profile.show') }}" class="dropdown-item">
                            <i class="fas fa-user mr-2"></i> Profile
                        </a>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-cog mr-2"></i> Settings
                        </a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </button>
                        </form>
                    </div>
                </li>
            </ul>
        </nav>

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ route('admin.dashboard') }}" class="brand-link">
                <img src="{{ asset('images/azamfc-logo.png') }}" alt="Azam FC" class="brand-image img-circle elevation-3" style="opacity: .8; width: 33px; height: 33px; object-fit: cover;">
                <span class="brand-text">Azam FC Admin</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Dashboard -->
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        <!-- News Management -->
                        <li class="nav-item {{ request()->routeIs('admin.news.*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->routeIs('admin.news.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-newspaper"></i>
                                <p>
                                    News Management
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.news.index') }}" class="nav-link {{ request()->routeIs('admin.news.index') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All News</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.news.create') }}" class="nav-link {{ request()->routeIs('admin.news.create') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add News</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Players Management -->
                        <li class="nav-item {{ request()->routeIs('admin.players.*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->routeIs('admin.players.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Players Management
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.players.index') }}" class="nav-link {{ request()->routeIs('admin.players.index') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Players</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.players.create') }}" class="nav-link {{ request()->routeIs('admin.players.create') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add Player</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Teams Management -->
                        <li class="nav-item {{ request()->routeIs('admin.teams.*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->routeIs('admin.teams.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-shield-alt"></i>
                                <p>
                                    Teams Management
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.teams.index') }}" class="nav-link {{ request()->routeIs('admin.teams.index') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Teams</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.teams.create') }}" class="nav-link {{ request()->routeIs('admin.teams.create') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add Team</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Tournament Management -->
                        <li class="nav-item {{ request()->routeIs('admin.tournaments.*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->routeIs('admin.tournaments.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-trophy"></i>
                                <p>
                                    Tournament Management
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.tournaments.index') }}" class="nav-link {{ request()->routeIs('admin.tournaments.index') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Tournaments</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.tournaments.create') }}" class="nav-link {{ request()->routeIs('admin.tournaments.create') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add Tournament</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Fixtures Management -->
                        <li class="nav-item {{ request()->routeIs('admin.fixtures.*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->routeIs('admin.fixtures.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-calendar-alt"></i>
                                <p>
                                    Fixtures Management
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.fixtures.index') }}" class="nav-link {{ request()->routeIs('admin.fixtures.index') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Fixtures</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.fixtures.create') }}" class="nav-link {{ request()->routeIs('admin.fixtures.create') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add Fixture</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Divider -->
                        <li class="nav-header">FAN ENGAGEMENT</li>

                        <!-- Fan Management -->
                        <li class="nav-item {{ request()->routeIs('admin.fans.*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->routeIs('admin.fans.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-heart"></i>
                                <p>
                                    Fan Management
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.fans.index') }}" class="nav-link {{ request()->routeIs('admin.fans.index') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Fans</p>
                                    </a>
                                </li>

                            </ul>
                        </li>

                        <!-- Message Management -->
                        <li class="nav-item {{ request()->routeIs('admin.messages.*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-envelope"></i>
                                <p>
                                    Messages
                                    <i class="right fas fa-angle-left"></i>
                                    @php
                                        $pendingCount = \App\Models\FanMessage::where('status', 'open')->count();
                                    @endphp
                                    @if($pendingCount > 0)
                                        <span class="badge badge-danger right">{{ $pendingCount }}</span>
                                    @endif
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.messages.index') }}" class="nav-link {{ request()->routeIs('admin.messages.index') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Messages</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.messages.index', ['status' => 'open']) }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Pending Messages</p>
                                        @if($pendingCount > 0)
                                            <span class="badge badge-warning right">{{ $pendingCount }}</span>
                                        @endif
                                    </a>
                                </li>

                            </ul>
                        </li>

                        <!-- Admin Notices -->
                        <li class="nav-item {{ request()->routeIs('admin.admin.notices.*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->routeIs('admin.admin.notices.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-bullhorn"></i>
                                <p>
                                    Admin Notices
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.notices.index') }}" class="nav-link {{ request()->routeIs('admin.notices.index') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Notices</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.notices.create') }}" class="nav-link {{ request()->routeIs('admin.notices.create') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Create Notice</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Vendor Management -->
                        <li class="nav-item {{ request()->routeIs('admin.vendors.*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->routeIs('admin.vendors.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-store"></i>
                                <p>
                                    Vendor Management
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.vendors.index') }}" class="nav-link {{ request()->routeIs('admin.vendors.index') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Vendors</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.vendors.create') }}" class="nav-link {{ request()->routeIs('admin.vendors.create') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add Vendor</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Divider -->
                        <li class="nav-header">SYSTEM</li>

                        <!-- User Management (Admin and Super Admin) -->
                        @if(auth()->check() && in_array(auth()->user()->role, ['super_admin', 'admin']))
                        <li class="nav-item {{ request()->routeIs('admin.users.*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users-cog"></i>
                                <p>
                                    User Management
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.index') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Users</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.users.create') }}" class="nav-link {{ request()->routeIs('admin.users.create') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add User</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif

                        <!-- Settings -->
                        <li class="nav-item">
                            <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-cog"></i>
                                <p>Settings</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Content Header -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">@yield('title', 'Dashboard')</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                @yield('breadcrumb')
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <section class="content">
                <!-- Success Messages -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i>
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <!-- Error Messages -->
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @yield('content')
            </section>
        </div>

        <!-- Footer -->
        <footer class="main-footer">
            <strong>Copyright &copy; {{ date('Y') }} <a href="{{ route('home') }}">Azam FC</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0.0
            </div>
        </footer>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Bootstrap 4 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- AdminLTE App -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    
    <!-- Auto-dismiss alerts -->
    <script>
        $(document).ready(function() {
            // Auto-dismiss alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);
        });
    </script>
    
    @stack('scripts')
</body>
</html>