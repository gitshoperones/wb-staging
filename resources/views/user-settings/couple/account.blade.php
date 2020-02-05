@extends('layouts.public')

@section('content')
<section id="wb-settings-block">
	<div class="container">
		<div class="text-center">
			@include('partials.user-settings.couple-tab-header')
			<div class="row">
                @include('modals.alert-messages')
				<div class="wb-box">
					<h4 class="title">Your Details</h4>
					<form method="POST" action="{{ url('couple-account-settings') }}" accept-charset="UTF-8">
                        <input type="hidden" name="_method" value="PATCH">
						<input type="hidden" name="my_id" value="{{ $user->id }}">
                        {{ csrf_field() }}
						<div class="row">
							<div class="col-md-4">
								<div class="form-group" title="Your First Name" data-toggle="tooltip">
									{{-- <label for="your_firstname">Your First Name</label> --}}
									<input name="your_firstname"
										type="text"
										placeholder="Your First Name"
                                        class="form-control"
                                        value="{{ old('your_firstname') ?: $user->fname }}">
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group" title="Your Last Name" data-toggle="tooltip">
									{{-- <label for="your_lastname">Your Last Name</label> --}}
									<input name="your_lastname"
										type="text"
										placeholder="Your Last Name"
                                        class="form-control"
                                        value="{{ old('your_lastname') ?: $user->lname }}">
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group" title="Your Email" data-toggle="tooltip">
									{{-- <label for="your_email">Your Email</label> --}}
									<input name="your_email"
										type="text"
										placeholder="Your Email"
                                        class="form-control"
                                        value="{{ old('your_email') ?:$user->email }}">
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group" title="Your Partner's First Name" data-toggle="tooltip">
									{{-- <label for="partner_firstname">Your Partner's First Name</label> --}}
									<input name="partner_firstname"
										type="text"
										placeholder="Your Partner's First Name"
                                        class="form-control"
                                        value="{{ $loggedInUserProfile->partner_firstname ?: old('partner_firstname') }}">
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group" title="Your Partner's Last Name" data-toggle="tooltip">
									{{-- <label for="partner_lastname">Your Partner's Last Name</label> --}}
									<input name="partner_lastname"
										type="text"
										placeholder="Your Partner's Last Name"
                                        class="form-control"
                                        value="{{ $loggedInUserProfile->partner_surname ?: old('partner_lastname') }}">
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group" title="Phone Number" data-toggle="tooltip">
									{{-- <label for="partner_lastname">Phone Number</label> --}}
									<input name="phone_number"
										type="text"
										placeholder="Phone Number"
                                        class="form-control"
                                        value="{{ old('phone_number') ?: $user->phone_number }}">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<h4 class="title">Change Your Password</h4>
							</div>

							<div class="col-md-6">
								<div class="form-group" title="New Password" data-toggle="tooltip">
									{{-- <label for="password">New Password</label> --}}
									<input name="password" type="password" placeholder="New Password" class="form-control">
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group" title="Confirm New Password" data-toggle="tooltip">
									{{-- <label for="password_confirmation">Confirm New Password</label> --}}
									<input name="password_confirmation" type="password" placeholder="Confirm New Password" class="form-control">
								</div>
							</div>
						</div>

						<div class="actions">
							<input type="submit" value="UPDATE SETTINGS" class="btn wb-btn-orange">
							@if (Auth::user()->status !== 'pending delete')
                                <a href="#" data-toggle="modal"
                                    data-target="#modal-delete-account"
                                    class="delete-account text-light pull-right">
                                    Delete my account
                                </a>
                            @endif
						</div><!-- /.actions -->
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
@include('modals.delete-account')
@endsection