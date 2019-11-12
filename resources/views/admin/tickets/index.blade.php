@extends('layouts.admin')

@section('page-subtitle', __('Ticket management'))

@section('page-title', __('Ticket list'))

@section('content')
    <div class="container-fluid">
        @if($tickets->isEmpty())
            <div class="row">
                <div class="col-12">
                    <div class="card card-flush">
                        <div class="card-body text-center">
                            <h1 class="display-4">
                                @lang('No tickets yet'). 😭
                            </h1>
                        </div>
                    </div>
                </div>
            </div> <!-- / .row -->
        @endif

        @if($tickets->isNotEmpty ())
            <div class="card" data-toggle="lists"
                data-options='{"valueNames": ["orders-number", "orders-user-name", "orders-status"]}'>
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <!-- Search -->
                            <form class="row align-items-center">
                                <div class="col-auto pr-0">
                                    <span class="fe fe-search text-muted"></span>
                                </div>
                                <div class="col">
                                    <input type="search" class="form-control form-control-flush search"
                                        placeholder="@lang('Search')">
                                </div>
                            </form>
                        </div>
                    </div> <!-- / .row -->
                </div>
                <div class="table-responsive">
                    <table class="card-table table table-hover table-sm table-nowrap">
                        <thead>
                            <tr>
                                <th scope="col">
                                    <a href="#" class="text-muted sort"
                                    data-sort="orders-number">
                                        @lang('Ticket #')
                                    </a>
                                </th>
                                <th scope="col">
                                    <a href="#" class="text-muted sort"
                                    data-sort="orders-user-name">
                                        @lang('User name')
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
                            @foreach($tickets as $ticket)
                                <tr>
                                    <td scope="row" class="align-middle">
                                        <p class="font-weight-bold mb-0">
                                            Ticket #{{ $ticket->id }}
                                            @if($ticket->parent_id)
                                                <i class="fe fe-git-branch font-weight-bold" data-toggle="tooltip" data-placement="top"
                                                title="Related to Ticket #{{$ticket->parent_id}}"></i>
                                            @endif
                                        </p>
                                        <p class="mb-0 text-black-50">
                                            @if($ticket->assigned)
                                                <i class="fe fe-user font-weight-bold"></i>
                                                {{ $ticket->assigned->full_name}}
                                            @else
                                                <em>@lang('Unassigned')</em>
                                            @endif
                                        </p>
                                    </td>
                                    <td class="align-middle orders-user-name">
                                        <p class="mb-0">{{ $ticket->fancyNumber->user->full_name }}</p>
                                        <p class="mb-0 font-weight-bold">
                                            <i class="fe fe-phone font-weight-bold"></i>
                                            {{ $ticket->fancyNumber->us_did_number }}
                                        </p>
                                    </td>
                                    <td class="align-middle orders-status">
                                        @if($ticket->status === 'pending')
                                            <div
                                                class="badge badge-soft-dark font-size-inherit">
                                                @lang('Pending')
                                            </div>
                                        @elseif($ticket->status == 'in_progress')
                                            <div
                                                class="badge badge-soft-primary font-size-inherit">
                                                @lang('In progress')
                                            </div>
                                        @elseif($ticket->status == 'completed')
                                            <div
                                                class="badge badge-soft-success font-size-inherit">
                                                @lang('Completed')
                                            </div>
                                        @elseif($ticket->status == 'removed')
                                            <div
                                                class="badge badge-soft-danger font-size-inherit">
                                                @lang('Removed')
                                            </div>
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        @if($ticket->status != 'in_progress')
                                            <a href="{{ route('admin.tickets.show', $ticket->id) }}"
                                            class="font-weight-normal h5 px-2">
                                                @lang('View')
                                            </a>
                                        @endif
                                        @if($ticket->status == 'in_progress')
                                            <a href="{{ route('admin.tickets.show', $ticket->id) }}"
                                            class="font-weight-normal h5 px-2">
                                                @lang('Edit')
                                            </a>
                                        @endif
                                        @if($ticket->status != 'removed' && $ticket->status != 'completed' && auth()->user()->can('remove ticket'))
                                            |
                                            <a href="{{ route('admin.tickets.show', $ticket->id) }}"
                                            class="font-weight-normal h5 px-2">
                                                @lang('Remove')
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
@endsection