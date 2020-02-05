@extends('adminlte::page')
@include('partials.admin.header')
@section('title', 'Parent Accounts')

@section('content')
    <div class="container">
        @include('partials.alert-messages')
        <table id="dataInfo" class="table display">
            <thead>
                <tr>
                    <th>Business Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($parentAccounts as $account)
                    <tr>
                        <td>{{ $account->vendorProfile->business_name}}</td>
                        <td>{{ $account->email }}</td>
                        <td>
                            <a class="btn btn-success btn-xs"
                                href="{{ url(sprintf('/admin/parent-accounts/%s/add-child-accounts', $account->vendorProfile->id)) }}">
                                Add Child Accounts
                            </a>
                            <br/>
                            <a class="btn btn-success btn-xs"
                                href="{{ url(sprintf('/admin/parent-accounts/%s/view-child-accounts', $account->vendorProfile->id)) }}">
                                View Child Accounts
                            </a>
                            <br/>
                            <a class="btn btn-info btn-xs"
                                href="{{ url(sprintf('/admin/parent-accounts/%s/edit', $account->id)) }}">
                                Edit
                            </a>
                            <br/>
                            <a class="btn btn-danger btn-xs btn-delete-account"
                                data-id="{{ $account->id }}"
                                href="#">
                                Delete
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination-wrap">
            {{ $parentAccounts->appends(request()->all())->links() }}
        </div>
        <form action="" id="delete-account" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="delete">
        </form>
    </div>
    @push('scripts')
        <script type="text/javascript">
            $('.btn-delete-account').on('click', function(e){
                e.preventDefault();
                var accountId = $(this).data('id');
                swal({
                    title: 'Are you sure?',
                    text: "You are about to delete this parent account!",
                    type: 'warning',
                    width: 600,
                    padding: '3em',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes understood!'
                }).then((result) => {
                    if (result.value) {
                        var form = $('#delete-account');
                        form.attr('action', '/admin/parent-accounts/' + accountId);
                        form.submit();
                    }
                });
            });
        </script>
    @endpush
@stop


@include('partials.admin.footer')