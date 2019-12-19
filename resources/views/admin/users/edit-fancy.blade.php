@extends('layouts.admin-sidebar')

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