@extends('mmlayouts.app')
@section('content')
<div class="container">
    <div class="col-md-8 offset-md-1">
        <h2 class="pt-5 pb-4">{{ __($heading) }}</h2>
    </div>
    @if (isset($company))
        <form method="POST" action="{{ route($stub.'.update', [$company, $obj->id]) }}" id="update">
    @elseif (in_array(Request::route()->getName(), ['sales-admin.edit']))
        <form method="POST" action="{{ route($stub.'.update', [$obj->id]) }}" id="update">
    @else
        <form method="POST" action="{{ route($stub.'.update', [$obj->stub, $obj->id]) }}" id="update">
    @endif
        @method('PUT')
        @csrf
        <component v-bind:redirect="'{{ route($redirect, [$company]).(isset($hash) ? $hash : '') }}'"  v-bind:stub="'{{ $company }}'" v-bind:action=" 'update' " v-bind:obj="{{ json_encode($obj) }}" v-bind:errors="{{ $errors }}" v-bind:old="{{ $old }}" v-bind:is="'{{ $vueComponent }}'"></component>
        <div class="form-group row mb-0">
            <div class="col-md-5 offset-md-4">
                    <span class="btn btn-primary btn-custom-secondary cancel" onclick="location.href = '{{ route($redirect, [$company]).(isset($hash) ? $hash : '') }}';">
                    {{ __('Cancel') }}
                </span>
                <button type="submit" class="btn btn-primary btn-custom confirm">
                    {{ __('Save') }}
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
