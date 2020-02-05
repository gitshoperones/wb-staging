	@if ($jobQuote->message)
	<div class="message-block">
		<div class="sub-header">
			Message From The Supplier
		</div>
		<div class="well">
			{!! $jobQuote->message !!}
		</div>
	</div>
	@endif
    @if (!$jobQuote->additionalFiles->isEmpty())
    <div class="sub-header">
        Attachments from {{ $jobQuote->user->vendorProfile->business_name }}
    </div>
    <div class="wb-gallery">
        @foreach($jobQuote->additionalFiles as $file)
            <a href="{{ $file->meta_filename }}" target="_blank" class="btn btn-default">
                {{ $file->meta_original_filename }}
            </a><br/><br/>
        @endforeach
    </div>
    @endif
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
					@foreach($jobQuote->specs as $item)
					<tr>
						<td class="title">{{ $item['title']}} </td>
						<td>$ {{ number_format($item['cost'], 2) }}</td>
					</tr>
					@endforeach
					@if ($jobQuote->apply_gst)
					<tr>
						<td><i>GST</i></td>
						<td>$ {{ number_format(0.10 * $jobQuote->amount, 2) }}</td>
					</tr>
					@endif
					<tr class="">
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
					<tr class="bg-dustypink">
						<th style="width: 18%"></th>
						<th style="width: 25%">AMOUNT</th>
						<th style="width: 25%">DUE DATE</th>
					</tr>
				</thead>
				<tbody>
                    @if (count($jobQuote->milestones) === 1)
                        <tr>
                            <td class="milestone-desc">Total Owing</td>
                            <td class="cost">$ {{ number_format(($jobQuote->milestones[0]->percent / 100) * $jobQuote->total, 2) }}</td>
                            <td>{{ $jobQuote->milestones[0]->due_date }}</td>
                        </tr>
                    @else
    					@foreach($jobQuote->milestones as $milestone)
    					<tr>
    						<td class="milestone-desc">{{ $milestone->desc }}</td>
    						<td class="cost">$ {{ number_format(($milestone->percent / 100) * $jobQuote->total, 2) }}</td>
    						<td>{{ $milestone->due_date }}</td>
    					</tr>
    					@endforeach
                    @endif
				</tbody>
			</table>
		</div>
	</div>
    @if (!$jobQuote->invoice || $jobQuote->invoice->status === 0)
    	<div class="propose-payment-block">
    		<div class="sub-header">
    			Quote Expiry Date
    		</div>
    		<div class="well">
    			{{ $jobQuote->duration }}
    		</div>
    	</div>
    @endif
	@if ($jobQuote->tcFile)
	<div class="terms-block">
		<div class="sub-header">
			{{ $jobQuote->user->vendorProfile->business_name }}'s Terms and Conditions
		</div>
		<a href="{{ $jobQuote->tcFile->meta_filename }}" class="btn wb-btn-grey-round-xs" target="_blank">
			{{ $jobQuote->tcFile->meta_original_filename }}
		</a>
	</div>
	@endif
    @if (!$gallery->isEmpty())
    <div class="sub-header">
        Photo Inspiration from {{ $jobQuote->jobPost->user->coupleA->title }}
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
    @if (!$jobQuoteGallery->isEmpty())
    <div class="sub-header">
        Images from {{ $jobQuote->user->vendorProfile->business_name }}
    </div>
    <div class="wb-gallery">
        <div class="carousel slide media-carousel" id="media">
            <div class="carousel-inner">
                <div class="grid" id="image-wrapper">
                    @foreach($jobQuoteGallery as $photo)
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
	<br /><br />
