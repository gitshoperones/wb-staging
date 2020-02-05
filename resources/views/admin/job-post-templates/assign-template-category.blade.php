@extends('adminlte::page')
@include('partials.admin.header')
@section('title', 'Job Post Templates')

@section('content')
    <div class="container">
        <form method="POST" action="{{ url('admin/assign-template-category') }}" accept-charset="UTF-8">
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="PATCH">
        @include('partials.alert-messages')
        <div class="row">
            <div class="col-lg-4 form-group">
                <label>Templates</label>
                <select id="job-post-template" class="form-control" name="template_id" required>
                    <option value="">Select</option>
                    @foreach ($templates as $template)
                        <option value="{{ $template->id }}"
                            @if (request('template_id') == $template->id)
                                selected
                            @endif
                            >{{ $template->title }} </option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-12">
                @if (request('template_id'))
                    <h4> All Categories </h4>
                @else
                    <h4> Current categories w/o templates</h4>
                @endif
                @foreach ($categories as $category)
                    <div class="col-sm-3 form-group">
                        <input type="checkbox"
                            id="cat-{{ $category->id }}"
                            name="categories[]"
                            value="{{ $category->id}}"
                            @if (in_array($category->id, $templateCategories))
                                checked
                            @endif
                            >
                        <label for="cat-{{ $category->id }}">{{ $category->name }}</label>
                    </div>
                @endforeach
            </div>
            <div class="col-lg-12 form-group">
                <input type="submit" class="btn btn-success"  value="Save" />
            </div>
        </div>
    </div>
    @push('scripts')
        <script type="text/javascript">
           $('#job-post-template').on('change', function(){
                var templateId = $(this).val();
                window.location.href= 'assign-template-category?template_id=' + templateId;
           })
        </script>
    @endpush
@stop

@include('partials.admin.footer')