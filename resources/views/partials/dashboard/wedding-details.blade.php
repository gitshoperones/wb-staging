<div class="wb-wedding-details box box-widget">
    <div class="box-header with-border p-l-13">
        <h3 class="box-title">
            <span class="icon"><i class="fa fa-paperclip"></i></span>
            <span class="title">WEDDING DETAILS</span>
        </h3>
    </div>
    <div class="box-body">
        <ul class="list-unstyled vlist">
            <form id="wedding-details-form"
                action="{{ url(sprintf('/%ss/%s', Auth::user()->account, $profile->id)) }}">
                {{ csrf_field() }}
                <input name="_method" type="hidden" value="PATCH">
                <li>
                    <label for="">Ceremony venue</label><br>
                    <textarea id="weddingCeremonyInput" rows="2" class="form-control">{{ $profile->ceremonyVenue ? $profile->ceremonyVenue->name : ''}}</textarea>
                    <input type="hidden"
                        id="ceremony_venue_id"
                        name="ceremony_venue_id"
                        value="{{ $profile->ceremony_venue_id }}">
                </li>
                <br/>
                <li>
                    <label for="">Reception venue</label><br>
                    <textarea id="weddingReceptionInput" rows="2" class="form-control">{{ $profile->receptionVenue ? $profile->receptionVenue->name : ''}}</textarea>
                    <input type="hidden"
                        id="reception_venue_id"
                        name="reception_venue_id"
                        value="{{ $profile->reception_venue_id }}">
                </li>
                <br/>
                <button id="update-weddeng-details" class="btn form-control btn-success">Update Wedding Details</button>
            </form>
        </ul>
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

        $("#weddingCeremonyInput").autocomplete({
            minLength: 0,
            source: dataSets,
            select: function( event, ui ) {
                event.preventDefault();
                $('#weddingCeremonyInput').val(ui.item.label);
                $('#ceremony_venue_id').val(ui.item.value);
            }
        }).focus(function(){
            $(this).autocomplete("search");
        });

        $("#weddingReceptionInput").autocomplete({
            minLength: 0,
            source: dataSets,
            select: function( event, ui ) {
                event.preventDefault();
                $('#weddingReceptionInput').val(ui.item.label);
                $('#reception_venue_id').val(ui.item.value);
            }
        }).focus(function(){
            $(this).autocomplete("search");
        });

        $('#update-weddeng-details').on('click', function(e){
            e.preventDefault();
            NProgress.start();
            var form = $('#wedding-details-form');
            $.ajax( {
                type: "POST",
                url: form.attr('action'),
                data: form.serialize(),
                success: function( response ) {
                    NProgress.done();
                }
            });
        });
    </script>
@endpush