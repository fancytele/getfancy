@extends('layouts.admin')

@section('page-subtitle', 'Overwiew')
@section('page-title', 'Dashboard')

@isset($range)
    @section('header-action')
        <form action="" method="GET">
            <label for="date-picker" class="sr-only">Date range</label>
            <input type="text" id="dashboard-date-picker" class="form-control" placeholder="Search by date range"
                data-toggle="flatpickr" disabled value="{{ $range }}"
                data-options='{"mode": "range", "altInput": true, "altFormat": "M j, Y", "dateFormat": "Y-m-d"}'>
        </form>
    @endsection
@endisset

@section('content')
    <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-lg-6 col-xl">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col text-truncate">
                                    <h6 class="card-title text-uppercase text-muted mb-2">
                                        Fancy Number
                                    </h6>

                                    <span class="h2 mb-0"></span>
                                </div>
                                <div class="col-auto">
                                    <span class="h2 fe fe-phone text-primary mb-0"></span>
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
                                        Total calls
                                    </h6>

                                    <span class="h2 mb-0"></span>
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

                                    <span class="h2 mb-0"></span>
                                    <span class="badge badge-soft-success mt-n1">
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

                                    <span class="h2 mb-0"></span>
                                    <span class="badge badge-soft-danger mt-n1">

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

                                    <span class="h2 mb-0"></span>
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
                    <div class="col-12 col-xl-5">
                        <!-- Calls -->
                        <div class="border border-bottom-0 border-left-0 border-primary border-right-0 border-top border-top-2 card" id="chart-calls">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col">

                                        <!-- Title -->
                                        <h4 class="card-header-title">
                                            Calls
                                        </h4>

                                    </div>
                                    {{-- <div class="col-auto mr-n3">

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

                                    </div> --}}
                                </div> <!-- / .row -->

                            </div>
                            <div class="card-body">

                                <!-- Chart -->
                                <div class="chart">
                                    <canvas id="callsChart" 
                                            class="chart-canvas" 
                                    ></canvas>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-7">
                        <!-- Card -->
                        <div class="border border-bottom-0 border-left-0 border-primary border-right-0 border-top border-top-2 card" data-toggle="lists"
                            data-options='{"valueNames": ["calls-did", "calls-source", "calls-duration", "calls-state"]}'>
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col">

                                        <!-- Search -->
                                        <form class="row align-items-center">
                                            <div class="col-auto pr-0">
                                                <span class="fe fe-search text-muted"></span>
                                            </div>
                                            <div class="col">
                                                <input type="search" class="form-control form-control-flush search"
                                                    placeholder="Search">
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover table-sm table-nowrap card-table">
                                    <thead>
                                        <tr>
                                            <th width="25%">
                                                <a href="#" class="text-muted sort" data-sort="calls-did">
                                                    Date
                                                </a>
                                            </th>
                                            <th width="25%">
                                                <a href="#" class="text-muted sort" data-sort="calls-source">
                                                    Call number
                                                </a>
                                            </th>
                                            <th width="25%">
                                                <a href="#" class="text-muted sort" data-sort="calls-duration">
                                                    Duration (min)
                                                </a>
                                            </th>
                                            <th colspan="2" width="25%">
                                                <a href="#" class="text-muted sort" data-sort="calls-state">
                                                    State
                                                </a>
                                            </th>
                                        </tr>
                                    </thead>
                                </table>
                                <div id="table-calls" class="overflow-auto">
                                    <table class="table table-hover table-sm table-nowrap card-table">
                                        <tbody class="list">
                                            <tr>
                                                <td class="calls-did" width="25%">
                                                    <p class="mb-0">
                                                    </p>
                                                </td>
                                                <td class="calls-source" width="25%">

                                                    <span class="text-capitalize"></span>

                                                </td>
                                                <td class="calls-duration" width="25%">
                                                    00:00 min

                                                </td>
                                                <td class="calls-state" colspan="2" width="25%">
                                                    <div class="badge badge-soft-success font-size-inherit">
                                                        Success
                                                    </div>
                                                    <div class="badge badge-soft-danger font-size-inherit">
                                                        Missed
                                                    </div>

                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <div class="row">
                <div class="col-12">
                    <div class="card card-flush">
                        <div class="card-body text-center">
                            <h1 class="display-4">
                                @lang($message).
                            </h1>
                        </div>
                    </div>
                </div>
            </div> <!-- / .row -->

    </div>
@endsection