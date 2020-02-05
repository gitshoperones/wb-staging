<ul class="list-unstyled wb-numlist">
	@foreach($how_vendor['title'] as $key => $vendor_title)
		@php
			preg_match('/vendor_section_(.*)_title/', $vendor_title->meta_key, $matches);
		@endphp
		<li class="{{ $matches[1] % 2 == 0 ? 'reverse-list' : '' }}">
			<div class="wb-numlist-lead">
				<span class="num">{{ $matches[1] }}</span>
				{{ strip_tags($vendor_title->meta_value) }}
			</div>
			<div class="wb-numlist-info">
				@foreach($how_vendor['img'] as $vendor_img)
					@php
						preg_match('/vendor_section_(.*)_img/', $vendor_img->meta_key, $matches_img);
					@endphp
					@if($matches[1] == $matches_img[1])
					<img src="{!! Storage::url($vendor_img->meta_value) !!}" class="thumb" />
					@endif
				@endforeach
				
				@foreach($how_vendor['text'] as $vendor_text)
					@php
						preg_match('/vendor_section_(.*)_text/', $vendor_text->meta_key, $matches_text);
					@endphp
					@if($matches[1] == $matches_text[1])
					<p>
						{!! strip_tags($vendor_text->meta_value) !!}
					</p>
					@endif
				@endforeach
			</div>
		</li>
	@endforeach
</ul>