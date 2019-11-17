@extends('layouts.admin')

@section('page-subtitle', __('Ticket management'))

@section('page-title', __('Edit Ticket'))

@section('content')
    <div class="container-fluid">
        <a href="{{ route('admin.tickets.index') }}" class="btn btn-link mb-3">
            <i class="fe fe-arrow-left mr-2"></i>
            @lang('Return to list')
        </a>

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">                            
                        <div>
                            <dl class="d-md-inline-block mr-md-6">
                                <dt>Ticket #</dt>
                                <dd>{{ $ticket->id }}</dd>
                            </dl>
                            <dl class="d-md-inline-block mr-md-6">
                                <dt>User</dt>
                                <dd>{{ $ticket->fancy_number->user->full_name }}</dd>
                            </dl>
                            <dl class="d-md-inline-block mr-md-6">
                                <dt>Fancy Number</dt>
                                <dd>
                                    <a href="https://my.didww.com/user_dids/{{ $ticket->fancy_number->did_id }}"
                                        target="_blank" rel="noreferrer noopener">
                                        {{ $ticket->fancy_number->us_did_number }}
                                        <i class="fe fe-external-link"></i>
                                    </a>
                                </dd>
                            </dl>
                        </div>
                        
                        @empty($settings)
                            <div class="alert alert-light font-italic" role="alert">
                                @lang('The user has not set any configuration for his Fancy number')
                            </div>
                        @endempty

                        <hr>
                        
                        @isset($settings)                            
                            <dl>
                                @if($settings->business_hours)
                                    <dt class="text-decoration-underline">Business Hours</dt>
                                    <dd>
                                        @if($settings->business_hours['all_day'])
                                            All day
                                        @else
                                            <table class="table table-borderless table-sm table-striped w-auto">
                                                <tbody>
                                                    @foreach ($settings->business_hours['days'] as $day)
                                                        @continue($day['enable'] === false)
                                                        <tr>
                                                            <td class="font-weight-bold pl-0 py-2">{{ $day['text'] }}</td>
                                                            <td class="py-2">{{ $day['start']['HH'] }}:{{ $day['start']['mm'] }}</td>
                                                            <td class="py-2">{{ $day['end']['HH'] }}:{{ $day['end']['mm'] }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @endif
                                    </dd>
                                @endif

                                @if($settings->downtime_hours)
                                    <dt class="text-decoration-underline">Downtime Hours</dt>
                                    <dd>
                                        <table class="table table-borderless table-sm table-striped w-auto">
                                            <tbody>
                                                @foreach ($settings->downtime_hours['days'] as $day)
                                                    @continue($day['enable'] === false)
                                                    <tr>
                                                        <td class="font-weight-bold pl-0 py-2">{{ $day['text'] }}</td>
                                                        <td class="py-2">{{ $day['start']['HH'] }}:{{ $day['start']['mm'] }}</td>
                                                        <td class="py-2">{{ $day['end']['HH'] }}:{{ $day['end']['mm'] }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </dd>
                                @endif

                                <dt class="text-decoration-underline">Notifications</dt>
                                <dd class="mb-4">
                                    <div>
                                        <span class="font-weight-bold mr-3">Email: </span>
                                        <span>{{ $settings->email_notification }}</span>
                                    </div>
                                    <div>
                                        <span class="font-weight-bold mr-1">Period: </span>
                                        <span>{{ $settings->period_notification_label }}</span>
                                    </div>
                                </dd>

                                @if($settings->hasPBX())
                                    <dt class="text-decoration-underline">PBX</dt>
                                    <dd class="mb-3">
                                        @if($settings->business_message_id || $settings->business_custom_message)
                                            <div class="pb-3">
                                                <div class="font-weight-bold">Business Message</div>
                                                <div>
                                                    @if($settings->business_message_id)
                                                        {{ $settings->pbx_business->message }}
                                                    @else
                                                        {{ $settings->business_custom_message }}
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                        @if($settings->downtime_message_id || $settings->downtime_custom_message)
                                            <div class="pb-3">
                                                <div class="font-weight-bold">Downtime Message</div>
                                                <div>
                                                    @if($settings->downtime_message_id)
                                                        {{ $settings->pbx_downtime->message }}
                                                    @else
                                                        {{ $settings->downtime_custom_message }}
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                        @if($settings->onhold_message_id || $settings->onhold_custom_message)
                                            <div class="pb-3">
                                                <div class="font-weight-bold">On-hold Message</div>
                                                <div>
                                                    @if($settings->onhold_message_id)
                                                        {{ $settings->pbx_onhold->message }}
                                                    @else
                                                        {{ $settings->onhold_custom_message }}
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    </dd>
                                @endif

                                @if($settings->extensions)
                                    <dt class="text-decoration-underline">Extensions</dt>
                                    <dd>
                                        <table class="table table-borderless table-sm table-striped w-auto">
                                            <tbody>
                                                @foreach ($settings->extensions as $extension)
                                                    <tr>
                                                        <td class="font-weight-bold pl-0 py-2">{{ $extension['name'] }}</td>
                                                        <td class="py-2">{{ $extension['number'] }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </dd>
                                @endif

                                <dt class="text-decoration-underline">Audio</dt>
                                <dd class="mb-4">{{ $settings->audio_label }}</dd>
                            </dl>

                            <hr>
                        @endisset

                        <a href="{{ route('admin.tickets.update', $ticket->id) }}" class="btn btn-primary" data-toggle="modal"
                           data-backdrop="static" data-target="#ticket-complete">
                            <i class="fe fe-archive"></i> @lang('Complete ticket')
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    {{-- Complete Ticket Modal --}}
    <div class="modal fade" id="ticket-complete" tabindex="-1" role="dialog" aria-labelledby="ticket-complete-label"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <button type="button" class="close mr-3 mt-3"
                            data-dismiss="modal" aria-label="Close">
                        <i class="fe fe-x-circle"></i>
                    </button>
                    <form action="{{ route('admin.tickets.update', $ticket->id) }}" method="POST">
                        @csrf
                        @method('PUT')
    
                        <div class="d-flex my-3 pl-4 pt-4">
                            <i class="display-4 fe fe-alert-circle mr-3 mt-n2 mt-n3 "></i>
                            <div>
                                <h3 id="ticket-complete-label" class="mb-0">
                                    @lang('Complete ticket') #{{ $ticket->id }}?
                                </h3>
                                <p class="text-black-50">
                                    @lang('You cannot undo this action')
                                </p>
                            </div>
                        </div>
    
                        <div class="d-flex overflow-hidden rounded-bottom">
                            <button type="button"
                                    class="btn btn-lg btn-outline-light rounded-0 text-body w-50"
                                    data-dismiss="modal">
                                @lang('Cancel')
                            </button>
                            <button type="submit"
                                    class="btn btn-lg btn-primary ladda-button js-ladda-submit rounded-0 w-50"
                                    data-style="zoom-out">
                                @lang('Complete')
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
