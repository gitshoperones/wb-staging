@if( ! $agent->isMobile())
{!! NoCaptcha::renderJs() !!}
@endif
<div class="tab-pane fade login-step" id="step-{{ (request()->vendor_id) ? '6' : '5' }}">
    <h1 class="title"> Let's get your quotes </h1>
    <p class="btn-block text-primary">Please login or sign up, so we can send you quotes.</p>
    

    <ul class="nav nav-tabs">
        <li class="active">
            <a id="step-1-section" href="#login-step" data-toggle="tab">Login</a>
        </li>
        <li>
            <a id="step-2-section" href="#signup-step" data-toggle="tab">Sign Up</a>
        </li>
    </ul>

    <div class="tab-content job-post-tabs">
        <div class="tab-pane fade in active" id="login-step">
            <div class="btn-block">
                <div class="wb-form-group">
                    <input type="email" name="emailLog" value="{{ old('emailLog') }}" placeholder="Email" class="form-control text-center">
                </div>
            </div>
            <div class="btn-block">
                <div class="wb-form-group">
                    <input type="password" name="passwordLog" value="" placeholder="Password" class="form-control text-center" autocomplete="off">
                </div>
            </div>
            <div class="btn-block" id="login-warning-notif" style="display:none;">
                <div class="wb-form-group">
                    <span class="text-danger" id="notif-mes">Invalid Email or Password</span>
                </div>
            </div>

            @php
            $btnLast = 'Post Job';
            if(request()->vendor_id) {
                $btnLast = 'Request Quote';
            }
            @endphp
            
            <input type="hidden" value="login" name="identifier">

            <div class="action-buttons">
                <input type="hidden" name="status" value="3">
                <button id="{{ (request()->vendor_id) ? "submit-quote-request" : "submit-job-post"}}" type="submit" class="btn wb-btn wb-btn-primary {{ ($btnLast == 'Post Job') ? "thank-you" : "submit-quote-request" }}">
                    {{ isset($btnLbl) ? $btnLbl : $btnLast }}
                </button>
            </div>
        </div>   
        
        <div class="tab-pane fade" id="signup-step">
            <div class="wb-form-group row">
                <div class="col-md-12">
                    <input type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="form-control text-center"
                    placeholder="Email"
                    >
                </div>
            </div>
            <div class="wb-form-group row">
                <div class="col-md-12">
                    <input type="password"
                    name="password"
                    class="form-control text-center"
                    placeholder="Password"
                    >
                </div>
            </div>
            @if( ! $agent->isMobile())
            <div class="wb-form-group row">
                <div class="col-md-12">
                    <input type="password"
                    name="password_confirmation"
                    class="form-control text-center"
                    placeholder="Confirm Password"
                    >
                </div>
            </div>
            @endif
            <div class="wb-form-group hide">
                <select class="form-control" name="account" required>
                    <option value="couple" selected>Couple</option>
                </select>
            </div>

            <div class="wb-form-group form-group" style="margin-bottom: 0px;">
                <input type="checkbox"
                id="newsletter_signup"
                name="subscribe"
                class="form-control"
                checked />
                <label class="text-cursor-pointer text-light text-case-normal" for="newsletter_signup">
                    Sign up to the wedBooker email newsletter
                </label>
            </div><!-- /.form-group -->

                <div class="form-group tac" style="margin-bottom: 0px;">
                    <input type="checkbox"
                    id="accept_tc"
                    name="accept_tc"
                    class="form-control"/>
                    <label class="text-cursor-pointer text-light text-case-normal" for="accept_tc">
                        By registering you confirm that you accept the
                        <a href="{{ url('/terms-and-conditions') }}" target="_blank">Terms and Conditions</a>
                        and <a href="{{ url('/privacy-policy') }}" target="_blank">Privacy Policy</a>
                    </label>

                </div><!-- /.form-group -->
                <br />

                @if( ! $agent->isMobile())
                {!! NoCaptcha::display() !!}
                @endif

                <div class="form-group">
                    @php
                    $btnLast = 'Post Job';
                    if(request()->vendor_id) {
                        $btnLast = 'Request Quote';
                    }
                    @endphp

                    <div class="action-buttons">
                        <button id="{{ (request()->vendor_id) ? "submit-quote-request-register" : "submit-job-post-register"}}" type="submit" name="status" value="3" class="wb-hide">
                            {{ isset($btnLbl) ? $btnLbl : $btnLast }}
                        </button>
                        
                        <button type="button" data-toggle="modal" data-target="#modalContinue" class="btn wb-btn wb-btn-primary">
                            {{ isset($btnLbl) ? $btnLbl : $btnLast }}
                        </button>
                    </div>
                </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div id="modalContinue" class="modal-signup modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content text-center">
			<div class="modal-header">
				<h4 class="title wb-br-b-0" style="font-weight: 300; color: #353554; text-transform: uppercase; padding: 0;">THANKS FOR POSTING YOUR JOB</h4>
			</div>
			<div class="modal-body">
                <p>    
                    @if(request()->vendor_id)
                        Thanks for requesting a quote. We need a few quick details to finish setting up your account so you can receive quotes.
                        @else
                        Let's finish setting up your account so we can send you quotes for your event!
                    @endif
                </p>

                <div class="btn-block" style="margin: 0;">
                    <div class="form-group">
                        <div class="action-buttons" style="margin: 0;">
                            <button type="button" value="1" class="btn wb-btn wb-btn-primary btn-continue {{ ($btnLast == 'Post Job') ? "thank-you" : "submit-quote-request-register" }}">
                                Continue
                            </button>
                        </div>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>

