<div class="tab-pane fade" id="step-5">
    <h1 class="title"> Invite some more favourites... </h1>
    <p class="btn-block text-primary">Would you like us to invite your favourite businesses and a few of our top suggestions to quote on this job?</p>

    <div class="btn-block">
        <input type="checkbox" id="invite-favourite" name="invite_favourite" class="vendor-expertise">
        <label for="invite-favourite">Yes please</label>
    </div>
    <input type="hidden" id="v_id" name="v_id" value="{{request()->vendor_id}}">
    
    @if(Auth::user())
    <div class="action-buttons">
        <button type="submit" type="submit" name="status" value="0" class="btn wb-btn wb-btn-outline-default">SAVE AS DRAFT</button>
        <button id="{{ (request()->vendor_id) ? "submit-quote-request" : "submit-job-post"}}" type="submit" name="status" value="{{ (isset($jobPost) && $jobPost->status === 1) ? 1 : 5 }}" class="btn wb-btn wb-btn-primary {{ isset($btnLbl) ? "thank-you" : "submit-quote-request" }}">
            {{ isset($btnLbl) ? $btnLbl : 'Request Quote'}}
    </button>
    @else
    <div class="action-buttons">
		<a href="#" onClick="event.preventDefault(); moveToStep('step-6-section');" class="btn wb-btn wb-btn-primary">NEXT STEP</a>
    </div>
    @endif
</div>
