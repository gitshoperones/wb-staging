<div class="tab-pane" id="tab_step_4">
    <div>
        <div class="sub-header">
            Please provide a personalised message to the couple with any extra details
        </div>
        <div class="wb-notes-dashboard wb-job-description block editOn">
            <div id="message-editor"></div>
            <input type="hidden" name="message" id="message" value='{!! isset($jobQuote) ? $jobQuote->message : "" !!}'>
        </div>
        <br/>
        <input type="checkbox" id="confirm-availability" name="confirm_availability">
        <label for="confirm-availability">Confirming that I have checked our business availability, and have provided all necessary details of our availability using the text box above.</label>
    </div>
</div>
@push('css')
    <link href="{{ asset('assets/js/Trumbowyg/ui/trumbowyg.min.css') }}" rel="stylesheet" />
@endpush
@push('scripts')
    <script type="text/javascript" src="{{ asset('assets/js/Trumbowyg/trumbowyg.min.js') }}"></script>
    <script type="text/javascript">
        $('#message-editor').trumbowyg({
            removeformatPasted: true,
            btns: [
                ['formatting'],
                ['strong', 'em', 'underline'],
                ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
                ['unorderedList', 'orderedList'],
            ],
        }).on('tbwchange', function(){
            $('#message').val($('#message-editor').trumbowyg('html'));
         }).on('tbwblur', function(){
            $('#message').val($('#message-editor').trumbowyg('html'));
         }).on('tbwfocus', function(){
            $('#message').val($('#message-editor').trumbowyg('html'));
         });
        $('#message-editor').trumbowyg('html', $('#message').val());
    </script>
@endpush
