<div class="job-spec-block">
	<div class="wb-table-wrapper table-responsive">
		<table class="table table-hover">
			<thead>
				<tr>
					<th style="width: 35%">DESCRIPTION</th>
					<th style="width: 25%">AMOUNT</th>
				</tr>
			</thead>
			<tbody>
				@foreach($jobQuote->specs as $item)
				<tr>
					<td class="title">{{ $item['title']}} </td>
					<td>$ {{ number_format($item['cost'], 2) }}</td>
				</tr>
				@endforeach
				<tr class="total">
					<td><strong>Total</strong></td>
					<td colspan="2"><strong>$ {{ $jobQuote->total }}</strong></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<div class="propose-payment-block">
	<div class="sub-header">
		Payments Schedule
	</div>
	<div class="wb-payment-milestone table-responsive">
		<table class="table table-hover">
			<thead>
				<tr>
					<th style="width: 18%"></th>
					<th style="width: 25%">AMOUNT</th>
					<th style="width: 25%">DUE DATE</th>
				</tr>
			</thead>
			<tbody>
				@foreach($jobQuote->milestones as $milestone)
				<tr>
					<td class="milestone-desc">{{ $milestone->desc }}</td>
					<td class="cost">$ {{ number_format(($milestone->percent / 100) * $jobQuote->total, 2) }}</td>
					<td>{{ $milestone->due_date }}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
