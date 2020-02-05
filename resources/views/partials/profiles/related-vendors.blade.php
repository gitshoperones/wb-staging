@if(count($vendors))
    <section class="related-vendors section-suppliers-venues venues-search text-center" style="padding: 40px 0px;">
        <div class="container">
            <div class="section-content">
                <header class="section-header">
                    <p class="h2 head">{{ ($result = $vendorProfile->firstWhere('meta_key', "related_vendors_title")) ? strip_tags($result->meta_value) : 'You might also like these businesses...' }}</p>
                </header>
                <div class="section-item venues-search text-left">
                    <div class="items" style="margin-top: 40px;">
                        @foreach($vendors as $vendor)
                        <div class="item">
                            <div class="user-card">
                                <div class="card-image vendor-profile"
                                    data-link="{{ url(sprintf('vendors/%s', $vendor->id)) }}"
                                    style="background-image: url({{ $vendor->profile_avatar }});">
                                </div>
                                <div class="card-body" style="{{ (isset($vendor->offer) && ((!$vendor->offer->heading==null || !$vendor->offer->description==null) && ($vendor->offer->end_date === null || \Carbon\Carbon::parse($vendor->offer->end_date) > now()->subDays(1)))) ? "background-image: url('/assets/images/wedbooker-offer.png')" : "" }}">
                                    <div class="desc text-case-up text-color-primary">
                                        <a href="{{ url(sprintf('vendors/%s', $vendor->id)) }}">
                                        {{ $vendor->business_name }}
                                        </a>
                                    </div>
                                    @include('vendor-search.vendor-stars', $vendor)
                                    <small class="desc text-bold div-block text-color-primary desc-locs">
                                        {{ $vendor->expertise->implode('name', ', ') }}
                                    </small>
                                    <div class="location tooltip-holder">
                                        <span class="pull-left">
                                        @if(!request()->locations)
                                            {{
                                                isset($vendor->locations[0])
                                                ? $vendor->locations[0]->name
                                                : ''
                                            }}
                                            </span>
                                            @if(count($vendor->locations) > 1)
                                                <br/>
                                                {{ count($vendor->locations) - 1 }} more locations
                                                <div class="tooltip-alt" style="padding: 10px;">
                                                    Service regions:
                                                    {{
                                                        $vendor->locations->forget(0)->map(function ($item) {
                                                            return ['d' => $item['name']];
                                                        })->implode('d', ', ')
                                                    }}
                                                </div>
                                            @endif
                                        @else
                                            @php
                                                $reqLoc = $vendor->locations->whereIn('name', request()->locations)->first();
                                                $wideLoc = (!$reqLoc) ? $vendor->locations->where('name', 'Australia Wide')->first() : null ;
                                                $firstLoc = ($reqLoc) ? $vendor->locations->where('id', $reqLoc['id'])->keys()->first() : $vendor->locations->where('id', $wideLoc['id'])->keys()->first() ;
                                            @endphp
                                            {{
                                                isset($reqLoc)
                                                ? $reqLoc['name']
                                                : $wideLoc['name']
                                            }}
                                            </span>
                                            @if(count($vendor->locations) > 1)
                                                <br/>
                                                {{ count($vendor->locations) - 1 }} more locations
                                                <div class="tooltip-alt" style="padding: 10px;">
                                                    Service regions:
                                                    {{
                                                        $vendor->locations->forget($firstLoc)->map(function ($item) {
                                                            return ['d' => $item['name']];
                                                        })->implode('d', ', ')
                                                    }}
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('css')
    <style>
        .related-vendors {
            background: #fcfaf7;
            color: #353554;
            padding: 50px;
        }
        .h2.head {
            font-family: "Josefin Slab";
            margin: 11px 0;
        }
    </style>
    @endpush

    @push('scripts')
        <script>
            $('.vendor-profile').on('click', function(e){
                e.preventDefault();
                window.location = $(this).data('link');
            })
            cardwidth =  $('.venues-search .card-image').outerWidth();
            $('.venues-search .card-image').css({
                height: cardwidth+'px'
            });

            $( window ).resize(function() {
            cardwidth =  $('.venues-search .card-image').outerWidth();
            $('.venues-search .card-image').css({
                    height: cardwidth+'px'
                });
            });
        </script>
    @endpush

@else
<hr style="margin: 0; border: 1px solid #eee;">
@endif