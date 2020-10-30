@extends('layouts.admin')

@section('page-title', __('Fancy Settings'))

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
</div>
@endsection