@extends('layouts.admin')

@section('page-title', 'Dahboard')

@section('content')
<div class="container-fluid">
    <p>@lang('Welcome'), {{ Auth::user()->full_name }}</p>
</div>
@endsection