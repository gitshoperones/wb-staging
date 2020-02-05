@extends('adminlte::page')
@include('partials.admin.header')

	@section('title', 'Admin Notifications')


	@section('content')
	  <div class="row">
		<div class="col-md-12">
			<div class="box">
				<div class="box-header">
				  <h3 class="box-title">Admin Notification</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <p><strong>Actioned:</strong> <input type="checkbox" class="update-status" value="{{ $admin_notification->id }}" {{ ($admin_notification->is_read) ? 'checked' : '' }}></p>
                            <p><strong>Trigger/event:</strong> {{ $admin_notification->notification_event->name }}</p>
                            <p><strong>Subject:</strong> {{ $admin_notification->subject }}</p>
                            <p><strong>Body:</strong></p>
                            <div class="bg-gray" style="min-height: 500px; padding: 20px;">
                                {!! $admin_notification->body !!}
                            </div>
                        </div>
                    </div>
				</div>
				<!-- /.box-body -->
			  </div>

		</div>
	</div>


@stop

@push('scripts')
<script>
	$('.update-status').click(function() {
		let cb = $(this),
			status = cb.is(':checked') ? '1' : '0',
			id = cb.val();

		$.ajax( {
			type: "PUT",
			data: {
				'_token': '{{ @csrf_token() }}',
				'is_read': status
			},
			url: '/admin/admin_notification/'+id,
			success: function() {
			}
		});
	})
</script>
@endpush

@include('partials.admin.footer')