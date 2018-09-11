@if (! isCompanyUser())
            <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right required">{{ __('Organisation Name') }}</label>
                <div class="col-md-6">
                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ isset($obj) ? $obj->name : old('name') }}" required autofocus>
                    @if ($errors->has('name'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <label for="stub" class="col-md-4 col-form-label text-md-right required">{{ __('Link Name') }}</label>
                <div class="col-md-4">
                    <input id="name" type="text" class="form-control{{ $errors->has('stub') ? ' is-invalid' : '' }}" name="stub" value="{{ isset($obj) ? $obj->stub : old('stub') }}" required autofocus>
                    @if ($errors->has('stub'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('stub') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <label for="licences" class="col-md-4 col-form-label text-md-right required">{{ __('Licences') }}</label>
                <div class="col-md-2">
                    <input id="licences" type="text" pattern="[0-9]{0,10}" title="Please enter up to 10 digits."  class="form-control{{ $errors->has('licences') ? ' is-invalid' : '' }}" name="licences" value="{{ isset($obj) ? $obj->licences : old('licences') }}" required autofocus>
                    @if ($errors->has('licences'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('licences') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            @if (! isset($obj) || (isset($obj) && $obj->licence_status !== 'ACTIVE'))
                <div class="form-group row">
                    <label for="date" class="col-md-4 col-form-label text-md-right required">{{ __('Licence Start Date') }}</label>
                    <div class="col-md-2">
                        <input id="datepicker" type="text" class="form-control" name="form-date" value="{{ isset($obj) ? $obj->licence_start_date : old('form-date') }}" required autofocus>
                        <input type="hidden" name="start-date" id="start-date" value="{{ old('start-date') }}" />
                    </div>
                </div>
            @endif
        @endif
        <div class="form-group row">
            <label for="register_passkey" class="col-md-4 col-form-label text-md-right">{{ __('User portal passkey') }}</label>
            <div class="col-md-5">
                <input id="register_passkey" type="text" class="form-control{{ $errors->has('register_passkey') ? ' is-invalid' : '' }}" name="register_passkey" value="{{ isset($obj) ? $obj->employee_register_passkey : old('register_passkey') }}" autofocus>
                @if ($errors->has('register_passkey'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('register_passkey') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        @if (!isset($edit))
            <hr />
            <div class="col-md-6 offset-md-2 mb-4">
                <h4>HR Administrator</h4> <span>All fieilds must be completed if adding an HR administrator.</span>
            </div>
            <div class="form-group row">
                <label for="admin_name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
                <div class="col-md-6">
                    <input id="admin_name" type="text" class="form-control{{ $errors->has('admin_name') ? ' is-invalid' : '' }}" name="admin_name" value="{{ old('name') }}" autofocus>
                    @if ($errors->has('admin_name'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('admin_name') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email Address') }}</label>
                <div class="col-md-6">
                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" autofocus>
                    @if ($errors->has('email'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                <div class="col-md-6">
                    <input id="password" type="text" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" value="{{ old('password') }}" autofocus autocomplete="new-password">
                    @if ($errors->has('password'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        @endif

