@extends('layouts.admin')

@section('page-subtitle', __('Edit User'))

@section('page-title', __('Fancy Settings'))

@push('head-scripts')
    <script src="{{ asset('js/lang.js') }}" defer></script>
@endpush

@section('content')
<div class="container-fluid">
    <a href="{{ route('admin.users.index') }}" class="btn btn-link mb-3">
        <i class="fe fe-arrow-left mr-2"></i>
        @lang('Back')
    </a>

    <fancy-setting-component
                             :ticket-in-progress="{{ json_encode($user->hasTicketInProgress()) }}"
                             :has-professional-recording='@json($has_professional_recording)'
                             :professional-recording-price="{{ $professional_recording_price }}"
                             :settings='@json($settings)'
                             :notification-periods='@json($notification_periods)'
                             :messages='@json($messages)'
                             :url-action="'{{ route('admin.users.update_fancy', $user->id) }}'"
                             :allow-upload-audio='@json($allow_upload_audio)'>
    </fancy-setting-component>
</div>
@endsection