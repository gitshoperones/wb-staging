@php
    $averageRating = 0;
    $reviewCount = $vendor->reviews->where('status', 1)->count();
    $totalRating = $vendor->reviews->where('status', 1)->sum('rating');

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
@push('css')
<style>
    .rating.vendor-card a,
    .rating.vendor-card a .fa,
    .rating.vendor-card a.hover,
    .rating.vendor-card a.selected,
    .rating.vendor-card a.selected .fa,
    .rating.vendor-card a.hover .fa {
        color: #353554;
        text-decoration: none;
    }
    .rating.vendor-card, .rating.vendor-card a {
        font-size: 14px;
    }
</style>
@endpush
@if ($reviewCount > 0)
    <div class="rating vendor-card">
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