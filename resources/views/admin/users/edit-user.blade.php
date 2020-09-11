@extends('layouts.admin')

@section('page-title', __('User Settings'))

@push('head-scripts')
<script>
  import UserSettingComponent from "../../../js/components/UserSettingComponent";
  export default {
    components: {UserSettingComponent}
  }
</script>
@endpush

@section('content')
    <div class="container-fluid">

        <user-setting-component :url-action="'{{ route('admin.users.update_profile', $user->id) }}'"
                                :route="'{{ route('admin.users.edit_profile', $user->id) }}'"
                                :url="'{{ route('admin.users.cancel_subscription', $user->id) }}'"
        ></user-setting-component>
    </div>
@endsection