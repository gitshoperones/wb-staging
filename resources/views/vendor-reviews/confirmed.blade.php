@extends('layouts.public')

@section('content')
<div class="wb-small-banner wd-about">
    <div class="caption">Photo: Elin Bandmann</div><!-- /.caption -->
</div>
<section id="wb-about" class="wb-about wb-bg-grey" style="padding: 40px 0px 0px;">
    <div class="container">
        <div class="col-md-8 col-md-offset-2">
            <div class="about-content text-center">
                <h4>
                    Thank you for your review! Interested in learning more about wedBooker?
                    <br />
                    <br />
                </h4>
                <a href="{{ url('/') }}" class="btn wb-btn-orange">
                    Learn More Here
                </a>
            </div>
        </div>
    </div>
</div>
</section>
@endsection
