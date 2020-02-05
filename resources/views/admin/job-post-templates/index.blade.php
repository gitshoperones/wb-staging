@extends('adminlte::page')
@include('partials.admin.header')
@section('title', 'Job Post Templates')

@section('content')
    <div class="container">
        @include('partials.alert-messages')
        <table id="dataInfo" class="table display">
            <thead>
                <tr>
                    <th>Template Title</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($templates as $template)
                    <tr>
                        <td>{{ $template->title }}</td>
                        <td>
                            <a class="btn btn-info btn-xs"
                                href="{{ url(sprintf('admin/job-post-templates/%s/edit', $template->id)) }}">
                                Edit
                            </a>
                            <a class="btn btn-delete btn-danger btn-xs"
                                data-id="{{ $template->id }}"
                                href="">
                                Delete
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination-wrap">
            {{ $templates->appends(request()->all())->links() }}
        </div>
        <form action="" id="delete-template" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="delete">
        </form>
    </div>
    @push('scripts')
        <script type="text/javascript">
            $('.btn-delete').on('click', function(e){
                e.preventDefault();
                var templateId = $(this).data('id');
                var r = confirm("This will permanently delete the template.");
                if (r == true) {
                    var form = $('#delete-template');
                    form.attr('action', '/admin/job-post-templates/' + templateId);
                    form.submit();
                }
            })
        </script>
    @endpush
@stop


@include('partials.admin.footer')