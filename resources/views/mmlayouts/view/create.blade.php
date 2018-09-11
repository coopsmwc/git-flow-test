@extends('mmlayouts.app')
@section('content')
<div class="container">
        <div class="col-md-6 offset-md-2">
            <h2 class="pt-5 pb-4">{{ __($heading) }}</h2>
        </div>
        @if (in_array(Request::route()->getName(), ['companies', 'company.details.create', 'sales-admin.create']))
            <form method="POST" action="{{ route($stub.'.store') }}">
        @else
            <form method="POST" action="{{ route($stub.'.store', [$company]) }}">
        @endif
        @csrf
        @include('mmlayouts.view.partials.'.$view.'.form')
        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
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

