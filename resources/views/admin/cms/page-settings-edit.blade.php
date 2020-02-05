@extends('adminlte::page')
@include('partials.admin.header')
@section('title', 'Edit Page Settings')

@section('content')
    <div class="container">
        <form method="POST" action="{{ action('Admin\PageSettingsController@update', ['pageSetting' => $pageSetting->id]) }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}
            <input type="hidden" name="pageId" value="{{ $pageId }}">
            @include('partials.alert-messages')
            <div class="row">
                <div class="col-lg-4 form-group">
                    <label>Setting Key</label>
                    <input type="text" class="form-control" name="meta_key" value="{{ $pageSetting->meta_key }}" required>
                </div>
                <div class="clearfix"></div>
                <div class="col-lg-4 form-group">
                    <label>Setting Type</label>
                    <select class="form-control" name="meta_type" id="setting-type">
                        <option value="">Select Setting Type</option>
                        <option value="text" {{ ($pageSetting->meta_type == 1) ? 'selected' : '' }}>Text</option>
                        <option value="image" {{ ($pageSetting->meta_type == 2) ? 'selected' : '' }}>Image</option>
                        <option value="file" {{ ($pageSetting->meta_type == 3) ? 'selected' : '' }}>File</option>
                    </select>
                </div>
                <div class="clearfix"></div>
                <div class="col-lg-8 form-group {{ ($pageSetting->meta_type == 1) ? '' : 'hidden' }}" id="text-setting-type">
                    <label>Add Text</label>
                    <textarea class="form-control" cols="5" rows="15" id="editor" name="meta_value_text">{{ $pageSetting->meta_value }}</textarea>
                </div>
                <div class="clearfix"></div>
                <div class="col-lg-4 form-group {{ ($pageSetting->meta_type == 2) ? '' : 'hidden' }}" id="image-setting-type">
                    <label for="meta_value_image">Upload Image</label>
                    <input type="file" name="meta_value_image"/>
                    <br>
                    @if ($pageSetting->meta_type == 2)
                        <label for="">Preview of uploaded image</label>
                        <img style="width: 100%;" src="{{ Storage::url($pageSetting->meta_value) }}" alt="">
                    @endif   
                </div>
                <div class="clearfix"></div>
                <div class="col-lg-4 form-group {{ ($pageSetting->meta_type == 3) ? '' : 'hidden' }}" id="file-setting-type">
                    <label for="meta_value_file">Upload File</label>
                    <input type="file" name="meta_value_file"/>
                    <br>
                    @if ($pageSetting->meta_type == 3)
                        <p><strong>Link of the uploaded file:</strong></p>
                        <a href="{{ url(Storage::url($pageSetting->meta_value)) }}">{{ url(Storage::url($pageSetting->meta_value)) }}</a>
                    @endif   
                </div>
                <div class="clearfix"></div>
                <div class="col-lg-12 form-group">
                    <input type="submit" class="btn btn-success"  value="Save" />
                </div>
            </div>
        </form>
    </div>
@endsection
@push('scripts')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script> 
    <script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.js"></script>

    <script type="text/javascript">
        $('#editor').summernote({
            height: 300
        });

       $('#setting-type').on('change', function(){
            var settingType = $(this).val();

            if(settingType === 'image') {
                $('#image-setting-type').removeClass('hidden');
                $('#text-setting-type').addClass('hidden');
                $('#file-setting-type').addClass('hidden');
            }

            if(settingType === 'text') {
                $('#image-setting-type').addClass('hidden');
                $('#text-setting-type').removeClass('hidden');
                $('#file-setting-type').addClass('hidden');
            }

            if(settingType === 'file') {
                $('#text-setting-type').addClass('hidden');
                $('#image-setting-type').addClass('hidden');
                $('#file-setting-type').removeClass('hidden');
            }

       })
       $('#setting-type').trigger('change');
    </script>
@endpush
@include('partials.admin.footer')