@extends('layouts.admin')

@section('page-subtitle', 'Overwiew')
@section('page-title', 'Dahboard')

@section('content')
<div class="container-fluid">
    <p>@lang('Welcome'), {{ Auth::user()->display_name }}</p>
</div>
@endsection