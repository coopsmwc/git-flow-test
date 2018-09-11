        <div class="col-md-8 offset-md-1">
            <p>If you change your passcode, you will need to give this to your end users in order</p>
        </div>        
        <div class="form-group row">
            <label for="register_passkey" class="col-md-4 col-form-label text-md-right">{{ __('Passcode') }}</label>
            <div class="col-md-5">
                <input id="register_passkey" type="text" class="form-control{{ $errors->has('register_passkey') ? ' is-invalid' : '' }}" name="register_passkey" value="{{ isset($obj) ? $obj->employee_register_passkey : old('register_passkey') }}" autofocus>
                @if ($errors->has('register_passkey'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('register_passkey') }}</strong>
                    </span>
                @endif
            </div>
        </div>

