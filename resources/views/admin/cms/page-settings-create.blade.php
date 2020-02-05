@extends('adminlte::page')
@include('partials.admin.header')
@section('title', 'Create Page')

@section('content')
    <div class="container">
        <h3>{{ $page->name }} </h3>
        <a href="{{ url(sprintf('admin/pages/%s/page-settings', $page->id)) }}" class="btn btn-info">View Settings</a>
        <form action="{{ url(sprintf('/admin/pages/%s/page-settings', $page->id)) }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="hidden" name="pageId" value="{{ $page->id }}">
            @include('partials.alert-messages')
            <div class="row">
                <div class="col-lg-4 form-group">
                    <label>Setting Key</label>
                    <input type="text" class="form-control" name="meta_key" value="{{ old('meta_key') }}" required>
                </div>
                <div class="clearfix"></div>
                <div class="col-lg-4 form-group">
                    <label>Setting Type</label>
                    <select class="form-control" name="meta_type" id="setting-type">
                        <option value="">Select Setting Type</option>
                        <option value="text">Text</option>
                        <option value="image">Image</option>
                        <option value="file">File</option>
                    </select>
                </div>
                <div class="clearfix"></div>
                <div class="col-lg-8 form-group hidden" id="text-setting-type">
                    <label>Add Text</label>
                    <textarea class="form-control" cols="5" rows="15" id="editor" name="meta_value_text"></textarea>
                </div>
                <div class="clearfix"></div>
                <div class="col-lg-4 form-group hidden" id="image-setting-type">
                    <label for="meta_value_image">Upload Image</label>
                    <input type="file" name="meta_value_image"/>
                </div>
                <div class="clearfix"></div>
                <div class="col-lg-4 form-group hidden" id="file-setting-type">
                    <label for="meta_value_file">Upload File</label>
                    <input type="file" name="meta_value_file"/>
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