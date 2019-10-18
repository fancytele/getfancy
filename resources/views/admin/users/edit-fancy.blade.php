@extends('layouts.admin')

@section('page-subtitle', __('Edit User'))

@section('page-title', __('DID configuration'))

@section('content')
<div class="container-fluid" id="did-settings">
    <a href="{{ route('admin.users.index') }}" class="btn btn-link mb-3">
        <i class="fe fe-arrow-left mr-2"></i>
        @lang('Return to list')
    </a>

    <div
         class="border border-bottom-0 border-left-0 border-primary border-right-0 border-top border-top-2 card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <h2 class="mb-1">Business hours</h2>
                    <p class="text-black-50">
                        Lorem ipsum dolor sit, amet consectetur adipisicing
                        elit.
                    </p>
                </div>
                <div class="border-left border-left-2 col-md-8">
                    <div class="form-group">
                        <div
                             class="custom-control custom-control-box custom-switch">
                            <label for="all_day">
                                <span class="custom-control-text">
                                    Open 24/7
                                </span>
                                <input type="checkbox"
                                       class="custom-control-input"
                                       id="all_day">
                                <span class="custom-control-label"></span>
                            </label>
                        </div>
                    </div>

                    <div class="mt-5">
                        <div class="form-inline">
                            <div
                                 class="custom-control custom-checkbox custom-control-md mr-4">
                                <input type="checkbox"
                                       class="custom-control-input"
                                       id="customCheck1">
                                <label class="align-items-start label-day custom-control-label"
                                       for="customCheck1">Mon</label>
                            </div>

                            <div class="form-group mr-4">
                                <label class="sr-only" for="mon_open_time">
                                    Start time
                                </label>
                                <div
                                     class="input-group input-group-sm input-group-time">
                                    <input type="text" class="form-control"
                                           id="mon_open_time"
                                           name="mon_open_time"
                                           aria-label="Monday open time"
                                           aria-describedby="mon-open-time-icon">
                                    <div class="input-group-append">
                                        <span class="input-group-text"
                                              id="mon-open-time-icon">
                                            <i class="fe fe-clock"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mr-4">
                                <label class="sr-only" for="mon_open_time">
                                    Start time
                                </label>
                                <div
                                     class="input-group input-group-sm input-group-time">
                                    <input type="text" class="form-control"
                                           id="mon_open_time"
                                           name="mon_open_time"
                                           aria-label="Monday open time"
                                           aria-describedby="mon-open-time-icon">
                                    <div class="input-group-append">
                                        <span class="input-group-text"
                                              id="mon-open-time-icon">
                                            <i class="fe fe-clock"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <button
                                        class="btn btn-link text-decoration-underline">
                                    <i class="fe fe-copy"></i>
                                    Copy to all
                                </button>
                            </div>
                        </div>
                        <div class="form-inline">
                            <div
                                 class="custom-control custom-checkbox custom-control-md mr-4">
                                <input type="checkbox"
                                       class="custom-control-input"
                                       id="customCheck1">
                                <label class="align-items-start label-day custom-control-label"
                                       for="customCheck1">Tue</label>
                            </div>

                            <div class="form-group mr-4">
                                <label class="sr-only" for="mon_open_time">
                                    Start time
                                </label>
                                <div
                                     class="input-group input-group-sm input-group-time">
                                    <input type="text" class="form-control"
                                           id="mon_open_time"
                                           name="mon_open_time"
                                           aria-label="Monday open time"
                                           aria-describedby="mon-open-time-icon">
                                    <div class="input-group-append">
                                        <span class="input-group-text"
                                              id="mon-open-time-icon">
                                            <i class="fe fe-clock"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mr-4">
                                <label class="sr-only" for="mon_open_time">
                                    Start time
                                </label>
                                <div
                                     class="input-group input-group-sm input-group-time">
                                    <input type="text" class="form-control"
                                           id="mon_open_time"
                                           name="mon_open_time"
                                           aria-label="Monday open time"
                                           aria-describedby="mon-open-time-icon">
                                    <div class="input-group-append">
                                        <span class="input-group-text"
                                              id="mon-open-time-icon">
                                            <i class="fe fe-clock"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <button
                                        class="btn btn-link text-decoration-underline">
                                    <i class="fe fe-copy"></i>
                                    Copy to all
                                </button>
                            </div>
                        </div>
                        <div class="form-inline">
                            <div
                                 class="custom-control custom-checkbox custom-control-md mr-4">
                                <input type="checkbox"
                                       class="custom-control-input"
                                       id="customCheck1">
                                <label class="align-items-start label-day custom-control-label"
                                       for="customCheck1">Wen</label>
                            </div>

                            <div class="form-group mr-4">
                                <label class="sr-only" for="mon_open_time">
                                    Start time
                                </label>
                                <div
                                     class="input-group input-group-sm input-group-time">
                                    <input type="text" class="form-control"
                                           id="mon_open_time"
                                           name="mon_open_time"
                                           aria-label="Monday open time"
                                           aria-describedby="mon-open-time-icon">
                                    <div class="input-group-append">
                                        <span class="input-group-text"
                                              id="mon-open-time-icon">
                                            <i class="fe fe-clock"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mr-4">
                                <label class="sr-only" for="mon_open_time">
                                    Start time
                                </label>
                                <div
                                     class="input-group input-group-sm input-group-time">
                                    <input type="text" class="form-control"
                                           id="mon_open_time"
                                           name="mon_open_time"
                                           aria-label="Monday open time"
                                           aria-describedby="mon-open-time-icon">
                                    <div class="input-group-append">
                                        <span class="input-group-text"
                                              id="mon-open-time-icon">
                                            <i class="fe fe-clock"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <button
                                        class="btn btn-link text-decoration-underline">
                                    <i class="fe fe-copy"></i>
                                    Copy to all
                                </button>
                            </div>
                        </div>
                        <div class="form-inline">
                            <div
                                 class="custom-control custom-checkbox custom-control-md mr-4">
                                <input type="checkbox"
                                       class="custom-control-input"
                                       id="customCheck1">
                                <label class="align-items-start label-day custom-control-label"
                                       for="customCheck1">Thu</label>
                            </div>

                            <div class="form-group mr-4">
                                <label class="sr-only" for="mon_open_time">
                                    Start time
                                </label>
                                <div
                                     class="input-group input-group-sm input-group-time">
                                    <input type="text" class="form-control"
                                           id="mon_open_time"
                                           name="mon_open_time"
                                           aria-label="Monday open time"
                                           aria-describedby="mon-open-time-icon">
                                    <div class="input-group-append">
                                        <span class="input-group-text"
                                              id="mon-open-time-icon">
                                            <i class="fe fe-clock"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mr-4">
                                <label class="sr-only" for="mon_open_time">
                                    Start time
                                </label>
                                <div
                                     class="input-group input-group-sm input-group-time">
                                    <input type="text" class="form-control"
                                           id="mon_open_time"
                                           name="mon_open_time"
                                           aria-label="Monday open time"
                                           aria-describedby="mon-open-time-icon">
                                    <div class="input-group-append">
                                        <span class="input-group-text"
                                              id="mon-open-time-icon">
                                            <i class="fe fe-clock"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <button
                                        class="btn btn-link text-decoration-underline">
                                    <i class="fe fe-copy"></i>
                                    Copy to all
                                </button>
                            </div>
                        </div>
                        <div class="form-inline">
                            <div
                                 class="custom-control custom-checkbox custom-control-md mr-4">
                                <input type="checkbox"
                                       class="custom-control-input"
                                       id="customCheck1">
                                <label class="align-items-start label-day custom-control-label"
                                       for="customCheck1">Fri</label>
                            </div>

                            <div class="form-group mr-4">
                                <label class="sr-only" for="mon_open_time">
                                    Start time
                                </label>
                                <div
                                     class="input-group input-group-sm input-group-time">
                                    <input type="text" class="form-control"
                                           id="mon_open_time"
                                           name="mon_open_time"
                                           aria-label="Monday open time"
                                           aria-describedby="mon-open-time-icon">
                                    <div class="input-group-append">
                                        <span class="input-group-text"
                                              id="mon-open-time-icon">
                                            <i class="fe fe-clock"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mr-4">
                                <label class="sr-only" for="mon_open_time">
                                    Start time
                                </label>
                                <div
                                     class="input-group input-group-sm input-group-time">
                                    <input type="text" class="form-control"
                                           id="mon_open_time"
                                           name="mon_open_time"
                                           aria-label="Monday open time"
                                           aria-describedby="mon-open-time-icon">
                                    <div class="input-group-append">
                                        <span class="input-group-text"
                                              id="mon-open-time-icon">
                                            <i class="fe fe-clock"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <button
                                        class="btn btn-link text-decoration-underline">
                                    <i class="fe fe-copy"></i>
                                    Copy to all
                                </button>
                            </div>
                        </div>
                        <div class="form-inline">
                            <div
                                 class="custom-control custom-checkbox custom-control-md mr-4">
                                <input type="checkbox"
                                       class="custom-control-input"
                                       id="customCheck1">
                                <label class="align-items-start label-day custom-control-label"
                                       for="customCheck1">Sat</label>
                            </div>

                            <div class="form-group mr-4">
                                <label class="sr-only" for="mon_open_time">
                                    Start time
                                </label>
                                <div
                                     class="input-group input-group-sm input-group-time">
                                    <input type="text" class="form-control"
                                           id="mon_open_time"
                                           name="mon_open_time"
                                           aria-label="Monday open time"
                                           aria-describedby="mon-open-time-icon">
                                    <div class="input-group-append">
                                        <span class="input-group-text"
                                              id="mon-open-time-icon">
                                            <i class="fe fe-clock"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mr-4">
                                <label class="sr-only" for="mon_open_time">
                                    Start time
                                </label>
                                <div
                                     class="input-group input-group-sm input-group-time">
                                    <input type="text" class="form-control"
                                           id="mon_open_time"
                                           name="mon_open_time"
                                           aria-label="Monday open time"
                                           aria-describedby="mon-open-time-icon">
                                    <div class="input-group-append">
                                        <span class="input-group-text"
                                              id="mon-open-time-icon">
                                            <i class="fe fe-clock"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <button
                                        class="btn btn-link text-decoration-underline">
                                    <i class="fe fe-copy"></i>
                                    Copy to all
                                </button>
                            </div>
                        </div>
                        <div class="form-inline">
                            <div
                                 class="custom-control custom-checkbox custom-control-md mr-4">
                                <input type="checkbox"
                                       class="custom-control-input"
                                       id="customCheck1">
                                <label class="align-items-start label-day custom-control-label"
                                       for="customCheck1">Sun</label>
                            </div>

                            <div class="form-group mr-4">
                                <label class="sr-only" for="mon_open_time">
                                    Start time
                                </label>
                                <div
                                     class="input-group input-group-sm input-group-time">
                                    <input type="text" class="form-control"
                                           id="mon_open_time"
                                           name="mon_open_time"
                                           aria-label="Monday open time"
                                           aria-describedby="mon-open-time-icon">
                                    <div class="input-group-append">
                                        <span class="input-group-text"
                                              id="mon-open-time-icon">
                                            <i class="fe fe-clock"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mr-4">
                                <label class="sr-only" for="mon_open_time">
                                    Start time
                                </label>
                                <div
                                     class="input-group input-group-sm input-group-time">
                                    <input type="text" class="form-control"
                                           id="mon_open_time"
                                           name="mon_open_time"
                                           aria-label="Monday open time"
                                           aria-describedby="mon-open-time-icon">
                                    <div class="input-group-append">
                                        <span class="input-group-text"
                                              id="mon-open-time-icon">
                                            <i class="fe fe-clock"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <button
                                        class="btn btn-link text-decoration-underline">
                                    <i class="fe fe-copy"></i>
                                    Copy to all
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div
         class="border border-bottom-0 border-left-0 border-primary border-right-0 border-top border-top-2 card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <h2 class="mb-1">Notifications</h2>
                    <p class="text-black-50">
                        Lorem ipsum dolor sit amet, consectetur adipisicing
                        elit.
                    </p>
                </div>
                <div class="border-left border-left-2 col-md-8">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">E-mail</label>
                                <input type="email" class="form-control"
                                       id="email" name="email" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="period">Period</label>
                                <select name="period" id="period"
                                        class="form-control" required>
                                    <option value="daily">Daily</option>
                                    <option value="weekly">Weekly</option>
                                    <option value="monthly">Monthly</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div
         class="border border-bottom-0 border-left-0 border-primary border-right-0 border-top border-top-2 card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <h2 class="mb-1">PBX</h2>
                    <p class="text-black-50">
                        Lorem ipsum dolor sit amet, consectetur adipisicing
                        elit.
                    </p>
                </div>
                <div class="border-left border-left-2 col-md-8">
                    <div
                         class="custom-control custom-control-md custom-radio d-inline-block mr-5">
                        <input type="radio" id="predefined" name="pbx_type"
                               class="custom-control-input">
                        <label class="custom-control-label" for="predefined">
                            Predefined
                        </label>
                    </div>
                    <div
                         class="custom-control custom-control-md custom-radio d-inline-block">
                        <input type="radio" id="custom" name="pbx_type"
                               class="custom-control-input">
                        <label class="custom-control-label" for="custom">
                            Custom
                        </label>
                    </div>

                    <div class="mt-5">
                        <fieldset class="mb-4">
                            <legend class="pl-4">Message for Bussiness hours</legend>
                            <div class="custom-control custom-radio mb-3">
                                <input type="radio" id="business-message-1"
                                       name="bussiness-message"
                                       class="custom-control-input">
                                <label class="custom-control-label"
                                       for="business-message-1">
                                    For English press 1, para Español presione
                                    el número dos.” For training purposes this
                                    call may be recorded
                                </label>
                            </div>
                            <div class="custom-control custom-radio mb-3">
                                <input type="radio" id="business-message-2"
                                       name="bussiness-message"
                                       class="custom-control-input">
                                <label class="custom-control-label"
                                       for="business-message-2">
                                    You’ve reached “Company Name”. For Sales
                                    Press 1. For Customer Service press 2. For
                                    all other inquiries press 3 or wait in line
                                    for one of our operators.
                                </label>
                            </div>
                            <div class="custom-control custom-radio mb-3">
                                <input type="radio" id="business-message-3"
                                       name="bussiness-message"
                                       class="custom-control-input">
                                <label class="custom-control-label"
                                       for="business-message-3">
                                    For Sales, Press 1. For Support, Press 2.
                                    For all other questions, press 3.
                                </label>
                            </div>
                            <div class="custom-control custom-radio mb-3">
                                <input type="radio" id="business-message-4"
                                       name="bussiness-message"
                                       class="custom-control-input">
                                <label class="custom-control-label"
                                       for="business-message-4">
                                    If you know the extension of the person you
                                    would like to reach, you may dial it at any
                                    time. You can also press 0 to reach an
                                    agent. For all other callers, please listen
                                    to the following options: for account
                                    information press 1, for questions about a
                                    product you purchased press 2…
                                </label>
                            </div>
                            <div class="custom-control custom-radio mb-3">
                                <input type="radio" id="business-message-5"
                                       name="bussiness-message"
                                       class="custom-control-input">
                                <label class="custom-control-label"
                                       for="business-message-5">
                                    If you know your party’s extension, you may
                                    dial it at any time. Otherwise, please
                                    choose from the following options: for
                                    customer support press 1, for sales press 2…
                                </label>
                            </div>
                            <div class="custom-control custom-radio mb-3">
                                <input type="radio" id="business-message-6"
                                       name="bussiness-message"
                                       class="custom-control-input">
                                <label class="custom-control-label"
                                       for="business-message-6">
                                    To reach our company directory, press 1. For
                                    more information about [Company Name], press
                                    2. If you are an existing customer, please
                                    press 3. For billing questions, press 4. To
                                    repeat menu options, press 9. For all other
                                    inquiries, press 0.
                                </label>
                            </div>
                        </fieldset>

                        <fieldset class="mb-4">
                            <legend class="pl-4">Message for Downtime hours</legend>
                            <div class="custom-control custom-radio mb-3">
                                <input type="radio" id="downtime-message-1"
                                       name="downtime-message"
                                       class="custom-control-input">
                                <label class="custom-control-label"
                                       for="downtime-message-1">
                                    You have reached “Company Name” our business
                                    hours are 8 am to 5 pm.
                                </label>
                            </div>
                            <div class="custom-control custom-radio mb-3">
                                <input type="radio" id="downtime-message-2"
                                       name="downtime-message"
                                       class="custom-control-input">
                                <label class="custom-control-label"
                                       for="downtime-message-2">
                                    Hello! Thank you for calling "Company Name".
                                    Our offices are closed. We are open Monday
                                    to Friday from 8.30 a.m. to 1.30 p.m. and
                                    from 4.30 p.m. to 7.30 p.m. If you wish you
                                    can send a fax to the number *** or an email
                                    to ***. Thank you and goodbye for now!
                                </label>
                            </div>
                        </fieldset>

                        <fieldset class="mb-4">
                            <legend class="pl-4">Message for On-hold hours</legend>
                            <div class="custom-control custom-radio mb-3">
                                <input type="radio" id="on-hold-message-1"
                                       name="on-hold-message"
                                       class="custom-control-input">
                                <label class="custom-control-label"
                                       for="on-hold-message-1">
                                    Our operators are all busy as to not keep
                                    you waiting too long, if you have called us
                                    from an identifiable user, you will be
                                    contacted by the first available operator.
                                    Thank you for calling and talk to you later!
                                </label>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection