@extends('layouts.admin')

@section('page-subtitle', __('User management'))

@section('page-title', __('Agent list'))

@section('header-action')
<a href="{{ route('admin.agents.create') }}" class="btn btn-primary">
    <i class="fe fe-user-plus mr-2"></i>
    @lang('Create agent')
</a>
@endsection

@section('content')
<div class="container-fluid">
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
                            @if($user->is_active)
                            <a href="{{ route('admin.agents.edit', $user->id) }}"
                               class="font-weight-normal h5 px-2">
                                @lang('Edit')
                            </a>
                            |
                            <a href="{{ route('admin.agents.destroy', $user->id) }}"
                               class="font-weight-normal h5 px-2"
                               data-toggle="modal" data-backdrop="static"
                               data-target="#delete-agent"
                               data-agent-email="{{ $user->email }}"
                               data-agent-action="{{ route('admin.agents.destroy', $user->id) }}">
                                @lang('Delete')
                            </a>
                            @else
                            <a href="{{ route('admin.agents.restore', $user->id) }}"
                               class="font-weight-normal h5 px-2"
                               data-toggle="modal" data-backdrop="static"
                               data-target="#restore-agent"
                               data-agent-email="{{ $user->email }}"
                               data-agent-action="{{ route('admin.agents.restore', $user->id) }}">
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
</div>

<!-- Modal -->
<div class="modal fade" id="delete-agent" tabindex="-1" role="dialog"
     aria-labelledby="delete-agent-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <button type="button" class="close mr-3 mt-3"
                        data-dismiss="modal" aria-label="Close">
                    <i class="fe fe-x-circle"></i>
                </button>
                <form action="/" method="POST" class="mb-0">
                    @csrf
                    @method('DELETE')

                    <div class="d-flex my-3 pl-4 pt-4">
                        <i
                           class="display-4 fe fe-alert-circle mr-3 mt-n2 mt-n3 "></i>
                        <div>
                            <h3 class="mb-0">
                                @lang('Delete agent')?
                            </h3>
                            <p class="agent-email text-black-50"></p>
                        </div>
                    </div>

                    <div class="d-flex overflow-hidden rounded-bottom">
                        <button type="button"
                                class="btn btn-lg btn-outline-light rounded-0 text-body w-50"
                                data-dismiss="modal">
                            @lang('Cancel')
                        </button>
                        <button type="submit"
                                class="btn btn-lg btn-danger ladda-button rounded-0 w-50"
                                data-style="zoom-out">
                            @lang('Delete')
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="restore-agent" tabindex="-1" role="dialog"
     aria-labelledby="restore-agent-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <button type="button" class="close mr-3 mt-3"
                        data-dismiss="modal" aria-label="Close">
                    <i class="fe fe-x-circle"></i>
                </button>
                <form action="/" method="POST" class="mb-0">
                    @csrf

                    <div class="d-flex my-3 pl-4 pt-4">
                        <i
                           class="display-4 fe fe-alert-circle mr-3 mt-n2 mt-n3 "></i>
                        <div>
                            <h3 class="mb-0">
                                @lang('Restore agent')?
                            </h3>
                            <p class="agent-email text-black-50"></p>
                        </div>
                    </div>

                    <div class="d-flex overflow-hidden rounded-bottom">
                        <button type="button"
                                class="btn btn-lg btn-outline-light rounded-0 text-body w-50"
                                data-dismiss="modal">
                            @lang('Cancel')
                        </button>
                        <button type="submit"
                                class="btn btn-lg btn-success ladda-button rounded-0 w-50"
                                data-style="zoom-out">
                            @lang('Restore')
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
