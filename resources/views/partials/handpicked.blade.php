<div id="wb-handpicked">
	<h1 class="wb-title">{!! $pageSettings->firstWhere('meta_key', 'what_you_need_title')->meta_value ?? 'What Do You Need For Your Wedding?' !!}</h1>
	<div class="container">
        <div id="wb-supplier-thumbs" class="wb-supplier-thumbs">
            @foreach($categories as $category)
                <div class="item">
                    <a href="{{ url((auth()->user() ? 'dashboard/' : '').'job-posts/create?category='.$category->name) }}">
                        <img data-src="{{ asset('assets/images/icons/colour/'.$category->icon) }}" class="lazy wb-icon" />
                        <div>{{ $category->name }}</div>
                    </a>
                </div>
            @endforeach
        </div>
   </div>
</div>
