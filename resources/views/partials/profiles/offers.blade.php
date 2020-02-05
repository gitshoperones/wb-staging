@if(isset($userProfile->offer) && ((!$userProfile->offer->heading==null || !$userProfile->offer->description==null) && ($userProfile->offer->end_date === null || \Carbon\Carbon::parse($userProfile->offer->end_date) > now()->subDays(1))) || ($editing === 'editOn'))
    <div id="wb-profile-offers">
        @if ($editing === 'editOff')
            <div class="text-center offer-panel">
                <img src="{{ ($result = $vendorProfile->firstWhere('meta_key', "offer_profile_img")) ? Storage::url($result->meta_value) : '/assets/images/wedbooker-white-icon.png' }}" class="text-center img-responsive offer-img"/>
                <p class="h2 head">{{ ($result = $vendorProfile->firstWhere('meta_key', "offer_profile_title")) ? strip_tags($result->meta_value) : '' }}</p>
                <p class="h2 head">{{ $userProfile->offer->heading }}</p>
                <p>{{ $userProfile->offer->description }}</p>
                <p class="offer-expire">{!! ($userProfile->offer->end_date) ? 'Offer until: '.date_format(date_create($userProfile->offer->end_date), 'd-m-Y') : "" !!}</p>
            </div>
        @else
            <div class="text-center offer-panel">
                <img src="{{ ($result = $vendorProfile->firstWhere('meta_key', "offer_profile_img")) ? Storage::url($result->meta_value) : '/assets/images/wedbooker-white-icon.png' }}" class="text-center img-responsive offer-img"/>
                <div class="offer-header">
                    <span class="h2 head">{{ ($result = $vendorProfile->firstWhere('meta_key', "offer_profile_title")) ? strip_tags($result->meta_value) : '' }}</span>
                    <span class="tooltip-icon">
                        <span class="btn exoffers">
                            <i class="fa fa-question"></i>
                        </span>
                        <div class="tooltip-wrapper">
                            This is a place for you to promote an offer to couples. It is a great way to encourage couples to book your services, by adding a little "icing on the cake". This is entirely optional, you don't have to include an offer if you don't want to.
                        </div>
                    </span>
                </div>

                <div class="panel-body row">
                    <div class="col-md-12">
                        <input type="text" class="form-control" name="heading" placeholder="Offer Heading" style="margin-bottom: 20px;" maxlength="60" autocomplete="off" value="{{ ($userProfile->offer) ? $userProfile->offer->heading : "" }}" />
                        <textarea class="form-control" name="description" placeholder="Offer Description" rows="5" maxlength="450">{{ ($userProfile->offer) ? $userProfile->offer->description : "" }}</textarea>
                        <div class="offer-exp">
                            <div data-provide="datepicker"
                                data-date-format="dd-mm-yyyy"
                                data-date-start-date="+1d"
                                class="wb-form-group input-group date text-center"
                                style="margin-bottom: 0;">
                                <input id="end_date"
                                type="text"
                                onkeydown="return false"
                                name="end_date"
                                autocomplete="off"
                                @if (isset($userProfile->offer))
                                value="{{ ($userProfile->offer->end_date) ? date_format(date_create($userProfile->offer->end_date), 'd-m-Y') : "" }}"
                                @else
                                value="{{ old('end_date') }}"
                                @endif
                                class="form-control"
                                {{ (isset($userProfile->offer) && !$userProfile->offer->end_date) ? "disabled" : "" }}>
                                <label for="end_date" class="text-primary" style="font-weight: 100;">Offer End Date</label>
                                <div class="input-group-addon" style="display: none;">
                                    <span class="fa fa-calendar"></span>
                                </div>
                            </div>
                            <input type="checkbox" id="no_end_date" name="no_end_date" value="1" {{ (isset($userProfile->offer) && !$userProfile->offer->end_date) ? "checked" : "" }}/>
                            <label for="no_end_date" class="text-center" style="text-transform: capitalize;">No End Date</label>
                        </div>
                        <button type="button" class="btn pull-right clear" style="background-color: #999999; color: #ffffff;">Delete Offer</button>
                    </div>
                </div>
            </div>

            @push('scripts')
                <script>
                    $('#no_end_date').change(function () {
                        if($(this).is(':checked')) {
                            $('#end_date').prop('disabled', 'true')
                        }else {
                            $('#end_date').removeAttr('disabled')
                        }
                    })

                    $('.clear').click(function() {
                        $('input[name="heading"], textarea[name="description"], #end_date').val('')
                        if(!$('#no_end_date').is(':checked')) {
                            $('#no_end_date').click()
                        }
                    })
                </script>
            @endpush
        @endif
    </div>
@endif