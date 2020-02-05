@extends('adminlte::page')
@include('partials.admin.header')

	@section('title', 'Dashboard')
{{--
	@section('content_header')
		<h1>Dashboard</h1>
	@stop
  --}}


	@section('content')
	<div class="row">
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>44</h3>

              <p>User Registrations</p>
              <p>Within 1 Month</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>150 / 25</h3>

              <p>Couples / Vendors</p>
              <p>Active Users</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-stalker"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-orange">
            <div class="inner">
              <h3>10</h3>

              <p>Pending Vendors</p>
              <p>&nbsp;</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>85 %</h3>

              <p>Couple Satisfaction</p>
              <p>Review and Status</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
	  </div>

	  <div class="row">
		<div class="col-md-12">
			<div class="box">
				<div class="box-header">
				  <h3 class="box-title">Admin Notifications</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body no-padding">
				  <table class="table table-condensed">
					  <thead>
							<tr>
								<th style="width: 15px"></th>
								<th>Created Date</th>
								<!-- <th style="width: 15px">#</th> -->
								<th>Trigger</th>
								<th>Business or Couple</th>
								<th style="width: 15px">Actions</th>
							</tr>
					  </thead>
					<tbody>
						@forelse($admin_notifications as $notification)
						<tr class="{{ ($notification->is_read) ? 'bg-green' : '' }}">
							<td>
								<input type="checkbox" class="update-status" value="{{ $notification->id }}" {{ ($notification->is_read) ? 'checked' : '' }}>
							</td>
							<td>{{ $notification->created_at->format('d/m/y') }}</td>
							<td>{{ $notification->notification_event->name }}</td>
							@if($notification->user['account'] == 'couple')
								@php 
									$couple = \App\Models\Couple::where('userA_id', $notification->user['id'])->first(['id', 'title']);
								@endphp
								<td>{{ $notification->user['fname'] }} {{ $notification->user['lname'] }} | {{ $couple->title }}</td>
							@elseif($notification->user['account'] == 'vendor')
								@php 
									//$vendor = \App\Models\Vendor::where('user_id', $notification->user['id'])->first(['id', 'business_name']);
								@endphp
								<td>{{ $notification->user['fname'] }} {{ $notification->user['lname'] }}</td>
							@else
								<td>N/A</td>
							@endif
							<td>
								<a href="/admin/admin_notification/{{ $notification->id }}" class="btn btn-sm btn-primary">View</a>
							</td>
						</tr>
						@empty
						<tr>
							<td class="text-center" colspan="5">No Records</td>
						</tr>
						@endforelse
					</tbody>
				</table>
				{{ $admin_notifications->links() }}
				</div>
				<!-- /.box-body -->
			  </div>

		</div>

		{{-- <div class="col-md-4">
			<!-- Info Boxes Style 2 -->
			<div class="info-box bg-yellow">
			  <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>

			  <div class="info-box-content">
				<span class="info-box-text">Top Event</span>
				<span class="info-box-number">350</span>

				<div class="progress">
				  <div class="progress-bar" style="width: 50%"></div>
				</div>
				<span class="progress-description">
					  Wedding got 50% Increase in 30 Days
					</span>
			  </div>
			  <!-- /.info-box-content -->
			</div>
			<!-- /.info-box -->
			<div class="info-box bg-green">
			  <span class="info-box-icon"><i class="ion ion-ios-heart-outline"></i></span>

			  <div class="info-box-content">
				<span class="info-box-text">Posts and Reactions</span>
				<span class="info-box-number">30</span>

				<div class="progress">
				  <div class="progress-bar" style="width: 20%"></div>
				</div>
				<span class="progress-description">
					  20% Increase in 30 Days
					</span>
			  </div>
			  <!-- /.info-box-content -->
			</div>
			<!-- /.info-box -->
			<div class="info-box bg-aqua">
			  <span class="info-box-icon"><i class="ion-ios-chatbubble-outline"></i></span>

			  <div class="info-box-content">
				<span class="info-box-text">Direct Messages</span>
				<span class="info-box-number">101,331</span>

				<div class="progress">
				  <div class="progress-bar" style="width: 40%"></div>
				</div>
				<span class="progress-description">
					  40% Increase in 30 Days
					</span>
			  </div>
			  <!-- /.info-box-content -->
			</div>
			<!-- /.info-box -->

			<!-- /.info-box -->
			<div class="info-box bg-teal">
			  <span class="info-box-icon"><i class="ion ion-ios-cloud-download-outline"></i></span>

			  <div class="info-box-content">
				<span class="info-box-text">Successfull Events and Engagements</span>
				<span class="info-box-number">22</span>

				<div class="progress">
				  <div class="progress-bar" style="width: 30%"></div>
				</div>
				<span class="progress-description">
					  30% Increase in 30 Days
					</span>
			  </div>
			  <!-- /.info-box-content -->
			</div>
		</div> --}}
	</div>


@stop

@push('scripts')
<script>
	$('.update-status').click(function() {
		let cb = $(this),
			status = cb.is(':checked') ? '1' : '0',
			id = cb.val(),
			row = cb.parents('tr');

		$.ajax( {
			type: "PUT",
			data: {
				'_token': '{{ @csrf_token() }}',
				'is_read': status
			},
			url: '/admin/admin_notification/'+id,
			success: function() {
				if(status == '1') {
					row.addClass('bg-green');
				}else {
					row.removeClass('bg-green');
				}
			}
		});
	})
</script>
@endpush

@include('partials.admin.footer')