<div class="wb-business-details box box-widget">
    <div class="box-header with-border">
        <h3 class="box-title">
            <span class="icon"><i class="fa fa-paperclip"></i></span>
            <span class="title">BUSINESS DETAILS</span>
        </h3>
    </div>
    <div class="box-body">
        <form class="form-horizontal"
            id="vendor-details-form"
            enctype="multipart/form-data"
            method="POST"
            action="{{ url(sprintf('/%ss/%s', Auth::user()->account, $profile->id)) }}"
        >
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PATCH">
            <div class="form-group">
                <label class="control-label item">Registered Business Name</label>
                <div class="item">
                    <div class="wb-input-with-check">
                        <textarea rows="2" name="business_name" cols="50" class="form-control">{{ $profile->business_name }}</textarea>
                        <a class="check-button"><i class="fa fa-check"></i></a>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label item">Trading Name</label>
                <div class="item">
                    <div class="wb-input-with-check">
                        <input name="trading_name" type="text" class="form-control" value="{{ $profile->trading_name }}">
                        <a class="check-button"><i class="fa fa-check"></i></a>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label item">ABN</label>
                <div class="item">
                    <div class="wb-input-with-check">
                        <input name="abn" type="text" class="form-control" value="{{ $profile->abn }}">
                        <a class="check-button"><i class="fa fa-check"></i></a>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label item">Email</label>
                <div class="item">
                    <div class="wb-input-with-check">
                        <input name="contact_email" type="text" class="form-control" value="{{ $profile->contact_email }}">
                        <a class="check-button"><i class="fa fa-check"></i></a>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label item">Contact Phone Number</label>
                <div class="item">
                    <div class="wb-input-with-check">
                        <input name="contact_phone_number" type="text" value="{{ $profile->contact_phone_number }}" class="form-control">
                        <a class="check-button"><i class="fa fa-check"></i></a>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label item">Registered Business Address</label>
                <div class="item">
                    <div class="wb-input-with-check">
                        <textarea id="businessLocation" name="location" rows="2" class="form-control">{{ $profile->location ? $profile->location->name : '' }}</textarea>
                        <input type="hidden" id="location_id" name="location_id" value="{{ $profile->location_id }}">
                        <a class="check-button"><i class="fa fa-check"></i></a>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label item">Website</label>
                <div class="item">
                    <div class="wb-input-with-check">
                        <input id="website" name="website" type="text" class="form-control" value="{{ $profile->website }}">
                        <a class="check-button"><i class="fa fa-check"></i></a>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label item">Terms & Conditions</label>
                <label id="filename" class="control-label item">{{ $profile-> tc_original_filename }}</label>
                <div class="item">
                    <input type="file" id="tc" name="tc" class="hidden" onchange="displayFilename()">
                    <label for="tc" class="upload">
                        Select File
                    </label>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-sm-12">
                        <input type="submit"
                            id="update-vendor-details"
                            class="submit btn wb-btn-primary pull-left"
                            name="submit" value="Save"
                            style="margin-top: 11px;" />
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@php
    $dataSets = $locations->reduce(function($dataSets, $location){
        $dataSets[] = ['label' => $location->name, 'value' => $location->id];
        return $dataSets;
    });
@endphp
@push('scripts')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript">
        var dataSets = JSON.parse('<?php echo json_encode($dataSets) ?>');

        $("#businessLocation").autocomplete({
            minLength: 0,
            source: dataSets,
            select: function( event, ui ) {
                event.preventDefault();
                $('#businessLocation').val(ui.item.label);
                $('#location_id').val(ui.item.value);
            }
        }).focus(function(){
            $(this).autocomplete("search");
        });

        $('#vendor-details-form').submit(function(e){
            e.preventDefault();
            NProgress.start();
            var form = $('#vendor-details-form');
            var formData = new FormData(this);
            $.ajax( {
                type: "POST",
                url: form.attr('action'),
                data: formData,
                processData: false,
                contentType: false,
                success: function( response ) {
                    showCheckMark();
                    NProgress.done();
                }
            });
        });

        function showCheckMark() {
            $('.check-button').each(function(){
                $(this).css({'visibility': 'visible', 'opacity': 1});
            });

            setTimeout(function(){
                $('.check-button').each(function(){
                    $(this).css({'visibility': 'invisible', 'opacity': 0});
                });
            }, 5000);
        }

        function displayFilename() {
            var name = document.getElementById('tc');
            var el = $('#filename');
            el.html('');
            el.html(name.files.item(0).name);
        };
    </script>
@endpush