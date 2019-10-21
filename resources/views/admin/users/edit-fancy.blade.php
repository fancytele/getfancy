@extends('layouts.admin')

@section('page-subtitle', __('Edit User'))

@section('page-title', __('DID configuration'))

@section('content')
<div class="container-fluid">
    <a href="{{ route('admin.users.index') }}" class="btn btn-link mb-3">
        <i class="fe fe-arrow-left mr-2"></i>
        @lang('Return to list')
    </a>

    <fancy-configuration-component></fancy-configuration-component>
</div>
@endsection