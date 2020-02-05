@extends('adminlte::page')
@include('partials.admin.header')
@section('title', 'Businesses Reviews')

@section('content')
    <div class="container">
        @include('partials.alert-messages')
        <form class="form-inline">
            <br/>

            <div class="form-group">
                <label>Event Type: </label>
                {{ $review->event_type }}
            </div>
            <br/>
            <div class="form-group">
                <label>Event Date:</label>
                {{ $review->event_date }}
            </div>
            <br/>
            <br/>
            <div class="rating" id="easy_to_work_with">
                <label>Ease to work with: </label>
                @php
                    $asize = $review->rating_breakdown["easy_to_work_with"];
                @endphp
                @for($i = 1; $i <= $asize; $i++)
                    <a class='star selected'><i class="fa fa-star"></i></a>
                @endfor
            </div>
            <br/>
            <div class="rating" id="likely_to_recoment_to_a_friend">
                <label>Likelihood of recommending your business: </label>
                @php
                    $bsize = $review->rating_breakdown["likely_to_recoment_to_a_friend"];
                @endphp
                @for($i = 1; $i <= $bsize; $i++)
                    <a class='star selected'><i class="fa fa-star"></i></a>
                @endfor
            </div>
            <br/>
            <div class="rating" id="overall_satisfaction">
                <label>Overall Satisfaction:</label>
                @php
                    $csize = $review->rating_breakdown["overall_satisfaction"];
                @endphp
                @for($i = 1; $i <= $csize; $i++)
                    <a class='star selected'><i class="fa fa-star"></i></a>
                @endfor
            </div>
            <br/>

            <div class="form-group">
                <label>Additional comments from the Couple: </label>
                <br/>
                <i>{{ $review->message }}</i>
            </div>
        </form>
    </div>
@stop


@include('partials.admin.footer')