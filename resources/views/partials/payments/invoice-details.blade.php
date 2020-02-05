	<div class="details-block">
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
	</div>
	<div class="job-spec-block">
		<div class="wb-table-wrapper table-responsive">
			<table class="table table-hover">
				<thead>
					<tr class="bg-dustypink">
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
					<tr class="totals">
						<td><strong>Total</strong></td>
						<td colspan="2"><strong>$ {{ $invoice->jobQuote->total }}</strong></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div class="propose-payment-block">
		<div class="sub-header">
			Payment Schedule
		</div>
		<div class="wb-payment-milestone table-responsive">
			<table class="table">
				<thead>
					<tr class="total bg-dustypink">
						<th style="width: 18%">DESCRIPTION</th>
						<th style="width: 25%">AMOUNT</th>
						<th style="width: 25%">DUE DATE</th>
					</tr>
				</thead>
				<tbody>
					@foreach($invoice->jobQuote->milestones as $milestone)
						@if ($milestone->paid === 1)
							<tr class="form-group">
								<td style="color:gray;">
									<input type="checkbox"
										id="mileston-{{ $milestone->id }}"
										@if ($milestone->desc == 'deposit' || count($invoice->jobQuote->milestones) == 1)
											checked disabled
										@endif
										>
									<label for="mileston-{{ $milestone->id }}">
										<strike>{{ $milestone->desc }}</strike>
									</label>
								</td>
								<td class="cost" style="color:gray;">
									${{ number_format(($milestone->percent / 100) * $invoice->jobQuote->total, 2) }}
								</td>
								<td style="color:gray;">{{ $milestone->due_date }}</td>
							</tr>
						@else
							<tr class="form-group">
								<td>
									<input class="invoice-payable" type="checkbox"
										id="mileston-{{ $milestone->id }}" value="{{ $milestone->id }}"
										@if ($milestone->desc == 'deposit' || count($invoice->jobQuote->milestones) == 1)
											checked disabled
										@endif
										>
									<label for="mileston-{{ $milestone->id }}">
                                        @if (count($invoice->jobQuote->milestones) === 1 && $milestone->desc == 'deposit')
                                            Total Owing
                                        @else
                                            {{ $milestone->desc }}
                                        @endif
									</label>
								</td>
								<td class="cost">${{ number_format(($milestone->percent / 100) * $invoice->jobQuote->total, 2) }}</td>
								<td>{{ $milestone->due_date }}</td>
							</tr>
						@endif
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
	@if ($invoice->jobQuote->tcFile)
    <div class="terms-block">
        <div class="sub-header">
            Terms and Conditions
        </div>
        <a href="{{ $invoice->jobQuote->tcFile->meta_filename }}" class="btn wb-btn-grey-round-xs" target="_blank">
            {{ $invoice->jobQuote->tcFile->meta_original_filename }}
        </a>
    </div>
    @endif
    @if (!$gallery->isEmpty())
        <div class="sub-header">
            Our Photo Inspiration
        </div>
        <div class="wb-gallery">
            <div class="carousel slide media-carousel" id="media">
                <div class="carousel-inner">
                    <div class="grid" id="image-wrapper">
                        @foreach($gallery as $photo)
                            <div class="grid-item">
                                <img src="{{ $photo->getFileUrl() }}"
                                    class="img-responsive" alt="no image">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
	@endif