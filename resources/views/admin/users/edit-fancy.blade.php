@extends('layouts.admin')

@section('page-subtitle', __('Edit User'))

@section('page-title', __('Fancy configuration'))

@push('head-scripts')
<script src="{{ asset('js/lang.js') }}" defer></script>
@endpush

@section('content')
<div class="container-fluid">
    <a href="{{ route('admin.users.index') }}" class="btn btn-link mb-3">
        <i class="fe fe-arrow-left mr-2"></i>
        @lang('Return to list')
    </a>

    <fancy-configuration-component :periods='@json($notification_period)'
                                   :messages='@json($messages)'>
    </fancy-configuration-component>
</div>
@endsection