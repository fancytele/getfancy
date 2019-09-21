@extends('layouts.admin')

@section('page-subtitle', __('User management'))
@section('page-title', __('Create agent'))

@section('content')
<div class="container-fluid">
    <a href="{{ route('admin.agents.index') }}" class="btn btn-link mb-3">
        <i class="fe fe-arrow-left mr-2"></i>
        @lang('Return to list')
    </a>
    <div class="row">
        <div class="col-lg-6 col-xl-4">
            <div class="card">
                <div class="card-body">
                    <form method="POST"
                          action="{{ route('admin.agents.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="first_name">
                                @lang('First Name')
                            </label>
                            <input type="text"
                                   class="form-control @error('first_name') is-invalid @enderror"
                                   id="first_name" name="first_name"
                                   value="{{ old('first_name') }}" required
                                   autofocus>
                            @error('first_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="last_name">@lang('Last Name')</label>
                            <input type="text"
                                   class="form-control @error('last_name') is-invalid @enderror"
                                   id="last_name" name="last_name"
                                   value="{{ old('last_name') }}" required>
                            @error('last_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">@lang('E-mail')</label>
                            <input type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email"
                                   value="{{ old('email') }}" required>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <button type="submit"
                                class="btn btn-primary ladda-button px-4"
                                data-style="zoom-out">@lang('Create')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
