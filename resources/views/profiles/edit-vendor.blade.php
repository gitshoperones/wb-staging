@extends('layouts.public')

@section('top-content')
    @include('partials.edit-alert')
@endsection

@section('content')
<div class="wb-bg-grey">
    <div class="container">
        @include('partials.alert-messages')
        <div id="wb-dashboard">
            <form id="edit-user-form"
                action="{{ url(sprintf('/%ss/%s', Auth::user()->account, $userProfile->id)) }}"
                method="POST"
                enctype="multipart/form-data">
                {{ csrf_field() }}
                <input name="_method" type="hidden" value="PATCH">
                @include('partials.profiles.vendor-header')

                @include('partials.profiles.expertise')

                @include('partials.profiles.featured-images')

                @include('partials.profiles.offers')

                @include('partials.profiles.description')

                @include('partials.profiles.packages')
                
                @include('partials.profiles.gallery')
                
                @include('partials.profiles.videos-upload')

				@include('partials.profiles.vendor-location')

            </form>
        </div>
    </div>
</div>
@if(session()->has('success_review'))
    @include('modals.success-modal', [
        'header' => '',
        'message' => session('success_review'),
    ])
@endif
@endsection

@push('css')
<style>
    input.form-control, textarea.form-control {
        border: 1px solid #ccd0d2;
        margin-bottom: 3px;
        resize: none;
    }
    input.mw-250 {
        max-width: 250px;
        margin: auto;
    }
    input.form-control:focus, textarea.form-control:focus {
        border-color: #6868a0;
    }
    .wb-notes-dashboard, #wb-dashboard .wb-gallery.editOn, .wb-profile-videos {
        padding: 55px 55px 65px;
        background-color: #fcfaf7;
    }
    #wb-dashboard .wb-gallery.editOn, #wb-dashboard .wb-gallery.editOn .grid {
        background-color: #e7d8d1;
        margin-top: 0;
    }
    .wb-cover div.name, .wb-cover-couple div.name, .wb-cover-vendor div.name, .wb-cover-quote div.name {
        font-size: unset;
        color: unset;
        text-transform: unset;
        font-weight: unset;
    }
    .wb-cover-vendor .name span.editOff {
        font-size: 23px;
        color: #fff;
        text-transform: uppercase;
        font-weight: 700;
    }

    @media ( max-width: 420px ) {
        .gallery-sort {
            font-size: 10px;
        }
    }
</style>
@endpush

