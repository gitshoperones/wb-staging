@extends('layouts.dashboard')

@section('content')
<section class="content dashboard-container">
	{{-- @include('partials.job-posts.search-form', [
	'action' => url('dashboard/received-quotes'),
	'hideLocationSearch' => true
	]) --}}
	<div class="row">
		<div class="col-sm-12"> <br />
			<div class="wb-sent-quote-box">
				<div class="">
					<table class="table sortable-table" id="simpleTable">
						<thead>
							<tr>
								<th data-sort="string" style="width: 11.5%;">
									Business <span class="icon"><i class="fa fa-caret-down"></i></span>
								</th>
								<th data-sort="string" style="width:40%;">
									Job <span class="icon"><i class="fa fa-caret-down"></i></span>
								</th>
								<th data-sort="int" style="width:8.5%;">
									Amount <span class="icon"><i class="fa fa-caret-down"></i></span>
								</th>
								<th data-sort="string" style="width:11.5%;">
									Quote Expiry <span class="icon"><i class="fa fa-caret-down"></i></span>
								</th>
								<th data-sort="string" style="width:11.5%;">
									STATUS <span class="icon"><i class="fa fa-caret-down"></i></span>
								</th>
								<th style="width: 348px;">

								</th>
							</tr>
						</thead>
						<tbody>
							@if(count($jobQuotes) > 0)
							@foreach($jobQuotes as $quote)
							<tr>
								<td>
									<!-- <a class="name btn wrap" href="{{ url(sprintf('vendors/%s', $quote->user->vendorProfile->id)) }}"> -->
									<a class="name btn wrap" href="{{ url(sprintf('/dashboard/job-quotes/%s', $quote->id)) }}">
										{{ $quote->user->vendorProfile->business_name }}
									</a>
								</td>
								<td>
									<!-- <a class="name btn wrap" href="{{url(sprintf('dashboard/job-posts/%s', $quote->jobPost->id))}}"> -->
									<a class="name btn wrap" href="{{ url(sprintf('/dashboard/job-quotes/%s', $quote->id)) }}">
										{{ $quote->jobPost->category->name }} |
										{!! $quote->jobPost->locations->implode('name', ',&nbsp;') !!} |
										{{ $quote->jobPost->event->name }}
									</a>
								</td>
								<td>$ {{ $quote->total }}</td>
								<td> {{ $quote->duration }} </td>
								<td>
									@if ($quote->invoice && in_array($quote->invoice->status, [1, 2]))
									Confirmed
									@elseif ($quote->status === 1)
									Awaiting Your Response
									@elseif ($quote->status === 2)
									Requested Changes
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
								<td class="quote-actions">
									@if ($quote->invoice && in_array($quote->invoice->status, [1, 2]))
									<a href="{{ url(sprintf('/dashboard/job-quotes/%s', $quote->id)) }}"
										class="btn wb-btn-primary">
										View Booking
									</a>
									@elseif ($quote->status === 3)
									<a href="{{ url(sprintf('payments/create?invoice_id=%s', $quote->invoice->id)) }}"
										class="btn wb-btn-primary">
										VIEW & PAY INVOICE
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