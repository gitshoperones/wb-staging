



<div class="wb-notification-box box box-widget">
	<div class="box-header with-border">
		{{-- <h3 class="box-title" style="width: auto;">
			<span class="icon"><i class="fa fa-eye"></i></span>
			<span class="title">Notifications</span>
		</h3> --}}

		<button onclick="markAllAsRead()" id="mark-all-as-read" class="btn wb-btn-orange btn-sm" style="font-size: 11px;">
			Mark all notifications as read
		</button>
	</div>
	<div class="box-body no-padding">
		<div class="">
			<table class="table no-margin table-notification">
				<tbody>
					@foreach($notifications as $notification)
    					@php
        					$view = explode('\\', $notification->type)[2] ?? '';
        					$view = trim(strtolower(kebab_case($view)));
    					@endphp
					   @includeIf(sprintf('partials.notifications.%s', $view))
					@endforeach
				</tbody>
			</table>
			
		</div>
	</div>
</div>
@if (count($notifications) > 0)
<div class="text-center">
	<a href="{{ url('/dashboard/notifications') }}" class="btn wb-btn-pink primary-text" style="text-decoration: underline; font-weight: bold; font-size: 12px;
	padding: 10px 16px;">view all notifications</a>
</div><!-- /.text-center -->
<br />
@endif
@include('modals.vendor-review')
@include('modals.mark-all-notification')
