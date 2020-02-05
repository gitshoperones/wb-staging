<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<form method="POST" action="{{url('/login')}}">
			{{ csrf_field() }}
			@if (!isset($token))
				@include('partials.alert-messages')
			@endif
			<div class="wb-login-card"
			style="background-color: #fff;
			padding: 30px; box-shadow: 0px 0px 4px rgba(0,0,0,0.2);
			text-align: center"
			>
				<div class="row">
					<div class="col-sm-6 wd-login-form">
						<div class="wb-form-group">
							<label for=""><i class="fa fa-user"></i> <span>Email</span></label>
							<input type="email" name="email" value="{{ old('email') }}" class="form-control text-center">
						</div>
						<div class="wb-form-group">
							<label for=""><i class="fa fa-lock"></i> <span>Password</span></label>
							<input type="password" name="password" value="" class="form-control text-center" autocomplete="off">
						</div>
						<div class="form-group">
							<button type="submit" name="button" class="btn btn-warning btn-lg btn-block">LOGIN</button>
							<br>
							<a class="forgotpass" href="#" data-toggle="modal" data-target="#wb-modal-password">Forgot Password?</a>
							<a class="forgotpass" style="display: none;" href="#" data-toggle="modal" data-target="#wb-modal-newpassword">New Password?</a>
						</div>
					</div>
					<div class="col-sm-6 hide-mobile-420">
						<div class="card-feature">
							<div class="item login">
								{!! $pageSettings->firstWhere('meta_key', 'section_text')->meta_value ?? '<span class="title">All the</span>
								<span class="number" style="margin-bottom: 5px">little things</span>
								<span class="title" style="margin-bottom: 10px">One big</span>
								<span class="title">day.</span>' !!}
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

@include('modals.password-reset-request')

@if (isset($token))
	@include('modals.password-reset')
@endif
