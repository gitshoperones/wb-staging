<div class="col-md-6">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Identification Documents</h3>
        </div>
        <form role="form"
            method="POST"
            action="{{ url(sprintf('/admin/upload-user-files/%s', $userDetails->id)) }}"
            enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="box-body">
                <div class="form-group">
                    <input type="file" name="user_file" id="user-file">
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            <div class="box-footer">
            @foreach($adminUploadedUserFiles as $file)
                <a class="btn btn-default" target="_blank" href="{{ $file->meta_filename }}">
                    {{ $file->meta_original_filename }}
                </a>
            @endforeach
            </div>
        </form>
    </div>
</div>