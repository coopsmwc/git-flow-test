        <input type="hidden" name="type" value="2">
        <div class="form-group row">
            <label for="email" class="col-md-4 col-form-label text-md-right required">{{ __('Email Address') }}</label>
            <div class="col-md-6">
                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ isset($obj) ? $obj->user->email : old('email') }}" required autofocus>
                @if ($errors->has('email'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group row">
            <label for="name" class="col-md-4 col-form-label text-md-right required">{{ __('Name') }}</label>
            <div class="col-md-6">
                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ isset($obj) ? $obj->name : old('name') }}" required autofocus>
                @if ($errors->has('name'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
        </div>
            @if (!isset($edit))
                <div class="form-group row">
                    <label for="password" class="col-md-4 col-form-label text-md-right required">{{ __('Password') }}</label>
                    <div class="col-md-6">
                        <input id="password" type="text" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required autofocus autocomplete="new-password">
                        @if ($errors->has('password'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            @else
                @can('change-admin-password')
                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Change Password') }}</label>
                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Enter new password" autofocus autocomplete="new-password">
                            @if ($errors->has('password'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                @endcan
            @endif
        <div class="form-group row">
            <label for="notes" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>
            <div class="col-md-6">
                <textarea id="notes" class="form-control{{ $errors->has('notes') ? ' is-invalid' : '' }}" name="notes" autofocus>{{ isset($obj) ? $obj->notes : old('notes') }}</textarea>
                @if ($errors->has('notes'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('notes') }}</strong>
                    </span>
                @endif
            </div>
        </div>


