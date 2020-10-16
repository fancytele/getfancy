@extends('layouts.admin')

@section('page-title', __('DID Settings'))

@push('head-scripts')
    <script>

      import DidSettingComponent from "../../../js/components/DidSettingComponent";
      export default {
        components: {DidSettingComponent}
      }
    </script>
@endpush

@section('content')
    <div class="container-fluid">

        <did-setting-component :get_dashboard_link = "'{{ route('admin.users.dashboard_link' , $user->id) }}'">

        </did-setting-component>
    </div>
@endsection