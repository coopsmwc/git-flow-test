@extends('mmlayouts.app')
@section('content')
    <main class="main" id="subscribe">
        <div id="app" class="container">
            <div class="row">
                <div class="col-md-4 offset-md-1 text-center">
                    <div class="onboarding">
                        <div class="onboarding-slider">
                            <div class="onboarding-slide">
                                <div class="onboarding-slide-image">
                                    <img src="{{ asset('images/one.png') }}" alt="" class="onboarding-slide-image__src">
                                </div>
                                <p class="onboarding-slide__text">
                                    Clinically proven learning modules to help reduce stress, anxiety and depression
                                </p>
                            </div>
                            <div class="onboarding-slide">
                                <div class="onboarding-slide-image">
                                    <img src="{{ asset('images/two.png') }}" alt="" class="onboarding-slide-image__src">
                                </div>
                                <p class="onboarding-slide__text">
                                    Symptom and behaviour tracking to help you spot patterns in your everyday life
                                </p>
                            </div>
                            <div class="onboarding-slide">
                                <div class="onboarding-slide-image">
                                    <img src="{{ asset('images/three.png') }}" alt="" class="onboarding-slide-image__src">
                                </div>
                                <p class="onboarding-slide__text">
                                    A safe, secure place to record your thoughts, feelings and experiences
                                </p>
                            </div>
                        </div>
                        <div class="mobile-only">
                            <div class="form-skin__v2">
                                <a class="btn btn-primary btn-block btn-custom">Sign Up</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="account-form" class="col-md-4 offset-md-2">
                    <h2 class="no-tm font-size-h1">Now create your account</h2>
                    <form action="{{ route('mps-employee-register.post', [$company->stub]) }}" id="register-form" class="form-skin form-skin__v2 show-loading" method="post">
                        @csrf
                        @if ($errors->has('error') )
                            <span class="terms-error">
                                <strong>There was a problem processing your request, please try again later</strong>
                            </span>
                        @endif
                        <div class="form-group form-group--margin-half clearfix">
                            <a title="Why do we need this?" class="align-right" data-toggle="modal" data-target="#RegisterModal1">Why do we need this?</a>
                        </div>
                        <div class="form-group form-group--input">
                            <input type="text" id="email" class="form-control {{ $errors->has('email') || $errors->has('emailDomain') ? ' is-invalid' : '' }}" name="email" placeholder="Email address" value="{{ old('email') }}">
                            @if ($errors->has('email') || $errors->has('emailDomain'))
                                <span class="error-msg">{{ $errors->first('email') }}{{ $errors->first('emailDomain') }}</span>
                            @endif
                        </div>
                        <div class="form-group form-group--input">
                            <input type="password" id="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" value="{{ old('password') }}">
                            @if ($errors->has('password'))
                                <span class="error-msg">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                        <div class="form-group form-group--input form-group--margin-2x">
                            <input type="password" class="form-control" id="password_confirmation" placeholder="Confirm password" name="password_confirmation" value="{{ old('password_confirmation') }}">
                        </div>
                        <div class="form-group">
                            <p>Data protection laws allow you to control how your information is processed and stored</p>
                            <a title="Your rights explained" data-toggle="modal" data-target="#RegisterModal2">Your rights explained</a>
                        </div>
                        <div class="form-group form-group--checkbox">
                            @if ($errors->has('gdpr'))
                                <span class="error-msg">{{ $errors->first('gdpr') }}</span>
                            @endif
                            <input type="hidden" id="gdpr" name="gdpr" value="0" checked="false" required>
                            <div id="gdpr" data-checked="false" class="faux-checkbox"></div>
                            <label for="data-protection-rights-agree" class="form-group__label">
                                I understand my data protection rights and consent to my data being stored.
                            </label>
                        </div>
                        <div class="form-group form-group--checkbox">
                            @if ($errors->has('terms'))
                                <span class="error-msg">{{ $errors->first('terms') }}</span>
                            @endif
                            <input type="hidden" id="terms" name="terms" value="0" checked="false" required>
                            <div id="terms" data-checked="false" class="faux-checkbox"></div>
                            <label for="minimum-age-agree" class="form-group__label">
                                I am 16 or over and agree to the <a href="https://www.my-possible-self.com/terms" title="terms and conditions">terms and conditions</a>.
                            </label>
                        </div>
                        <div class="form-group form-group--checkbox form-group--margin-2x">
                            <input type="hidden" id="optin" name="optin" value="0" checked="false">
                            <div id="optin" data-checked="false" class="faux-checkbox"></div>
                            <label for="subscribe-agree" class="form-group__label">
                                I am happy to receive news and offers from My Possible Self via email.
                            </label>
                        </div>
                        <div class="form-group">
                            <button type="submit" role="button" class="btn btn-primary btn-block btn-custom">
                                Continue
                            </button>
                        </div>
                    </form>
                    <div class="form-group">
                        <div class="text-center">
                            <ul class="button-list align-center">
                                <li class="button-list__item">
                                    <a href="https://www.my-possible-self.com/faq" class="chevron-link chevron-link--small" target="new">FAQs <i class="ion-chevron-right chevron-link__icon"></i></a>
                                </li>
                                <li class="button-list__item">
                                    <a href="https://www.my-possible-self.com/terms" class="chevron-link chevron-link--small" target="new">Terms and conditions <i class="ion-chevron-right chevron-link__icon"></i></a>
                                </li>
                                <li class="button-list__item">
                                    <a href="https://www.my-possible-self.com/privacy" class="chevron-link chevron-link--small" target="new">Privacy policy <i class="ion-chevron-right chevron-link__icon"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>




    <!---------------------------------- MODAL DIALOG --------------------------------------------------------------->
    <div id="RegisterModal1" role="dialog" class="modal register-modal">
    <div class="modal-dialog modal-dialog--mid modal-lg">
        <div class="section-title-block section-title-block--blue-bg">
            <div data-dismiss="modal" class="close btn">
                <i class="section-title-block__icon icon fas fa-times"></i>
            </div>
        </div> 
        <div class="modal-body modal-body--white">
            <main class="main">
                <div class="modal-content modal-content--white">
                    <div class="container">
                        <h3 class="no-tm">Why do we need your email address?</h3> 
                        <p>We need your email address for the following purposes:</p> 
                        <ul>
                            <li>To discuss any issues relating to your contract with us, including any change to our service, terms of use, or privacy policy</li> 
                            <li>To resolve any payment issues</li>
                            <li>To be able to tell you about any notifiable data breaches, in the unlikely event they should happen.</li>
                        </ul> 
                        <p>You give us consent to use your email address for the following purposes:</p> 
                        <ul>
                            <li>To allow you to access your account from this, or other, devices</li>
                            <li>To allow us to contact you about your account</li> 
                            <li>To allow us to contact you with marketing updates, but only if you actively consent to this.</li>
                        </ul> 
                        <h4 class="no-tm">What we do not use your email address for:</h4> 
                        <ul>
                            <li>Any form of profiling or automatic decision-making</li>
                            <li>Contact you for marketing updates that you have not opted into receiving.</li>
                        </ul>
                    </div>
                </div>
            </main>
        </div>
    </div>
