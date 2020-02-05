@extends('layouts.public')

@section('content')
<div class="wb-small-banner wd-about">
    <div class="caption">Photo: Elin Bandmann</div><!-- /.caption -->
</div>
<section id="wb-about" class="wb-about wb-bg-grey" style="padding: 40px 0px 0px;">
    <div class="container">
    <div class="text-center">
        <h1 class="wb-title">Review {{ $review->vendor->business_name }}</h1>
    </div>
    <div class="col-md-8 col-md-offset-2">
        <div class="about-content text-center">
            @include('partials.vendor-reviews.review-form')
        </div>
    </div>
</div>
</section>
@endsection



