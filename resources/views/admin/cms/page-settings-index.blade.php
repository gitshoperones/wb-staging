@extends('adminlte::page')
@include('partials.admin.header')
@section('title', 'Pages')

@section('content')
    <div class="container">
        @include('partials.alert-messages')
        <h3>{{ $page->name }} </h3>
        <br/><br/>
        <a href="{{ url(sprintf('/admin/pages/%s/page-settings/create', $page->id)) }}" class="btn btn-info">Add New Setting</a>
        <table class="table dataTable display">
            <thead>
                <tr>
                    <th>Setting Key</th>
                    <th>Setting Value</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="sortablePage">
                @foreach($page->pageSettings()->orderBy('order')->get() as $setting)
                    <tr id="page_setting_id_{{ $setting->id }}">
                        <td>{{ $setting->meta_key }}</td>
                        @if ($setting->meta_type === 2)
                            <td><img style="max-width: 100px;" src="{{ Storage::url($setting->meta_value) }}"></td>
                        @elseif ($setting->meta_type === 3)
                            <td><a href="{{ url(Storage::url($setting->meta_value)) }}" target="_blank">{{ str_limit(url(Storage::url($setting->meta_value)), 50) }}</a></td>
                        @else
                            <td>{{ str_limit($setting->meta_value, 50) }}</td>
                        @endif
                        <td>
                            <a class="btn btn-info btn-xs"
                                href="{{ url(sprintf('/admin/pages/%s/page-settings/%s/edit', $page->id, $setting->id)) }}">
                                Edit
                            </a>
                            <br/>
                            <a class="btn btn-danger btn-xs btn-delete-page"
                                data-id="{{ $setting->id }}"
                                href="#">
                                Delete
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <form action="" id="delete-page" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="delete">
        </form>
    </div>
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.11/lodash.min.js"></script>
        <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script type="text/javascript">
            $('.btn-delete-page').on('click', function(e){
                e.preventDefault();
                var accountId = $(this).data('id');
                swal({
                    title: 'Are you sure?',
                    text: "You are about to delete this setting!",
                    type: 'warning',
                    width: 600,
                    padding: '3em',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes understood!'
                }).then((result) => {
                    if (result.value) {
                        var form = $('#delete-page');
                        form.attr('action', '/admin/page-settings/' + accountId);
                        form.submit();
                    }
                });
            });

            var sortedIds = $('.sortablePage').sortable();

            var updateOrder = _.debounce(function (event, ui) {
                var sortArr = $('.sortablePage').sortable('toArray');

                $.ajax({
                    url: '/admin/page-settings/' + '{{ $page->id }}' + '/order',
                    method: 'PATCH',
                    data: {
                        _token: '{{ csrf_token() }}',
                        pageSettings: sortArr
                    }
                }).done(function(response) {
                    console.log(response);
                });
            }, 1000);

            $('.sortablePage').on('sortupdate', updateOrder);
        </script>
    @endpush
@stop


@include('partials.admin.footer')