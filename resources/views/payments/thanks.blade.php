@extends('layouts.public')

@section('content')
<div class="wb-small-banner wd-privay-policy" {!! ($result = $pageSettings->firstWhere('meta_key', 'banner_background')) ? $result->style_image_url : '' !!}>
	<div class="caption">{{ $pageSettings->firstWhere('meta_key', 'banner_caption')->meta_value ?? 'Photo: Andreas Holm' }}</div><!-- /.caption -->
</div>
<section id="wb-about" class="wb-about wb-bg-grey" style="padding: 40px 0px;">
	<div class="container text-center">
        <h1 class="wb-title thank-you">{!! $pageSettings->firstWhere('meta_key', 'section_title')->meta_value ?? 'Thank you for your payment!' !!}</h1>
		<div class="col-md-8 col-md-offset-2 text-primary" style="font-weight: 100;">
			<p>Your booking {{ ($vendor) ? 'with '.$vendor : '' }} is now confirmed. You can continue to manage this booking and reach out to us anytime via your wedBooker planning dashboard.</p>

            <div style="margin-top: 20px;">
                <p>{!! $pageSettings->firstWhere('meta_key', 'section_cta')->meta_value ?? 'Ready to book your next supplier?' !!}</p>
                <a href="{{ url('/dashboard') }}" type="button" class="btn btn-orange">Keep Planning</a>
                {{-- <a href="{{ url('/suppliers-and-venues') }}" type="button" class="btn btn-orange">Search Suppliers & Venues</a>
                <a href="{{ url('/dashboard/job-posts/create') }}" type="button" class="btn btn-orange">Post a job</a> --}}
            </div>
        </div>
    </div>
</section>
@endsection