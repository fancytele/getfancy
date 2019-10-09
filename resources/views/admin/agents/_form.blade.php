<div class="form-group">
    <label for="code">@lang('Agent code')</label>
    <input type="text"
           class="form-control w-50 @error('code') is-invalid @enderror"
           id="code" name="code"
           value="{{ old('code',  $agent->employee_code ?? '') }}" required
           autofocus>
    @error('first_name')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>
<div class="form-group">
    <label for="first_name">
        @lang('First Name')
    </label>
    <input type="text"
           class="form-control @error('first_name') is-invalid @enderror"
           id="first_name" name="first_name"
           value="{{ old('first_name',  $agent->first_name ?? '') }}" required
           autofocus>
    @error('first_name')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>

<div class="form-group">
    <label for="last_name">@lang('Last Name')</label>
    <input type="text"
           class="form-control @error('last_name') is-invalid @enderror"
           id="last_name" name="last_name"
           value="{{ old('last_name',  $agent->last_name ?? '') }}" required>
    @error('last_name')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>

<div class="form-group">
    <label for="email">@lang('E-mail')</label>
    <input type="email"
           class="form-control @error('email') is-invalid @enderror" id="email"
           name="email" value="{{ old('email',  $agent->email ?? '')  }}"
           required>
    @error('email')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>
