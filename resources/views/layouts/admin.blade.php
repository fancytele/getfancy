<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }}</title>

        <!-- Scripts -->
        @stack('head-scripts')
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>

    <body>
        <div id="app" v-cloak>
            <!-- SIDEBAR NAVIGATION -->
            <nav class="bg-primary  fixed-left navbar navbar-dark navbar-expand-md navbar-vertical" id="sidebar">
                <div class="container-fluid">

                    <!-- Toggler -->
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidebarCollapse"
                            aria-controls="sidebarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <!-- Brand -->
                    <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                        <img src="{{ asset('img/logo-light.png') }}" class="navbar-brand-img 
                      mx-auto" alt="Fancy Logo Light">
                    </a>

                    <!-- User (xs) -->
                    <div class="navbar-user d-md-none">

                        <!-- Dropdown -->
                        <div class="dropdown">

                            <!-- Toggle -->
                            <a href="#" id="sidebarIcon" class="dropdown-toggle" role="button" data-toggle="dropdown"
                               aria-haspopup="true" aria-expanded="false">
                                <div class="avatar avatar-sm avatar-online d-inline-block">
                                    <img src="{{ Auth::user()->avatar }}" class="avatar-img rounded-circle"
                                         alt="{{ Auth::user()->display_name }} avatar">
                                </div>
                            </a>

                            <!-- Menu -->
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="sidebarIcon">
                                <a href="{{ route('admin.logout') }}" class="dropdown-item logout-action">Logout</a>
                            </div>

                        </div>

                    </div>

                    <!-- Collapse -->
                    <div class="collapse navbar-collapse" id="sidebarCollapse">

                        <!-- Form -->
                        <form class="mt-4 mb-3 d-md-none">
                            <div class="input-group input-group-rounded input-group-merge">
                                <input type="search" class="form-control form-control-rounded form-control-prepended"
                                       placeholder="Search" aria-label="Search">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <span class="fe fe-search"></span>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link{{ (request()->is('admin/dashboard')) ? ' active' : ''}}"
                                   href="{{ route('admin.dashboard') }}">
                                    <i class="fe fe-home"></i> Dashboard
                                </a>
                            </li>
                            @hasanyrole('admin|agent')
                            <li class="nav-item">
                                <a class="nav-link{{ (request()->is('admin/users*', 'admin/agents*', 'admin/operators*')) ? ' active' : ''}}"
                                   href="#sidebarUsers" data-toggle="collapse" role="button"
                                   aria-expanded="{{ (request()->is('admin/users*', 'admin/agents*', 'admin/operators*')) ? 'true' : 'false'}}"
                                   aria-controls="sidebarUsers">
                                    <i class="fe fe-users"></i>
                                    @lang('User management')
                                </a>
                                <div id="sidebarUsers"
                                     class="collapse {{ (request()->is('admin/users*', 'admin/agents*', 'admin/operators*')) ? ' show' : ''}}">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('admin.users.index') }}"
                                               class="nav-link {{ (request()->is('admin/users*')) ? ' active' : ''}}">
                                                @lang('Users')
                                            </a>
                                        </li>
                                        @role('admin')
                                        <li class="nav-item">
                                            <a href="{{ route('admin.agents.index') }}"
                                               class="nav-link{{ (request()->is('admin/agents*')) ? ' active' : ''}}">
                                                @lang('Agents')
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.operators.index') }}"
                                               class="nav-link{{ (request()->is('admin/operators*')) ? ' active' : ''}}">
                                                @lang('Operator')
                                            </a>
                                        </li>
                                        @endrole
                                    </ul>
                                </div>
                            </li>
                            @endhasanyrole
                            @hasanyrole('admin|operator')
                            <li class="nav-item">
                                <a class="nav-link{{ (request()->is('admin/tickets*')) ? ' active' : ''}}"
                                   href="{{ route('admin.tickets.index') }}">
                                    <i class="fe fe-clipboard"></i> Tickets
                                </a>
                            </li>
                            @endhasanyrole
                        </ul>

                        <!-- Push content down -->
                        <div class="mt-auto"></div>

                        <div class="mb-3 text-center text-white">
                            @if(App::isLocale('en'))
                            <span class="text-muted">English</span>
                            @else
                            <a href="{{ route('web.locale', 'en') }}" class="text-white">English</a>
                            @endif
                            <span class="px-3">|</span>
                            @if(App::isLocale('es'))
                            <span class="text-muted">Español</span>
                            @else
                            <a href="{{ route('web.locale', 'es') }}" class="text-white">Español</a>
                            @endif
                        </div>
                    </div> <!-- / .navbar-collapse -->
                </div>
            </nav>

            <main class="main-content">
                <!-- MAIN NAVIGATION -->
                <nav class="navbar navbar-expand-md navbar-light d-none d-md-flex" id="topbar">
                    <div class="container-fluid">

                        <!-- Form -->
                        <form class="form-inline mr-4 d-none d-md-flex">
                            <div class="input-group input-group-flush input-group-merge">

                                <!-- Input -->
                                <input type="search" class="form-control form-control-prepended search"
                                       placeholder="@lang('Search')" aria-label="Search">
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
                                <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown"
                                   aria-haspopup="true" aria-expanded="false">
                                    <span class="align-middle mr-2">
                                        {{ Auth::user()->display_name }}
                                    </span>
                                    <span class="avatar avatar-sm d-inline-block">
                                        <img src="{{ Auth::user()->avatar }}"
                                             alt="{{ Auth::user()->display_name }} avatar"
                                             class="avatar-img rounded-circle">
                                    </span>
                                </a>

                                <!-- Menu -->
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="{{ route('admin.logout') }}" class="dropdown-item logout-action">
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
                            <div class="row align-items-center">
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
                                @hasSection('header-action')
                                <div class="col-auto">
                                    @yield('header-action')
                                </div>
                                @endif
                            </div> <!-- / .row -->
                        </div> <!-- / .header-body -->

                    </div>
                </div> <!-- / .header -->

                @includeWhen(session('alert'), 'partials.alert', ['alert' => session('alert')])

                @yield('content')
            </main>
        </div>

        <!-- Logout Form -->
        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
            @csrf
        </form>
        <!-- / Logout Form -->

        <script src="{{ asset('js/admin.js') }}" defer></script>
    </body>

</html>