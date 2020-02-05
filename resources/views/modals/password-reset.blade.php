<!-- Modal -->
<div class="modal show wb-modal-password" id="wb-modal-newpassword" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel" aria-hidden="true">
    <div id="wb-modal-success" class="modal-dialog">
        <div class="modal-dialog">
            <div class="logo-container">
                <div class="logo">
                    <span><i class="fa fa-unlock"></i></span>
                </div>
            </div>
            <div class="modal-content text-center">
                <div class="modal-header">
                    <h4>SET YOUR NEW PASSWORD</h4>
                </div>
                <div class="modal-body ">
                    @include('partials.alert-messages')
                    <form class="form-horizontal" method="POST" action="{{ route('password.request') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="token" value="{{ $token }}">
                        <label for="" style="margin-bottom: 15px;">
                            <input type="email" placeholder="Email" name="email" value="{{ $email or old('email') }}" required autofocus>
                            <span><i class="fa fa-user"></i></span>
                        </label> <br />
                        <label for="" style="margin-bottom: 15px;">
                            <input type="password" name="password" required placeholder="New Password" /><span><i class="fa fa-lock"></i></span>
                        </label> <br />
                        <label for="" style="margin-bottom: 25px;">
                            <input type="password" name="password_confirmation" required placeholder="Confirm New Password" />
                            <span><i class="fa fa-lock"></i></span>
                        </label>
                        <br />
                        <button type="submit" href="#" class="btn wb-btn-orange">SAVE PASSWORD</button> <br />
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>