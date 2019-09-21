@extends('layouts.admin')

@section('page-subtitle', 'Overwiew')
@section('page-title', 'Dahboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        @foreach ($users as $user)
        <div class="col-12 col-lg-6 col-xl">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col text-truncate">
                            <!-- Title -->
                            <h6
                                class="card-title text-uppercase text-muted mb-2">
                                @lang(ucfirst(Str::plural($user->role)))
                            </h6>

                            <!-- Heading -->
                            <span class="h2 mb-0">{{ $user->count }}</span>
                        </div>
                        <div class="col-auto">
                            <span class="h2 fe fe-users text-muted mb-0"></span>
                        </div>
                    </div> <!-- / .row -->
                </div>
            </div>
        </div>
        @endforeach

        <div class="col-12 col-lg-6 col-xl">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col text-truncate">
                            <!-- Title -->
                            <h6
                                class="card-title text-uppercase text-muted mb-2">
                                1 month subscriptions
                            </h6>

                            <!-- Heading -->
                            <span class="h2 mb-0">0</span>
                        </div>
                        <div class="col-auto">
                            <span
                                  class="h2 fe fe-calendar text-muted mb-0"></span>
                        </div>
                    </div> <!-- / .row -->
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6 col-xl">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col text-truncate">
                            <!-- Title -->
                            <h6
                                class="card-title text-uppercase text-muted mb-2">
                                1 year subscriptions
                            </h6>

                            <!-- Heading -->
                            <span class="h2 mb-0">0</span>
                        </div>
                        <div class="col-auto">
                            <span
                                  class="h2 fe fe-calendar text-muted mb-0"></span>
                        </div>
                    </div> <!-- / .row -->
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6 col-xl">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col text-truncate">
                            <h6
                                class="card-title text-uppercase text-muted mb-2">
                                2 year subscriptions
                            </h6>

                            <span class="h2 mb-0">0</span>
                        </div>
                        <div class="col-auto">
                            <span
                                  class="h2 fe fe-calendar text-muted mb-0"></span>
                        </div>
                    </div> <!-- / .row -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
