@extends('mmlayouts.app')
@section('content')
    <section id="emp-register">
        <div class="container">
            <div class="row">
                <div class="emp-register-container">
                    <div class="emp-register-wrapper">
                        <div class="emp-register-logo">
                            <img src="/images/mps-logo.svg">                 
                        </div>
                        <div class="form-wrap">
                            <h2 class="text-center">{{ $company->name }}</h2>
                        <h3 class="mb-2">{{ __('Enter your registration passcode here') }}</h3>
                        @if (session('error'))
                            <div class="alert alert-danger">
                        {{ session('error') }}
                            </div>
                        @endif
                            <form method="POST" action="{{ route('employee-register.post', [Request::route('company')]) }}">
                                @csrf
                                <div class="form-group">
                                    <label for="passkey" class="sr-only">{{ __('Password') }}</label>
                                    <input id="passkey" type="password" class="form-control{{ $errors->has('credentials') ? ' is-invalid' : '' }}" name="passkey" required autocomplete="new-password" placeholder="Passcode">
                                    @if ($errors->has('credentials'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('credentials') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="checkbox">
                                    <span class="character-checkbox" onclick="showPassword()"></span>
                                    <span class="label">Show passcode</span>
                                </div>
                                <div class="g-recaptcha" data-sitekey="{{ $googleRecapchtaSiteKey }}"></div>
                                <div class="btn-holder mb-2 register-btn-holder">
                                    <input type="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="{{ __('Submit') }}">
                                </div>
                            </form>
                        </div>
                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section>
@endsection
