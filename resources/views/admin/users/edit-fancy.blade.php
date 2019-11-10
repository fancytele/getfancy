@extends('layouts.admin')

@section('page-subtitle', __('Edit User'))

@section('page-title', __('Fancy Setting'))

@push('head-scripts')
    <script src="{{ asset('js/lang.js') }}" defer></script>
@endpush

@section('content')
    <div class="container-fluid">
        <a href="{{ route('admin.users.index') }}" class="btn btn-link mb-3">
            <i class="fe fe-arrow-left mr-2"></i>
            @lang('Return to list')
        </a>

        @if($user->hasTicketInProgress())
            <div class="alert alert-warning align-items-center d-flex" role="alert">
                <i class="display-4 fe fe-alert-triangle mr-4"></i>
                <div>
                    <strong>A Ticket is already in progress</strong>.
                    <p class="mb-0">
                        If you proceed a new Ticket will be created and the previous one will be removed.
                        A <span class="text-decoration-underline">reason</span> is required.
                    </p>
                </div>
            </div>
        @endif

        <fancy-setting-component 
            :ticket-in-progress="{{ json_encode($user->hasTicketInProgress()) }}"
            :has-professional-recording='@json($has_professional_recording)'
            :settings='@json($settings)'
            :notification-periods='@json($notification_periods)'
            :messages='@json($messages)'
            :url-action="'{{ route('admin.users.update_fancy', $user->id) }}'"
            :url-user-list="'{{ route('admin.users.index') }}'">
        </fancy-setting-component>
    </div>
@endsection