@extends('adminlte::page')
@include('partials.admin.header')
@section('title', 'Pending Job Posts')

@section('content_header')
    <h1>Pending Job 
        <div class="btn-group pull-right" role="group">
            <button type="submit" class="btn btn-success btn-approve btn-sm" data-id="{{ $jobPost->id }}"><i class="fa fa-check"></i> Approve Job</button>
            <button type="submit" class="btn btn-danger btn-destroy btn-sm" data-id="{{ $jobPost->id }}"><i class="fa fa-trash"></i> Delete Job</button>
        </div>
    </h1>
@endsection

@push('css')
<style>
    @keyframes rotate360 {
        to { transform: rotate(360deg); }
    }
    .fa-refresh { animation: 2s rotate360 infinite linear; }
</style>
@endpush

@section('content')
    <div class="well container wb-box">
        @include('partials.alert-messages')

        <div class="row">
            <div class="col-lg-4 form-group">
                <label>Couple Name</label>
                <span class="form-control">{{ucwords($jobPost->userProfile->title)}}</span>
            </div>
            <div class="col-lg-4 form-group">
                <label>Category</label>
                <span class="form-control">{{ucwords($jobPost->category->name)}}</span>
            </div>
            <div class="col-lg-4 form-group">
                <label>Location</label>
                <span class="form-control">{!! $jobPost->locations->implode('name', ',&nbsp;') !!}</span>
            </div>
            <div class="col-lg-4 form-group">
                <label>Event Type</label>
                <span class="form-control"><i class="fa fa-star-o"></i> {{ $jobPost->event->name }}</span>
            </div>
            <div class="col-lg-4 form-group">
                <label>Date Required</label>
                <span class="form-control"><i class="fa fa-calendar"></i> 
                    {{ $jobPost->event_date ?: 'Not set' }}
                    @if ($jobPost->is_flexible)
                    (this date is flexible)
                    @endif
                </span>
            </div>
            @if (($jobPost->number_of_guests > 0 && isset($types['approx'])) || ($jobPost->number_of_guests > 0 && isset($types['hasTemplate'])))
                <div class="col-lg-4 form-group">
                    <label>Approximate Number of Guests</label>
                    <span class="form-control">
                        {{ $jobPost->number_of_guests }}
                    </span>
                </div>
            @endif
            @if ($jobPost->required_address && isset($types['address']))
                <div class="col-lg-4 form-group">
                    <label>{{ $types['address'] }}</label>
                    <span class="form-control">
                        {{ $jobPost->required_address }}
                    </span>
                </div>
            @endif
            @if($jobPost->fields && !empty($jobPost->fields))
                @foreach(json_decode($jobPost->fields) as $field)
                    @if(isset($field->val))
                    <div class="{{ (isset($field->type) && $field->type == 'custom_multi') ? "col-lg-12" : "col-lg-4"}} form-group">
                        <label>{{ isset($field->title) ? $field->title : "" }}</label>
                        @if(isset($field->type) && $field->type == 'custom_multi')
                            <ul>
                                @foreach ($field->val as $option)
                                <li>{{ $option }}</li>
                                @endforeach
                            </ul>
                        @else
                            <span class="form-control">
                                {{ (isset($field->type) && $field->type == 'currency') ? '$': '' }}{{ $field->val }}
                            </span>
                        @endif
                    </div>
                    @endif
                @endforeach
            @endif
        </div>
    </div>
@stop


@push('scripts')
<script>
$('.btn-approve').click(function() {
    var jobId = $(this).data('id')

    $(this).find('i').removeClass('fa-check').addClass('fa-refresh')

    $.ajax( {
        type: "PUT",
        data: {
            '_token': '{{ @csrf_token() }}'
        },
        url: '/admin/pending-job-posts/'+jobId,
        success: function() {
            window.location.replace('/admin/pending-job-posts');
        }
    });

})

$('.btn-destroy').click(function() {
    var jobId = $(this).data('id')

    $(this).find('i').removeClass('fa-trash').addClass('fa-refresh')

    $.ajax( {
        type: "DELETE",
        data: {
            '_token': '{{ @csrf_token() }}'
        },
        url: '/admin/pending-job-posts/'+jobId,
        success: function() {
            window.location.replace('/admin/pending-job-posts');
        }
    });

})

</script>
@endpush

@include('partials.admin.footer')