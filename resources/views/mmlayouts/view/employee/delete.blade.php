<div class="container mt-5">
    <form class="mt-5" id="mform" method="POST" action="{{ route('employee-remove.remove', [$company]) }}">
        @csrf
        <div class="form-group row">
            <label for="emai" class="col-md-4 col-form-label text-md-right required">{{ __('User email address') }}</label>
            <div class="col-md-4">
                <input id="email" type="email" class="form-control" name="email" required autofocus>
                @if ($errors->has('emai'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('emai') }}</strong>
                    </span>
                @endif
            </div>
            <div class="col-md-1">
                <popover v-bind:title="'{{ __('User email address') }}'" v-bind:text="'{{ __('Users’, also referred to as ‘end users’, are the people who are eligible to claim a My Possible Self licence under this contract. For example, if you are an employer, the end users are your employees. If you are a health provider, your end users are your patients/service users.') }}'"></popover>
            </div>
        </div>
        <div class="form-group row mt-4">
            <div class="col-md-5 offset-md-4">
                    <span class="btn btn-primary btn-custom-secondary cancel" onclick="location.href = '{{ route('company-manage-users', [$company]) }}';">
                    {{ __('CANCEL') }}
                </span>
                <button type="submit" class="btn btn-primary btn-custom confirm" data-modal="delete">
                    {{ __('SUBMIT') }}
                </button>
            </div>
        </div>
    </form>
</div>
<div class="mt-5">Removed users may continue to use the full service by paying for their own subscription.</div>
<modal v-bind:button="'{{ __('REMOVE') }}'" v-bind:content="'<span>Are you sure you want to remove the user?</span>'" v-bind:title="'{{ __('Confirm remove user') }}'"></modal>