<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }} - @yield('page-title')</title>

        <!-- Scripts -->
        @stack('head-scripts')
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>

    <body>
        <div id="app" v-cloak>
            <main class="main-content">
                <!-- MAIN NAVIGATION -->
                <nav class="navbar navbar-expand-md navbar-light d-none d-md-flex" id="topbar">
                    <div class="container-fluid">
                        <!-- User -->
                        <div class="navbar-user ml-auto">

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
                                    @role('admin')
                                        <a href="#" class="dropdown-item"
                                            data-toggle="modal" data-target="#modal-vertical-right">
                                            @lang('Login as')...
                                        </a>
                                        <div class="dropdown-divider m-0"></div>
                                    @endrole
                                    @if(Auth::user()->isImpersonating())
                                        <a href="{{ route('admin.users.stop_impersonate') }}" class="dropdown-item">
                                            @lang('Stop viewing as ') {{ Auth::user()->roles->first()->name }}
                                        </a>
                                        <div class="dropdown-divider m-0"></div>
                                    @endif
                                    <a href="{{ route('admin.logout') }}" class="dropdown-item logout-action">
                                        @lang('Logout')
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>

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