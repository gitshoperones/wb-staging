@if (count($featured) > 0 || $editing === 'editOn')
<div class="wb-gallery featured {{ $editing }}">

	@if ($editing === 'editOn')
        <p>Add 6 of your best images to showcase your business</p>
        <br/>
    @endif
    
    <div class="row featured-images {{ count($featured->whereIn("meta_key", ["featured_1", "featured_2", "featured_3"])) || $editing == "editOn" ? $editing : "hide" }}">
        @for($i = 1; $i < 4; $i++)
            @include('partials.profiles.featured-images-upload')
        @endfor
    </div>
    
    <div class="row featured-images {{ count($featured->whereIn("meta_key", ["featured_4", "featured_5", "featured_6"])) || $editing == "editOn" ? $editing : "hide" }}">
        @for($i = 4; $i < 7; $i++)
            @include('partials.profiles.featured-images-upload')
        @endfor
    </div>
    
</div>
@endif

@if ($editing === 'editOn')

    <input id="featured-photos" type="file" name="featured" accept="image/*" class="hidden"/>
    @push('css')
        <style>
            .tooltip-holder .tooltip-alt {
                top: 0;
                padding: 10px;
            }
        </style>
    @endpush

@else

    @push('css')
        <link href="{{ asset('assets/js/simple-lightbox/css/lightbox.min.css') }}" rel="stylesheet" />
    @endpush

@endif

