<div class="package-upload-button">
    <input id="package-document" type="file" name="package_document" accept=".pdf, .doc, .docx" class="hidden"/>
    <input type="hidden" name="meta_key" value="package" class="hidden">
    <label for="package-document" class="btn btn-danger" id="package-trigger" style="margin-bottom: 10px; {{ (count($userProfile->package) > 2) ? 'display: none;': '' }}">
    Add package(PDF/Word) document
    </label>
</div>
<div class="progress hidden" id="progress-package">
    <div style="width: 100%;" id="progress-bar" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
        <span>Uploading...</span>
    </div>
</div>

@push('scripts')
<script type="text/javascript">
    var totalPackages = {{ count($userProfile->package) }};

    $('#package-trigger').on('click', function(){
        $('#package-document').val('');
    });

    var Upload = function (file) {
        this.file = file;
    };

    Upload.prototype.getType = function() {
        return this.file.type;
    };
    Upload.prototype.getSize = function() {
        return this.file.size;
    };
    Upload.prototype.getName = function() {
        return this.file.name;
    };
    
    Upload.prototype.doUpload = function () {
        var that = this;
        var formData = new FormData();

        // add assoc key values, this will be posts values
        formData.append("package_document", this.file);
        formData.append("filename", this.file.name);
        formData.append('meta_key', 'package');
        formData.append('_token', '{{ csrf_token() }}');

        $.ajax({
            type: "POST",
            url: "{{ url('package') }}",
            xhr: function () {
                var myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) {
                    myXhr.upload.addEventListener('progress', that.progressHandling, false);
                }
                return myXhr;
            },
            success: function (data) {
                if(++totalPackages > 2) {
                    $('#package-trigger').hide();
                }
                var package_item = `<div class="package-item" data-media="${data.media_id}">
                            <p>${data.filename} <i class="fa fa-close removepackage" data-media="${data.media_id}"></i></p>
                            <input class="form-control" name="package" data-id="${data.id}" placeholder="Package title/detail" value=""/>
                        </div>`;
                $('.package-container').append(package_item);
                $('#progress-package').addClass('hidden');
            },
            error: function (error) {
                // handle error
            },
            async: true,
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            timeout: 60000
        });
    };

    Upload.prototype.progressHandling = function (event) {
        $('#progress-package').removeClass('hidden');
    };

    $("#package-document").on("change", function (e) {
        var file = $(this)[0].files[0],
            upload = new Upload(file),
            extensions = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
            max = 5000000;
            
        if(!extensions.includes(upload.getType())) {
            alert('The file must be of type: pdf, doc, and docx.');
            
            return false;
        }

        if(upload.getSize() > max) {
            alert('Your file is too large. The max file size is 5mb, please reduce your file size before uploading.');

            return false;
        }

        upload.doUpload();
    });

    $(document).on('click', '.removepackage', function(){
        var media_id = $(this).data("media");
        
		NProgress.start();

        $.ajax({
            type: "DELETE",
            url: "{{ url('package') }}/" + media_id,
            dataType: "JSON",
            async: true,
            data: {
                _token: '{{ csrf_token() }}',
                _method: 'DELETE',
                media_id: media_id,
            },
            success: function (data) {
                $('.package-item[data-media="' + media_id + '"]').remove();
                
                if(--totalPackages < 3) {
                    $('#package-trigger').show();
                }

                NProgress.done();
            },
            error: function (error) {
                // handle error
            },
        });
    });
</script>
@endpush