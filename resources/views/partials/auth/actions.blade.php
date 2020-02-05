<div class="row">
    <div class="col-md-10 col-md-offset-1 text-center">
        <div style="border-bottom: 1px solid #dbdbdb; margin-bottom: 40px">
            <a href="{{ url('/login') }}" class="wb-btn-link {{ Request::is('login') ? 'active' : ''}}">LOGIN</a>
            <i class="wb-btn-separator"></i>
            <a href="{{ url('/sign-up') }}" class="wb-btn-link {{ Request::is('sign-up') ? 'active' : ''}}">SIGN UP</a>
        </div>
    </div>
</div>