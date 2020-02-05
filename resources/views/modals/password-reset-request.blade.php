<!-- Modal -->
<div class="modal fade wb-modal-password" id="wb-modal-password" role="dialog">
    <div id="wb-modal-success" class="modal-dialog">
        <div class="modal-dialog">
            <div class="logo-container">
                <div class="logo">
                    <span><i class="fa fa-key"></i></span>
                </div>
            </div>
            <div class="modal-content text-center">
                <div class="modal-header">
                    <h4>FORGOT YOUR PASSWORD?</h4>
                </div>
                <div class="modal-body ">
                    <form id="password-reset-form" class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                        {{ csrf_field() }}
                        Enter the email address associated with your account and we will email you a link to reset your password. <br /><br />
                        <label for="">
                            <input type="email" name="email" placeholder="Email Address" />
                            <span><i class="fa fa-envelope"></i></span>
                        </label> <br /><br />
                        <button type="submit" href="#" class="btn wb-btn-orange">SEND PASSWORD RESET LINK</button> <br />
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>