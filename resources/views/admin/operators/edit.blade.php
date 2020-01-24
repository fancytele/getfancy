@extends('layouts.admin')

@section('page-subtitle', __('User management'))
@section('page-title', __('Edit operator'))

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
                          action="{{ route('admin.operators.update', $operator->id) }}">
                        @csrf
                        @method('PUT')

                        @include('admin.operators._form')

                        <div
                             class="align-items-center d-flex justify-content-between">
                            <button type="submit"
                                    class="btn btn-primary ladda-button js-ladda-submit px-4"
                                    data-style="zoom-out">
                                @lang('Edit')
                            </button>
                            <a href="{{ route('admin.operators.reset_password', $operator->id) }}"
                               data-toggle="modal" data-backdrop="static"
                               data-target="#reset-operator-password">
                                @lang('Reset password')
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Reset Modal --}}
<div class="modal fade" id="reset-operator-password" tabindex="-1" role="dialog"
     aria-labelledby="reset-operator-password-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <button type="button" class="close mr-3 mt-3"
                        data-dismiss="modal" aria-label="Close">
                    <i class="fe fe-x-circle"></i>
                </button>
                <form action="{{ route('admin.operators.reset_password', $operator->id) }}"
                      method="POST">
                    @csrf

                    <input type="hidden" name="email"
                           value="{{ $operator->email }}">

                    <div class="d-flex my-3 pl-4 pt-4">
                        <i
                           class="display-4 fe fe-alert-circle mr-3 mt-n2 mt-n3 "></i>
                        <div>
                            <h3 class="mb-0">@lang('Reset password')?</h3>
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
                            @lang('Confirm')
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
