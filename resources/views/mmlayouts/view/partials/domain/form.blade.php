        <input type="hidden" name="type" value="2">
        <div class="form-group row">
            <label for="domain" class="col-md-4 col-form-label text-md-right required">{{ __('Email domain') }}</label>
            <div class="col-md-6">
                <input id="domain" type="text" placeholder="domain.com, co.uk etc" pattern="[^@]*\..+" title="Domain part only." class="form-control{{ $errors->has('domain') || $errors->has('dns') || $errors->has('there')? ' is-invalid' : '' }}" name="domain" value="{{ isset($obj) ? $obj->domain : old('domain') }}" required autofocus>
                @if ($errors->has('domain') || $errors->has('dns') || $errors->has('there'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('domain') }}{{ $errors->first('dns') }}{{ $errors->first('there') }}</strong>
                    </span>
                @endif
            </div>
            <div class="col-md-1">
                <popover v-bind:title="'{{ __('Email domain') }}'" v-bind:text="'{{ __('Entering an allowed email domain will enable anyone with that type of email address to create their own My Possible Self account. The domain is the last part of the email address, and is usually specific to your organisation (e.g. mybusiness.com).') }}'"></popover>
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
                <popover v-bind:title="'{{ __('Description') }}'" v-bind:text="'{{ __('Please enter a description for this domain, such as the organisation or division it relates to.') }}'"></popover>
            </div>
        </div>



