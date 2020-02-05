@extends('adminlte::page')
@include('partials.admin.header')
@section('title', 'Add Child Accounts')

@section('content')
    <div class="container">
        @include('partials.alert-messages')
        <p><b>Parent Account Business Name:</b> {{ $parentVendor->business_name }}</p>
        <p><b>Parent Account Email:</b> {{ $parentVendor->user->email }}</p>
        <table id="dataInfo" class="table display">
            <thead>
                <tr>
                    <th>Business Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($parentVendor->childVendors as $vendor)
                    <tr>
                        <td>{{ $vendor->childVendorProfile->business_name}}</td>
                        <td>
                            <a class="btn btn-danger btn-xs btn-delete-child-account"
                                href="{{ url(sprintf('/admin/parent-accounts/%s/remove-child-accounts/%s', $parentVendor->id, $vendor->childVendorProfile->id)) }}">
                                Remove As Child Accounts
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
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