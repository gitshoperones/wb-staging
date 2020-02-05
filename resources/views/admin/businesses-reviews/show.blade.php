@extends('adminlte::page')
@include('partials.admin.header')
@section('title', 'Business Reviews')

@section('content')
    <div class="container">
        @include('partials.alert-messages')
        <div class="text-center">
            <h2 class="expertise-title reviews-title text-center">Reviews for {{ $business->business_name }}</h2>
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
                    <p>
                        <a class="btn btn-danger btn-delete-review"
                            href="{{ url(sprintf('/admin/businesses/%s/reviews/%s', $business->id, $review->id)) }}">
                            Delete This Review
                        </a>
                        <a class="btn btn-success"
                            target="_blank"
                            href="{{ url(sprintf('/admin/businesses/%s/reviews/%s', $business->id, $review->id)) }}">
                            View Review Details
                        </a>
                    </p>
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
                    </div> <br/>
                    <i>{{ $review->message }}</i>
                </li>
            @endforeach
        </ul>
        <div class="pagination-wrap">
            {{ $reviews->links() }}
        </div>
        <form action="" id="delete-review-form" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="delete">
        </form>
    </div>
@stop
@push('scripts')
    <script type="text/javascript">
        $('.btn-delete-review').on('click', function(e){
            e.preventDefault();
            var link = $(this).attr('href');
            swal({
                title: 'Are you sure?',
                text: "You are about to delete this review!",
                type: 'warning',
                width: 600,
                padding: '3em',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes understood!'
            }).then((result) => {
                if (result.value) {
                    var form = $('#delete-review-form');
                    form.attr('action', link);
                    form.submit();
                }
            });
        });
    </script>
@endpush
@include('partials.admin.footer')
