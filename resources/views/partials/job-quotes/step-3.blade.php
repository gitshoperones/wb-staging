<div class="tab-pane" id="tab_step_3">
	<div>
		<div class="sub-header">
			ADD IMAGES TO SHOW THEM YOUR WORK
		</div>
		<br>
        <div class="row jq-gallery" id="job-quote-gallery">
            @if (isset($jobQuoteGallery))
                @foreach($jobQuoteGallery as $item)
                    <div class="col-md-4 jq-img jobImg updateQuote">
                        <div class="delImg" data-file="{{ $item->id }}">
                            <i class="fa fa-close fa-2x" style="color: #ff0000;"></i>
                        </div>
                        <img src="{{ Storage::url($item->meta_filename) }}" class="img-responsive" width="143" />
                    </div>
                @endforeach
            @endif
        </div>
        <div class="btn-block">
            <br/>
            <input type="file" id="add-photos" name="photos[]" class="hidden" multiple accept=".jpg, .png, .jpeg">
            <label id="addImageBtn" for="add-photos" class="btn wb-btn-white wb-btn-round-xs wb-btn-addons">
                <i class="fa fa-file-image-o"></i>
                UPLOAD IMAGE(S)
            </label>
            <label id="addFromProfile" class="btn wb-btn-white wb-btn-round-xs wb-btn-addons">
                <i class="fa fa-picture-o"></i>
                SELECT FROM PROFILE
            </label>
            <br/><br/>
        </div>
        <div class="sub-header">
            ADD OTHER SUPPORTING DOCUMENTS TO YOUR QUOTE (OPTIONAL)
        </div>
        <br>
        <div id="upload-files">
            @if (isset($jobQuote) && !$jobQuote->additionalFiles->isEmpty())
                @foreach($jobQuote->additionalFiles as $file)
                    <div class="quoteFile updateQuote" style="margin-bottom: 3px;">
                        <a href="{{ $file->meta_filename }}" targe="_blank" class="btn btn-default">
                            {{ $file->meta_original_filename }}
                        </a>
                        <span class="delFile" data-file="{{ $file->id }}">
                            <i class="fa fa-close fa-1x" style="color: #ff0000;"></i>
                        </span>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="btn-block">
            <br/>
            <input type="file" id="add-files" name="files[]" class="hidden" multiple accept=".txt,.pdf,.doc,.docx,.xlsx">
            <label id="addFileBtn" for="add-files" class="btn wb-btn-white wb-btn-round-xs wb-btn-addons">
                <i class="fa fa-file"></i>
                UPLOAD FILE(S)
            </label>
        </div>
	</div>
</div>

@include('modals.profile-gallery')

@push('scripts')
    <script type="text/javascript">
        var imagesPreview = function(input, placeToInsertImagePreview) {
            var previewWrapper = $(placeToInsertImagePreview);
            if (input.files) {
                var filesAmount = input.files.length;
                previewWrapper.find('.additional-item').remove();
                for (i = 0; i < filesAmount; i++) {
                    var reader = new FileReader(),
                        ind = 0;
                    reader.onload = function(event) {
                        if (input.id === 'add-files') {
                            previewWrapper.append(
                                `<div class="additional-item quoteFile" style="margin-bottom: 3px;">
                                    <a href="#" class="btn btn-default">${input.files.item(ind++).name}</a>
                                    <span class="delFile">
                                        <i class="fa fa-close fa-1x" style="color: #ff0000;"></i>
                                    </span>
                                </div>`
                            );
                        } else {
                            previewWrapper.append(
                                `<div class="col-md-4 jq-img jobImg additional-item">
                                    <div class="delImg">
                                        <i class="fa fa-close fa-2x" style="color: #ff0000;"></i>
                                    </div>
                                    <img src="${event.target.result}" class="img-responsive" width="143" />
                                </div>`
                            );
                        }
                    }
                    reader.readAsDataURL(input.files[i]);
                }
            }
        };

        function validateFileSize(input) {
            var max = 5000000;
            var valid = true;
            var filesAmount = input.files.length;

            for (i = 0; i < filesAmount; i++) {
                if (input.files[i].size > max) {
                    valid = false;
                    break;
                }
            }

            return valid;
        }

        function validateFileType(input) {
            var validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            var valid = true;
            var filesAmount = input.files.length;

            for (i = 0; i < filesAmount; i++) {
                if (!validTypes.includes(input.files[i].type)) {
                    valid = false;
                    break;
                }
            }

            return valid;
        }

        $('#add-photos').on('change', function() {
            if (! validateFileType(this)) {
                alert('The Image must be a file of type: jpeg, png.');
                $(this).val('');
                return false;
            }

            if (! validateFileSize(this)) {
                alert('Image size may not be greater than 5MB.');
                $(this).val('');
                return false;
            }

            $('div.gallery .additional-item').remove();
            imagesPreview(this, '#job-quote-gallery');
        });

        $('#add-files').on('change', function() {
            if (! validateFileSize(this)) {
                alert('This file is too large, please upload files no larger than 5MB in size.');
                $(this).val('');
                return false;
            }

            $('#upload-files .additional-item').remove();
            imagesPreview(this, '#upload-files');
        });
    </script>
@endpush
