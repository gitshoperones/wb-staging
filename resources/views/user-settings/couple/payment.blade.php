@extends('layouts.public')

@section('content')
<section id="wb-settings-block">
	<div class="container">
		<div class="text-center">
			@include('partials.user-settings.couple-tab-header')
            @include('modals.alert-messages')
			<div class="card-account-container">
				<div class="row">
					<div id="wb-credit-cards">
                        @foreach($creditCards as $card)
    						<div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <p>Card Type: {{ ucwords($card->card['type']) }}</p>
                                        <p>Name: {{ $card->card['full_name'] }}</p>
                                        <p>Number: {{ $card->card['number'] }}</p>
                                        <form action="{{url(sprintf('user-card-accounts/%s', $card->id))}}"
                                            method="POST">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-primary">Delete</button>
                                        </form>
                                    </div>
                                </div>
    						</div>
                        @endforeach
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection