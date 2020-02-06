<link rel="stylesheet" href="https://cdn.rawgit.com/stevenmonson/googleReviews/master/google-places.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/stevenmonson/googleReviews@6e8f0d794393ec657dab69eb1421f3a60add23ef/google-places.js"></script>

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyBJq0XAnTD_y8Hc9MazV96o5n4bOCVVKIs&signed_in=true&libraries=places"></script>


<h1>Google Reviews</h1>
<div id="google-reviews"></div>



<script>
jQuery(document).ready(function( $ ) {
   $("#google-reviews").googlePlaces({
        placeId: 'ChIJdfkQvOSbLIgRrJy5Ws1D8Fg' //Find placeID @: https://developers.google.com/places/place-id
      , render: ['reviews']
      , min_rating: 4
      , max_rows:4
   });
});
</script>
