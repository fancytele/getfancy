@extends('layouts.admin')

@section('page-title', __('Fancyy Settings'))

@push('head-scripts')
    <script src="{{ asset('js/lang.js') }}" defer></script>
    <script>
        function getDashboardLink(){
          this.laddaButton = Ladda.create(
            document.querySelector('#link-to-dashboard')
          );
          this.laddaButton.start();
          axios.get("{{ route('admin.users.dashboard_link' , $user->id) }}")
          .then(response =>{
            console.log(response)
            window.open(response.data.link , '_blank');
            this.laddaButton.stop();
          })
          .catch(error =>{
            console.log(error);
            $('#phone_system_error').modal('show');
            this.laddaButton.stop();

          })
        }
    </script>
@endpush

@section('content')
<div class="container-fluid">
    <a href="{{ route('admin.users.index') }}" class="btn btn-link mb-3">
        <i class="fe fe-arrow-left mr-2"></i>
        @lang('Back')
    </a>

    <button onclick="getDashboardLink()"
            id="link-to-dashboard"
            class="btn btn-primary btn btn-primary ladda-button float-right"
            data-style="zoom-out"
    >
        <i class="fa fa-link" aria-hidden="true"></i> {{ trans('Edit Call Flow') }}
    </button>

    <fancy-setting-component :ticket-in-progress="{{ json_encode($user->hasTicketInProgress()) }}"
                             :has-professional-recording='@json($has_professional_recording)'
                             :professional-recording-price="{{ $professional_recording_price }}"
                             :settings='@json($settings)'
                             :notification-periods='@json($notification_periods)'
                             :messages='@json($messages)'
                             :url-action="'{{ route('admin.users.update_fancy', $user->id) }}'"
                             :allow-upload-audio='@json($allow_upload_audio)'>
    </fancy-setting-component>

    <div class="modal fade" id= "phone_system_error" tabindex="-1" role="dialog"
         aria-labelledby="delete-element-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <button type="button" class="close mr-3 mt-3"
                            data-dismiss="modal" aria-label="Close">
                        <i class="fe fe-x-circle"></i>
                    </button>
                    <div class="d-flex my-3 pl-4 pt-4">
                        <i
                                class="display-4 fe fe-alert-circle mr-3 mt-n2 mt-n3 "></i>
                        <div>
                            <h3 class="mb-0">
                                {{ trans('Something went wrong!') }}
                                <br>
                                <span
                                        class="element-name text-capitalize"></span>{{ trans('Please, try again after some time.') }}
                            </h3>
                            <p class="element-detail text-black-50"></p>
                        </div>
                    </div>
                    <div class="d-flex overflow-hidden rounded-bottom">
                        <button type="button"
                                class="btn btn-lg btn-outline-primary rounded-0 text-body w-100"
                                data-dismiss="modal">
                            {{ trans('OK') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection