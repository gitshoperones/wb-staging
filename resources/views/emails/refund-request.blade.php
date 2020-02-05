<h1>Refund Request</h1>
<h2>Vendor: {{ $invoice->vendor->business_name }}</h2>
<h2>Couple: {{ $invoice->couple->title }}</h2>
<p>Amount: $ {{ number_format(floatval($param['amount']), 2) }} </p>
<p>Reason: {{ $param['reason'] }} </p>
<p>Cancel Booking: {{ $param['cancel_booking'] }} </p>
<strong>Job Details</strong>

<p>Category: {{ $invoice->jobQuote->jobPost->category->name }}</p>
<p>Locations: {!! $invoice->jobQuote->jobPost->locations->implode('name', ',&nbsp;') !!}</p>

<ul class="list-inline">
    @if($invoice->jobQuote->jobPost->event->name)
        <li>
            <small><b>Event Type:</b></small> <br />
            {{ $invoice->jobQuote->jobPost->event->name }}
        </li>
    @endif

    <li>
        <small><b>Date Required:</b></small> <br />
        {{ $invoice->jobQuote->jobPost->event_date ?: 'unknown' }}
    </li>

    @if($invoice->jobQuote->jobPost->budget)
        <li>
            <small><b>Max Budget:</b></small> <br />
            {{ $invoice->jobQuote->jobPost->budget }}
        </li>
    @endif
</ul>

@if(in_array($invoice->jobQuote->jobPost->category->template, [1, 2, 3]) && $invoice->jobQuote->jobPost->number_of_guests)
    <h1>Approximate Number of Guests:</h1>
    {{ $invoice->jobQuote->jobPost->number_of_guests }}
@endif

@if($invoice->jobQuote->jobPost->category->template === 1 && !$invoice->jobQuote->jobPost->propertyTypes->isEmpty())
    <h1>Property Types:</h1>
    <ul>
        @foreach($invoice->jobQuote->jobPost->propertyTypes as $item)
            <li>{{ $item->name }}</li>
        @endforeach
    </ul>
@endif

@if($invoice->jobQuote->jobPost->category->template === 6 && $invoice->jobQuote->jobPost->beauty_subcategories_id)
    <strong>Looking for...</strong>
    <p>{{ $invoice->jobQuote->jobPost->beautySubcategory->name ?: '' }}</p>
@endif

@if($invoice->jobQuote->jobPost->category->template === 7 && !$invoice->jobQuote->jobPost->websiteRequirements->isEmpty())
    <h1>Website Requirements:</h1>
    <ul>
        @foreach($invoice->jobQuote->jobPost->websiteRequirements as $item)
        <li>{{ $item->name }}</li>
        @endforeach
    </ul>
@endif

@if(in_array($invoice->jobQuote->jobPost->category->template, [3, 4, 7]) && $invoice->jobQuote->jobPost->completion_date)
    <h1>Completion Date:</h1>
    <p>{{ $invoice->jobQuote->jobPost->completion_date }}</p>
@endif

@if($invoice->jobQuote->jobPost->category->template === 1 && !$invoice->jobQuote->jobPost->propertyFeatures->isEmpty())
    <h1>Other Requirements:</h1>
    <ul>
        @foreach($invoice->jobQuote->jobPost->propertyFeatures as $item)
            <li>{{ $item->name }}</li>
        @endforeach
    </ul>
@endif

@if(($invoice->jobQuote->jobPost->category->template === 1 || $invoice->jobQuote->jobPost->category->template === 2) && $invoice->jobQuote->jobPost->timeRequirement)
    <h1>Time Required:</h1>
    {{ $invoice->jobQuote->jobPost->timeRequirement->name }}
@endif

@if($invoice->jobQuote->jobPost->category->template === 2 && $invoice->jobQuote->jobPost->required_address)
    <h1>Venue or Address where Supplier is required:</h1>
    {{ $invoice->jobQuote->jobPost->required_address }}
@endif

@if($invoice->jobQuote->jobPost->category->template === 3 && $invoice->jobQuote->jobPost->completion_date)
    <h1>Completion Date:</h1>
    {{ $invoice->jobQuote->jobPost->completion_date }}
@endif

@if($invoice->jobQuote->jobPost->category->template === 3 || $invoice->jobQuote->jobPost->category->template === 4 && $invoice->jobQuote->jobPost->shipping_address)
    <h1>Shipping Address:</h1>
    @if($invoice->jobQuote->jobPost->status == 2)
        <p>Street: {{ $invoice->jobQuote->jobPost->shipping_address['street'] }}</p>
        <p>Suburb: {{ $invoice->jobQuote->jobPost->shipping_address['suburb'] }}</p>
    @endif
    <p>State: {{ $invoice->jobQuote->jobPost->shipping_address['state'] }}</p>
    <p>Post Code: {{ $invoice->jobQuote->jobPost->shipping_address['post_code'] }}</p>
@endif

@if($invoice->jobQuote->jobPost->specifics)
    <h1>Job Specification:</h1>
    {!! $invoice->jobQuote->jobPost->specifics !!}
@endif
