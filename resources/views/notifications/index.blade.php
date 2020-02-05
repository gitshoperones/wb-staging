@extends('layouts.dashboard')

@section('content')
<section id="wb-notification-block" class="content">
	<div class="container-fluid">
		@if (count($notifications) < 1)
		<div class="alert wb-alert-info">
			No notifications.
		</div>
		@endif
		<div class="wb-timeline">
			<div class="wb-timeline-panel" style="margin-top: 0;">
				<div class="box-header with-border">
					{{-- <h3 class="box-title" style="width: auto;">
						<span class="icon"><i class="fa fa-eye"></i></span>
						<span class="title">Notifications</span>
					</h3> --}}

					<button onclick="markAllAsRead()" id="mark-all-as-read" class="btn wb-btn-orange btn-sm" style="font-size: 11px;">
						Mark all notifications as read
					</button>
				</div>
				<table class="table no-margin table-notification">
					<tbody>
						@foreach($notifications as $notification)
							@php
								$view = explode('\\', $notification->type)[2] ?? '';
								$view = strtolower(preg_replace('/(?<=\\w)(?=[A-Z])/',"-$1", $view));
							@endphp
							@includeIf(sprintf('partials.notifications.%s', $view))
						@endforeach
					</tbody>
				</table>
				
			</div>
		</div>
		<div class="wb-pagination-block">
			{{ $notifications->links() }}
		</div>
	</div>
</section>
@include('modals.vendor-review')
@include('modals.mark-all-notification')
@endsection