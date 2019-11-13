@extends('layouts.admin')

@section('page-subtitle', __('Ticket management'))

@section('page-title', __('Ticket Detail'))

@section('content')
    <div class="container-fluid">
        <a href="{{ route('admin.tickets.index') }}" class="btn btn-link mb-3">
            <i class="fe fe-arrow-left mr-2"></i>
            @lang('Return to list')
        </a>
        <div class="card">
            <div class="card-body">
                <dl>
                    <dt>Ticket #</dt>
                    <dd class="mb-4 text-black-50">
                        {{ $ticket->id }}
                        <div
                            class="badge @ticket_badge_status($ticket->status) ml-2">
                            @lang($ticket->status_label)
                        </div>
                    </dd>

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
                        <a href="{{ route('admin.users.edit', $ticket->fancy_number->user_id) }}"
                            target="_blank" rel="noopener noreferrer">
                            {{ $ticket->fancy_number->user->full_name }}
                            <i class="fe fe-external-link"></i>
                        </a>
                    </dd>

                    <dt>Fancy Number</dt>
                    <dd class="mb-4 text-black-50">{{ $ticket->fancy_number->us_did_number }}</dd>
                </dl>
            </div>
        </div>
    </div>
@endsection
