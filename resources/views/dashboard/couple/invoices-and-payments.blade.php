@extends('layouts.dashboard')

@section('content')
	<section class="content dashboard-container">
		{{-- @include('partials.job-posts.search-form', [
			'action' => url('/dashboard/invoices-and-payments'),
			'hideLocationSearch' => true
		]) <br /> --}}
		<div class="row row-no-padding">
			<div class="col-sm-12">
				<div class="box-payment-wrapper">
					<div class="box-item">
						<div class="wb-payment-total-box white">
							<div class="box-body">
								<div class="box-wrapper">
									<p class="title">TOTAL PAID</p>
									$ <span class="value ">{{ number_format($totalPaid, 2, '.', ',') }}</span>
								</div>
							</div>
						</div>
					</div>
					<div class="box-item">
						<div class="wb-payment-total-box primary">
							<div class="box-body">
								<div class="box-wrapper">
									<p class="title">STILL OWING</p>
									$ <span class="value white">{{ number_format($totalOwing, 2, '.', ',') }}</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-12">
				<div class="wb-budget-payment-box">
					<div class="box-body no-padding">
						<div class="table-responsive">
							<table class="table no-margin">
								<thead>
									<tr>
										<th>
											<span class="icon">
												<img src="{{ asset('/assets/images/icons/dashboard/payments.png') }}" height="19px">
											</span>
											PAYMENTS
										</th>
										<th>Total Invoice</th>
										<th>Total Paid</th>
										<th>Still Owing</th>
										<th>Next Payment Due</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody>
									@foreach($data as $invoice)
										<tr>
											<td>
												<a href="{{ url(sprintf('/dashboard/job-quotes/%s', $invoice->jobQuote->id)) }}">
													{{ $invoice->vendor->business_name }} |
													{{ $invoice->jobQuote->jobPost->category->name }}
												</a>
											</td>
											<td>$ {{ number_format($invoice->total, 2, '.', ',') }}</td>
											<td>$ {{ number_format($invoice->total - $invoice->balance, 2, '.', ',') }}</td>
											<td> $ {{ number_format($invoice->balance, 2, '.', ',') }}</td>
											<td>{{ $invoice->next_payment_date }}</td>
											<!-- <td>Nov 20, 2017 <span class="label label-danger">OVERDUE</span></td> -->
											<td>{{ $invoice->is_cancelled ? 'Cancelled' . (($invoice->is_refunded) ? ' & Refunded' : '') : ucwords($invoice->statusText()) }}</td>
											<td>
												<a href="{{ url(sprintf('invoice/%s/pdf', $invoice->id)) }}" target="_blank" class="btn wb-btn-primary">
													Download Invoice
												</a>
												@if ($invoice->status !== 2)
													@if ( ! $invoice->is_cancelled)
													<a href="{{ url(sprintf('payments/create?invoice_id=%s', $invoice->id)) }}" class="btn wb-btn-primary">
														View & Pay Invoice
													</a>
													@endif
												@endif
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="wb-pagination-block">
				{{ $data->appends([
					'category' => request('job_category'),
					'locations' => request('locations'),
					])->links()
				}}
			</div>
			@if (count($data) === 0)
				<h3 class="text-center">
					No record found.
				</h3>
			@endif
		</div>
	</section>
@endsection