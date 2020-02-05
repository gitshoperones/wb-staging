@extends('adminlte::page')
@include('partials.admin.header')
@section('title', 'Job Quotes')

@section('content')
    <div class="container">
        @include('partials.alert-messages')
        <table id="dataInfo" class="table display">
            <thead>
                <tr>
                    <th>Vendor</th>
                    <th>Total</th>
                    <th>Expiration</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($jobQuotes as $jobQuote)
                    <tr>
                        <td>{{ $jobQuote->user->vendorProfile->business_name }}</td>
                        <td>{{ $jobQuote->total }}</td>
                        <td>{{ $jobQuote->duration }}</td>
                        <td>{{ $jobQuote->statusText() }}</td>
                        <td>
                            <form class="delete-job-quotes" action="{{ url('admin/job-quotes/' . $jobQuote->id) }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}

                                <button type="submit" class="btn btn-xs btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <form action="" id="delete-fee" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="delete">
        </form>
        <form action="" id="toggle-default-fee" method="POST">
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PATCH">
        </form>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $('.delete-job-quotes button.btn').on('click', function(e){
            e.preventDefault();

            var _this = $(this).parents('form');

            swal({
                title: 'Are you sure?',
                text: "You are about to delete this job quote!",
                type: 'warning',
                width: 600,
                padding: '3em',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes understood!'
            }).then((result) => {
                if (result.value) {
                    console.log(_this);
                    _this.submit();
                }
            });
        });
    </script>
@endpush

@include('partials.admin.footer')