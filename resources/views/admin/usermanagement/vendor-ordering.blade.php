@extends('adminlte::page')
@include('partials.admin.header')
@section('title', 'Vendor Ordering')

@section('content')
    <div class="container">
        @include('partials.alert-messages')
        <div class="row">
            <div class="col-md-9">
                <form method="POST" action="{{ url('/admin/vendors/ordering') }}" enctype="multipart/form-data" accept-charset="UTF-8">
                    {{ csrf_field() }}
                    <input name="_method" type="hidden" value="PATCH">
                    <div class="col-lg-7">
                        <label>Instructions for upload: please have two columns, the first with vendor ID and the second with Rank</label>
                        <input class="pull-right form-control" type="file" name="csv_file">
                    </div>
                    <div class="col-lg-5">
                        <input type="submit" class="form-control btn btn-xs pull-right btn-success" value="Upload csv vendor">
                    </div>

                </form>
            </div>
            <div class="col-md-3">
                <form method="GET" action="{{ url('/admin/vendors/ordering') }}" accept-charset="UTF-8">
                    <div class="col-lg-5">
                        <input class="pull-right form-control" type="search" name="q" placeholder="Search">
                    </div>
                    <div class="col-lg-4"><input type="submit" class="form-control btn btn-xs pull-right btn-success" value="Search"></div>
                </form>
            </div>
        </div>
        <table id="dataInfo" class="table display">
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Business Name</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vendors as $vendor)
                    <tr>
                        <td><input class="form-control" type="number" id="vendor-rank-{{ $vendor->id }}"value="{{ $vendor->vendorProfile->rank}}"></td>
                        <td>{{ $vendor->vendorProfile->business_name}}</td>
                        <td>{{ $vendor->email }}</td>
                        <td>
                            <a class="btn btn-delete btn-info btn-xs update-ordering"
                                data-id="{{ $vendor->id }}"
                                href="">
                                Update
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $vendors->links() }}
    </div>
    @push('scripts')
        <script type="text/javascript">
            $('.update-ordering').on('click', function(e) {
                e.preventDefault();
                var vendorId = $(this).data('id');
                axios.post('/admin/vendors/ordering/'+vendorId, {
                     _method: 'patch',
                     rank: $('#vendor-rank-'+vendorId).val()
                }).then(function(){
                    alert('Order updated!');
                });
            })
        </script>
    @endpush
@stop


@include('partials.admin.footer')