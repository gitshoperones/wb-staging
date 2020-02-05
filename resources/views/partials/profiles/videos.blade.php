@if($userProfile->getEmbeddedVideo())
    <div class="wb-profile-videos text-center">
        @foreach($userProfile->getEmbeddedVideo() as $video) 
            <iframe width="560" height="315" style="max-width: 100%;" src="{{ $video }}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        @endforeach
    </div>
@endif