@extends('layouts.admin')

@section('page-subtitle', __('User management'))
@section('page-title', __('Create user'))

@push('head-scripts')
<script src="{{ asset('js/lang.js') }}" defer></script>
<script src="https://js.stripe.com/v3/"></script>
@endpush

@section('content')
<div class="container-fluid">
    <a href="{{ route('admin.users.index') }}" class="btn btn-link mb-3">
        <i class="fe fe-arrow-left mr-2"></i>
        @lang('Return to list')
    </a>

    <create-user-component :locale="'{{ app()->getLocale() }}'"
                           :urls='@json($urls)'
                           :did-country='@json($did_country)'
                           :did-regions='@json($did_regions)'
                           :products='@json($products)'
                           :addons='@json($addons)'></create-user-component>
</div>
@endsection