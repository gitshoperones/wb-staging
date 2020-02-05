<div id="wb-expertise" class="wb-expertise text-center {{ $editing }}">
	@couple
	   <favorite-vendor vendor-id="{{ $userProfile->id }}" favorited="{{ $isFavorite }}"></favorite-vendor>
	@endcouple
	<div class="wrapper2">
        <div>
            @if ($editing === 'editOff')
                <span class="expertise-title">SERVICES</span>
                <br/>
                <span class="tag">{{ collect($userProfile['expertise'])->implode('name', ' | ') }} </span>
                <br/>
                @if (count($userProfile['propertyTypes']) > 0)
                    <br/>
                    <span class="expertise-title">PROPERTY TYPES</span>
                    <br/>
                    <span class="tag">{{ collect($userProfile['propertyTypes'])->implode('name', ' | ') }} </span>
                    <br/>
                    <br/>
                @endif
                @if (count($userProfile['propertyFeatures']) > 0)
                    <span class="expertise-title">PROPERTY FEATURES</span>
                    <br/>
                    <span class="tag">{{ collect($userProfile['propertyFeatures'])->implode('name', ' | ') }} </span>
                    <br/>
                @endif
            @else
                @if($userProfile->user->status == 'active')
                    <div class="services-select">
                        <span class="tag" style="color: #7b7b7b;">{{ collect($userProfile['expertise'])->implode('name', ', ') }} </span>
                        <p class="expertise-title">BUSINESS SERVICES</p>
                    </div>
                    @push('scripts')
                    <script>
                        $('div[property-capacity] .selectdropdown').first().addClass('hide');
                    </script>
                    @endpush
                @endif

                <vendor-services
                vendor-expertises="{{ json_encode($userProfile['expertise']->pluck('name')->toArray()) }}"
                expertises="{{ json_encode($categories->pluck('name')->toArray()) }}"
                property-types="{{ json_encode($propertyTypes->pluck('name')->toArray()) }}"
                vendor-property-types="{{ json_encode($userProfile['propertyTypes']->pluck('name')->toArray()) }}"
                property-features="{{ json_encode($propertyFeatures->pluck('name')->toArray()) }}"
                property-capacity="{{ $userProfile->venueCapacity->capacity }}"
                vendor-property-features="{{ json_encode($userProfile['propertyFeatures']->pluck('name')->toArray()) }}"
                >
                </vendor-services>
            @endif
        </div>
        <div class="cover-location location">
            @if ($editing === 'editOn')
                <!-- <vendor-service-locations locations="{{ json_encode($locationsByState) }}"
                    query="{{ json_encode(isset($userProfile['locations']) ? collect($userProfile['locations'])->pluck('name') : [])  }}">
                </vendor-service-locations> -->
                <div class="loc-value editOn">
                    <div>
                        <dl class="selectdropdown">
                            <dt>
                                <a href="#" class="dropdown">
                                    <div class="expertise-title"><i class="fa fa-map-marker"></i> SERVICE REGIONS</div>
                                    <div class="resizing-input editOn">
                                    <p class="multiSel" id="vendor-category-selection">
                                        @if(count($userProfile->locations->pluck('name')) > 0)
                                            @foreach($userProfile->locations->pluck('name') as $location)
                                            <span title="{{ $location }}">{{ $location }},</span>
                                            @endforeach
                                        @endif
                                    </p>
                                    </div>
                                    <span class="btn wb-btn-orange mini dropdown">
                                        Edit Your Service Locations
                                    </span>
                                </a>
                            </dt>
                            <dd>
                                <div class="mutliSelect">
                                    <ul>
                                        @foreach ($locationsByState as $states)
                                            @foreach ($states as $key1 => $locs)
                                            <li class="statename">
                                                <div class="toggleLocations text-primary">
                                                    {{ $key1 }} <i class="fa fa-plus"></i>
                                                </div>
                                                <ul class="stateunder">
                                                    @foreach ($locs as $key2 => $loc)
                                                    <li>
                                                    <input class="vendor-service-locations" type="checkbox"
                                                    @if((is_array($userProfile->locations->pluck('name')->toArray()) && (in_array($loc['name'], $userProfile->locations->pluck('name')->toArray()))))
                                                    checked
                                                    @endif
                                                    name="locations[]"
                                                    id="loc{{ $key1.$key2 }}"
                                                    value="{{ $loc['name'] }}" />
                                                    <label for="loc{{ $key1.$key2 }}">{{ $loc['name'] }}</label>
                                                    </li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                            @endforeach
                                        @endforeach
                                    </ul>
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            @else
                <div class="loc-value {{ $editing }}">
    	           <span class="icon">
                        <i class="fa fa-map-marker"></i>
                    </span>
                    <span class="expertise-title">SERVICE LOCATIONS</span>
                    <br/>
                    <span class="tag">
                        {{
                            collect($userProfile['locations'])
                                ->map(function ($item) {
                                    return ['d' => $item['name']];
                                })->implode('d', ', ')
                        }}
                    </span>
                </div>
            @endif
        </div>
        @if ($editing === 'editOn')
            <div class="packages">
                <div class="expertise-title"><img src="/assets/images/icons/dollar.png" style="max-width: 20px; margin-bottom: 3px;" alt=""> PACKAGES FROM</div>
                <input type="number" name="packages_price" class="form-control mw-250" id="packages_price" value="{{ $userProfile->packages_price }}"/>
            </div>
            <br/>
        @else
            @if($userProfile->packages_price !== null && $userProfile->packages_price > 0)
                <br/>
                <div class="packages">
                    <div class="expertise-title"><img src="/assets/images/icons/dollar.png" style="max-width: 20px; margin-bottom: 3px;" alt=""> PACKAGES FROM</div>
                    <span style="font-weight: 300;">$ {{ $userProfile->packages_price }}</span>
                </div>
            @endif
        @endif

        @if ($editing === 'editOn')
            <div class="guest-capacity">
                <div class="expertise-title"><i class="fa fa-users"></i> GUEST CAPACITY</div>
                <input type="number" id="venueCapacity" class="form-control mw-250" value="{{ $userProfile->venueCapacity->capacity }}">
            </div>
        @else
            @if ( intval($userProfile->venueCapacity->capacity) > 0)
                <br/>
                <div class="guest-capacity">
                    <div class="expertise-title"><i class="fa fa-users"></i> GUEST CAPACITY</div>
                    <span style="font-weight: 300;">{{ $userProfile->venueCapacity->capacity }}</span>
                </div>
            @endif
        @endif
    </div>
    @auth
        @couple
            <a href="{{ url(sprintf('dashboard/job-posts/create?vendor_id=%s', $userProfile->id)) }}" class="btn btn-orange">
                Request Quote
            </a>
        @endcouple
    @else
        <a href="{{ '/job-posts/create?vendor_id=' . $userProfile->id }}" class="btn btn-orange request-quote">Request Quote</a>
    @endif

</div>

@push('css')
<style>
    .wrapper2 {
        max-width: 600px;
        text-align: center;
        margin: auto auto 14px;
    }
    .wrapper2 > div:first-child {
        max-width: 600px;
        width: 100%;
        overflow-y: unset;
        margin: 0 auto auto;
        font-weight: 300; margin-bottom: 20px;
    }
    .expertise-title {
        font-size: 13px;
    }
    
    .loc-value .selectdropdown {
        width: 100%;
    }

    .loc-value dt {
        max-width: 600px;
        margin: auto;
    }

    .loc-value a.dropdown {
        min-height: 58px;
        text-align: center;
    }

    .loc-value span.dropdown {
        color: #fff;
    }

    .loc-value dd {
        max-width: 400px;
        margin: auto;
    }

    .loc-value span.icon {
        margin-right: 5px;
    }
    .expertise-title .fa, .loc-value .icon .fa {
        font-size: 18px;
        margin-right: 3px;
    }
</style>
@endpush