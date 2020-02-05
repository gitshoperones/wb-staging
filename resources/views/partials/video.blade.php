<div class="wb-home-video">
	<div class="container">
		<iframe src="{{ ($pageSettings->firstWhere('meta_key', 'video_url')) ? strip_tags($pageSettings->firstWhere('meta_key', 'video_url')->meta_value) : "https://player.vimeo.com/video/374059637"}}" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
	</div>
</div>