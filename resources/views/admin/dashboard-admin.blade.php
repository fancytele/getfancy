@extends('layouts.admin')

@section('page-title',  ucfirst(Auth::user()->roles->first()->name).' Dashboard')

@section('content')
<div class="container-fluid">
    @if(count($users) > 0 )
        <h2>User Management</h2>
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
        </div>
    @endif
</div>
@endsection
