<div class="mt-4">
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
