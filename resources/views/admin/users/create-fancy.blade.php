@extends('layouts.admin', ['hide_menu' => true])

@section('page-subtitle', __('Edit User'))

@section('page-title', __('Fancy number'))

@push('head-scripts')
    <script src="{{ asset('js/lang.js') }}" defer></script>
@endpush

@section('content')
<div class="container">
    <div class="justify-content-center mb-3 mt-6 row">
        <div class="col-md-10 col-lg-8">
            <create-fancy-number-component 
                :urls='@json($urls)'
                :did-country='@json($did_country)'
                :did-regions='@json($did_regions)'></create-fancy-number-component>
        </div>
    </div>
@endsection