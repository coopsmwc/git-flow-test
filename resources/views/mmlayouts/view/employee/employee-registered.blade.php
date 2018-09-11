@extends('mmlayouts.app')
@section('content')
<main id="subscribe" class="hasRegistered">
	<div id="app" class="container">
		<div class="row">
            <div class="hasRegistered-container">
                <div class="hasRegistered-wrapper">
                    <div class="login-logo">
                            <img src="/images/mps-logo.svg">                 
                        </div>
                    <h2 class="text-center">{{ $obj->name }}</h2>
                    <div>
                        <h3 class="text-center">Thanks for registering. Just one more step to go!</h3>
                        <p class="text-center">We now need you to validate your email address. Please check your inbox for a validation email, then click the link in the email.</p>
                        <p class="text-center">Once that’s done, you can start using the My Possible Self smartphone app (available in the iTunes and Google Play stores) or the desktop programme.
                        </p>
                    </div>
                    <div class="row registerImage-holder">
                        <div class="col-sm-4 large-only">
                            <div class="registerImage">
                                <img src="/images/phone-fear.png" alt="">
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="registerImage">
                                <img src="/images/phone-happiness.png" alt="">
                            </div>
                        </div>
                        <div class="col-sm-4 large-only">
                            <div class="registerImage">
                                <img src="/images/phone-stressed.png" alt="">
                            </div>
                        </div>
                    </div>
                </div> 
            </div>   
		</div>
	</div>
</main>
@endsection