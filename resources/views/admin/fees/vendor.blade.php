@extends('adminlte::page')
@include('partials.admin.header')
@section('title', 'Vendor Fees')

@section('content')
    <div class="container">
        <div class="row">
            <h4> Add/Remove Vendor Fees </h4>
            <br/>
            <div class="col-lg-4 form-group">
                <label>Business Name</label>
                <p>{{ $vendor->business_name }}</p>
            </div>
            <div class="col-lg-4 form-group">
                <label>Business Email</label>
                <p><a href="{{ url(sprintf('/admin/vendor/%s', $vendor->user->id)) }}">{{ $vendor->user->email }}</a></p>
            </div>
            <div class="col-lg-4 form-group">
                <label>Website</label>
                <p>{{ $vendor->website }}</p>
            </div>
        </div>
        <form method="POST" action="{{ url('admin/fees/vendor') }}" accept-charset="UTF-8">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="patch">
            <input type="hidden" name="vendorId" value="{{ request('id') }}">

            @include('partials.alert-messages')
            <div class="row">
                <div class="col-sm-12">
                    <table id="dataInfo" class="table display">
                        <thead>
                            <tr>
                                <th>Fee Name</th>
                                <th>Fee Type</th>
                                <th>Amount</th>
                                <th>Select</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($fees as $fee)
                                <tr>
                                    <td>{{ $fee->name }}</td>
                                    <td>{{ $fee->type }}</td>
                                    <td>{{ $fee->amount ?: '--' }}%</td>
                                    <td>
                                        <input type="radio"
                                            name="feeId"
                                            value="{{ $fee->id}}"
                                            @if ($fee->id === $vendor->fee->fee_id))
                                                checked
                                            @endif
                                            >
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <br/>
                    <div class="clearfix"></div>
                    <div class="col-lg-12 form-group">
                        <input type="submit" class="btn btn-success"  value="Update" />
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@include('partials.admin.footer')