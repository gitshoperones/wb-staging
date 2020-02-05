@extends('adminlte::page')
@include('partials.admin.header')
@section('title', 'Automated Notifications')

@section('content_header')
    <h1>Automated Notifications</h1><div class="filter-content">
        <h4>Filter by:</h4>
        <select id="filter_by" class="form-control filter-by">
            <option value="all">All</option>
            <option value="admin">Admin</option>
            <option value="parent">Parent</option>
            <option value="vendor">Vendor</option>
            <option value="couple">Couple</option>
        </select>
    </div>
@endsection

@push('css')
<style>
    .table>thead>tr>td.v-center, .table>tbody>tr>td.v-center, .table>tfoot>tr>td.v-center {
        vertical-align: middle;
    }
    .m-3{
        margin: 15px;
    }
    .filter-content {
        width: 25%;
    }
    table tbody:nth-child(odd) {
        background: #d2d6de;
    }
</style>
@endpush
@section('content')
    @include('partials.alert-messages')
    <div class="">
        <table class="table display sortablePage">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Trigger</th>
                    <th>Description</th>
                    <th>Recipient(s)</th>
                    <th>Subject</th>
                    <th>Type</th>
                    <th>Action</th>
                </tr>
            </thead>
            @php $i = 1; @endphp
            @foreach($merged_notifications as $merged_items)
                <tbody id="order_id_{{ $merged_items[0]->notification_event_id }}">
                    @foreach($merged_items as $key => $merged_item)
                    <tr>
                        @if($key == 0)
                            <td rowspan="{{ count($merged_items) }}" class="v-center order_index">{{ $i }}</td>
                            <td rowspan="{{ count($merged_items) }}" class="v-center">
                                {{ $merged_item->notification_event->name }}
                            </td>
                            <td rowspan="{{ count($merged_items) }}" class="v-center">
                                {{ $merged_item->notification_event->description }}
                            </td>
                        @endif
                        <td>{{ $merged_item->recipient }}</td>
                        <td>{{ $merged_item->subject }}</td>
                        <td>{{ $merged_item->type }}</td>
                        @if($key == 0)
                            <td rowspan="{{ count($merged_items) }}" class="v-center">
                                <a class="btn btn-info btn-xs" href="{{ url(sprintf('/admin/automated-notifications/%s/edit', $merged_item->notification_event_id)) }}">
                                    Edit
                                </a>
                            </td>
                        @endif
                    </tr>
                    @endforeach
                    @php $i++; @endphp
                </tbody>
            @endforeach
        </table>
    </div>
@stop

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/lodash@4.17.11/lodash.min.js"></script>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    var sortedIds = $('.sortablePage').sortable({
        items: 'tbody:not(.filtered)'
    });

    var updateOrder = _.debounce(function (event, ui) {
        var sortArr = $('.sortablePage').sortable('toArray');
        
        $.ajax({
            url: '/admin/automated-notifications/order',
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                eventIds: sortArr
            }
        }).done(function(response) {
            $('.order_index').each(function(e) {
                $(this).text(e+1)
            })
        });
    }, 1000);

    $('.sortablePage').on('sortupdate', updateOrder);

    $('.filter-by').on('change', function() {
        let table = $('table'),
            value = $(this).val();

        if(value == 'all')  location.reload();
        $.ajax({
            url: '{{ url(sprintf('/admin/automated-notifications-filter')) }}',
            type: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                filter_by: value
            },
            dataType: 'json',
            beforeSend: () => {
                table.find('tbody').remove();
            },
            success: (notifications) => {
                let html = '',
                    tbody = '',
                    append = '',
                    counter = 1;

                Object.keys(notifications).forEach(function(key) {

                    Object.keys(notifications[key]).forEach(function(key1) {
                        let count = notifications[key].length,
                            notification = notifications[key][key1];

                        html += `<tr>
                                ${(key1 == 0) ? 
                                    `<td rowspan="${count}" class="v-center">${counter}</td>
                                    <td rowspan="${count}" class="v-center">
                                        ${notification.notification_event.name}
                                    </td>
                                    <td rowspan="${count}" class="v-center">
                                        ${(notification.notification_event.description === null) ? `` : notification.notification_event.description}
                                    </td>`
                                : ``}
                                
                                <td>${notification.recipient}</td>
                                <td>${notification.subject}</td>
                                <td>${notification.type}</td>
                                ${(key1 == 0) ? 
                                `<td rowspan="${count}" class="v-center">
                                    <a class="btn btn-info btn-xs" href="/admin/automated-notifications/${notification.notification_event.id}/edit">
                                        Edit
                                    </a>
                                </td>`
                                : ``}
                            </tr>`;
                    })

                    tbody += '<tbody class="filtered">' + html + '</tbody>';
                    html = '';
                    counter++;
                    
                });

                table.append(tbody);
            },
            error: (error) => {
                console.log(error);
            }
        });
        
    });
</script>
@endpush

@include('partials.admin.footer')