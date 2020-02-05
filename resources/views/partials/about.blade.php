<section id="wb-about" class="wb-footer-about-wrapper wb-primary-box">
	<div class="footer-about">
		<div class="wb-footer-about desktop">
			<div class="item about">
				<div class="title">
					{!! $pageSettings->firstWhere('meta_key', 'left_section_title')->meta_value ?? 'About Wedbooker' !!}
				</div>
				<div class="details">
					@if (optional($pageSettings->firstWhere('meta_key', 'left_section_text'))->meta_value)
						{!! $pageSettings->firstWhere('meta_key', 'left_section_text')->meta_value !!}
					@else
						<a style="color: #fff; display: block;" href="{{ url('/about-us') }}">wedBooker is an online market network helping Couples to efficiently book talented Suppliers and beautiful Venues around Australia. wedBooker is Australia’s first end-to-end platform for Couples to search professional, trusted and reviewed wedding businesses, compare quotes, securely pay for bookings and manage their wedding Suppliers & Venues all in the one place. wedBooker takes the stress out of weddings. Sign up for free today!.</a>
						<br/><a style="color: #fff; margin-top: 10px; display: block;" href="{{ url('/about-us') }}">Read more...</a>
					@endif
				</div>
			</div>

			<div class="item">
				<div class="item-child">
					<div class="title">
						{!! $pageSettings->firstWhere('meta_key', 'middle_section_title')->meta_value ?? 'wedbooker' !!}
					</div>
					@if (optional($pageSettings->firstWhere('meta_key', 'middle_section_text'))->meta_value)
						{!! $pageSettings->firstWhere('meta_key', 'middle_section_text')->meta_value !!}
					@else
						<ul class="list-unstyled">
							<li><a href=" {{ url('/how-it-works')}} ">How wedBooker works</a></li>
							<li><a href="https://wedbooker.com/inspiration">blog</a></li>
							<li><a href=" {{ url('/suppliers-and-venues')}}">suppliers & venues</a></li>
							@guest
							<li><a href=" {{ url('/sign-up')}} ">sign up</a></li>
							<li><a href=" {{ url('/login')}} ">login</a></li>
							@endif
						</ul>
					@endif
				</div>
			</div>

			<div class="item">
				<div class="item-child">
					<div class="title">
						{!! $pageSettings->firstWhere('meta_key', 'right_section_title')->meta_value ?? 'need help?' !!}
					</div>
					@if (optional($pageSettings->firstWhere('meta_key', 'right_section_text'))->meta_value)
						{!! $pageSettings->firstWhere('meta_key', 'right_section_text')->meta_value !!}
					@else
					<ul class="list-unstyled">
						<li><a href="{{ url('/faqs')}}">FAQs</a></li>
						<li><a href="{{ url('/fees')}}">Fees</a></li>
						<li><a href="{{ url('/contact-us')}}">contact us</a></li>
					</ul>
					@endif
				</div>
			</div>

			<div class="item">
				<div class="item-child">
					<div class="title">
						{!! $pageSettings->firstWhere('meta_key', 'connect_section_title')->meta_value ?? 'connect with us' !!}
					</div>
					<div class="social" style="text-align: left;">
						<a href="https://www.instagram.com/wedbooker/" target="_blank"><i class="fa fa-instagram"></i></a>
						<a href="https://www.facebook.com/WedBooker/" target="_blank"><i class="fa fa-facebook"></i></a>
						<a href="https://www.pinterest.com/wedbooker" target="_blank"><i class="fa fa-pinterest"></i></a>
					</div>
				</div>
			</div>
		</div>

		<div class="wb-footer-about mobile">
			<div class="item about">
				<div class="title">
					{!! $pageSettings->firstWhere('meta_key', 'left_section_title')->meta_value ?? 'About Wedbooker' !!}
				</div>
				<div class="details">
					@if (optional($pageSettings->firstWhere('meta_key', 'left_section_text'))->meta_value)
						{!! $pageSettings->firstWhere('meta_key', 'left_section_text')->meta_value !!}
					@else
						<a style="color: #fff; display: block;" href="{{ url('/about-us') }}">wedBooker is an online market network helping Couples to efficiently book talented Suppliers and beautiful Venues around Australia. wedBooker is Australia’s first end-to-end platform for Couples to search professional, trusted and reviewed wedding businesses, compare quotes, securely pay for bookings and manage their wedding Suppliers & Venues all in the one place. wedBooker takes the stress out of weddings. Sign up for free today!.</a>
						<br/><a style="color: #fff; margin-top: 10px; display: block;" href="{{ url('/about-us') }}">Read more...</a>
					@endif
				</div>
			</div>

			<div class="item">
				<div class="item-child">
					<div class="title">
						{!! $pageSettings->firstWhere('meta_key', 'middle_section_title')->meta_value ?? 'wedbooker' !!}
					</div>
					@if (optional($pageSettings->firstWhere('meta_key', 'middle_section_text'))->meta_value)
						{!! $pageSettings->firstWhere('meta_key', 'middle_section_text')->meta_value !!}
					@else
						<ul class="list-unstyled">
							<li><a href=" {{ url('/how-it-works')}} ">How wedBooker works</a></li>
							<li><a href="https://wedbooker.com/inspiration">blog</a></li>
							<li><a href=" {{ url('/suppliers-and-venues')}}">suppliers & venues</a></li>
							@guest
							<li><a href=" {{ url('/sign-up')}} ">sign up</a></li>
							<li><a href=" {{ url('/login')}} ">login</a></li>
							@endif
						</ul>
					@endif
				</div>
			</div>

			<div class="item">
				<div class="item-child">
					<div class="title">
						{!! $pageSettings->firstWhere('meta_key', 'right_section_title')->meta_value ?? 'need help?' !!}
					</div>
					@if (optional($pageSettings->firstWhere('meta_key', 'right_section_text'))->meta_value)
						{!! $pageSettings->firstWhere('meta_key', 'right_section_text')->meta_value !!}
					@else
						<ul class="list-unstyled">
							<li><a href="{{ url('/faqs')}}">FAQs</a></li>
							<li><a href="{{ url('/fees')}}">Fees</a></li>
							<li><a href="{{ url('/contact-us')}}">contact us</a></li>
						</ul>
					@endif
				</div>
			</div>

			<div class="item">
				<div class="item-child">
					<div class="title">
						{!! $pageSettings->firstWhere('meta_key', 'connect_section_title')->meta_value ?? 'connect with us' !!}
					</div>
					<div class="social" style="text-align: left;">
						<a href="https://www.instagram.com/wedbooker/" target="_blank"><i class="fa fa-instagram"></i></a>
						<a href="https://www.facebook.com/WedBooker/" target="_blank"><i class="fa fa-facebook"></i></a>
						<a href="https://www.pinterest.com/wedbooker" target="_blank"><i class="fa fa-pinterest"></i></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
