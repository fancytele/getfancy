@extends('layouts.admin')

@section('page-subtitle', __('User management'))

@section('page-title', __('Agent list'))

@if($agents->isNotEmpty ())
    @section('header-action')
        <a href="{{ route('admin.agents.create') }}" class="btn btn-primary">
            <i class="fe fe-user-plus mr-2"></i>
            @lang('Create Agent')
        </a>
    @endsection
@endif

@section('content')
    <div class="container-fluid">
        @if($agents->isEmpty())
            <div class="row">
                <div class="col-12">
                    <div class="card card-flush">
                        <div class="card-body text-center">
                            <h1 class="display-4">
                                @lang('No agents yet'). 😭
                            </h1>

                            <a href="{{ route('admin.agents.create') }}"
                            class="btn btn-primary">
                                <i class="fe fe-user-plus mr-2"></i>
                                @lang('Create agent')
                            </a>
                        </div>
                    </div>
                </div>
            </div> <!-- / .row -->
        @endif

        @if($agents->isNotEmpty ())
            <div class="card" data-toggle="lists"
                data-options='{"valueNames": ["orders-name", "orders-code", "orders-email", "orders-last-login", "orders-status"]}'>
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <!-- Search -->
                            <form class="row align-items-center">
                                <div class="col-auto pr-0">
                                    <span class="fe fe-search text-muted"></span>
                                </div>
                                <div class="col">
                                    <input type="search"
                                        class="form-control form-control-flush search"
                                        placeholder="@lang('Search')">
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
                                       data-sort="orders-code">
                                        @lang('Agent code')
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
                            @foreach($agents as $key => $agent)
                                <tr>
                                    <td scope="row" class="align-middle">
                                        <span class="sr-only"
                                            aria-label="Default row number">{{ $key + 1 }}</span>
                                    </td>
                                    <td class="align-middle orders-name">
                                        {{ $agent->full_name }}
                                    </td>
                                    <td class="align-middle orders-code">
                                        {{ $agent->employee_code }}
                                    </td>
                                    <td class="align-middle orders-email">
                                        {{ $agent->email }}
                                    </td>
                                    <td class="align-middle orders-last-login">
                                        {{ optional($agent->last_login)->diffForHumans() }}
                                    </td>
                                    <td class="align-middle orders-status">
                                        @if($agent->is_active)
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
                                        @if($agent->is_active)
                                            <a href="{{ route('admin.agents.edit', $agent->id) }}"
                                               class="font-weight-normal h5 px-2">
                                                @lang('Edit')
                                            </a>
                                            |
                                            <a href="{{ route('admin.agents.destroy', $agent->id) }}"
                                               class="font-weight-normal h5 px-2"
                                               data-toggle="modal" data-backdrop="static"
                                               data-target="#delete-element"
                                               data-name="@lang('Agent')"
                                               data-detail="{{ $agent->email }}"
                                               data-action="{{ route('admin.agents.destroy', $agent->id) }}">
                                                @lang('Delete')
                                            </a>
                                        @else
                                            <a href="{{ route('admin.agents.restore', $agent->id) }}"
                                               class="font-weight-normal h5 px-2"
                                               data-toggle="modal" data-backdrop="static"
                                               data-target="#restore-element"
                                               data-name="@lang('Agent')"
                                               data-detail="{{ $agent->email }}"
                                               data-action="{{ route('admin.agents.restore', $agent->id) }}">
                                                @lang('Restore')
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
    @if($agents->isNotEmpty())
        @include('partials.delete-element')
        @include('partials.restore-element')
    @endif
@endsection
