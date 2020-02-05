<p>Business Name: {{ $vendor->business_name }}</p>
<p>Business Email: {{ $vendor->user->email }}

<p><strong>Review Details</strong></p>
<p>Couple Title: {{ $vendorReview->reviewer_name }}</p>
<p>Event Type: {{ $vendorReview->event_type }}</p>
<p>Event Date: {{ $vendorReview->event_date }}</p>
<p><b><u><i>Average Rating From Couple: {{ $vendorReview->rating }}</i></u></b></p>
<p>Easy to work with: {{ $vendorReview->rating_breakdown['easy_to_work_with'] }}</p>
<p>Likely to recommend to a friend: {{ $vendorReview->rating_breakdown['likely_to_recoment_to_a_friend'] }}</p>
<p>Overall Rating from Couple: {{ $vendorReview->rating_breakdown['overall_satisfaction'] }}</p>
<p><b>message: <i>{{ $vendorReview->message }}</i></b></p>
