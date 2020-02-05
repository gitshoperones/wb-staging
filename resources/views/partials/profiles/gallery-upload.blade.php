<input id="gallery-photos" type="file" name="photo[]" accept="image/*" class="hidden"/>
<input type="hidden" name="meta_key" value="gallery" class="hidden">
<label for="gallery-photos" class="btn btn-danger" id="upload-trigger">
    @vendor
        Add images of your work
    @endvendor
    @couple
        add images to show your wedding look & feel
    @endcouple
</label>
<a class="btn btn-danger gallery-sort">Edit images</a>
<br/>
<br/>
<div class="progress hidden" id="progress">
    <div style="width: 100%;" id="progress-bar" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
        <span>Uploading...</span>
    </div>
</div>
<div class="card-wrapper hide" id="image-wrapper-sort">
    @foreach ($gallery as $photo)
        <div class="card" data-id="{{ $photo->id }}">
            <div class="item">
                <div class="sortHandle tooltip-holder">
                    <i class="fa fa-bars"></i>
                    <div class="tooltip-alt">
                        Drag the images up and down to sort their order
                    </div>
                </div>
                <div class="card-image tooltip-holder" {!! "data-id=$photo->id data-url={$photo->getFileUrl()} data-position=\"{$photo->getFilePosition()}\"" !!}>
                    <div class="tooltip-alt">
                        Drag the image to adjust its position
                    </div>
                </div>
                <div class="removeimage"
                    data-id="{{ $photo->id }}">
                    <i class="fa fa-close"></i>
                </div>
                <input type="text" class="form-control image-caption" data-id="{{ $photo->id }}" placeholder="Insert your caption here" value="{{ $photo->getFileCaption() }}"/>
            </div>
        </div>
    @endforeach
</div>

