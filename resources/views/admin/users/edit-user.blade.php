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
        <a href="{{ route('admin.users.index') }}" class="btn btn-link mb-3">
            <i class="fe fe-arrow-left mr-2"></i>
            @lang('Back')
        </a>

        <user-setting-component>
            :url-action="'{{ route('admin.users.edit', $user->id) }}'"
        </user-setting-component>
    </div>
@endsection