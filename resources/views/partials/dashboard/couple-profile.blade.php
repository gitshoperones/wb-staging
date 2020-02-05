<div class="mini-wb-profile-box wb-profile-box box box-widget couple">
    <label for="profile-avatar">
        <span class="edit-icon"><i class="fa fa-pencil"></i></span>
    </label>
    <div class="profile-img">
        <a href="#" class="myprofile btn wb-btn-glass-white">
            <label id="editImageBtn" for="profile-avatar">
                Update profile picture
            </label>
        </a>
        <input type="file" id="profile-avatar" name="profile_avatar" class="hidden" accept=".png, .jpg, .jpeg">
        <img id="avatarImg"
            height="120px" width="120px" alt="no image"
            @if ($loggedInUserProfile->profile_avatar)
                src="{{ $loggedInUserProfile->profile_avatar }}"
            @else
                src="{{ asset('/assets/images/couple-placeholder.jpg') }}"
            @endif
        class="img-square editOff">
    </div>
    <div class="name">
        {{ $loggedInUserProfile->title }}
    </div>
</div>
<div id="photo-cropper-section" class="photo-cropper hidden-cropper">
    <div class="cropper-container">
        <div class="row">
            <div class="col-md-12">
                <div id="croppie-image"></div>
                <button type="button" id="crop-image-btn" class="btn btn-orange" id="crop">Crop</button>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script src="{{ asset('assets/js/image-compressor/image-compressor.min.js') }}"></script>
<link href="{{ asset('assets/js/cropperjs/croppie.css') }}" rel="stylesheet" />
<script src="{{ asset('assets/js/cropperjs/croppie.min.js') }}"></script>
<script src="{{ asset('assets/js/exif.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#editImageBtn, #crop-image-btn').on('click', function(e) {
            $('body').toggleClass('crop_active');
        });

        $('#photo-cropper-section').on('click', function(e) {
            if (e.target !== this) {
                return;
            }

            $('#photo-cropper-section').addClass('hidden-cropper');
        })

        var croppieInstance = $('#croppie-image').croppie({
            viewport: {
                width: 400,
                height: 400,
            },
            enableExif: true,
            enableZoom: true,
        });

        $('#profile-avatar').on('change', function(){
            if (! validateFileType(this)) {
                return false;
            }

            if (! validateFileSize(this)) {
                return false;
            }
            $('#photo-cropper-section').removeClass('hidden-cropper');

            readFile(this, croppieInstance, 'crop');
        })

        $('#crop-image-btn').on('click', function(e){
            e.preventDefault();
            croppieInstance.croppie('result').then(function(blob) {
                $('#avatar').attr('src', blob);
            });
            croppieInstance.croppie('result', {
                type: 'blob',
                size: 'viewport',
                format: 'jpeg'
            }).then(function(blob) {
                compressImage(blob);
            });
            $('#photo-cropper-section').addClass('hidden-cropper');
        })

        function compressImage(image) {
            new ImageCompressor(image, {
                file: Blob,
                quality: .8,
                success(result) {
                    var urlCreator = window.URL || window.webkitURL;
                    var imageUrl = urlCreator.createObjectURL(result);
                    $('#avatarImg').attr('src', imageUrl);
                    submit(result)
                },
                error(e) {
                  console.log(e.message);
                },
            });
        }

        function readFile(input, previewEl, type) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    if (type === 'crop') {
                        previewEl.croppie('bind', {
                            url: e.target.result
                        });
                    } else {
                        previewEl.attr('src', e.target.result);

                    }
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function validateFileSize(input) {
            var max = 10000000;
            var valid = true;
            var filesLength = input.files.length;

            for (i = 0; i < filesLength; i++) {
                if (input.files[i].size > max) {
                    valid = false;
                    break;
                }
            }

            if (!valid) {
                alert('Image size may not be greater than 10MB.');
            }

            return valid;
        }

        function validateFileType(input) {
            var validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            var valid = true;
            var filesLength = input.files.length;

            for (i = 0; i < filesLength; i++) {
                if (!validTypes.includes(input.files[i].type)) {
                    valid = false;
                    break;
                }
            }

            if (!valid) {
                alert('The Image must be a file of type: jpeg, png.');
            }

            return valid;
        }

        function submit(profileBlob) {
            var formData = new FormData();
            NProgress.start();

            if (profileBlob) {
                formData.append('profile_avatar', profileBlob);
            }
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('_method', 'PATCH');
            $.ajax('/dashboard/update-couple-avatar', {
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (res) {
                },
                error: function () {
                    NProgress.done();
                },
                complete: function () {
                    NProgress.done();
                },
            });
        }
    });
</script>
@endpush