</div>
<div id="RegisterModal2" role="dialog" class="modal register-modal">
    <div class="modal-dialog modal-dialog--mid modal-lg">
        <div class="section-title-block section-title-block--blue-bg">
            <div data-dismiss="modal" class="close btn">
                <i class="section-title-block__icon icon fas fa-times"></i>
            </div>
        </div>

        <div class="modal-body modal-body--white">
            <main class="main">
                <div class="modal-content modal-content--white">
                    <div class="container">
                        <h3 class="no-tm">Rights about your data</h3>
                        <p>Data protection (GDPR) legislation gives you various rights over how we store your data.</p>

                        <h4 class="no-tm">Consent</h4>
                        <p>Once you have registered in the app with your email address, we will only use it for the following purposes:</p>
                        <ul>
                            <li>To send you important communications about your contract with us;</li>
                            <li>For account access. You can withdraw consent for us to use your email for account access purposes but your access to the app will be lost;</li>
                            <li>To send you marketing updates, but only if you have actively opted in. Even if you have opted in, you can withdraw your consent at any time. </li>
                        </ul>
                        <p>You also give us consent to store the information you enter into the app – see the section ‘Other data you give to us’ for more details. Withdrawing consent means that we will delete this data.</p>

                        <h4 class="no-tm">Right to be informed</h4>
                        <p>You have the right to be informed about the collection and use of your personal data. Details on what we collect and why are given below in the section "Data we store about you".</p>
                        <p>You have the right to know who we are and how to contact our Data Protection Officer (see "Contacting us").</p>

                        <h4 class="no-tm">Right of data access</h4>
                        <p>You have the right to access and update your data.  The only personally identifiable data we hold on you is your email. To protect your identity, our app will never display your current email address.</p>
                        <p>All other data you store with us can be accessed from the relevant section of the app or web-app.</p>

                        <h4 class="no-tm">Right to rectification</h4>
                        <p>You have the right to ask us to correct any data we hold on you. You can update your email address at <a href="https://www.my-possible-self.com">www.my-possible-self.com</a>.</p>

                        <h4 class="no-tm">Right to erasure/Right to be forgotten</h4>
                        <p>You have the right to delete your account and all data we have that you have provided to us. This can be done in the "Settings" section at <a href="https://www.my-possible-self.com">www.my-possible-self.com</a>.</p>
                        <p>A private record of your email address will be kept for contractual reasons only, and for no more than three years.</p>

                        <h4 class="no-tm">Right to restrict processing</h4>
                        <p>We do not process your data. It is stored because you have asked us to do so.</p>

                        <h4 class="no-tm">Right to of data portability</h4>
                        <p>If you want a complete copy of the data we hold for you, please email <a href="mailto:techsupport@mypossibleself.com">techsupport@mypossibleself.com</a>.</p>

                        <h4 class="no-tm">Right to object</h4>
                        <p>You have the right to refuse consent to us processing your data in relation to:</p>
                        <ul>
                            <li>Direct marketing</li>
                            <li>Statistical analysis</li>
                        </ul>
                        <p>You can opt out of marketing updates by selecting "unsubscribe" in any email you receive from us, or by contacting <a href="mailto:dpo@mypossibleself.com">dpo@mypossibleself.com</a>.</p>
                        <p>Statistical analysis is completely anonymous, and allows us to provide content that people enjoy, and fix any problems that people may be having. To opt out of this please contact <a href="mailto:dpo@mypossibleself.com">dpo@mypossibleself.com</a>.</p>

                        <h4 class="no-tm">Rights related to automated decision making and profiling</h4>
                        <p>We do not automatically profile you either internally, or against external data sources.</p>

                        <h3 class="no-tm">Data we store about you</h3>

                        <h4 class="no-tm">Email address</h4>
                        <p>We need your email address to allow you to log in to your account on multiple platforms, and to email you about any changes to our policies, services or terms and conditions, or any problems with your payment.</p>
                        <p>If you opt in to receive marketing updates, we will contact you on the email address you provide.</p>
                        <p>No personally identifiable data is passed to our systems unless you have consented to this.</p>

                        <h4 class="no-tm">Other data you give to us</h4>
                        <p>Our app lets you record data about yourself on a variety of topics. This could be in our tracking section, or activities within our modules, and can include freeform text and photographs.</p>
                        <p>This data is stored solely for backup purposes, and to allow you to use the app from multiple platforms.</p>
                        <p>We do not process this data in any way. You can withdraw your consent for us to store this data at any time, but doing so will terminate your access to the app.</p>
                        <p>Please avoid storing sensitive personal data, such as credit card numbers, in any freeform text fields within the app.</p>

                        <h4 class="no-tm">Contacting us</h4>
                        <p>Both the Data Controller and the Data Processor is My Possible Self Ltd.</p>
                        <p>You can contact us at:</p>
                        <p>My Possible Self Ltd<br />
                            Cardale House,<br />
                            Cardale Court,<br />
                            Harrogate,<br />
                            HG3 1RY</p>
                        <p>Our Data Protection Officer can be contacted at:</p>
                        <p><a href="mailto:dpo@mypossibleself.com">dpo@mypossibleself.com</a></p>

                        <h4 class="no-tm">Other Data Processors</h4>
                        <p>We use the following third parties as Data Processors:</p>
                        <ul>
                            <li>Amazon Web Services</li>
                            <li>MailChimp</li>
                            <li>BrainTree</li>
                        </ul>
                    </div>
                </div>
            </main>
        </div>
    </div>
</div>
@endsection