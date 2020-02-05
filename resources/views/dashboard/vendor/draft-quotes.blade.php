@extends('layouts.dashboard')

@section('content')
<section class="content dashboard-container">
	@include('partials.job-posts.search-form', ['action' => url('dashboard/draft-quotes')])
	<div class="row">
		<div class="col-sm-12">
			@if(session()->has('modal_message'))
			@include('modals.success-modal', [
			'header' => 'JOB QUOTE',
			'message' => session('modal_message'),
			])
			@endif
			@include('partials.alert-messages')
			<div class="wb-sent-quote-box">
				<div class="">
					<table class="table">
						<thead>
							<tr>
								<th data-sort="string" style="width: 30%;">
									Job <span class="icon"><i class="fa fa-caret-down"></i></span>
								</th>
								<th data-sort="string" style="width: 20%;">
									Venue or Address <span class="icon"><i class="fa fa-caret-down"></i></span>
								</th>
								<th data-sort="string" style="width: 14%;">
									Date Required <span class="icon"><i class="fa fa-caret-down"></i></span>
								</th>
								<th data-sort="int" style="width: 14%;">
									Quote <span class="icon"><i class="fa fa-caret-down"></i></span>
								</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							@if(count($jobQuotes) > 0)
							@foreach($jobQuotes as $quote)
							<tr>
								<td>
									<a class="name btn wrap" href="{{url(sprintf('dashboard/job-posts/%s', $quote->jobPost->id))}}">
										{{ sprintf('%s looking for %s', $quote->jobPost->userProfile->title, $quote->jobPost->category->name) }}
									</a>
								</td>
								<td>{{ $quote->jobPost->locations->implode('name', ',') }}</td>
								<td>{{ $quote->jobPost->event_date }}</td>
								<td>$ {{ $quote->total }}</td>
								<td>
									@if ($quote->status !== 'Payment Received' && $quote->status !== 'Paid')
									<a href="{{ url(sprintf('/dashboard/job-quotes/%s/edit', $quote->id))}}"
										class="btn wb-btn-orange">
										Finish Quote
									</a>
									@endif
								</td>
							</tr>
							@endforeach
							@endif
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="wb-pagination-block">
			{{ $jobQuotes->appends([ 'q' => request('q') ])->links() }}
		</div>
	</div>
</section>
@endsection
