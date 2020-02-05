<div class="tab-pane fade" id="step-4">
    <h1 class="title"> Upload Inspiration Photos </h1>
    <p class="btn-block text-primary">You can add a few photos to show businesses what you’re looking for.</p>
    <br>
    <div class="gallery updateJob">
        @if (isset($gallery))
            @foreach($gallery as $item)
                <div class="item jobImg updateJob">
                    <div class="delImg" data-file="{{ $item->id }}">
                        <i class="fa fa-close fa-2x" style="color: #ff0000;"></i>
                    </div>
                    <img src="{{ $item->getFileUrl() }}" class="img-responsive" width="143" />
                </div>
            @endforeach
        @endif
    </div>
    <div class="gallery"></div>
    <div class="btn-block">
        {{-- <div class="uploader__box js-uploader__box l-center-box">
            <div class="uploader__contents">
                <label class="button button--secondary" for="fileinput">Select Files</label>
                <input id="fileinput" class="uploader__file-input" type="file" multiple value="Select Files">
            </div>
        </div> --}}
        <input type="file" id="add-photos" name="photos[]" class="hidden" multiple />
        <label id="addImageBtn" for="add-photos" class="btn wb-btn-white wb-btn-round-xs wb-btn-addons">
            <span class="left-icon"><i class="fa fa-picture-o"></i></span>
            UPLOAD IMAGE(S)
        </label>
    </div>
    @if(request()->vendor_id)
        <div class="action-buttons">
            @if(Auth::user())
            <button type="submit" type="submit" name="status" value="0" class="btn wb-btn wb-btn-outline-default">SAVE AS DRAFT</button>
            @endif
            <a href="#" onClick="event.preventDefault(); moveToStep('step-5-section');" class="btn wb-btn wb-btn-primary">Next Step</a>
        </div>
    @else
        @if(Auth::user())
        <div class="action-buttons">
            <button type="submit" type="submit" name="status" value="0" class="btn wb-btn wb-btn-outline-default">SAVE AS DRAFT</button>
            <button id="{{ (request()->vendor_id) ? "submit-quote-request" : "submit-job-post"}}" type="submit" name="status" value="{{ (isset($jobPost) && $jobPost->status === 1) ? 1 : 5 }}" class="btn wb-btn wb-btn-primary {{ isset($btnLbl) ? "submit-quote-request" : "thank-you" }}">
                {{ isset($btnLbl) ? $btnLbl : 'Post Job'}}
            </button>
        </div>
        @else
        <div class="action-buttons">
            <a href="#" onClick="event.preventDefault(); moveToStep('step-5-section');" class="btn wb-btn wb-btn-primary">Next Step</a>
        </div>
        @endif
    @endif
</div>
