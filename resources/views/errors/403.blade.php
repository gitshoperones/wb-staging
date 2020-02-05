@extends('layouts.public')

@section('content')
<div class="wb-action-banner post-job"></div>
<section id="wb-job-list" class="wb-bg-grey" style="padding: 40px 0px">
	<div class="container">
		<div class="text-center">
            @php
                $view = strtolower(Auth::user() ? Auth::user()->status : '');
                $view = str_replace(' ', '-', $view);
                $view = sprintf('%s%s-%s', 'errors.403-messages.',$view, 'user-account');
            @endphp

            @include('partials.alert-messages')

            @if (View::exists($view))
                @include($view)
            @elseif (View::exists('errors.403-messages.'.$exception->getMessage()))
                @include('errors.403-messages.'.$exception->getMessage())
            @else
                <h4 class="error-message">
                    {{ $exception->getMessage() }}
                </h4>
            @endif
		</div>
	</div>
</section>
@endsection
