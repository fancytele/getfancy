@extends('layouts.admin')

@section('page-subtitle', 'Overwiew')
@section('page-title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        @foreach ($users as $user)
            <div class="col-12 col-lg-6 col-xl-3">
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

        @foreach ($subscriptions as $subscription)
            <div class="col-12 col-lg-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col text-truncate">
                                <!-- Title -->
                                <h6 class="card-title text-uppercase text-muted mb-2">
                                    Subscription: {{ $subscription->product_name }}
                                </h6>

                                <!-- Heading -->
                                <span class="h2 mb-0">{{ $subscription->total }}</span>
                            </div>
                            <div class="col-auto">
                                <span class="h2 fe fe-dollar-sign text-muted mb-0"></span>
                            </div>
                        </div> <!-- / .row -->
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
