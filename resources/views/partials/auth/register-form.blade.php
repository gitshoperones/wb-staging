@if( ! $agent->isMobile())
{!! NoCaptcha::renderJs() !!}
@endif
<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<form method="POST" action="{{url('/register')}}">
			{{ csrf_field() }}
			@include('partials.alert-messages')
			<div class="wb-register-card"
			style="background-color: #fff;
			padding: 30px; box-shadow: 0px 0px 4px rgba(0,0,0,0.2);
			text-align: center">
			<div class="row">
				<div class="col-sm-6 wd-register">
					<div class="wb-form-group">
						<label for=""><i class="fa fa-user"></i> <span>email</span></label>
						<input type="email"
						name="email"
						value="{{ old('email') }}"
						class="form-control text-center"
						required>
					</div>
					<div class="wb-form-group">
						<label for=""><i class="fa fa-lock"></i> <span>Password</span></label>
						<input type="password"
						name="password"
						class="form-control text-center"
						required>
					</div>
					@if( ! $agent->isMobile())
					<div class="wb-form-group">
						<label for=""><i class="fa fa-lock"></i> <span>Confirm Password</span></label>
						<input type="password"
						name="password_confirmation"
						class="form-control text-center"
						required>
					</div>
					@endif
					<div class="wb-form-group">
						<select class="form-control" name="account" required>
							<option value="" disabled selected>Sign Up as</option>
							<option value="vendor" @if(old('account') === 'vendor') selected @endif>Business</option>
							<option value="couple" @if(old('account') === 'couple') selected @endif>Couple</option>
						</select>
					</div>
					<div class="form-group" style="margin-bottom: 0px;">
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
						<button type="submit" class="btn btn-warning btn-lg btn-block">SIGN UP</button>
					</div>
				</div>
				<div class="col-sm-6 hide-mobile-420">
					<div class="card-feature">
						<div class="item register">
							<span class="number" style="margin-bottom: 20px">
									{!! $pageSettings->firstWhere('meta_key', 'section_text')->meta_value ?? '<span style="color: #000;">Connecting Talented Suppliers & Venues with Australia\'s Couples for</span> Weddings Without Limits' !!}
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
</div>