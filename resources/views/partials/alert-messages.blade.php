@if ($errors->any())
<div class="alert alert-danger wd-alert-danger fade in alert-dismissable">
	@foreach ($errors->all() as $error)
	<p>{{ $error }}</p>
	@endforeach
</div>
@endif

@if (session('error'))
<div class="alert alert-danger wd-alert-danger fade in alert-dismissable">
	<p>{{ session('error') }}</p>
</div>
@endif

@if(session()->has('message'))
<div class="alert wd-alert-danger fade in alert-dismissable">
	{{ session()->get('message') }}
</div>
@endif

@if (session('status'))
<div class="alert wd-alert-danger fade in alert-dismissable">
	{{ session('status') }}
</div>
@endif

@if(session()->has('success_message'))
<div class="alert alert-success wb-alert-success fade in alert-dismissable">
    {{ session()->get('success_message') }}
</div>
@endif