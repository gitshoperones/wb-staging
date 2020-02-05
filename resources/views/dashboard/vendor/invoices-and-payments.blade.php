@extends('layouts.dashboard')

@section('content')
	<section class="content dashboard-container">
		@include('partials.job-posts.search-form', [
			'action' => url('/dashboard/invoices-and-payments'),
			'hideLocationSearch' => true
		])
		@if(session()->has('modal_message'))
			@include('modals.success-modal', [
				'header' => 'Payment Reminder',
				'message' => session('modal_message'),
			])
		@endif <br />
		<div class="row row-no-padding">
			<div class="col-sm-12">
				<div class="box-payment-wrapper">
					<div class="box-item">
						<div class="wb-payment-total-box white">
							<div class="box-body">
								<div class="box-wrapper">
									<p class="title">TOTAL INCOMING PAYMENTS</p>
									$ <span class="value ">{{ number_format($totalIncomingPayments, 2, '.', ',') }}</span>
								</div>
							</div>
						</div>
					</div>
					<div class="box-item">
						<div class="wb-payment-total-box primary">
							<div class="box-body">
								<div class="box-wrapper">
									<p class="title">YOUR TOTAL REVENUE THIS FINANCIAL YEAR</p>
									$ <span class="value white">{{ number_format($totalCurrentYearRevenue, 2, '.', ',') }}</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-12">
				<div class="wb-payment-box vendor">
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
										<th>Payment Received</th>
										<th>Payment Owing</th>
										<th>Next Payment Due</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody>
									@foreach($data as $invoice)
										<tr>
											<td>
												<a href="{{ url(sprintf('/dashboard/job-quotes/%s', $invoice->jobQuote->id))}}">
													{{ $invoice->jobQuote->jobPost->userProfile->title }} |
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
														<a href="" class="btn wb-btn-primary btn-send-payment-reminder"
															data-id="{{ $invoice->id }}">
															Send Payment Reminder
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
		<form action="" id="send-payment-reminder" method="POST">
			{{ csrf_field() }}
		</form>
	</div>
@endsection

@push('scripts')
	<script type="text/javascript">
		$('.btn-send-payment-reminder').on('click', function(e){
			e.preventDefault();
			var invoiceId = $(this).data('id');
			var form = $('#send-payment-reminder');
			form.attr('action', '/dashboard/send-payment-reminder/' + invoiceId);
			form.submit();
		});
	</script>
@endpush