<ul class="list-unstyled wb-numlist">
	@foreach($how_couple['title'] as $key => $couple_title)
		@php
			preg_match('/couple_section_(.*)_title/', $couple_title->meta_key, $matches);
		@endphp
		<li class="{{ $matches[1] % 2 == 0 ? 'reverse-list' : '' }}">
			<div class="wb-numlist-lead">
				<span class="num">{{ $matches[1] }}</span>
				{{ strip_tags($couple_title->meta_value) }}
			</div>
			<div class="wb-numlist-info">
				@foreach($how_couple['img'] as $couple_img)
					@php
						preg_match('/couple_section_(.*)_img/', $couple_img->meta_key, $matches_img);
					@endphp
					@if($matches[1] == $matches_img[1])
					<img src="{!! Storage::url($couple_img->meta_value) !!}" class="thumb" />
					@endif
				@endforeach
				
				@foreach($how_couple['text'] as $couple_text)
					@php
						preg_match('/couple_section_(.*)_text/', $couple_text->meta_key, $matches_text);
					@endphp
					@if($matches[1] == $matches_text[1])
					<p>
						{!! strip_tags($couple_text->meta_value) !!}
					</p>
					@endif
				@endforeach
			</div>
		</li>
	@endforeach
</ul>