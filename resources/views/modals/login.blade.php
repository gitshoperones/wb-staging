<!-- Modal -->
<div id="modal-signup" class="modal-signup modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content text-center">
			<div class="modal-header">
				<h4 class="title" style="font-weight: 300; color: #353554; text-transform: uppercase;">LOGIN TO WEDBOOKER</h4>
			</div>
			<div class="modal-body">
                <form id="login-form" method="POST" action="{{url('/login')}}">
                    {{ csrf_field() }}
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="wb-form-group">
                                    <label for=""><i class="fa fa-user"></i> <span>Email</span></label>
                                    <input type="email" id="user-email" name="email" value="{{ old('email') }}" class="form-control text-center">
                                </div>
                                <div class="wb-form-group">
                                    <label for=""><i class="fa fa-lock"></i> <span>Password</span></label>
                                    <input type="password" id="user-password" name="password" value="" class="form-control text-center" autocomplete="off">
                                    <input type="hidden" id="vendorId" name="vendorId" value="">
                                </div>

                                <div class="form-group">
                                    <button type="submit" id="login-btn" name="button" class="btn btn-warning btn-lg btn-block">LOGIN</button>
                                    <br>
                                    <a class="forgotpass" href="#" data-toggle="modal" data-target="#wb-modal-password">Forgot Password?</a>
                                    <br/>
                                    <a class="forgotpass" href="{{ url('/sign-up') }}">Not a member yet? Sign up for free!</a>
                                </div>
                            </div>
                        </div>
                </form>
			</div>
		</div>
	</div>
</div>
@include('modals.password-reset-request')
