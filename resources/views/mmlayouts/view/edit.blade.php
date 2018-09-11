@extends('mmlayouts.app')
@section('content')
<div class="container">
    <div class="col-md-8 offset-md-1">
        <h2 class="pt-5 pb-4">{{ __($heading) }}</h2>
    </div>
    @if (isset($company))
        <form method="POST" action="{{ route($stub.'.update', [$company, $obj->id]) }}">
    @elseif (in_array(Request::route()->getName(), ['sales-admin.edit']))
        <form method="POST" action="{{ route($stub.'.update', [$obj->id]) }}">
    @else
        <form method="POST" action="{{ route($stub.'.update', [$obj->stub, $obj->id]) }}">
    @endif
        @method('PUT')
        @csrf
        @include('mmlayouts.view.partials.'.$view.'.form')
        <div class="form-group row mb-0">
            <div class="col-md-5 offset-md-4">
                @if (isset($company))
                    <span class="btn btn-primary btn-custom-secondary cancel" onclick="location.href = '{{ route($redirect, [$company]).(isset($hash) ? $hash : '') }}';">
                @else
                    <span class="btn btn-primary btn-custom-secondary cancel" onclick="location.href = '{{ route($redirect) }}';">
                @endif
                    {{ __('CANCEL') }}
                </span>
                <button type="submit" class="btn btn-primary btn-custom confirm">
                    {{ __('SUBMIT') }}
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
