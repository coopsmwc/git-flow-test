@extends('mmlayouts.app')
@section('content')
<div class="container">
        <div class="col-md-6 offset-md-2">
            <h2 class="pt-5 pb-4">{{ __($heading) }}</h2>
        </div>
        @if (in_array(Request::route()->getName(), ['companies', 'company.details.create', 'sales-admin.create']))
            <form method="POST" action="{{ route($stub.'.store') }}" name="create" id="create">
        @else
            <form method="POST" action="{{ route($stub.'.store', [$company]) }}" name="create" id="create">
        @endif
        @csrf
        <component v-bind:redirect="'{{ route($redirect, [$company]).(isset($hash) ? $hash : '') }}'" v-bind:stub="'{{ $company }}'" v-bind:errors="{{ $errors }}" v-bind:old="{{ $old }}" v-bind:is="'{{ $vueComponent }}'"></component>
        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
                    <span class="btn btn-primary btn-custom-secondary cancel" onclick="location.href = '{{ route($redirect, [$company]).(isset($hash) ? $hash : '') }}';">
                    {{ __('Cancel') }}
                </span>
                <button type="submit" class="btn btn-primary btn-custom confirm">
                    {{ __($create) }}
                </button>
            </div>
        </div>
    </form>
    <div class="col-lg-6 col-sm-12 mt-4">
        <div>Registration URL:</div><span id="regurl">{{ route('employee-register', [$company]) }}</span> <clipboard v-bind:target="'#regurl'"></clipboard>
    </div>
</div>
@endsection

