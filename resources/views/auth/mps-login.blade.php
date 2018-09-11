@extends('mmlayouts.app')
@section('content')
    <section id="login-section">
        <div class="container">
            <div class="row">
                <div class="login-container">
                    <div class="login-wrapper">
                        <div class="login-logo">
                            <img src="/images/mps-logo.svg">                 
                        </div>
                        <div class="form-wrap">
                        <h2>{{ __('Login') }}</h2>
                            <form role="form" action="{{ route('login') }}" method="POST" id="login-form" autocomplete="off">
                                @csrf
                                <div class="form-group">
                                    <label for="email" class="sr-only">{{ __('E-Mail Address') }}</label>
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') || $errors->has('type') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
                                    @if ($errors->has('email') || $errors->has('type'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('email') }}{{ $errors->first('type') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="password" class="sr-only">{{ __('Password') }}</label>
                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="checkbox">
                                    <span class="character-checkbox" onclick="showPassword()"></span>
                                    <span class="label">Show password</span>
                                </div>
                                <div class="checkbox2">
                                    <span class="character-checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}></span>
                                    <span class="label">{{ __('Remember Me') }}</span>
                                </div>
                                <div class="btn-holder">
                                    <input type="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="{{ __('Login') }}">
                                </div>
                            </form>
                            <!--<a href="javascript:;" class="forget" data-toggle="modal" data-target=".forget-modal">Forgot your password?</a>-->
                        </div>
                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section>
@endsection
