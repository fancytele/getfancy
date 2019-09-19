<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/admin.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        <!-- SIDEBAR NAVIGATION -->
        <nav class="bg-primary  fixed-left navbar navbar-dark navbar-expand-md navbar-vertical"
             id="sidebar">
            <div class="container-fluid">

                <!-- Toggler -->
                <button class="navbar-toggler" type="button"
                        data-toggle="collapse" data-target="#sidebarCollapse"
                        aria-controls="sidebarCollapse" aria-expanded="false"
                        aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Brand -->
                <a class="navbar-brand" href="{{ route('web.homepage') }}">
                    <img src="{{ asset('img/logo-light.png') }}" class="navbar-brand-img 
                      mx-auto" alt="...">
                </a>

                <!-- User (xs) -->
                <div class="navbar-user d-md-none">

                    <!-- Dropdown -->
                    <div class="dropdown">

                        <!-- Toggle -->
                        <a href="#" id="sidebarIcon" class="dropdown-toggle"
                           role="button" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            <div
                                 class="avatar avatar-sm avatar-online d-inline-block">
                                <img src="{{ Auth::user()->avatar }}"
                                     class="avatar-img rounded-circle"
                                     alt="{{ Auth::user()->full_name }} avatar">
                            </div>
                        </a>

                        <!-- Menu -->
                        <div class="dropdown-menu dropdown-menu-right"
                             aria-labelledby="sidebarIcon">
                            <a href="{{ route('admin.logout') }}"
                               class="dropdown-item logout-action">Logout</a>
                        </div>

                    </div>

                </div>

                <!-- Collapse -->
                <div class="collapse navbar-collapse" id="sidebarCollapse">

                    <!-- Form -->
                    <form class="mt-4 mb-3 d-md-none">
                        <div
                             class="input-group input-group-rounded input-group-merge">
                            <input type="search"
                                   class="form-control form-control-rounded form-control-prepended"
                                   placeholder="Search" aria-label="Search">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <span class="fe fe-search"></span>
                                </div>
                            </div>
                        </div>
                    </form>

                    <ul class="navbar-nav">
                        @hasanyrole('admin|agent')
                        <li class="nav-item">
                            <a class="nav-link" href="#sidebarDashboards"
                               data-toggle="collapse" role="button"
                               aria-expanded="false"
                               aria-controls="sidebarDashboards">
                                <i class="fe fe-home"></i> User Management
                            </a>
                            <div class="collapse" id="sidebarDashboards">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            Users
                                        </a>
                                    </li>
                                    @role('admin')
                                    <li class="nav-item">
                                        <a href="#" class="nav-link ">
                                            Agent
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            Admin
                                        </a>
                                    </li>
                                    @endrole
                                </ul>
                            </div>
                        </li>
                        @endhasanyrole
                    </ul>
                </div> <!-- / .navbar-collapse -->
            </div>
        </nav>

        <main class="main-content">
            <!-- MAIN NAVIGATION -->
            <nav class="navbar navbar-expand-md navbar-light d-none d-md-flex"
                 id="topbar">
                <div class="container-fluid">

                    <!-- Form -->
                    <form class="form-inline mr-4 d-none d-md-flex">
                        <div class="input-group input-group-flush input-group-merge"
                             data-toggle="lists"
                             data-options='{"valueNames": ["name"]}'>

                            <!-- Input -->
                            <input type="search"
                                   class="form-control form-control-prepended search"
                                   placeholder="@lang('Search')"
                                   aria-label="Search">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fe fe-search"></i>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- User -->
                    <div class="navbar-user">

                        <!-- Dropdown -->
                        <div class="dropdown">

                            <!-- Toggle -->
                            <a href="#"
                               class="avatar avatar-sm avatar-online dropdown-toggle d-inline-block"
                               role="button" data-toggle="dropdown"
                               aria-haspopup="true" aria-expanded="false">
                                <img src="{{ Auth::user()->avatar }}"
                                     alt="{{ Auth::user()->full_name }} avatar"
                                     class="avatar-img rounded-circle">
                            </a>

                            <!-- Menu -->
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="{{ route('admin.logout') }}"
                                   class="dropdown-item logout-action">
                                    @lang('Logout')
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- HEADER -->
            <div class="header">
                <div class="container-fluid">

                    <!-- Body -->
                    <div class="header-body">
                        <div class="row align-items-end">
                            <div class="col">

                                @hasSection ('page-subtitle')
                                <!-- Pretitle -->
                                <h6 class="header-pretitle">
                                    @yield('page-subtitle')
                                </h6>
                                @endif

                                <!-- Title -->
                                <h1 class="header-title">
                                    @yield('page-title')
                                </h1>
                            </div>
                        </div> <!-- / .row -->
                    </div> <!-- / .header-body -->

                </div>
            </div> <!-- / .header -->

            @yield('content')
        </main>
    </div>

    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST"
          class="d-none">
        @csrf
    </form>
</body>

</html>