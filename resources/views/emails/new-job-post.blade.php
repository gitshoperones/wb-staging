<h1>Job Details</h1>
<p></p>
<p>Couple: {{ $jobPost->userProfile->title }}</p>
<p>Email: {{ $jobPost->user->email }}</p>
<p>Category: {{ $jobPost->category->name }}</p>
<p>Event Type: {{ $jobPost->event->name }}</p>
<p>Locations: {!! $jobPost->locations->implode('name', ',&nbsp;') !!}</p>
<p>Event Date: {{ $jobPost->event_date ?: 'Not set' }}</p>
<p>Created Date: {{ $jobPost->created_at->format('d/m/Y') }}</p>
<p>Job Expiry: {{ $jobPost->updated_at->addWeeks(12)->format('d/m/Y') }}</p>
<p>Job Type: @if($jobPost->job_type === 0)
        Job Posted
    @elseif($jobPost->job_type === 1)
        Quote Requested - Single
    @elseif($jobPost->job_type === 2)
        Quote Requested - Multiple
    @endif</p>
