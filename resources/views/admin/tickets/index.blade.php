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
                data-options='{"valueNames": ["orders-ticket", "orders-user-name", "orders-created-at", "orders-started", "orders-completed", "orders-status"]}'>
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
                                       data-sort="orders-ticket">
                                        @lang('Ticket #')
                                    </a>
                                </th>
                                <th scope="col">
                                    <a href="#" class="text-muted sort"
                                       data-sort="orders-user-name">
                                        @lang('User')
                                    </a>
                                </th>
                                <th scope="col">
                                    <a href="#" class="text-muted sort"
                                       data-sort="orders-created-at">
                                        @lang('Created at')
                                    </a>
                                </th>
                                <th scope="col">
                                    <a href="#" class="text-muted sort"
                                       data-sort="orders-started">
                                        @lang('Started')
                                    </a>
                                </th>
                                <th scope="col">
                                    <a href="#" class="text-muted sort"
                                       data-sort="orders-completed">
                                        @lang('Completed')
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
                                    <td scope="row" class="align-middle orders-ticket">
                                        <p class="font-weight-bold mb-0">
                                            Ticket #{{ $ticket->id }}
                                            @if($ticket->parent_id)
                                                <i class="fe fe-git-branch font-weight-bold" data-toggle="tooltip" data-placement="top"
                                                title="Related to Ticket #{{$ticket->parent_id}}"></i>
                                            @endif
                                        </p>
                                        <p class="mb-0 text-black-50">
                                            <i class="fe fe-user font-weight-bold"></i>
                                            @if($ticket->assigned)
                                                {{ $ticket->assigned->full_name}}
                                            @else
                                                <em>@lang('Unassigned')</em>
                                            @endif
                                        </p>
                                    </td>
                                    <td class="align-middle orders-user-name">
                                        <p class="mb-0">{{ $ticket->fancy_number->user->full_name }}</p>
                                        <p class="mb-0 text-black-50">
                                            <i class="fe fe-phone"></i>
                                            {{ $ticket->fancy_number->us_did_number }}
                                        </p>
                                    </td>
                                    <td class="align-middle orders-created-at">
                                            {{ optional($ticket->created_at)->isoFormat('lll') ?? '---' }}
                                        </td>
                                    <td class="align-middle orders-started">
                                        <span>
                                            @if($ticket->isOpen() && !$ticket->isCanceled())
                                                {{ $ticket->started_at->diffForHumans($ticket->created_at, ['parts' => 2]) }} created
                                            @else
                                                ---
                                            @endif
                                        </span>
                                    </td>
                                    <td class="align-middle orders-completed">
                                        <span>
                                            @if($ticket->isCompleted())
                                                {{ $ticket->completed_at->diffForHumans($ticket->started_at, ['parts' => 2]) }} started
                                            @else
                                                ---
                                            @endif
                                        </span>
                                    </td>
                                    <td class="align-middle orders-status">
                                        @if($ticket->isPending())
                                            <div
                                                class="badge badge-soft-dark font-size-inherit">
                                                @lang('Pending')
                                            </div>
                                        @elseif($ticket->inProgress())
                                            <div
                                                class="badge badge-soft-primary font-size-inherit">
                                                @lang('In progress')
                                            </div>
                                        @elseif($ticket->isCompleted())
                                            <div
                                                class="badge badge-soft-success font-size-inherit">
                                                @lang('Completed')
                                            </div>
                                        @elseif($ticket->isCanceled())
                                            <div
                                                class="badge badge-soft-danger font-size-inherit">
                                                @lang('Removed')
                                            </div>
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="font-weight-normal h5 px-2">
                                            @lang('View')
                                        </a>
                                        @if($ticket->inProgress())
                                            |
                                           <a href="{{ route('admin.tickets.edit', $ticket->id) }}"
                                               class="font-weight-normal h5 px-2">
                                                @lang('Edit')
                                            </a>
                                        @endif
                                        @if (auth()->user()->can('remove ticket') && ($ticket->isPending() || $ticket->inProgress()))
                                            |
                                            <a href="{{ route('admin.tickets.destroy', $ticket->id) }}"
                                               class="font-weight-normal h5 px-2"
                                               data-toggle="modal" data-backdrop="static"
                                               data-target="#delete-element"
                                               data-name="@lang('Ticket') #{{ $ticket->id }}"
                                               data-action="{{ route('admin.tickets.destroy', $ticket->id) }}">
                                                @lang('Delete')
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
    @if($tickets->isNotEmpty())
        @include('partials.delete-element')
    @endif
@endsection
