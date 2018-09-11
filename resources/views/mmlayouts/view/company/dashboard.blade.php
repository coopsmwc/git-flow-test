@extends('mmlayouts.app')
@section('content')
<div class="content">
        <div class="org-content org-content_company">
            <div class="org-content--stub mb-2">Licences</div>
			<div class="row">
				<div class="org-content--licences col-lg-3 col-sm-12">
                        <div class="licence-number">Total licences:</div>    
                        <div>{{ $obj->licences }}</div>                        				
				</div>
                    <div class="org-content--licences-used col-lg-3 col-sm-12">
                        @if ($showUsage)
                            <div class="licence-number">Licences used:</div>
                            <div>{{ $percentage }}&#37;</div>                            
                        @else
                            <div class="licence-number">Licences used:</div>
                            <div><span data-toggle="tooltip" data-placement="right" data-offset="-10px, 20px"
                                 title="'{{ __('Due to privacy restrictions, we cannot display the licence usage until at least 25 licences are in use') }}'">N/A</span></div>
                        @endif
                    </div>
                    <div class="col-lg-3 col-sm-12 org-content--licences">
					<div class="licence-number">Days left:</div><div id="startDate">{{ $obj->licence_status === 'ACTIVE' ? $obj->getLicenceDaysLeft() : 'Not started' }}</div>
				</div>
				<div class="col-lg-3 col-sm-12 org-content--licences">
					<div class="licence-number">End date:</div><div class=" {{ !$obj->getLicenceDaysLeft() ? 'expired' : '' }}" id="endDate">{{ $obj->licence_end_date ? $obj->licence_end_date : '-' }}</div>
				</div>
			</div>
                <div class="org-content--stub">User portal access credentials</div>
                <span style="margin-right: 10px;">Your end users will need the passcode and link below to access the end user portal.</span><popover v-bind:title="'{{ __('Registration link') }}'" v-bind:text="'{{ __('The ‘user portal’, also referred to as the ‘end user portal’ is the system through which your end users will access My Possible Self. ‘End users’ refers to anyone eligible to claim a My Possible Self licence, such as your employees (if you are an employer) or your patients/ service users (if you are a health provider).') }}'"></popover>
                <div class="row mt-3">
                    <div class="org-content--licences col-lg-3 col-sm-12">
                      <div class="licence-number">Passcode:</div><div  class="end-date">{{ $obj->employee_register_passkey }}</div>					
                    </div>
                    <div class="col-lg-6 col-sm-12">
                      <div class="licence-number mb-1">Registration URL:</div>
                      <span id="regurl" class="end-date">{{ route('employee-register', [$obj->stub]) }}</span> <clipboard v-bind:target="'#regurl'"></clipboard>
                    </div>
                </div>
		</div>
</div>
@endsection