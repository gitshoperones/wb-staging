<div id="wb-blog-banner" class="lazy" data-src="{{ ($result = $pageSettings->firstWhere('meta_key', 'blog_image')) ? Storage::url($result->meta_value) : asset('/assets/images/banners/homepage_bk.png') }}">
	<div class="wb-big-banner-content">
		<h4 class="blog-subheading">
            {!! $pageSettings->firstWhere('meta_key', 'blog_subheading')->meta_value ?? 'New on the blog?' !!}
        </h4>
        <h1 class="blog-heading">
            {!! $pageSettings->firstWhere('meta_key', 'blog_heading')->meta_value ?? 'HUNTER AS THE VALLEY' !!}
        </h1>
        <a href="{!! $pageSettings->firstWhere('meta_key', 'blog_button_link') ? strip_tags($pageSettings->firstWhere('meta_key', 'blog_button_link')->meta_value) : '/inspiration' !!}" class="blog-readnow">{!! ($pageSettings->firstWhere('meta_key', 'blog_button_text')) ? strip_tags($pageSettings->firstWhere('meta_key', 'blog_button_text')->meta_value) : "Read Now" !!}</a>
	</div>
</div>

@push('css')
<style>
#wb-blog-banner {
    display: flex;
    -webkit-box-pack: center;
    justify-content: center;
    height: 600px;
    text-align: center;
    position: relative;
    background-position: center 33px;
    background-size: auto;
    -webkit-box-align: center;
    align-items: center;
    background-attachment: fixed;
}
#wb-blog-banner h4.blog-subheading {
    font-family: Ubuntu;
    font-weight: bold;
    font-size: 16px;
    text-shadow: 0 0 16px #000000;
    color: #fff;
    text-transform: uppercase;
}

#wb-blog-banner h1.blog-heading {
    font-family: "Josefin Slab";
    font-weight: bold;
    font-size: 38px;
    text-shadow: 0 0 16px #000000;
    color: #fff;
    text-transform: uppercase;
}
#wb-blog-banner .blog-readnow {
    text-transform: uppercase;
    background: #fff;
    padding: 15px 50px;
    display: inline-block;
}
</style>
@endpush