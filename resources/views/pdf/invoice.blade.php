<!DOCTYPE html>
<html>
<head>
	<title>{{ $invoice->jobQuote->user->vendorProfile->business_name }} Invoice</title>
	<style>
		.profile-img {
			width: 196px;
			margin: auto;
			padding: 5px;
			position: relative;
		}

		.profile-img img {
			height: 170px;
			width: 170px;
			border: 3px solid #ffffff;
		}
		.company-name {
			text-align: center;
			font-size: 18px;
			text-transform: uppercase;
			font-weight: 700;
			display: block;
			color: #353554;
		}

		.sub-header {
			margin: 0px 0px 20px;
			font-size: 18px;
			font-weight: 600;
			color: #353554;
			letter-spacing: 0.1px;
		}

		.list-unstyled {
			padding-left: 0px;
			-webkit-columns: 2;
			columns: 2;
			list-style-position: inside;
			list-style: none;
		}

		table {
			border: 1px solid #DBDBDB;
			width: 100%;
			max-width: 100%;
		}

		table td {
			font-size: 13.5px;
			font-weight: 200;
			padding: 11px 10px 7px;
			border-bottom: none;
			line-height: 1.6;
			vertical-align: top;
			border-top: 1px solid #ddd;
		}
	</style>
</head>
<body>
	<div class="profile-img">
		@if ($invoice->jobQuote->user->vendorProfile->profile_avatar)
		<img src="{{ $invoice->jobQuote->user->vendorProfile->profile_avatar }}" alt="no image">
		@else
		<img src="http://via.placeholder.com/180x130" alt="no image">
		@endif
	</div>
	<a class="company-name">{{ $invoice->jobQuote->user->vendorProfile->business_name }}</a>
	<br>
	<div class="sub-header">
		{{ $invoice->jobQuote->jobPost->userProfile->title }} |
		{{ $invoice->jobQuote->jobPost->category->name }} |
		{!! $invoice->jobQuote->jobPost->locations->implode('name', ',&nbsp;') !!}
	</div>
	<ul class="list-unstyled">
		<li>
			<span class="icon"><i class="fa fa-calendar"></i></span>
			<label>Date Required: </label> {{ $invoice->jobQuote->jobPost->event_date }}
		</li>
		<li>
			<span class="icon"><i class="fa fa-star"></i></span>
			<label>Event Type: </label> {{ $invoice->jobQuote->jobPost->event->name }}
		</li>
		@if ($invoice->jobQuote->jobPost->number_of_guests)
			<li>
				<span class="icon"><i class="fa fa-users"></i></span>
				<label>Approx number of guests: </label> {{ $invoice->jobQuote->jobPost->number_of_guests }}
			</li>
		@endif
		@if ($invoice->jobQuote->jobPost->required_address)
			<li>
				<span class="icon"><i class="fa fa-map-marker"></i></span>
				<label>Venue or Address: </label> {{ $invoice->jobQuote->jobPost->required_address }}
			</li>
		@endif
		<li>
			<span class="icon"><i class="fa fa-usd"></i></span>
			<label>Max Budget: </label> {{ $invoice->jobQuote->jobPost->budget }}
		</li>
		@if ($invoice->jobQuote->jobPost->timeRequirement)
		<li>
			<span class="icon"><i class="fa fa-clock-o"></i></span>
			<label>Time Required: </label>
			<span class="value">
				{{ $invoice->jobQuote->jobPost->timeRequirement->name  }}
			</span>
		</li>
		@endif
	</ul>
	<table class="table table-hover">
		<thead>
			<tr>
				<th style="width: 35%">DESCRIPTION</th>
				<th style="width: 25%">AMOUNT</th>
			</tr>
		</thead>
		<tbody>
			@foreach($invoice->jobQuote->specs as $item)
			<tr>
				<td class="title">{{ $item['title']}} </td>
				<td>$ {{ number_format($item['cost'], 2) }}</td>
			</tr>
			@endforeach
			@if ($invoice->jobQuote->apply_gst)
			<tr>
				<td><i>GST</i></td>
				<td>$ {{ number_format(0.10 * $invoice->amount, 2) }}</td>
			</tr>
			@endif
			<tr class="total">
				<td><strong>Total</strong></td>
				<td><strong>$ {{ $invoice->total }}</strong></td>
			</tr>
		</tbody>
	</table>
	<br>
	<div class="sub-header">
		Payments Schedule
	</div>
	<table class="table table-hover">
		<thead>
			<tr>
				<th style="width: 18%"></th>
				<th style="width: 25%">AMOUNT</th>
				<th style="width: 25%">DUE DATE</th>
			</tr>
		</thead>
		<tbody>
			@foreach($invoice->jobQuote->milestones as $milestone)
			<tr>
				<td class="milestone-desc">{{ $milestone->desc }}</td>
				<td class="cost">$ {{ number_format(($milestone->percent / 100) * $invoice->total, 2) }}</td>
				<td>{{ $milestone->due_date }}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</body>
</html>