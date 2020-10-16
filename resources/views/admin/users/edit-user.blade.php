@extends('layouts.admin')

@section('page-title', __('User Settings'))

@push('head-scripts')
    <script src="https://js.stripe.com/v3/"></script>
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
                                :locale="'{{ app()->getLocale() }}'"
                                :get_all_payment_methods="'{{route('admin.users.get_all_payment_methods' , $user->id)}}'"
                                :delete_payment_method="'{{ route('admin.users.delete_payment_methods',$user->id) }}'"
                                :update_two_factor_authentication="'{{ route('admin.users.update_two_factor_authentication', $user->id )}}'"
                                :add_authorized_user="'{{ route('admin.users.add_authorized_user', $user->id) }}'"
                                :delete_authorized_user="'{{ route('admin.users.delete_authorized_user', $user->id) }}'"
                                :update_default_card="'{{ route('admin.users.update_default_card', $user->id) }}'"
                                :phone_system_dashboard_link="'{{ route('admin.users.dashboard_link' , $user->id) }}'"
        ></user-setting-component>
    </div>
@endsection