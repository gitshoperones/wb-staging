@php
    $feature = $featured->where("meta_key", "featured_$i")->first();
@endphp
<div class="col-md-4 {{ ($feature || $editing === 'editOn') ? "" : "hide-mobile" }}">
    @if(($editing === 'editOff' && $feature)) <a href="{{ $feature->getFileUrl() }}" data-lightbox="featured-images"> @endif
        <div class="inner-feature tooltip-holder" {!! ($feature) ? "data-id=$feature->id data-url={$feature->getFileUrl()} data-position=\"{$feature->getFilePosition()}\"" : "" !!} data-featured="featured_{{ $i }}">
            @if($feature)
                @if ($editing === 'editOn')
                    <div class="tooltip-alt">
                        Drag the image to adjust the position
                    </div>
                    <div class="removeimage">
                        <i class="fa fa-close"></i>
                    </div>
                @endif
            @else
                @if ($editing === 'editOn')
                    <label for="featured-photos" class="btn btn-danger upload-featured">
                        Upload Now
                    </label>
                    <div class="progress progress-featured hidden" style="width: 100%;">
                        <div style="width: 100%;" id="progress-bar" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                            <span>Uploading...</span>
                        </div>
                    </div>
                @endif
            @endif

        </div>
    @if(($editing === 'editOff' && $feature)) </a> @endif
</div>