@push('scripts')
    @if ($editing === 'editOn')
        <script>
            ImageControl = function () {
                return function () {
                    this.init = function (args) {
                        var imageContainer, mainContainer, patternImage;
                        this.originalArgs = args;
                        mainContainer = $(args.container).css({
                            position: 'relative',
                            height: args.containerSize,
                            overflow: 'hidden' });

                        imageContainer = $('<div />').css({
                            width: '100%',
                            height: '100%',
                            top: '0',
                            position: 'absolute',
                            overflow: 'hidden',
                            cursor: 'move' });

                        patternImage = $('<div />').attr({
                            class: 'pattern-background-image' }).
                        css({
                            left: 0,
                            top: 0,
                            width: '100%',
                            height: '100%',
                            position: 'absolute',
                            'background-size': "cover",
                            'background-repeat': 'repeat',
                            'background-position': args.savedPosition,
                            'background-image': `url('${args.backgroundPattern}')` });

                        imageContainer.append(patternImage);
                        mainContainer.append(imageContainer);
                        this.patternImage = patternImage;
                        return imageContainer.on('mousedown touchstart', function (e) {
                            var containerSize, elepos, mousedown, patternBackground, patternBackgroundWidth;
                            e.preventDefault();
                            patternBackground = $(this).find('.pattern-background-image');
                            patternBackgroundWidth = patternBackground.width();
                            mousedown = {
                                x: e.originalEvent.pageX || e.originalEvent.touches[0].pageX,
                                y: e.originalEvent.pageY || e.originalEvent.touches[0].pageY };

                            elepos = {
                                x: parseFloat(patternBackground.css("backgroundPosition").split(" ")[0].replace('%', '')),
                                y: parseFloat(patternBackground.css("backgroundPosition").split(" ")[1].replace('%', '')) };

                            containerSize = parseInt(patternBackgroundWidth);
                            $(document).on('mouseup touchend', function (e) {
                                return $(document).unbind('mousemove touchmove');
                            });
                            return $(document).on('mousemove touchmove', function (e) {
                                var actualMovePercentage, mousepos, movePercentage;
                                mousepos = {
                                    x: e.originalEvent.pageX || e.originalEvent.changedTouches[0].pageX || mousedown.x,
                                    y: e.originalEvent.pageY || e.originalEvent.changedTouches[0].pageY || mousedown.y };

                                if (mousedown !== mousepos) {
                                    movePercentage = {
                                        x: 100 * (mousepos.x - mousedown.x) / patternBackgroundWidth,
                                        y: 100 * (mousepos.y - mousedown.y) / patternBackgroundWidth };

                                    actualMovePercentage = {
                                        x: 3 * movePercentage.x,
                                        y: 3 * movePercentage.y };

                                    patternBackground.css({
                                        'background-position': `${elepos.x - actualMovePercentage.x}% ${elepos.y - actualMovePercentage.y}%` });
                                }
                            });
                        });
                    };
                };
            }();

            var imageControl = new ImageControl();
            
            $('.inner-feature').each(function() {
                var element = $(this);

                if(element.data('id') !== undefined) {
                    imageControl.init({
                        container: '[data-featured="' + element.data('featured') + '"]',
                        containerSize: '200px',
                        savedPosition: element.data('position'),
                        backgroundPattern: element.data('url')
                    });
                }
            });

            var feature_wrapper = $('.featured-images'),
                featured_meta_key = null;

            feature_wrapper.on('click touchstart', '.removeimage', function(event){

                event.preventDefault();

                let featured = $(this).parents('.inner-feature'),
                    id = featured.attr('data-id');

                NProgress.start();

                axios.post('/media/'+ id, {
                    _method: 'DELETE'
                }).then(() => {
                    let upload_button = `<label for="featured-photos" class="btn btn-danger upload-featured">
                            Upload Now
                        </label>
                        <div class="progress progress-featured hidden" style="width: 100%;">
                            <div style="width: 100%;" id="progress-bar" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                <span>Uploading...</span>
                            </div>
                        </div>`

                    featured.html(upload_button);
                    featured.removeAttr('data-id')
                        .removeAttr('data-position')
                        .removeAttr('data-url')
                        .removeAttr('style');

                    NProgress.done();
                });
            });

            feature_wrapper.on('click', '.upload-featured', function(event){
                $('#featured-photos').val('');
                featured_meta_key = $(this).parents('.inner-feature').data('featured');
            });

            $('#featured-photos').change(function(e){
                let photos = [],
                    file = e.target.files[0],
                    validateType = validateFileType(file),
                    validateSize = validateFileSize(file);

                if (!validateType || !validateSize) {
                    return false;
                }

                photos.push(e.target.files[0]);
                toggleFeaturedProgress();
                compressFeatured(photos);
            })

            function compressFeatured(photos) {
                for(var i = 0; i < photos.length; i++) {
                    new ImageCompressor(photos[i], {
                        file: File,
                        quality: .8,
                        success(result) {
                            uploadFeaturedPhoto(result);
                        },
                        error(e) {
                        console.log(e.message);
                        },
                    });
                }
            }

            function uploadFeaturedPhoto(photo) {
                let formData = new FormData();
                formData.append('photo', photo);
                formData.append('meta_key', featured_meta_key);
                axios.post('{{ url('media') }}', formData, {
                    headers: {
                    'Content-Type': 'multipart/form-data',
                    }
                }).then(function(response) {
                    toggleFeaturedProgress();

                    if (response.data && response.data.id) {
                        let newFeatured = response.data,
                            inner_featured = $('.inner-feature[data-featured="' + featured_meta_key + '"]'),
                            featured_image = `<div class="removeimage">
                                    <i class="fa fa-close"></i>
                                </div>`;

                        inner_featured.html(featured_image)
                            .attr('data-id', newFeatured.id)
                            .attr('data-url', newFeatured.fileUrl)
                            .attr('data-position', '0%');
                        
                        imageControl.init({
                            container: inner_featured,
                            containerSize: '200px',
                            savedPosition: inner_featured.attr('data-position'),
                            backgroundPattern: inner_featured.attr('data-url')
                        });
                    }
                }).catch(function (error) {
                    toggleFeaturedProgress();
                });
            }

            function toggleFeaturedProgress() {
                let inner_featured = $('.inner-feature[data-featured="' + featured_meta_key + '"]');
                $('.upload-featured').toggleClass('hidden');
                inner_featured.find('.progress-featured').toggleClass('hidden');
            }

        </script>
    @else
        <script src="{{ asset('assets/js/simple-lightbox/js/lightbox.min.js') }}"></script>
        <script>
            $('.inner-feature').each(function() {
                var element = $(this);

                if(element.attr('data-id') !== undefined) {
                    element.css('background-image', `url(${element.data('url')})`)
                        .css('background-position', element.data('position'));
                }
            });

            lightbox.option({
                'wrapAround': true,
                'albumLabel': '',
            });
        </script>
    @endif
@endpush