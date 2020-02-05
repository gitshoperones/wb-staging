@if (!$reviews->isEmpty())
<div class="vendor-reviews">
	<div class="text-center">
		<h2 class="expertise-title reviews-title text-center">REVIEWS from couples</h2>
	</div>

	<br/>
	<ul class="list-group reviews-items">
		@foreach($reviews as $review)
			@php
				$averageRating = $review->rating;
				$grayStarCount = 5;
				$goldStarCount = (int) $averageRating;
				$halflStar = $averageRating - $goldStarCount;

				if ($halflStar > 0) {
					$grayStarCount = $grayStarCount - ($goldStarCount + 1);
				} else {
					$grayStarCount = $grayStarCount - $goldStarCount;
				}
			@endphp
			<li class="list-group-item">
				<span class="pull-right review-date">{{ $review->event_date }} <br/> {{ $review->event_type }}</span>
				<span>{{ $review->reviewer_name }}</span>
				<div class="rating small">
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

					@for($i = 1; $i <= $grayStarCount; $i++)
						<a class="">
							<i class="fa fa-star"></i>
						</a>
					@endfor
				</div> <br/>
				<i>{{ $review->message }}</i>
			</li>
		@endforeach
	</ul>
	<div class="pagination-wrap">
		{{ $reviews->links() }}
	</div>
</div>
@endif

@push('css')
<style>
.vendor-reviews {
	background-color: #e7d8d1;
	padding: 15px 55px 0;
}
</style>
@endpush