@extends('mmlayouts.app')
@section('content')
<div class="content">
    <h2>{{ __('Change Password') }}</h2>
       @if (session('error'))
        <div class="alert alert-danger">
        {{ session('error') }}
        </div>
        @endif
        @if (session('success'))
        <div class="alert alert-success">
        {{ session('success') }}
        </div>
        @endif
    <form method="POST" action="{{ Auth::user()->isAdmin() ? route('changeAdminPassword', ['company' => Auth::user()->company]) : route('changePassword') }}">
        @csrf
        <div class="form-group row">
            <label for="current-password" class="col-md-4 col-form-label text-md-right">{{ __('Current Password') }}</label>
            <div class="col-md-6">
                <input id="current-password" type="password" class="form-control{{ $errors->has('current-password') ? ' is-invalid' : '' }}" name="current-password" required>
                @if ($errors->has('current-password'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('current-password') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group row">
            <label for="new-password" class="col-md-4 col-form-label text-md-right">{{ __('New Password') }}</label>
            <div class="col-md-6">
                <input id="new-password" type="password" class="form-control{{ $errors->has('new-password') ? ' is-invalid' : '' }}" name="new-password" required>

                @if ($errors->has('new-password'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('new-password') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group row">
            <label for="new-password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>
            <div class="col-md-6">
                <input id="new-password-confirm" type="password" class="form-control" name="new-password_confirmation" required>
            </div>
        </div>
        <div class="form-group row mb-0">
            <div class="col-md-8 offset-md-4">
                @if (Auth::user()->company)
                    <span class="btn btn-secondary btn-custom-secondary" onclick="location.href ='/{{ Auth::user()->company->stub }}';">
                @else
                    <span class="btn btn-secondary btn-custom-secondary" onclick="location.href ='/';">
                @endif
                    {{ __('Cancel') }}
                </span>
                <button type="submit" class="btn btn-primary btn-custom" style="margin-bottom: 0 !important">
                    {{ __('Change Password') }}
                </button>
            </div>
        </div>
    </form>
</div>
@endsection