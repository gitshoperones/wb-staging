@extends('layouts.public')

@section('meta')
<meta name="keywords" content="{{ ($pageSettings->firstWhere('meta_key', 'meta_keywords')) ? strip_tags($pageSettings->firstWhere('meta_key', 'meta_keywords')->meta_value) : "wedBooker, couple, wedding"}}" />
	<meta name="description" content="{{ ($pageSettings->firstWhere('meta_key', 'meta_description')) ? strip_tags($pageSettings->firstWhere('meta_key', 'meta_description')->meta_value) : "wedBooker helps Couples to efficiently book talented Suppliers and beautiful Venues around Australia. The first end-to-end platform for Couples to search professional, trusted and reviewed wedding businesses, compare quotes, securely pay for bookings and manage their wedding Suppliers & Venues all in the one place."}}"/>
	<meta name="title" content="{{ ($pageSettings->firstWhere('meta_key', 'meta_title')) ? strip_tags($pageSettings->firstWhere('meta_key', 'meta_title')->meta_value) : "Content Policy"}}">
@endsection

@section('content')
<div class="wb-small-banner wd-privay-policy" {!! ($result = $pageSettings->firstWhere('meta_key', 'banner_background')) ? $result->style_image_url : '' !!}>
	<div class="headOverlay">
		<h1 class="wb-title">{!! $pageSettings->firstWhere('meta_key', 'section_title')->meta_value ?? 'Content Policy' !!}</h1>
	</div>
	<div class="caption">{{ $pageSettings->firstWhere('meta_key', 'banner_caption')->meta_value ?? 'Photo: Andreas Holm' }}</div><!-- /.caption -->
</div>
<section id="wb-about" class="wb-about wb-bg-grey" style="padding: 40px 0px 0px;">
	<div class="container">
		<div class="col-md-8 col-md-offset-2">
			<div class="about-content text-justify">
				@if (optional($pageSettings->firstWhere('meta_key', 'section_text'))->meta_value)
					{!! $pageSettings->firstWhere('meta_key', 'section_text')->meta_value !!}
				@else
					<p>When a Supplier/Venue or Couple (<strong>User</strong>) posts content to wedBooker, including but not limited to on their profile, in job posts, quotes, private messaging and reviews, the User agrees to abide by the guidelines set out in this Content Policy as well as wedBooker’s <a href="https://wedbooker.com/terms-and-conditions" data-mce-href="https://wedbooker.com/terms-and-conditions">Terms and Conditions</a> and any other wedBooker policy in operation from time to time.</p><p>wedBooker reserves the right in its absolute discretion to remove any content, in whole or in part, that in any way violates this Policy, the wedBooker’s <a href="https://wedbooker.com/terms-and-conditions" data-mce-href="https://wedbooker.com/terms-and-conditions">Terms and Conditions</a>, <a href="https://wedbooker.com/community-guidelines" data-mce-href="https://wedbooker.com/community-guidelines">Community Guidelines</a>, Ratings &amp; Reviews Policy.</p><p>The following content is not permitted under any circumstances on wedBooker:</p><ul><li>Content created solely for the purpose of advertising or other commercial content, including company logos, links, or company names</li><li>Spam, unwanted contact, or content that is shared repeatedly in a disruptive manner</li><li>Content that endorses or promotes illegal or harmful activity, or that is profane, vulgar, obscene, threatening, or harassing</li><li>Content that is in any way discriminatory</li><li>Attempts to impersonate another person</li><li>Content that is illegal or that violates another person’s or entity’s rights, including intellectual property rights and privacy rights</li></ul><p>In respect of Reviews, you must not provide:</p><p>(a) reviews that do not represent the author’s personal experience or that of their wedding event guests;</p><p>(b) reviews incentivised by a promise for payment, additional services or a discounted rate;</p><p>(c) reviews motivated by a threat of extortion; or</p><p>&nbsp;(d) reviews that provide false or misleading information which may mislead or deceive Users, or any other party.</p><p>If you believe that content has been posted that is in violation of this Policy, please report the content <a href="https://wedbooker.com/contact-us" data-mce-href="https://wedbooker.com/contact-us">here</a>.</p><p><br></p><p>In accordance with wedBooker’s <a href="https://wedbooker.com/terms-and-conditions" data-mce-href="https://wedbooker.com/terms-and-conditions">Terms and Conditions</a>, wedBooker reserves the right in our absolute discretion to suspend or permanently delete an account that is in violation of this policy.</p><p><br></p><p><br data-mce-bogus="1"></p>
				@endif
			</div>
		</div>
	</div>
</section>
@endsection

@section('page_title')
{{ ($pageSettings->firstWhere('meta_key', 'page_title')) ? strip_tags($pageSettings->firstWhere('meta_key', 'page_title')->meta_value) : "wedBooker" }}
@endsection