@push('scripts')
<script src="{{ asset('assets/js/image-compressor/image-compressor.min.js') }}"></script>
<link href="{{ asset('assets/js/cropperjs/croppie.css') }}" rel="stylesheet" />
<script src="{{ asset('assets/js/cropperjs/croppie.min.js') }}"></script>
<script src="{{ asset('assets/js/exif.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var profileBlob, coverBlob;

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

        $('#profile-cover').on('change', function(){
            if (! validateFileType(this)) {
                return false;
            }

            if (! validateFileSize(this)) {
                return false;
            }

            readFile(this, $('#user-profile-wrapper'), 'set');

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
                compressImage(blob, 'avatar');
            });
            $('#photo-cropper-section').addClass('hidden-cropper');
        })

        function compressImage(image, type) {
            new ImageCompressor(image, {
                file: Blob,
                quality: .8,
                success(result) {
                    var urlCreator = window.URL || window.webkitURL;
                    var imageUrl = urlCreator.createObjectURL(result);
                    if(type == 'avatar') {
                        $('#avatar').attr('src', imageUrl);
                        profileBlob = result;
                    }else {
                        $('#user-profile-wrapper').css('background-image', 'url('+imageUrl+')');
                        coverBlob = result;
                    }
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
                        previewEl.css('background-image', 'url('+e.target.result+')');
                        var blob = b64toBlob(e.target.result);
                        compressImage(blob, 'cover');
                    }
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function b64toBlob(dataURI) {
            var byteString = atob(dataURI.split(',')[1]);
            var ab = new ArrayBuffer(byteString.length);
            var ia = new Uint8Array(ab);

            for (var i = 0; i < byteString.length; i++) {
                ia[i] = byteString.charCodeAt(i);
            }

            return new Blob([ab], { type: 'image/jpeg' });
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

        $('#saveBtn').on('click', function(e){
            e.preventDefault();
            NProgress.start();
            submit();
        })

        function submit() {
            var formData = new FormData();
            if (profileBlob) {
                formData.append('profile_avatar', profileBlob);
            }
            
            if (coverBlob) {
                formData.append('profile_cover', coverBlob);
            }

            formData.append('desc', window.profileDescription);

            var hasVenues = false;
            var exp = [];
            $('.vendor-expertise:checkbox:checked').each(function () {
                var valExp =$(this).val();
                if (valExp === 'Venues') {
                    hasVenues = true;
                }
                exp.push(valExp);
            });
            formData.append('expertises', JSON.stringify(exp));

            var propTypes = [];
            $('.vendor-property-types:checkbox:checked').each(function () {
                propTypes.push($(this).val());
            });
            formData.append('propertyTypes', JSON.stringify(hasVenues ? propTypes : []));

            var propertyFeatures = [];
            $('.vendor-property-features:checkbox:checked').each(function () {
                propertyFeatures.push($(this).val());
            });
            formData.append('propertyFeatures', JSON.stringify(hasVenues ? propertyFeatures : []));

            var loc = [];
            $('.vendor-service-locations:checkbox:checked').each(function () {
                loc.push($(this).val());
            });
            formData.append('locations', JSON.stringify(loc));

            if (window.galleryReordered && window.gallerySorting) {
                formData.append('gallerySorting', JSON.stringify(window.gallerySorting));
            }

            $('.card-wrapper .image-caption').each(function(i, item) {
                window.galleryCaptions.push({
                    itemId: $(item).data('id'),
                    caption: $(item).val()
                });
            });

            formData.append('galleryCaptions', JSON.stringify(window.galleryCaptions));

            $('.inner-feature').each(function(i, item) {
                if($(item).attr('data-id') !== undefined) {
                    window.featuredPositions.push({
                        itemId: $(item).data('id'),
                        background_position: $(item).find('.pattern-background-image').css('background-position')
                    });
                }
            });

            formData.append('featuredPositions', JSON.stringify(window.featuredPositions));

            $('#image-wrapper-sort .card-image').each(function(i, item) {
                if($(item).attr('data-id') !== undefined) {
                    window.galleryPositions.push({
                        itemId: $(item).data('id'),
                        background_position: $(item).find('.pattern-background-image').css('background-position')
                    });
                }
            });
            
            formData.append('galleryPositions', JSON.stringify(window.galleryPositions));

            var videos = [];
            $('input[name="embedded_video[]"]').map(function() {
                videos.push($(this).val());
            });

            var packages_array = [];
            $('input[name="package"]').map(function() {
                var pack = {
                        id: $(this).data("id"),
                        value: $(this).val()
                    };
                packages_array.push(pack);
            });
            
            var no_end_date = ($('input[name="no_end_date"]').is(':checked')) ? 1 : 0 ;
            
            formData.append('venue_capacity', $('#venueCapacity').val());
            formData.append('packages_price', $('#packages_price').val());
            formData.append('heading', $('input[name="heading"]').val());
            formData.append('description', $('textarea[name="description"]').val());
            formData.append('end_date', $('input[name="end_date"]').val());
            formData.append('no_end_date', no_end_date);
            formData.append('vendor_location', 1);
            formData.append('lat', $('input[name="lat"]').val());
            formData.append('lng', $('input[name="lng"]').val());
            formData.append('address', $('input[name="address"]').val());
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('_method', 'PATCH');
            formData.append('embedded_video', videos);
            formData.append('packages', JSON.stringify(packages_array));
            $.ajax($('#edit-user-form').attr('action'), {
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (res) {
                    window.location = "{{ url(sprintf('%ss/%s%s', Auth::user()->account, $userProfile['id'], request('status') ? '?status='.request('status') : '')) }}";
                },
                error: function () {
                    NProgress.done();
                },
                complete: function () {
                    window.featuredPositions = [];
                    window.galleryPositions = [];
                    window.galleryCaptions = [];
                    window.gallerySorting = [];
                    window.galleryReordered = false;
                    NProgress.done();
                },
            });
        }
    });
</script>
@endpush