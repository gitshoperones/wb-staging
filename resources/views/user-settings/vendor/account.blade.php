@extends('layouts.public')

@section('content')
<section id="wb-settings-block">
	<div class="container">
		<div class="text-center">
			@include('partials.user-settings.vendor-tab-header')
			<div class="row">
				<div class="wb-box">
					@include('modals.alert-messages')
					<div class="row">
						<div class="col-md-6">
							<div class="form-group" title="To update your business name, you'll need to email hello@wedbooker.com" data-toggle="tooltip">
								{{-- <label for="vendor-business-name">Business Name</label> --}}
								<input disabled
									id="vendor-business-name"
									type="text"
									placeholder="Business Name"
									value="{{ $loggedInUserProfile->business_name }}"
									class="form-control" >
							</div>
						</div>
                        <div class="col-md-6">
                            <div class="form-group" title="To update your ABN, you'll need to email hello@wedbooker.com" data-toggle="tooltip">
                                {{-- <label for="couple_member">ABN</label> --}}
                                <input disabled
                                    name="abn"
                                    type="text"
									placeholder="ABN"
                                    value="{{ $loggedInUserProfile->abn }}"
                                    class="form-control">
                            </div>
                        </div>
					</div>
					<form method="POST"
                        action="{{ url(sprintf('vendor-account-settings')) }}"
                        accept-charset="UTF-8">
                        <input type="hidden" name="_method" value="PATCH">
						<input type="hidden" name="form_src" value="account">
						{{ csrf_field() }}
						<div class="row">
							<div class="col-md-6">
								<div class="form-group" title="Business Website *" data-toggle="tooltip">
									{{-- <label for="website">Business website <span class="required">*</span></label> --}}
									<input name="website" type="text" value="{{ old('website') ?: $loggedInUserProfile->website }}" placeholder="Business website *" class="form-control">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group" title="Phone Number *" data-toggle="tooltip">
									{{-- <label for="phone_number">Phone Number <span class="required">*</span>   </label> --}}
									<input name="phone_number" type="text" value="{{ old('phone_number') ?: $user->phone_number }}" placeholder="Phone Number *"class="form-control">
								</div>
							</div>
						</div>
						<div class="actions">
							<input type="submit" value="SAVE CHANGES" class="btn wb-btn-orange">
                            @if (Auth::user()->status !== 'pending delete')
    							<a href="#" data-toggle="modal"
                                    data-target="#modal-delete-account"
                                    class="delete-account text-grey text-light pull-right">
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