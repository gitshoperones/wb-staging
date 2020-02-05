@extends('adminlte::page')
@include('partials.admin.header')
@section('title', 'Refund Request')

@section('content_header')
    <h1>Refund Requests <a class="btn btn-primary btn-sm  pull-right" href="{{ url('admin/export-refund-requests') }}" >Export Refund Request Records</a></h1>
@endsection

@section('content')
    @include('partials.alert-messages')

    <table id="dataInfo" class="table display">
        <thead>
            <tr>
                <th>Vendor</th>
                <th>Couple</th>
                <th>Locations</th>
                <th>Total Payable</th>
                <th>Balance</th>
                <th>Refund Amount Asked</th>
                <th>Reason</th>
                <th>Requested By</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($refundRecords as $record)
                @if($record->invoice !== null)
                    <tr>
                        <td>{{ $record->invoice->jobQuote->user->vendorProfile->business_name }}</td>
                        <td>{{ $record->invoice->jobQuote->jobPost->userProfile->title }}</td>
                        <td>{!! $record->invoice->jobQuote->jobPost->locations->implode('name', ',&nbsp;') !!}</td>
                        <td>$ {{ number_format($record->invoice->total, 2) }}</td>
                        <td>$ {{ number_format($record->invoice->balance, 2) }}</td>
                        <td>$ {{ number_format($record->amount, 2) }}</td>
                        <td>{!! $record->reason !!}</td>
                        <td>{{ optional($record->user)->email }} ({{ ucfirst(optional($record->user)->account) }})</strong></td>
                        <td>{{ ucwords($record->statusText()) }}</td>
                        <td>
                            <form action="{{ route('refund-request.update', ['id' => $record->id]) }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('PATCH') }}
                    
                                <input type="hidden" name="status" value="1">
                                <button type="submit" class="btn btn-warning btn-block btn-xs">Pending</button>
                            </form>

                            <form action="{{ route('refund-request.update', ['id' => $record->id]) }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('PATCH') }}
                    
                                <input type="hidden" name="status" value="2">
                                <button type="submit" class="btn btn-danger btn-block btn-xs">Reject</button>
                            </form>

                            <form action="{{ route('refund-request.update', ['id' => $record->id]) }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('PATCH') }}
                        
                                <input type="hidden" name="status" value="3">
                                <button type="submit" class="btn btn-success btn-block btn-xs">Complete</button>
                            </form>
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>

    <div class="pagination-wrap">
        {{ $refundRecords->links() }}
    </div>
    
@endsection

@include('partials.admin.footer')