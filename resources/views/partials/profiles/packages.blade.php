@if(count($userProfile->package) > 0 || $editing === 'editOn')
    <div id="wb-profile-packages">

        @if ($editing === 'editOff')

            <div class="text-center packages-panel">
                <div class="packages-header">
                    <p class="h2 head">AVAILABLE PACKAGES</p>
                    @foreach ($userProfile->package as $package)
                        <p><a href="{{ Storage::url($package->package_path) }}" target="_blank">
                                <span class="download-package {{ pathinfo($package->package_path, PATHINFO_EXTENSION) }}"></span>
                            </a>
                            <span>{{ $package->subheading }}</span></p>
                    @endforeach
                </div>
            </div>

        @else

            <div class="text-center packages-panel">
                <div class="packages-header">
                    <span class="h2 head">AVAILABLE PACKAGES</span>
                    <span class="tooltip-icon">
                        <span class="btn exoffers">
                            <i class="fa fa-question"></i>
                        </span>
                        <div class="tooltip-wrapper">
                            This is a space for you to upload any of your available packages, menus etc that you'd like couples to be able to view. Upload these in Word or PDF format.
                        </div>
                    </span>
                </div>

                @include('partials.profiles.packages-upload')

                <div class="package-container">
                    @foreach ($userProfile->package as $package)
                        <div class="package-item" data-media="{{ $package->media_id }}">
                            <p>{{ $package->filename }} <i class="fa fa-close removepackage" data-media="{{ $package->media_id }}"></i></p>
                            <input class="form-control" name="package" data-id="{{ $package->id }}" placeholder="Package title/detail" value="{{ $package->subheading }}"/>
                        </div>
                    @endforeach
                </div>
            </div>

        @endif

    </div>
@endif