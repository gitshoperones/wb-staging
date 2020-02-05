@extends('layouts.public')

@section('content')
<section id="wb-settings-block">
    <div class="container">
        <div class="text-center">
            @include('partials.user-settings.vendor-tab-header')
            <div class="row">
                <div class="wb-box">
                    @include('modals.alert-messages')
                    <h4 class="title">Primary User</h4>
                    <form method="POST"
                        action="{{ url(sprintf('users/%s', Auth::user()->id)) }}"
                        accept-charset="UTF-8">
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="_method" value="PATCH">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group" title="First Name *" data-toggle="tooltip">
                                    {{-- <label for="fname">Firstname <span class="required">*</span></label> --}}
                                    <input name="fname" type="text" value="{{ old('fname') ?: $user->fname }}" placeholder="First Name *" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group" title="Lastname *" data-toggle="tooltip">
                                    {{-- <label for="lname">Lastname <span class="required">*</span></label> --}}
                                    <input name="lname" type="text" value="{{ old('lname') ?: $user->lname }}" placeholder="Lastname *" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group" title="Email *" data-toggle="tooltip">
                                    {{-- <label for="email">Email <span class="required">*</span></label> --}}
                                    <input name="email" type="text" value="{{ old('email') ?: $user->email }}" placeholder="Email *" class="form-control">
                                </div>
                            </div>
                        </div>
						<div class="row">
							<div class="col-md-12"><h4 class="title">Update Password</h4></div><!-- /.col-md-12 -->
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
                            <input type="submit" value="SAVE CHANGES" class="btn wb-btn-orange">
                            <a href="#" data-toggle="modal" data-target="#modal-delete-account" class="delete-account text-light pull-right">Delete my account</a>
                        </div><!-- /.actions -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
    @include('modals.delete-account')
@endsection

