        <input type="hidden" name="type" value="2">
        <div class="form-group row">
            <label for="email" class="col-md-4 col-form-label text-md-right required">{{ __('Email Address') }}</label>
            <div class="col-md-6">
                <input id="email" type="email" placeholder="someone@domain.com, co.uk etc" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ isset($obj) ? $obj->email : old('email') }}" required autofocus>
                @if ($errors->has('email'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            <div class="col-md-1">
                <popover v-bind:title="'{{ __('Email address') }}'" v-bind:text="'{{ __('If some of your end users have email addresses that are different from your organisation’s email address (such as gmail.com), you can give them permission to create a My Possible Self account by entering their individual email addresses below.') }}'"></popover>
            </div>
        </div>
        <div class="form-group row">
            <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>
            <div class="col-md-6">
                <textarea id="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" autofocus>{{ isset($obj) ? $obj->description : old('description') }}</textarea>
                @if ($errors->has('description'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('description') }}</strong>
                    </span>
                @endif
            </div>
            <div class="col-md-1">
                <popover v-bind:title="'{{ __('Description') }}'" v-bind:text="'{{ __('Please enter some information that identifies the user (usually their name, but can be any unique identifier).') }}'"></popover>
            </div>
        </div>



