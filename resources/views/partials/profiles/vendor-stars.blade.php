<div class="text-center">
	@php
		$averageRating = 0;
		$reviewCount = $userProfile->reviews->count();
		$totalRating = $userProfile->reviews->sum('rating');

		if ($reviewCount > 0) {
			$averageRating = $totalRating / $reviewCount;

			$intTotalRating = (int) $averageRating;
			$decimalTotalRating = $averageRating - $intTotalRating;

			if ($decimalTotalRating >= 0.10 && $decimalTotalRating <= 0.24) {
				$averageRating = $intTotalRating;
			} elseif ($decimalTotalRating >= 0.25 && $decimalTotalRating <= 0.50) {
				$averageRating = $intTotalRating + 0.50;
			} elseif ($decimalTotalRating >= 0.51 && $decimalTotalRating <= 0.74) {
				$averageRating = $intTotalRating + 0.50;
			} elseif ($decimalTotalRating >= 0.75 && $decimalTotalRating <= 0.99) {
				$averageRating = ceil($averageRating);
			}
		}

		$grayStarCount = 5;
		$goldStarCount = (int) $averageRating;
		$halflStar = $averageRating - $goldStarCount;

		if ($halflStar > 0) {
			$grayStarCount = $grayStarCount - ($goldStarCount + 1);
		} else {
			$grayStarCount = $grayStarCount - $goldStarCount;
		}

	@endphp
	@if ($reviewCount == 0)
		@if (Auth::check() && Auth::id() === $userProfile->user_id)
			<span class="tooltip"></span>


			@if (!isset($hideModal))
				<span class="right-icon tooltip-icon tool1" style="position: relative;">
					<span class="btn wb-btntline-pink newtowedbooker" data-toggle="modal" data-target="#setup-vendor-review">
						New To wedBooker
					</span>
					<div class="tooltip-wrapper">
						You have no star rating yet. You can invite two past couples who have used your services to review your business.
					</div>
				</span>
				<form action="{{ url(sprintf('/dashboard/request-vendor-review')) }}" method="POST" id="request-review-form">
					{{ csrf_field() }}
					<input id="c1name" type="hidden" name="couple1_name">
					<input id="c1email" type="hidden" name="couple1_email">
					<input id="c2name" type="hidden" name="couple2_name">
					<input id="c2email" type="hidden" name="couple2_email">
				</form>
				@if ($userProfile->invite_review_status)
					@include('modals.done-review-invitation')
				@else
					@include('modals.review-invitation')
				@endif
			@else
				<span class="right-icon tooltip-icon tool1" style="position: relative;">
					<span class="btn wb-btntline-pink newtowedbooker">
						New To wedBooker
					</span>
					<div class="tooltip-wrapper">
						You have no star rating yet. You can invite two past couples who have used your services to review your business.
					</div>
				</span>
			@endif
		@else
			<span class="btn wb-btntline-pink newtowedbooker">New To wedBooker</span>
		@endif
	@else
		<div class="rating">
			@for($i = 1; $i <= $goldStarCount; $i++)
				<a class="selected">
					<i class="fa fa-star"></i>
				</a>
			@endfor

			@if ($halflStar > 0)
			<a class="selected">
				<i class="fa fa-star-half-o"></i>
			</a>
			@endif

            @if (!isset($hideEmptyStars) || $hideEmptyStars === false)
    			@for($i = 1; $i <= $grayStarCount; $i++)
    				<a class="">
    					<i class="fa fa-star"></i>
    				</a>
    			@endfor
            @endif
		</div>
	@endif
</div>