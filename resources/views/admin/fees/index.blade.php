@extends('adminlte::page')
@include('partials.admin.header')
@section('title', 'Fees')

@section('content')
    <div class="container">
        @include('partials.alert-messages')
        <table id="dataInfo" class="table display">
            <thead>
                <tr>
                    <th>Fee Type</th>
                    <th>Fee Name</th>
                    <th>Percent</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($fees as $fee)
                    <tr>
                        <td>{{ $fee->type}}</td>
                        <td>{{ $fee->name }}</td>
                        <td>{{ $fee->amount}}%</td>
                        <td>{{ $fee->status === 1 ? 'Active' : 'Inactive'}}
                        <td>
                            <a class="btn btn-delete btn-danger btn-xs"
                                data-id="{{ $fee->id }}"
                                href="">
                                Delete
                            </a>
                            <a class="btn btn-info btn-xs"
                                data-id="{{ $fee->id }}"
                                href="{{ url(sprintf('/admin/fees/%s/edit', $fee->id)) }}">
                                edit
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination-wrap">
            {{ $fees->appends(request()->all())->links() }}
        </div>
        <form action="" id="delete-fee" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="delete">
        </form>
        <form action="" id="toggle-default-fee" method="POST">
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PATCH">
        </form>
    </div>
    @push('scripts')
        <script type="text/javascript">
            $('.btn-delete').on('click', function(e){
                e.preventDefault();
                var feeId = $(this).data('id');
                var r = confirm("This will permanently delete the Fee. Click OK to continue or Cancel to abort.");
                if (r == true) {
                    var form = $('#delete-fee');
                    form.attr('action', '/admin/fees/' + feeId);
                    form.submit();
                }
            });
            $('.default-vendor-fee').on('change', function(e) {
                e.preventDefault();
                var feeId = $(this).data('id');
                var form = $('#toggle-default-fee');
                form.attr('action', '/admin/fees/toggle-default/' + feeId);
                form.submit();
            })
        </script>
    @endpush
@stop


@include('partials.admin.footer')