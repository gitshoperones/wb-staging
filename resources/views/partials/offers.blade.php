<div id="wb-offers">
    {{-- <img src="{{ ($result = $pageSettings->firstWhere('meta_key', "offers_image")) ? Storage::url($result->meta_value) : '/assets/images/wedbooker-white-icon.png' }}" class="text-center img-responsive offer-img"/> --}}
	<h1 class="wb-title no-underline">{{ ($pageSettings->firstWhere('meta_key', 'offers_title')) ? strip_tags($pageSettings->firstWhere('meta_key', 'offers_title')->meta_value) : "Featured Offers" }}</h1>
	<div class="container">
		<div class="row">
			<div class="col-md-12 px-0">
				<div class="carousel slide media-carousel" id="media">
					<div class="carousel-inner">
						<div class="row">
                            @foreach (['left', 'middle', 'right'] as $item)
                                <div class="col-xs-12 col-sm-4 col-md-4 offer-item">
                                    <a class="thumbnail" style="height: auto;" href="{!! $pageSettings->firstWhere('meta_key', "offer_{$item}_link") ? strip_tags($pageSettings->firstWhere('meta_key', "offer_{$item}_link")->meta_value) : '#' !!}">
                                        <div class="image">
                                            <img class="lazy img-responsive" data-src="{{ ($result = $pageSettings->firstWhere('meta_key', "offer_{$item}_img")) ? Storage::url($result->meta_value) : '' }}" />
                                        </div>
                                        <p class="offer-title">{!! $pageSettings->firstWhere('meta_key', "offer_{$item}_meta_tag") ? strip_tags($pageSettings->firstWhere('meta_key', "offer_{$item}_meta_tag")->meta_value) : 'Offer details' !!}</p>
                                        <div class="content">
                                            <img data-src="{{ "/assets/images/wedbooker-offer.png" }}" class="lazy ex-offer">
                                            <h5>{!! $pageSettings->firstWhere('meta_key', "offer_{$item}_title") ? strip_tags($pageSettings->firstWhere('meta_key', "offer_{$item}_title")->meta_value) : 'Offer Title' !!}</h5>
                                            <p>{!! $pageSettings->firstWhere('meta_key', "offer_{$item}_text") ? strip_tags($pageSettings->firstWhere('meta_key', "offer_{$item}_text")->meta_value) : 'Offer description' !!}</p>
                                            <button class="btn btn-orange" style="margin-top: 11px;">Request Quote</button>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>
    
	<div class="action">
        <a href="{{ url('/suppliers-and-venues') }}" class="wb-btn-lg">{!! ($pageSettings->firstWhere('meta_key', 'offers_button_text')) ? strip_tags($pageSettings->firstWhere('meta_key', 'offers_button_text')->meta_value) : "More Exclusive Offers" !!}</a>
    </div>
</div>