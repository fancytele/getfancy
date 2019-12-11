@extends('layouts.admin')

@section('page-subtitle', 'Overwiew')
@section('page-title', 'Dashboard')

@section('header-action')
<form action="" method="GET">
    <label for="date-picker" class="sr-only">Date range</label>
    <input type="text" id="date-picker" class="form-control" placeholder="Search by date range" data-toggle="flatpickr"
           value="{{ $range }}"
           data-options='{"mode": "range", "altInput": true, "altFormat": "M j, Y", "dateFormat": "Y-m-d"}'>
</form>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-lg-6 col-xl">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col text-truncate">
                            <h6 class="card-title text-uppercase text-muted mb-2">
                                Total calls
                            </h6>

                            <span class="h2 mb-0">{{ $overview['total'] }}</span>
                        </div>
                        <div class="col-auto">
                            <span class="h2 fe fe-phone-call text-muted mb-0"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6 col-xl">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col text-truncate">
                            <h6 class="card-title text-uppercase text-muted mb-2">
                                Successful calls
                            </h6>

                            <span class="h2 mb-0">{{ $overview['successful'] }}</span>
                            <span class="badge badge-soft-success mt-n1">
                                {{ $overview['successful_average'] }}%
                            </span>
                        </div>
                        <div class="col-auto">
                            <span class="h2 fe fe-phone-call text-success mb-0"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6 col-xl">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col text-truncate">
                            <h6 class="card-title text-uppercase text-muted mb-2">
                                Unsuccessful calls
                            </h6>

                            <span class="h2 mb-0">{{ $overview['unsuccessful'] }}</span>
                            <span class="badge badge-soft-danger mt-n1">
                                {{ $overview['unsuccessful_average'] }}%
                            </span>
                        </div>
                        <div class="col-auto">
                            <span class="h2 fe fe-phone-missed text-danger mb-0"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6 col-xl">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col text-truncate">
                            <h6 class="card-title text-uppercase text-muted mb-2">
                                Average call durations
                            </h6>

                            <span class="h2 mb-0">{{ $overview['duration'] }} min</span>
                        </div>
                        <div class="col-auto">
                            <span class="h2 fe fe-clock text-muted mb-0"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-xl-8">
            <!-- Calls -->
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">

                            <!-- Title -->
                            <h4 class="card-header-title">
                                Calls
                            </h4>

                        </div>
                        <div class="col-auto mr-n3">

                            <!-- Caption -->
                            <span class="text-muted">
                                Show missed calls:
                            </span>

                        </div>
                        <div class="col-auto">

                            <!-- Switch -->
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="cardToggle" data-toggle="chart"
                                       data-target="#callsChart"
                                       data-add='{"data":{"datasets":[{"data":[3,1,0,3,0,0,4,3,0],"backgroundColor":"#fad7dd","label":"Missed"}]}}'>
                                <label class="custom-control-label" for="cardToggle"></label>
                            </div>

                        </div>
                    </div> <!-- / .row -->

                </div>
                <div class="card-body">

                    <!-- Chart -->
                    <div class="chart">
                        <canvas id="callsChart" class="chart-canvas"></canvas>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-12 col-xl-4">
            <!-- Call by extensions -->
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-header-title">
                                Calls by extension
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart chart-appended">
                        <canvas id="extensionsChart" class="chart-canvas" data-toggle="legend"
                                data-target="#extensionsChartLegend"></canvas>
                    </div>

                    <div id="extensionsChartLegend" class="chart-legend"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card -->
    <div class="card" data-toggle="lists"
         data-options='{"valueNames": ["calls-did", "calls-source", "calls-destination", "calls-duration", "calls-state", "calls-atemp"]}'>
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col">

                    <!-- Search -->
                    <form class="row align-items-center">
                        <div class="col-auto pr-0">
                            <span class="fe fe-search text-muted"></span>
                        </div>
                        <div class="col">
                            <input type="search" class="form-control form-control-flush search" placeholder="Search">
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover table-sm table-nowrap card-table">
                <thead>
                    <tr>
                        <th>
                            <a href="#" class="text-muted sort" data-sort="calls-did">
                                Date
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted sort" data-sort="calls-source">
                                Source
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted sort" data-sort="calls-destination">
                                Destination
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted sort" data-sort="calls-duration">
                                Duration (min)
                            </a>
                        </th>
                        <th colspan="2">
                            <a href="#" class="text-muted sort" data-sort="calls-state">
                                State
                            </a>
                        </th>
                        <th colspan="2">
                            <a href="#" class="text-muted sort" data-sort="calls-disconector">
                                Attemp number
                            </a>
                        </th>
                    </tr>
                </thead>
                <tbody class="list">
                    @foreach ($calls as $call)
                    <tr>
                        <td class="calls-did">
                            {{ $call['started_at'] }}
                        </td>
                        <td class="calls-source">
                            {{ $call['source'] }}
                        </td>
                        <td class="calls-destination">
                            {{ $call['destination'] }}
                        </td>
                        <td class="calls-duration">
                            {{ $call['duration'] }}
                        </td>
                        <td class="calls-state" colspan="2">
                            @if($call['success'])
                            <div class="badge badge-soft-success font-size-inherit">
                                Success
                            </div>
                            @else
                            <div class="badge badge-soft-danger font-size-inherit">
                                Missed
                            </div>
                            @endif
                        </td>
                        <td class="calls-attemp" colspan="2">
                            {{ $call['attemp_number'] }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <nav class="d-flex justify-content-center">
        <ul class="pagination">
            <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
            </li>
            <li class="page-item"><a class="page-link" href="#">1</a>
            </li>
            <li class="page-item active" aria-current="page">
                <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
            </li>
            <li class="page-item"><a class="page-link" href="#">3</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="#">Next</a>
            </li>
        </ul>
    </nav>
</div>
@endsection