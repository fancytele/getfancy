@extends('layouts.admin', ['hide_menu' => true])

@section('page-title')
    @lang('Configure Your Fancyy Number')
    <p class="mb-0 mt-1 small text-muted">@lang('Get the Perfect Phone Number for Your Business')</p>
@endsection

@push('head-scripts')
    <script src="{{ asset('js/lang.js') }}" defer></script>
@endpush

@section('content')
<div class="container">
    <div class="justify-content-center mb-3 mt-6">
        <create-fancy-number-component 
            :urls='@json($urls)'
            :did-country='@json($did_country)'
            :did-regions='@json($did_regions)'></create-fancy-number-component>
    </div>
@endsection