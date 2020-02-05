@extends('layouts.dashboard')

@section('content')
<section class="content dashboard-container">
	@include('partials.job-posts.search-form', ['action' => url('dashboard/sent-quotes')])
	<div class="row">
		<div class="col-sm-12">
			@include('partials.alert-messages') <br />
			<div class="wb-sent-quote-box">
				<div class="">
					<table class="table sortable-table" id="simpleTable" style="margin-bottom: 0;">
						<thead>
							<tr>
								<th data-sort="string" style="width: 30%;">
									Job <span class="icon"><i class="fa fa-caret-down"></i></span>
								</th>
								<th data-sort="string" style="width: 20%;">
									Venue or Address <span class="icon"><i class="fa fa-caret-down"></i></span>
								</th>
								<th data-sort="string" style="width: 14%;">
									Event Date <span class="icon"><i class="fa fa-caret-down"></i></span>
								</th>
								<th data-sort="string" style="width: 14%;">
									Expiry Date <span class="icon"><i class="fa fa-caret-down"></i></span>
								</th>
								<th data-sort="float" style="width: 14%;">
									Quote <span class="icon"><i class="fa fa-caret-down"></i></span>
								</th>
								<th data-sort="string" style="width: 14%;">
									Status <span class="icon"><i class="fa fa-caret-down"></i></span>
								</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							@if(count($jobQuotes) > 0)
							@foreach($jobQuotes as $quote)
							<tr>
								<td>
									<!-- <a class="name btn wrap" href="{{url(sprintf('dashboard/job-posts/%s', $quote->jobPost->id))}}"> -->
									<a class="name btn wrap" href="{{ url(sprintf('/dashboard/job-quotes/%s', $quote->id)) }}">
										{{ sprintf('%s looking for %s', $quote->jobPost->userProfile->title, $quote->jobPost->category->name) }}
									</a>
								</td>
								<td>{{ $quote->jobPost->required_address }}</td>
								<td>{{ $quote->jobPost->event_date }}</td>
								<td>{{ $quote->duration }}</td>
								<td>$ {{ $quote->total }}</td>
								<td>
									@if ($quote->invoice && in_array($quote->invoice->status, [1, 2]))
										Confirmed
									@elseif ($quote->status === 1)
									   Awaiting Couple’s Response
									@elseif ($quote->status === 2)
									   Couple Requested Changes
									@elseif ($quote->status === 3)
									   Quote Accepted
									@elseif ($quote->status === 4)
									   Quote Declined
								   @elseif ($quote->status === 5)
                                       Quote Expired
                                    @elseif ($quote->status === 6)
									   Quote Withdrawn
									@endif
								</td>
								<td style="position: relative;">
									@if ($quote->invoice && in_array($quote->invoice->status, [1, 2]))
										<a href="{{ url(sprintf('/dashboard/job-quotes/%s', $quote->id)) }}"
											class="btn wb-btn-primary">
											View Booking
										</a>
									@elseif ($quote->status === 2)
                                        <a href="{{ url(sprintf('/dashboard/job-quotes/%s/edit', $quote->id)) }}"
                                            class="btn wb-btn-primary">
                                            EDIT QUOTE
                                        </a>
                                        <p></p>
                                        <a href="{{ url(sprintf('/dashboard/messages?recipient_user_id=%s', $quote->jobPost->user_id)) }}"
                                            class="btn wb-btn-primary">
                                            VIEW REQUEST
                                        </a>
                                    @elseif ($quote->status === 6)
									   <a href="{{ url(sprintf('/dashboard/job-quotes/%s/edit', $quote->id)) }}"
                                            class="btn wb-btn-primary">
                                            Re-Submit
                                        </a>
                                        <p></p>
									   <a href="{{ url(sprintf('/dashboard/job-quotes/%s', $quote->id)) }}"
                                            class="btn wb-btn-primary">
                                            VIEW QUOTE
                                        </a>
									@else
    									<a href="{{ url(sprintf('/dashboard/job-quotes/%s', $quote->id)) }}"
    										class="btn wb-btn-primary">
    										VIEW QUOTE
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

@push('scripts')
<script>
	$("#simpleTable").stupidtable();
</script>
@endpush
