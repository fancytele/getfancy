@extends('layouts.admin')

@section('page-subtitle', __('Ticket management'))

@section('page-title', __('Ticket Detail'))

@section('content')
    <div class="container-fluid">
        <a href="{{ route('admin.tickets.index') }}" class="btn btn-link mb-3">
            <i class="fe fe-arrow-left mr-2"></i>
            @lang('Return to list')
        </a>
        
        <div class="row">
            <div class="col-lg-6 col-xl-4">
                <div class="card">
                    <div class="card-body pb-0">
                        @if($ticket->isPending())
                            <form action="{{ route('admin.tickets.open', $ticket->id) }}" method="POST">
                            @csrf
                        @endif

                        <dl>
                            <dt>
                                Ticket # 
                                <span class="font-italic small"> - {{ $ticket->category_label }}</span>
                            </dt>
                            <dd class="mb-4 text-black-50">
                                {{ $ticket->id }}
                                <div
                                    class="badge @ticket_badge_status($ticket->status) ml-2">
                                    @lang($ticket->status_label)
                                </div>                        
                            </dd>

                            @if($ticket->reason)
                                <dt>Removed by</dt>
                                <dd class="mb-4 text-black-50">
                                    {{ $ticket->removed_by->full_name }}
                                </dd>

                                <dt>Reason</dt>
                                <dd class="mb-4 text-black-50">
                                    {{ $ticket->reason }}
                                </dd>
                            @endif

                            <dt>Started at</dt>
                            <dd class="mb-4 text-black-50">
                                {{ optional($ticket->started_at)->isoFormat('lll') ?? '---' }}
                            </dd>

                            <dt>Completed at</dt>
                            <dd class="mb-4 text-black-50">
                                {{ optional($ticket->completed_at)->isoFormat('lll') ?? '---' }}
                            </dd>

                            <dt>Assigned to</dt>
                            <dd class="mb-4 text-black-50">
                                @if($ticket->assigned_id)
                                    @if($ticket->assigned->hasRole('operator'))
                                        <a href="{{ route('admin.operators.edit', $ticket->assigned_id) }}"
                                            target="_blank" rel="noopener noreferrer">
                                            {{ $ticket->assigned->full_name }}
                                            <i class="fe fe-external-link"></i>
                                        </a>
                                    @else 
                                        {{ $ticket->assigned->full_name }}
                                    @endif
                                @else
                                    <span>Unassigned</span>
                                @endif
                            </dd>
                        </dl>

                        <hr>
                        
                        <dl>
                            <dt>User</dt>
                            <dd class="mb-4 text-black-50">
                                {{ $ticket->fancy_number->user->full_name }}
                            </dd>

                            <dt>Fancyy Number</dt>
                            <dd class="mb-4 text-black-50">{{ $ticket->fancy_number->us_did_number }}</dd>
                        </dl>

                        @if($ticket->isPending())
                            <hr>

                            <button type="submit"
                                    class="btn btn-primary ladda-button js-ladda-submit mb-4 px-4"
                                    data-style="zoom-out">
                                <i class="fe fe-layers mr-2"></i>
                                @lang('Open ticket')
                            </button>
                            </form>
                        @endif

                        @if($ticket->inProgress() && $ticket->belongsToAuthenticatedUser())
                            <hr>

                            <a href="{{ route('admin.tickets.edit', $ticket->id) }}"
                                class="btn btn-primary mb-4 px-4">
                                <i class="fe fe-edit-3 mr-2"></i>
                                @lang('Edit ticket')
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
