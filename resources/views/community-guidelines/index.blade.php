@extends('layouts.public')

@section('meta')
<meta name="keywords" content="{{ ($pageSettings->firstWhere('meta_key', 'meta_keywords')) ? strip_tags($pageSettings->firstWhere('meta_key', 'meta_keywords')->meta_value) : "wedBooker, couple, wedding"}}" />
	<meta name="description" content="{{ ($pageSettings->firstWhere('meta_key', 'meta_description')) ? strip_tags($pageSettings->firstWhere('meta_key', 'meta_description')->meta_value) : "wedBooker is an online market network helping Couples to efficiently book Suppliers and Venues"}}"/>
	<meta name="title" content="{{ ($pageSettings->firstWhere('meta_key', 'meta_title')) ? strip_tags($pageSettings->firstWhere('meta_key', 'meta_title')->meta_value) : "wedBooker"}}">
@endsection

@section('content')
<div class="wb-small-banner wd-com-guide" {!! ($result = $pageSettings->firstWhere('meta_key', 'banner_background')) ? $result->style_image_url : '' !!}>
	<div class="headOverlay">
		<h1 class="wb-title">{!! $pageSettings->firstWhere('meta_key', 'section_title')->meta_value ?? 'wedBooker User &amp; Community Guidelines' !!}</h1>
	</div>
	<div class="caption">{{ $pageSettings->firstWhere('meta_key', 'banner_caption')->meta_value ?? 'Photo: Lauren Gray Photographer' }}</div><!-- /.caption -->
</div>
<section id="wb-about" class="wb-about wb-bg-grey" style="padding: 40px 0px 0px;">
	<div class="container">
		<div class="col-md-8 col-md-offset-2">
			<div class="about-content text-justify">
				<p>{!! $pageSettings->firstWhere('meta_key', 'section_text')->meta_value ?? '' !!}</p>
			</div>
		</div>
	</div>
</section>
@endsection

@section('page_title')
{{ ($pageSettings->firstWhere('meta_key', 'page_title')) ? strip_tags($pageSettings->firstWhere('meta_key', 'page_title')->meta_value) : "wedBooker" }}
@endsection