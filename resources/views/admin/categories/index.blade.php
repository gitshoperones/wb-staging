@extends('adminlte::page')
@include('partials.admin.header')
@section('title', 'Categories')

@section('content')
    <div class="container">
        @include('partials.alert-messages')
        <div class="row">
            <form method="GET" action="{{ url('/admin/categories') }}" accept-charset="UTF-8">
                <div class="col-lg-6"></div>
                <div class="col-lg-5">
                    <input class="pull-right form-control" type="search" value="{{ request('q') }}" name="q" placeholder="Search">
                </div>
                <div class="col-lg-1">
                    <input type="submit" class="form-control btn btn-xs pull-right btn-success" value="Search">
                    <a href="{{ url('/admin/categories') }}" class="form-control btn btn-xs pull-right btn-info">Clear</a>
                </div>
            </form>
        </div>
        <table id="dataInfo" class="table display">
            <thead>
                <tr>
                    <th>Category Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->name}}</td>
                        <td>
                            <a class="btn btn-delete btn-danger btn-xs"
                                data-id="{{ $category->id }}"
                                href="">
                                Delete
                            </a>
                            <a class="btn btn-info btn-xs"
                                href="{{ url(sprintf('/admin/categories/%s/edit', $category->id)) }}">
                                Edit
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $categories->links() }}
        <form action="" id="delete-fee" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="delete">
        </form>
    </div>
    @push('scripts')
        <script type="text/javascript">
            $('.btn-delete').on('click', function(e){
                e.preventDefault();
                var feeId = $(this).data('id');
                swal({
                    title: 'Are you sure?',
                    text: "You will not be able to recover this category after deleting it!",
                    type: 'warning',
                    width: 600,
                    padding: '3em',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes delete it!'
                }).then((result) => {
                    if (result.value) {
                        var form = $('#delete-fee');
                        form.attr('action', '/admin/categories/' + feeId);
                        form.submit();
                    }
                });
            });
        </script>
    @endpush
@stop


@include('partials.admin.footer')