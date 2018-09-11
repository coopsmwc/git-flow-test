@extends('mmlayouts.app')
@section('content')
<div class="content">
    <h2 class="pb-2">{{ __($heading) }}</h2>
    @if (isset($companyName))
        <h3 class="pb-1">
            <a href="{{ route('company-company-dashboard', [$company]) }}">{{ $companyName }}</a>
        </h3>
    @endif
    @include('mmlayouts.view.partials.'.$view.'.table')
    <div class="create-btn-holder">
        @if (in_array(Request::route()->getName(), ['companies', 'sales-admins']))
            <form method="GET" action="{{ route($stub.'.create') }}">
        @elseif (isset($company))
            <form method="GET" action="{{ route($stub.'.create', [$company]) }}">
        @endif
            <button id="btn-create-company" class="btn btn-custom btn-lg btn-block">{{ __($new) }}</button>
        </form>
    </div>
</div>
@endsection