@push('scripts')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ asset('assets/js/jquery.ui.touch-punch.min.js') }}"></script>
<script type="text/javascript">
    var image_wrapper = $('#image-wrapper'),
        sort_wrapper = $('#image-wrapper-sort');

    window.galleryCaptions = [];
    window.featuredPositions = [];
    window.galleryPositions = [];
	window.galleryReordered = false;
    
    sort_wrapper.on('change', '.image-caption', function(){
        image_wrapper.find('.card[data-id="' + $(this).attr('data-id') + '"] .caption').text($(this).val());
    });

    $('#image-wrapper-sort .card-image').each(function() {
        var element = $(this);

        if(element.data('id') !== undefined) {
            imageControl.init({
                container: '#image-wrapper-sort .card-image[data-id="' + element.data('id') + '"]',
                containerSize: '300px',
                savedPosition: element.data('position'),
                backgroundPattern: element.data('url')
            });
        }
    });

    window.getItemsCurrentOrder = function() {
		window.gallerySorting = [];

		var items = sort_wrapper.find('.card');

		$(items).each(function(i, itemElem ) {
			if ($(itemElem).find('.image-caption').data('id')) {
				window.gallerySorting.push({
					itemId: $(itemElem).find('.image-caption').data('id'),
					order: i + 1
				});
			}
		});
	}

    $.fn.extend({
        toggleText: function(a, b){
            return this.text(this.text() == b ? a : b);
        }
    });

    $('.gallery-sort').click(function() {
        $(this).toggleText('Edit images', 'Preview gallery');
        $('#image-wrapper-sort').toggleClass('hide');
        $('#image-wrapper').toggleClass('hide');
    });

    sort_wrapper.sortable({
        handle: '.sortHandle',
        update: function(event, ui) {
            window.galleryReordered = true;
            getItemsCurrentOrder();
        }
    });
    
    sort_wrapper.disableSelection();

    sort_wrapper.on('click touchstart', '.removeimage', function(event){
        event.preventDefault();
        let photoId = $(this).data('id');
        NProgress.start();
        axios.post('/media/'+ photoId, {
            _method: 'DELETE'
        }).then(() => {
            if(!isSlickLoaded)
                initSlick();

            image_wrapper.slick('destroy');
            image_wrapper.find('.card[data-id="' + photoId + '"]').remove();

            initSlick();

            sort_wrapper.find('.card[data-id="' + photoId + '"]').remove();

            NProgress.done();
        });
    });

    $('#upload-trigger').on('click', function(){
        $('#gallery-photos').val('');
        window.totalPhotos = 0;
    });

    $('#gallery-photos').change(function(e){
        totalPhotos = e.target.files.length;
        var photos = [];

        if (totalPhotos > 0) {
            for(i = 0; i < totalPhotos; i++){
                var file = e.target.files[i];
                var validateType = validateFileType(file);
                var validateSize = validateFileSize(file);

                if (!validateType || !validateSize) {
                    return false;
                }

                photos.push(e.target.files[i]);
            }

            totalPhotos = photos.length;

            if (photos.length > 0) {
                toggleProgressBar();
                compressImage(photos);
            }
        }
    })

    function validateFileSize(file) {
        var max = 10000000;
        var valid = true;

        if (file.size > max) {
            valid = false;
       }

       if (!valid) {
            alert('Image size may not be greater than 10MB.');
       }

        return valid;
    }

    function validateFileType(file) {
        var validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        var valid = true;

        if (!validTypes.includes(file.type)) {
            valid = false;
        }

        if (!valid) {
            alert('The Image must be a file of type: jpeg, png.');
        }

        return valid;
    }

    function compressImage(photos) {
        for(var i = 0; i < photos.length; i++) {
            new ImageCompressor(photos[i], {
                file: File,
                quality: .8,
                success(result) {
                    uploadGalleryPhoto(result);
                },
                error(e) {
                  console.log(e.message);
                },
            });
        }
    }

    function uploadGalleryPhoto(photo) {
        var formData = new FormData();
        formData.append('photo', photo);
        formData.append('meta_key', 'gallery');
        axios.post('{{ url('media') }}', formData, {
            headers: {
              'Content-Type': 'multipart/form-data',
            }
        }).then(function(response) {
            done();

            if (response.data && response.data.id) {
                var newFile = response.data;
                
                var galleryItem = `<div class="card" data-id="${newFile.id}">
                        <div class="item">
                            <div class="card-image" data-id="${newFile.id}" data-url="${newFile.fileUrl}" data-position="0% 0%">
                                <p class="caption"></p>
                            </div>
                        </div>
                    </div>`,
                    
                    galleryItemSort = `<div class="card" data-id="${newFile.id}">
                        <div class="item">
                            <div class="sortHandle tooltip-holder">
                                <i class="fa fa-bars"></i>
                                <div class="tooltip-alt">
                                    Drag the images up and down to sort their order
                                </div>
                            </div>
                            <div class="card-image tooltip-holder" data-id="${newFile.id}" data-url="${newFile.fileUrl}" data-position="0% 0%">
                                <div class="tooltip-alt">
                                    Drag the image to adjust its position
                                </div>
                            </div>
                            <div class="removeimage"
                                data-id="${newFile.id}">
                                <i class="fa fa-close"></i>
                            </div>
                            <input type="text" class="form-control image-caption" data-id="${newFile.id}" placeholder="Insert your caption here" value=""/>
                        </div>
                    </div>`;

                if(image_wrapper.find(".card").length > 0) {
                    if(!isSlickLoaded)
                        initSlick();

                    image_wrapper.slick('destroy')
                    image_wrapper.append(galleryItem);

                    initSlick();
                }else {
                    image_wrapper.append(galleryItem);
                    
                    image_wrapper.find(".card .item").show();
                }

                sort_wrapper.append(galleryItemSort);

                var element = $('#image-wrapper-sort .card-image[data-id="' + newFile.id + '"]');

                imageControl.init({
                    container: element,
                    containerSize: '300px',
                    savedPosition: element.attr('data-position'),
                    backgroundPattern: element.attr('data-url')
                });
                updateSliderImage();
                updateSortImage();
            }
        }).catch(function (error) {
            done();
        });
    }

    function done() {
        totalPhotos -= 1;

        if (totalPhotos === 0) {
            toggleProgressBar();
        }
    }

    function toggleProgressBar() {
        $('#progress').toggleClass('hidden');
    }
    
</script>
@endpush