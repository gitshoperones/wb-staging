@extends('adminlte::page')
@include('partials.admin.header')
@section('title', 'Add Child Accounts')

@section('content')
    <div class="container">
        @include('partials.alert-messages')
        <p><b>Parent Account Business Name:</b> {{ $parentVendor->business_name }}</p>
        <p><b>Parent Account Email:</b> {{ $parentVendor->user->email }}</p>
        <div class="row">
            <form method="GET" action="{{ url(sprintf('admin/parent-accounts/%s/add-child-accounts', $parentVendor->id)) }}" accept-charset="UTF-8">
                {{ csrf_field() }}
                <div class="col-lg-6"></div>
                <div class="col-lg-5">
                    <input class="pull-right form-control" type="search" value="{{ request('search') }}" name="search" placeholder="Type email or business name">
                </div>
                <div class="col-lg-1">
                    <input type="submit" class="form-control btn btn-xs pull-right btn-success" value="Search" />
                    <a href="{{ url(sprintf('admin/parent-accounts/%s/add-child-accounts', $parentVendor->id)) }} "
                        class="form-control btn btn-xs pull-right btn-success"> Clear
                    </a>
                </div>
            </form>
        </div>
        <table id="dataInfo" class="table display">
            <thead>
                <tr>
                    <th>Business Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $childAccounts = $parentVendor->childVendors->pluck('child_vendor_id')->toArray()
                @endphp
                @foreach($availableChildVendors as $vendor)
                    <tr>
                        <td>{{ $vendor->business_name}}</td>
                        <td>{{ $vendor->user->email }}</td>
                        <td>
                            @if (in_array($vendor->id, $childAccounts))
                                <a class="btn btn-danger btn-xs btn-delete-child-account"
                                    href="{{ url(sprintf('/admin/parent-accounts/%s/remove-child-accounts/%s', $parentVendor->id, $vendor->id)) }}">
                                    Remove As Child Accounts
                                </a>
                            @else
                                <a class="btn btn-info btn-xs"
                                    href="{{ url(sprintf('/admin/parent-accounts/%s/save-child-accounts/%s', $parentVendor->id, $vendor->id)) }}">
                                    Add As Child Accounts
                                </a>
                            @endif
                            <a class="btn btn-success btn-xs"
                                href="{{ url(sprintf('/admin/vendor/%s', $vendor->user->id)) }}">
                                View details
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="col-lg-6">
            <div class="pull-right">
                {{ $availableChildVendors->links() }}
            </div>
        </div>
        <form action="" id="delete-account" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="delete">
        </form>
    </div>
    @push('scripts')
        <script type="text/javascript">
            $('.btn-delete-child-account').on('click', function(e){
                e.preventDefault();
                var href = $(this).attr('href');
                swal({
                    title: 'Are you sure?',
                    text: "You are about to remove this child account from its parent account!",
                    type: 'warning',
                    width: 600,
                    padding: '3em',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes understood!'
                }).then((result) => {
                    if (result.value) {
                        window.location.replace(href);
                    }
                });
            });
        </script>
    @endpush
@stop


@include('partials.admin.footer')