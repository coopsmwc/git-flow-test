@extends('mmlayouts.app')
@section('content')
<div class="content">
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
	<div class="org-wrapper">
		<div class="org-content">
            <h2>{{ $obj->name }}</h2>
	        <div class="switch-holder">
	        	<h3>Settings</h3>
                @if (($obj->licence_status !== 'ACTIVE' && Auth::user()->can('activate-licence')) 
                        || ($obj->licence_status == 'ACTIVE' && Auth::user()->can('deactivate-licence')))
                    @if ($obj->licence_status !== 'ACTIVE')
                    <div class="mb-3">
                        <div>Licence start date</div>
                        @if ($obj->licence_start_date)
                            <input type="text" id="datepicker" value="{{ $obj->licence_start_date }}">
                        @else
                            <input type="text" id="datepicker">
                        @endif
                    </div>
                    @endif
                    <div class="toggle-switch-licence">
                      <div class="licence">
					    <label for="cb-switch-licence">
					    	<p> {{ $obj->licence_status === 'ACTIVE' ? 'Stop' : 'Start' }} licence</p>
                                @if ($obj->licence_status === 'ACTIVE')
                                    <input type="checkbox" id="cb-switch-licence" checked>
                                @else
                                    <input type="checkbox" id="cb-switch-licence">
                                @endif
					      <span>
					        <small></small>
					      </span>
					    </label>
				    </div>
			  	</div>
                    <form method="POST" id="activate-licence" action="{{ route('activate-licence', [$obj->stub]) }}">
                        <input type="hidden" name="id" value="{{ $obj->id }}" />
                        <input type="hidden" name="start-date" id="start-date" value="{{ date('Y/m/d', $obj->getLicenceStartDateTimestamp()) }}" />
                        @csrf
                    </form>
                    <form method="POST" id="deactivate-licence" action="{{ route('deactivate-licence', [$obj->stub]) }}">
                        <input type="hidden" name="id" value="{{ $obj->id }}" />
                        <input type="hidden" name="start-date" id="start-date" value="" />
                        @csrf
                    </form>
                @endif
                @if ($obj->status !== 'PENDING')
                    @can('suspend-account')
                        <div class="toggle-switch-suspend">
                            <div class="suspend">
                                <label for="cb-switch-suspend">
                                    <p>{{ $obj->status === 'ACTIVE' ? 'Suspend' : 'Activate' }} account</p>
                                    @if ($obj->status !== 'SUSPENDED')
                                        <input type="checkbox" id="cb-switch-suspend" data-keyboard="false" data-backdrop="static" data-toggle="modal" data-target="#delete-confirm-{{ $obj->id }}">
                                    @else
                                        <input type="checkbox" id="cb-switch-suspend" checked>
                                    @endif
                                    <span>
                                        <small></small>
                                    </span>
                                </label>
                            </div>
                        </div>
                        <form method="POST" id="activate" action="{{ route('activate', [$obj->stub]) }}">
                            <input type="hidden" name="id" value="{{ $obj->id }}" />
                            @csrf
                        </form>
                    @endcan
                @endif
			 	<div class="toggle-switch-renew">
			  		<div class="renew">
					    <label for="cb-switch-renew">
					    	<p>{{ $obj->auto_renew ? 'Cancel auto renew' : 'Auto renew licence' }}</p>
                                @if (!$obj->auto_renew)
                                    <input type="checkbox" id="cb-switch-renew">
                                @else
                                    <input type="checkbox" id="cb-switch-renew" checked>
                                @endif
					      <span>
					        <small></small>
					      </span>
					    </label>
				    </div>
			  	</div>    
			 </div>
                <form method="POST" id="auto-renew" action="{{ route('auto-renew', [$obj->stub]) }}">
                    <input type="hidden" name="id" value="{{ $obj->id }}" />
                    @csrf
                </form>
                <form method="POST" id="cancel-auto-renew" action="{{ route('cancel-auto-renew', [$obj->stub]) }}">
                    <input type="hidden" name="id" value="{{ $obj->id }}" />
                    @csrf
                </form>
               <div class="org-content--stub mb-2 mt-2">Licence information</div>
			<div class="row">
				<div class="org-content--licences col-lg-4 col-sm-12">
					<div class="licence-number">Total licences:</div>   <div>{{ $obj->licences }}</div>				
				</div>
				<div class="org-content--licences-used col-lg-4 col-sm-12">
					<div class="licence-number">Usage:</div><div>{{ $percentage }}&#37;</div>
				</div>
                    <div class="org-content--licences-used col-lg-4 col-sm-12">
					<div class="licence-number">Days left:</div><div>{{ $obj->licence_status === 'ACTIVE' ? $obj->getLicenceDaysLeft() : '--' }}</div>
				</div>
			</div>
			<div class="row mb-4">	
				<div class="col-lg-4 col-sm-12">
					<div class="licence-number">Start date: </div><div class="start-date" id="startDate">{{ $obj->licence_start_date ? $obj->licence_start_date : 'Not started' }}</div>				</div>
				<div class="col-lg-4 col-sm-12">
					<div class="licence-number">End date: </div><div class="end-date {{ !$obj->getLicenceDaysLeft() ? 'expired' : '' }}" id="endDate">{{ $obj->licence_end_date ? $obj->licence_end_date : '-' }}</div>
				</div>
                    <div class="col-lg-4 col-sm-12">
					<div class="licence-number">Licence status:</div><div class="end-date">{{ $obj->licence_status }}</div>					
				</div>
			</div>
                <div class="org-content--stub  mb-2">Employee registration credentials</div>
                <div class="row">
                    <div class="org-content--licences col-lg-4 col-sm-12">
                      <div class="licence-number">Passcode:</div><div  class="end-date">{{ $obj->employee_register_passkey }}</div>					
                    </div>
     
                </div>
                <div class="row mb-4">
                    <div class=" org-content--licences col-lg-12 col-sm-12">
                      <div class="licence-number">Registration URL:</div><div class="end-date">{{ route('employee-register', [$obj->stub]) }}</div>
                    </div>
                </div>
                 <div class="org-content--stub mb-2">General information</div>
    			<div class="row">
				<div class="org-content--licences col-lg-4 col-sm-12">
					<div class="licence-number">Organisation status:</div><div class="end-date">{{ $obj->status }}</div>					
				</div>
				<div class="org-content--licences-used col-lg-4 col-sm-12">
					<div class="licence-number">Link name:</div><div class="end-date">{{ $obj->stub }}</div>					
				</div>
			</div>
                <hr class="mt-1 mb-0">
                <div class="org-content--domains row">
                    <div class="col-lg-3 col-sm-12 org-content--domains_title">Allowed domains: </div>
                    <div class="col-lg-7 col-sm-12">
                        @foreach($domains as $key => $domain)
                            @if ($key)
                            <span class="start-date">, {{ $domain->domain }}</span>
                            @else
                                <span class="start-date">{{ $domain->domain }}</span>
                            @endif
                        @endforeach
                    </div>
                    <form method="GET" action="{{ route('company-company-manage-users', [$obj->stub]) }}">
                        <button type="submit"><i class="fas fa-edit" data-toggle="tooltip" data-placement="top" title="Manage Email Domains"></i></button>
                    </form>
                </div>
		</div>
        <div class="button-holder row">
          <input onclick="location.href = '{{ route($redirect, [$obj->stub]) }}';" type="button" class="btn btn-secondary btn-custom-secondary" value="Back"/>
          <input type="button" class="btn btn-primary btn-custom" value="Edit" onclick="location.href = '{{ route('company.details.edit', [$obj->stub, $obj->id]) }}';"/>
		</div>        
	</div>
    @include('mmlayouts.view.company.confirm-suspend')
</div>
@endsection