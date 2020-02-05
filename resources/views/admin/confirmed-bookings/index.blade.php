@extends('adminlte::page')
@include('partials.admin.header')
@section('title', 'Confirmed Bookings')

@section('content_header')
    <h1>Confirmed Bookings <a class="btn btn-primary btn-sm  pull-right" href="{{ url('admin/export-confirmed-bookings') }}" >Export Confirmed Bookings</a></h1>
@endsection

@section('content')
    <div class="container">
        @include('partials.alert-messages')
        <div class="row">
            <form method="GET" action="{{ url('admin/confirmed-bookings') }}" accept-charset="UTF-8">
                <div class="col-lg-5 col-lg-offset-6">
                    <input class="pull-right form-control" type="search" name="search" placeholder="Search..">
                </div>
                <div class="col-lg-1"><input type="submit" class="form-control btn btn-xs pull-right btn-success" value="Search" /></div>
            </form>
        </div>
        <table id="dataInfo" class="table display">
            <thead>
                <tr>
                    <th>Vendor</th>
                    <th>Couple</th>
                    <th>Category</th>
                    <th>Event</th>
                    <th>Locations</th>
                    <th>Total Payable</th>
                    <th>Balance</th>
                    <th>Next Payment Due</th>
                    <th>Event Date</th>
                    {{-- <th>Created Date</th> --}}
                    <th>Status</th>
                    <th>Cancelled?</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($confirmedBookings as $booking)
                    <tr>
                        <td>{{ $booking->jobQuote->user->vendorProfile->business_name }}</td>
                        <td>{{ $booking->jobQuote->jobPost->userProfile->title }}</td>
                        <td>{{ $booking->jobQuote->jobPost->category->name }}</td>
                        <td>{{ $booking->jobQuote->jobPost->event->name }}</td>
                        <td>{!! $booking->jobQuote->jobPost->locations->implode('name', ',&nbsp;') !!}</td>
                        <td>$ {{ number_format($booking->total, 2, '.', ',') }}</td>
                        <td>$ {{ number_format($booking->balance, 2, '.', ',') }}</td>
                        <td>
                            {{ $booking->next_payment_date }}
                        </td>
                        <td>{{ $booking->jobQuote->jobPost->event_date ?: 'unknown' }}</td>
                        {{-- <td>{{ $booking->created_at->format('d/m/Y') }}</td> --}}
                        <td>{{ ucwords($booking->statusText()) }}</td>
                        <td>
                            {{ $booking->is_cancelled ? 'Yes' : 'No' }}
                        </td>
                        <td style="width: 150px;">
                            @if($booking->is_cancelled)
                                <form class="refund-booking-form" method="POST" action="{{ url('admin/confirmed-bookings/' . $booking->id . '/refund') }}">
                                    {{ csrf_field() }}
                                    {{ method_field('PATCH') }}
                                    <input type="checkbox" name="is_refunded" {{ $booking->is_refunded ? 'checked' : '' }} value="{{ $booking->is_refunded ? false : true }}"> Mark as refunded
                                </form>

                                
                                <button data-details="{{ $booking->cancelled_reason }}" class="btn btn-warning btn-xs cancel-details-btn">Cancellation Details</button>
                            @else
                                <button type="button" data-booking-id="{{ $booking->id }}" {{ $booking->is_cancelled ? 'disabled' : '' }} class="btn btn-xs btn-warning cancel-booking">Cancel Booking</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination-wrap">
            {{ $confirmedBookings->appends(request()->all())->links() }}
        </div>
    </div>

    <div id="cancel-detail-modal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Cancellation Details</h4>
                </div>
                <div class="modal-body">
                    <p></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div id="cancel-modal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="cancel-booking-form" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('PATCH') }}

                    <input type="hidden" name="is_cancelled" value="1">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Are you sure you want to cancel this booking?</h4>
                    </div>
                    <div class="modal-body">
                        <textarea required name="cancelled_reason" id="" cols="30" rows="10" class="form-control" placeholder="Reason for cancelling"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@stop

@push('scripts')
    <script>
        $('.cancel-booking').on('click', function(e){
            e.preventDefault();

            var bookingId = $(this).data('booking-id');

            var url = '/admin/confirmed-bookings/' + bookingId + '/cancel';

            $('#cancel-booking-form').attr('action', url);
            $('#cancel-modal').modal();
        });

        $('.cancel-details-btn').on('click', function(e) {
            e.preventDefault();

            var details = $(this).data('details');

            $('#cancel-detail-modal .modal-body p').html(details);
            $('#cancel-detail-modal').modal();
        });

        $('input[name="is_refunded"]').change(function() {
            var form = $(this).parents('form');
            if ($(this).is(':checked')) {
                swal({
                    title: 'Are you sure?',
                    text: "Are you positive the refund has been granted?",
                    type: 'warning',
                    width: 600,
                    padding: '3em',
                    showCancelButton: true,
                    cancelButtonText: 'No',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.value) {
                        form.submit();
                    }
                });
            } else {
                swal({
                    title: 'Are you sure?',
                    text: "Are you sure you want to make this as not refunded?",
                    type: 'warning',
                    width: 600,
                    padding: '3em',
                    showCancelButton: true,
                    cancelButtonText: 'No',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.value) {
                        form.submit();
                    }
                });
            }
        });
    </script>
@endpush

@include('partials.admin.footer')