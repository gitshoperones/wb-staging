@if($editing == 'editOff')

    @if((!empty($userProfile->vendor_location->lat) && !empty($userProfile->vendor_location->lng)) || !empty($userProfile->vendor_location->address))

        <div id="stay22-script"></div>

        <script>
            document.addEventListener("DOMContentLoaded", function(e) {
                var settings22 = {
                    width: '100%',
                    height: '420px'
                };
                
                var s22obj = {
                    aid: 'wedbooker-vendor',

                    @if($userProfile->vendor_location->lat && $userProfile->vendor_location->lng)
                        lat: '{{ $userProfile->vendor_location->lat }}',
                        lng: '{{ $userProfile->vendor_location->lng }}',
                    @else
                        address: '{!! addslashes($userProfile->vendor_location->address) !!}',
                    @endif

                    venue : '{!! addslashes($userProfile->business_name) !!}',
                    maincolor: '353554',
                    loadingbarcolor: '353554',
                    markerimage: '{{ ($userProfile->profile_avatar) ? url($userProfile->profile_avatar) : asset('assets/images/logo.png') }}',
                    navimage: '{{ asset('assets/images/logo.png') }}',
                    showgmapsicon: true,
                    hideshare : true,
                    hidesettings  : true,
                    hidelanguage : true,
                    hidebrandlogo: true,
                    hideppn : true,
                    //hideguestpicker : true,
                    // hidecheckinout : true,
                    // hideadults : true,
                    // hidechildren : true,
                    hiderooms : true,
                    freezeviewport: true,
                    adults: 1,
                    children: 0,
                };

                // Leave this part intact
                var params22=''; for (var key in s22obj){if (params22){params22 +='&';}params22 +=key + '=' + encodeURIComponent(s22obj[key]);}var div22=document.getElementById('stay22-script'); div22.insertAdjacentHTML('afterend', '<iframe id="stay22-widget" width="' + settings22.width + '" height="' + settings22.height + '" src="' + 'https://www.stay22.com/embed/gm?' + params22 + '" frameborder="0"></iframe>');
            });
        </script>

    @endif

@else

@push('css')
<link href="{{ asset('assets/js/simple-lightbox/css/lightbox.min.css') }}" rel="stylesheet" />
@endpush

@push('scripts')
<script src="{{ asset('assets/js/simple-lightbox/js/lightbox.min.js') }}"></script>
<script>
    lightbox.option({
        'wrapAround': true,
        'albumLabel': '',
    });

    $('.preview-map').click(function(e) {
        $('#stay22-script').html(`<div id="nprogress" class="loadmap"><div class="spinner-icon"></div></div>`);
        $('#stay22-widget').remove();

        var type = $(this).data('type'),
            lat = (type == 'latlng') ? $('input[name="lat"]').val() : null,
            lng = (type == 'latlng') ? $('input[name="lng"]').val() : null,
            address = (type == 'address') ? $('input[name="address"]').val() : null,
            settings22 = {
                width: '100%',
                height: '420px'
            };
        
        var s22obj = {
            aid: 'wedbooker-vendor',
            lat: lat,
            lng: lng,
            address: address,
            venue : '{!! addslashes($userProfile->business_name) !!}',
            maincolor: '353554',
            loadingbarcolor: '353554',
            markerimage: '{{ ($userProfile->profile_avatar) ? url($userProfile->profile_avatar) : asset('assets/images/logo.png') }}',
            navimage: '{{ asset('assets/images/logo.png') }}',
            showgmapsicon: true,
            hideshare : true,
            hidesettings  : true,
            hidelanguage : true,
            hidebrandlogo: true,
            hideppn : true,
            // hideguestpicker : true,
            // hidecheckinout : true,
            // hideadults : true,
            // hidechildren : true,
            hiderooms : true,
            freezeviewport: true,
            adults: 1,
            children: 0,
        };

        // Leave this part intact
        var params22=''; for (var key in s22obj){if (params22){params22 +='&';}params22 +=key + '=' + encodeURIComponent(s22obj[key]);}var div22=document.getElementById('stay22-script'); div22.insertAdjacentHTML('afterend', '<iframe id="stay22-widget" width="' + settings22.width + '" height="' + settings22.height + '" src="' + 'https://www.stay22.com/embed/gm?' + params22 + '" frameborder="0"></iframe>');

        console.clear();

        setTimeout(() => {
            $('#stay22-script').html('');
        }, 5000);
    });

    $('#stay22-widget').on('ready', function(){
        $('#stay22-script').html('');
    });
</script>
@endpush

<div class="wb-profile-locations row">
    <p class="h2 text-center">Option to add your business location</p>
    <p class="h4 text-center">(most useful for venues)</p>
    <div class="col-md-6">
        <p class="h3">Option 1 - Use the street address of your business</p>
        <p>Example format: 11A Lawrence Street, Sydney, New South Wales, 2096</p>
        <input type="text" name="address" class="form-control" placeholder="Address" value="{{ ($userProfile->vendor_location) ? $userProfile->vendor_location->address : "" }}" />
        <button type="button" class="btn btn-danger preview-map" data-type="address">Preview Map</button>

        <p class="h3">Option 2 - Use the latitude and longitude of your business location</p>

        <ol>
            <li><p>Go to <strong><a href="https://maps.google.com" target="_blank">Google Maps</a></strong> website.</p></li>
            <li><p>Search for the name or address of your business.</p></li>
            <li><p>Right-click (or Control+click on a Mac) on the location</p></li>
            <li>
                <p>Select <strong>What's here?</strong> from the menu. <a href="{{ asset('assets/images/how/location/latlng1.jpg') }}" data-lightbox="how-to-latlng" data-title="Get Latitude and Longitude in Google Maps">Click here to see sample.</a></p>
            </li>
            <li><p>Find the latitude and longitude at the bottom of the screen. <a href="{{ asset('assets/images/how/location/latlng2.jpg') }}" data-lightbox="how-to-latlng" data-title="Get Latitude and Longitude in Google Maps">Click here to see sample.</a></p></li>
            <li>
                <p>Paste your latitude and longitude or address here.</p>
            </li>
            <li>
                <p>Sample formats: </p>
                <p>Latitude: <strong>-24.624181</strong></p>
                <p>Longitude: <strong>133.302921</strong></p>
            </li>
        </ol>
        <div class="row">
            <div class="col-md-6">
                <input type="text" name="lat" class="form-control" placeholder="Latitude" value="{{ ($userProfile->vendor_location) ? $userProfile->vendor_location->lat : "" }}" />
            </div>
            <div class="col-md-6">
                <input type="text" name="lng" class="form-control" placeholder="Longitude" value="{{ ($userProfile->vendor_location) ? $userProfile->vendor_location->lng : "" }}" />
            </div>
        </div>
        <button type="button" class="btn btn-danger preview-map" data-type="latlng">Preview Map</button>
    </div>
    <div class="col-md-6">
        <div id="stay22-script" class="stay22-script"></div>
    </div>
</div>

@endif