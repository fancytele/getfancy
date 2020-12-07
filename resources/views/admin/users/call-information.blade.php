@extends('layouts.admin')

@section('page-title', 'Call Information')

@section('content')
    <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-xl-12 ">
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
                                    @if(count($calls) > 0)
                                    @foreach ($calls as $call)
                                        <tr>
                                            <td class="calls-did" width="25%">
                                                {{ (new \Carbon\Carbon($call['Date']))->toFormattedDateString() }}
                                                <p class="mb-0">
                                                    {{ $call['Time'] }}
                                                </p>
                                            </td>
                                            <td class="calls-source" width="25%">
                                                @if(is_numeric($call['Source']))
                                                    {{ preg_replace('/(\d{1})(\d{3})(\d{3})(\d{4})/', '$1($2) $3-$4', $call['Source']) }}
                                                @else
                                                    <span class="text-capitalize">{{ $call['Source'] }}</span>
                                                @endif
                                            </td>
                                            <td class="calls-duration" width="25%">
                                                @isset($call['Duration (secs)'])
                                                    {{ gmdate("i:s",  $call['Duration (secs)']) }} min
                                                @else
                                                    00:00 min
                                                @endisset

                                            </td>
                                            <td class="calls-state" colspan="2" width="25%">
                                                @if($call['Disconnect Code'] == 200)
                                                    <div class="badge badge-soft-success font-size-inherit">
                                                        Success
                                                    </div>
                                                @else
                                                    <div class="badge badge-soft-danger font-size-inherit">
                                                        Missed
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    @else
                                    <h4 class="text-center py-4">
                                        No data to show.
                                    </h4>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
@endsection