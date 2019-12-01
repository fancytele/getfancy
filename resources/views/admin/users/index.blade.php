@extends('layouts.admin')

@section('page-subtitle', __('User management'))

@section('page-title', __('User list'))

@if($users->isNotEmpty ())
@section('header-action')
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
        <i class="fe fe-user-plus mr-2"></i>
        @lang('Create User')
    </a>
@endsection
@endif

@section('content')
    <div class="container-fluid">
        @if($users->isEmpty())
            <div class="row">
                <div class="col-12">
                    <div class="card card-flush">
                        <div class="card-body text-center">
                            <h1 class="display-4">
                                @lang('No Users yet'). 😭
                            </h1>

                            <a href="{{ route('admin.users.create') }}"
                               class="btn btn-primary">
                                <i class="fe fe-user-plus mr-2"></i>
                                @lang('Create User')
                            </a>
                        </div>
                    </div>
                </div>
            </div> <!-- / .row -->
        @endif

        @if($users->isNotEmpty ())
            <div class="card" data-toggle="lists"
                 data-options='{"valueNames": ["orders-name", "orders-email", "orders-last-login", "orders-status"]}'>
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <!-- Search -->
                            <form class="row align-items-center">
                                <div class="col-auto pr-0">
                                    <span class="fe fe-search text-muted"></span>
                                </div>
                                <div class="col">
                                    <label>
                                        <input type="search"
                                               class="form-control form-control-flush search"
                                               placeholder="@lang('Search')">
                                    </label>
                                </div>
                            </form>
                        </div>
                    </div> <!-- / .row -->
                </div>
                <div class="table-responsive">
                    <table
                            class="card-table table table-hover table-sm table-nowrap table-row-counter">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">
                                <a href="#" class="text-muted sort"
                                   data-sort="orders-name">
                                    @lang('Name')
                                </a>
                            </th>
                            <th scope="col">
                                <a href="#" class="text-muted sort"
                                   data-sort="orders-email">
                                    @lang('E-mail')
                                </a>
                            </th>
                            <th scope="col">
                                <a href="#" class="text-muted sort"
                                   data-sort="orders-last-login">
                                    @lang('Last login')
                                </a>
                            </th>
                            <th scope="col">
                                <a href="#" class="text-muted sort"
                                   data-sort="orders-status">
                                    @lang('Status')
                                </a>
                            </th>
                            <th>
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="list">
                        @foreach($users as $key => $user)
                            <tr>
                                <td scope="row" class="align-middle">
                            <span class="sr-only"
                                  aria-label="Default row number">{{ $key + 1 }}</span>
                                </td>
                                <td class="align-middle orders-name">
                                    {{ $user->full_name }}</td>
                                <td class="align-middle orders-email">{{ $user->email }}
                                </td>
                                <td class="align-middle orders-last-login">
                                    {{ optional($user->last_login)->diffForHumans() }}
                                </td>
                                <td class="align-middle orders-status">
                                    @if($user->is_active)
                                        <div
                                                class="badge badge-soft-success font-size-inherit">
                                            @lang('Active')
                                        </div>
                                    @else
                                        <div
                                                class="badge badge-soft-danger font-size-inherit">
                                            @lang('Inactive')
                                        </div>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    @if($user->fancy_number)
                                        <a href="{{ route('admin.users.edit_fancy', $user->id) }}" class="font-weight-normal h5 px-2">
                                            @lang('Fancy Settings')
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>

    <!-- Modals -->
    @if($users->isNotEmpty ())
        @include('partials.delete-element')
        @include('partials.restore-element')
    @endif

@endsection
