<!-- Start Planning Modal -->
<div class="modal fade" id="start-planning" tabindex="-1" role="dialog" aria-labelledby="requiredFields" aria-hidden="true">
    <div class="modal-dialog start-planning">
        <div class="modal-content text-center">
            <div class="modal-header text-primary">
                <h3>Let's find you a <span class="modal-category"></span><span class="modal-location"></span></h3>
            </div>
            <div class="modal-body row text-center text-primary">
                <div class="col-md-6 col-sm-12">
                    <h3>{!! $pageSettings->firstWhere('meta_key', 'start_post_title') ? strip_tags(str_replace('%category%', '<span class="modal-category"></span>', $pageSettings->firstWhere('meta_key', 'start_post_title')->meta_value), '<span>') : "Let Us Match You" !!}</h3>
                    <p>{!! $pageSettings->firstWhere('meta_key', 'start_post_text') ? strip_tags(str_replace('%category%', '<span class="modal-category"></span>', $pageSettings->firstWhere('meta_key', 'start_post_text')->meta_value), '<span>') : "Tell us what you need using our quick and easy job template, and we'll invite our top picks to send you a quote" !!}</p>
                    <button type="submit" form="get-quote" class="btn wb-btn-primary wb-btn-orange tell-us">{!! $pageSettings->firstWhere('meta_key', 'start_post_button') ? strip_tags($pageSettings->firstWhere('meta_key', 'start_post_button')->meta_value) : "Post A Job" !!}</button>
                </div>
                <div class="col-md-6 col-sm-12">
                    <h3>{!! $pageSettings->firstWhere('meta_key', 'start_browse_title') ? strip_tags(str_replace('%category%', '<span class="modal-category"></span>', $pageSettings->firstWhere('meta_key', 'start_browse_title')->meta_value), '<span>') : "Pick Your Own Faves" !!}</h3>
                    <p>{!! $pageSettings->firstWhere('meta_key', 'start_browse_text') ? strip_tags(str_replace('%category%', '<span class="modal-category"></span>', $pageSettings->firstWhere('meta_key', 'start_browse_text')->meta_value), '<span>') : "Browse our professional Suppliers & Venues, and request quotes directly from the ones you like best" !!}</p>
                    <button type="submit" form="get-quote" class="btn wb-btn-primary wb-btn-orange browse-us">{!! $pageSettings->firstWhere('meta_key', 'start_browse_button') ? strip_tags($pageSettings->firstWhere('meta_key', 'start_browse_button')->meta_value) : "Browse Suppliers & Venues" !!}</button>
                </div>
            </div>
        </div>
    </div>
</div>