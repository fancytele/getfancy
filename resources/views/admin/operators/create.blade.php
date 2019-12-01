@extends('layouts.admin')

@section('page-subtitle', __('User management'))
@section('page-title', __('Create Operator'))

@section('content')
<div class="container-fluid">
    <a href="{{ route('admin.operators.index') }}" class="btn btn-link mb-3">
        <i class="fe fe-arrow-left mr-2"></i>
        @lang('Return to list')
    </a>
    <div class="row">
        <div class="col-lg-6 col-xl-4">
            <div class="card">
                <div class="card-body">
                    <form method="POST"
                          action="{{ route('admin.operators.store') }}">
                        @csrf

                        @include('admin.operators._form')

                        <button type="submit"
                                class="btn btn-primary ladda-button js-ladda-submit px-4"
                                data-style="zoom-out">@lang('Create')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection