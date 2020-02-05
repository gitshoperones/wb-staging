<div id="couples" class="tab-pane active">
	<div class="container">
		<div id="accordion" role="tablist" aria-multiselectable="true" class="panel-group">
			@foreach($couple['questions'] as $key => $question)
				<div class="panel panel-default">
					<div role="tab" id="heading{{ $question->id }}" class="panel-heading">
						<h4 class="panel-title">
							<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $question->id }}" aria-expanded="false" aria-controls="collapseOne">
								{!! strip_tags($question->meta_value) !!}
								<span class="pull-right"><i class="fa fa-chevron-right"></i></span>
								<span class="pull-right"><i class="fa fa-chevron-down"></i></span>
							</a>
						</h4>
					</div>
					<div id="collapse{{ $question->id }}" role="tabpanel" aria-labelledby="heading{{ $question->id }}" class="panel-collapse collapse">
						<div class="panel-body">
							@foreach($couple['answers'] as $answer)
								{!! (substr($answer->meta_key, strpos($answer->meta_key, "_") + 1) == substr($question->meta_key, strpos($question->meta_key, "_") + 1)) ? $answer->meta_value : "" !!}
							@endforeach
						</div>
					</div>
				</div>
			@endforeach

			@if(count($couple) <= 0)
			<div class="panel panel-default">
					<div role="tab" id="headingOne" class="panel-heading">
						<h4 class="panel-title">
							<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
								What is wedBooker?
								<span class="pull-right"><i class="fa fa-chevron-right"></i></span>
								<span class="pull-right"><i class="fa fa-chevron-down"></i></span>
							</a>
						</h4>
					</div>
					<div id="collapseOne" role="tabpanel" aria-labelledby="headingOne" class="panel-collapse collapse">
						<div class="panel-body">
							wedBooker is an online marketplace helping wedding couples to efficiently book talented Suppliers and beautiful Venues around Australia. wedBooker is Australia’s first end-to-end platform for Couples to search trusted and reviewed wedding businesses, compare quotes, make bookings and  securely pay.
						</div>
					</div>
				</div>
				<div class="panel panel-default">
					<div role="tab" id="headingTwo" class="panel-heading">
						<h4 class="panel-title">
							<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
								Why use wedBooker?
								<span class="pull-right">
									<i class="fa fa-chevron-right"></i></span>
									<span class="pull-right"><i class="fa fa-chevron-down"></i></span>
								</a>
							</h4>
						</div>
						<div id="collapseTwo" role="tabpanel" aria-labelledby="headingTwo" class="panel-collapse collapse">
							<div class="panel-body">
								<ol>
									<li>
										<u> Trusted Network of Suppliers & Venues </u> - wedBooker Venues and Suppliers are pre-vetted and verified to ensure Couples are securing professional suppliers and venues for their big day. Our integrated review system provides Couples with the information they need to confidently book their Wedding team
									</li>
									<li>
										<u>Compare Quotes All In One Place </u>- wedBooker's planning dashboard makes it easy for couples to compare quotes, and choose the suppliers and venues that are most suited to their wedding. We want to help Couples reduce the admin in the lead up to their big day, and to choose quotes that are suited to their budget
									</li>
									<li>
										<u>Get Married Like a Local, Wherever You Are </u> - Getting married away from home can make it tricky to find the right Suppliers & Venues for your wedding events. wedBooker brings the wedding market to your fingertips, with online bookings and reviews for Suppliers & Venues all around Australia.
									</li>
								</ol>
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div role="tab" id="headingThree" class="panel-heading">
							<h4 class="panel-title">
								<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
									How does wedBooker work for Couples?
									<span class="pull-right"><i class="fa fa-chevron-right"></i></span>
									<span class="pull-right"><i class="fa fa-chevron-down"></i></span>
								</a>
							</h4>
						</div>
						<div id="collapseThree" role="tabpanel" aria-labelledby="headingThree" class="panel-collapse collapse">
							<div class="panel-body">
								<ol>
									<li>
										<u>Tell us what you need for your wedding day</u>. Whether you're looking for a florist, a photographer, a venue or something else entirely, simply post a job detailing the service you require, and let our professional community of wedding businesses pitch for your work. Using our quick and easy templates, you can specify what you need so that the most suited businesses can send you a quote.
									</li>
									<li>
										<u>Sit back and let the quotes roll in</u>. We'll automatically notify you when you receive quotes, so you can review and compare them in your planning Dashboard. Our integrated review system will allow you to choose the Suppliers and Venues that are most suited to your budget, style and preference.
									</li>
									<li>
										<u>Pay securely & manage your budget</u>. Once you're ready to confirm your bookings, check out safely with our secure payment system. Each booking will be added to your payment tracker so you can easily manage your budget and be reminded when your final payments are due.
									</li>
									<li>
										<u>Help us maintain a professional community</u>. After your big day, you'll have the chance to review any suppliers and venues you booked through wedBooker. We value each Couple's experience, as this helps us to maintain a network of reliable and trusted wedding businesses.
									</li>
								</ol>
							</div>
						</div>
					</div>
	
	
					<div class="panel panel-default">
						<div role="tab" id="headingThirteen" class="panel-heading">
							<h4 class="panel-title">
								<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThirteen" aria-expanded="false" aria-controls="collapseThirteen">
									Does wedBooker charge me any fees to book through the site?
									<span class="pull-right"><i class="fa fa-chevron-right"></i></span>
									<span class="pull-right"><i class="fa fa-chevron-down"></i></span>
								</a>
							</h4>
						</div>
						<div id="collapseThirteen" role="tabpanel" aria-labelledby="headingThirteen" class="panel-collapse collapse">
							<div class="panel-body">
								No, wedBooker doesn't charge Couples anything to book on our platform. It is completely free for couples to use our booking services.
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div role="tab" id="headingFour" class="panel-heading">
							<h4 class="panel-title">
								<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
									How do I sign up as a Couple?
									<span class="pull-right">
										<i class="fa fa-chevron-right"></i></span>
										<span class="pull-right"><i class="fa fa-chevron-down"></i></span>
									</a>
								</h4>
							</div>
							<div id="collapseFour" role="tabpanel" aria-labelledby="headingFour" class="panel-collapse collapse">
								<div class="panel-body">
									Simply click <a href="{{ url('/sign-up') }}" style="color: rgb(255, 255, 255);">here</a> - it takes less than 30 seconds!
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div role="tab" id="headingFive" class="panel-heading">
								<h4 class="panel-title">
									<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
										How do I communicate with a Supplier or Venue I have booked?
										<span class="pull-right"><i class="fa fa-chevron-right"></i></span>
										<span class="pull-right"><i class="fa fa-chevron-down"></i></span>
									</a>
								</h4>
							</div>
							<div id="collapseFive" role="tabpanel" aria-labelledby="headingFive" class="panel-collapse collapse">
								<div class="panel-body">
									wedBooker’s inbuilt messaging system makes it easier to communicate with the Suppliers and Venues you book, all in the one place! You will be notified when you have new messages in your inbox via your notification method of choice, be it text or email.
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div role="tab" id="headingSix" class="panel-heading">
								<h4 class="panel-title">
									<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
										How does payment work?
										<span class="pull-right">
											<i class="fa fa-chevron-right"></i>
										</span>
										<span class="pull-right"><i class="fa fa-chevron-down"></i></span>
									</a>
								</h4>
							</div>
							<div id="collapseSix" role="tabpanel" aria-labelledby="headingSix" class="panel-collapse collapse">
								<div class="panel-body">
									When you select a quote that you are happy with, simply check out using your payment method of choice via our secure payment platform (powered by Assembly Payments). Your invoice will then be saved into your dashboard and amounts paid and owing added to your budget.
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div role="tab" id="headingSeven" class="panel-heading">
								<h4 class="panel-title">
									<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
										What happens once I've booked a Supplier or Venue?
										<span class="pull-right"><i class="fa fa-chevron-right"></i></span>
										<span class="pull-right"><i class="fa fa-chevron-down"></i></span>
									</a>
								</h4>
							</div>
							<div id="collapseSeven" role="tabpanel" aria-labelledby="headingSeven" class="panel-collapse collapse">
								<div class="panel-body">
									The booking will be saved to your dashboard.  You can then communicate with your Supplier or Venue via wedBooker’s inbuilt messaging system and begin planning your big day!
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div role="tab" id="headingEight" class="panel-heading">
								<h4 class="panel-title">
									<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
										What happens if a Supplier or Venue cancels on me or I need to cancel on them?
										<span class="pull-right"><i class="fa fa-chevron-right"></i></span>
										<span class="pull-right"><i class="fa fa-chevron-down"></i></span>
									</a>
								</h4>
							</div>
							<div id="collapseEight" role="tabpanel" aria-labelledby="headingEight" class="panel-collapse collapse">
								<div class="panel-body">
									If due to circumstances the wedding is unable to go ahead, each Venue or Supplier should have its own cancellation policy within their terms and conditions. Be sure to read the Venue or Supplier’s terms and conditions before accepting their quote and clarifying anything you are uncertain about. You can contact us at <a href="mailto:hello@wedbooker.com">hello@wedbooker.com</a> for any assistance.
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div role="tab" id="headingNine" class="panel-heading">
								<h4 class="panel-title">
									<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
										How do I leave a review?
										<span class="pull-right"><i class="fa fa-chevron-right"></i></span>
										<span class="pull-right"><i class="fa fa-chevron-down"></i></span>
									</a>
								</h4>
							</div>
							<div id="collapseNine" role="tabpanel" aria-labelledby="headingNine" class="panel-collapse collapse">
								<div class="panel-body">
									Once you have had your perfect day, we will prompt you to leave a review to help other Couples plan their day.
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div role="tab" id="headingTen" class="panel-heading">
								<h4 class="panel-title">
									<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
										Having trouble logging in?
										<span class="pull-right"><i class="fa fa-chevron-right"></i></span>
										<span class="pull-right"><i class="fa fa-chevron-down"></i></span>
									</a>
								</h4>
							</div>
							<div id="collapseTen" role="tabpanel" aria-labelledby="headingTen" class="panel-collapse collapse">
								<div class="panel-body">
									Use our "reset password" function on the login page and we will send you an email to reset your password . If you’ve forgotten which email address you signed up with, you can contact us at <a href="mailto:hello@wedbooker.co" style="color: rgb(255, 255, 255);">hello@wedbooker.com</a> and we will help you out!
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div role="tab" id="headingEleven" class="panel-heading">
								<h4 class="panel-title">
									<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseEleven" aria-expanded="false" aria-controls="collapseEleven">
										How do I report an issue?
										<span class="pull-right"><i class="fa fa-chevron-right"></i></span>
										<span class="pull-right"><i class="fa fa-chevron-down"></i></span>
									</a>
								</h4>
							</div>
							<div id="collapseEleven" role="tabpanel" aria-labelledby="headingEleven" class="panel-collapse collapse">
								<div class="panel-body">
									We are here to help with any issues you experience when using our site. We want to make it better for you so please contact us at <a href="mailto:hello@wedbooker.co" style="color: rgb(255, 255, 255);">hello@wedbooker.com</a>
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div role="tab" id="headingTwelve" class="panel-heading">
								<h4 class="panel-title">
									<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwelve" aria-expanded="false" aria-controls="collapseTwelve">
										I want to remove my profile
										<span class="pull-right"><i class="fa fa-chevron-right"></i></span>
										<span class="pull-right"><i class="fa fa-chevron-down"></i></span>
									</a>
								</h4>
							</div>
							<div id="collapseTwelve" role="tabpanel" aria-labelledby="headingTwelve" class="panel-collapse collapse">
								<div class="panel-body">
									We are sad to hear you are leaving. Please send us an email at <a href="mailto:hello@wedbooker.co" style="color: rgb(255, 255, 255);">hello@wedbooker.com</a> and we will remove your profile for you. Thanks for joining the wedBooker community – we have loved having you. Come back any time! Remember you can always book other events such as hens and bucks on wedBooker. xo
								</div>
							</div>
						</div>
	
						<div class="panel panel-default">
							<div role="tab" id="headingFifteen" class="panel-heading">
								<h4 class="panel-title">
									<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFifteen" aria-expanded="false" aria-controls="collapseFifteen">
										How do wedBooker's verified reviews work? Can I trust the reviews about a business?
										<span class="pull-right"><i class="fa fa-chevron-right"></i></span>
										<span class="pull-right"><i class="fa fa-chevron-down"></i></span>
									</a>
								</h4>
							</div>
							<div id="collapseFifteen" role="tabpanel" aria-labelledby="headingFifteen" class="panel-collapse collapse">
								<div class="panel-body">
									You can learn all about how our Verified Review System works <a style="color: #fff;" href="{{ url('/review-policy') }}">here</a>.
								</div>
							</div>
						</div>
	
						<div class="panel panel-default">
							<div role="tab" id="headingSixteen" class="panel-heading">
								<h4 class="panel-title">
									<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSixteen" aria-expanded="false" aria-controls="collapseSixteen">
										What is wedBooker's Content Policy?
										<span class="pull-right"><i class="fa fa-chevron-right"></i></span>
										<span class="pull-right"><i class="fa fa-chevron-down"></i></span>
									</a>
								</h4>
							</div>
							<div id="collapseSixteen" role="tabpanel" aria-labelledby="headingSixteen" class="panel-collapse collapse">
								<div class="panel-body">
									You can view our Content Policy <a style="color: #fff;" href="{{ url('/content-policy') }}">here</a>.
								</div>
							</div>
						</div>
	
						<div class="panel panel-default">
							<div role="tab" id="headingSeventeen" class="panel-heading">
								<h4 class="panel-title">
									<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSeventeen" aria-expanded="false" aria-controls="collapseSeventeen">
										What if I want to cancel a booking?
										<span class="pull-right"><i class="fa fa-chevron-right"></i></span>
										<span class="pull-right"><i class="fa fa-chevron-down"></i></span>
									</a>
								</h4>
							</div>
							<div id="collapseSeventeen" role="tabpanel" aria-labelledby="headingSeventeen" class="panel-collapse collapse">
								<div class="panel-body">
								We recommend that you reach out to the business to let them know why you'd like to cancel the booking, using our in-dashboard messenger system. Please note in accordance with wedBooker's Terms and Conditions, once a deposit has been paid for a booking it is at the Supplier/Venue's discretion whether to refund the deposit. Once discussed with the Supplier/Venue and you are sure that you'd like to cancel the booking, you can then go to the Confirmed Bookings tab in your dashboard, and select "Cancel Booking / Request Refund" for that booking. We will then help to process the cancellation as long as it meets the requirements of wedBooker's <a style="color: #fff;" href="{{ url('/terms-and-conditions') }}">Terms and Conditions</a>.
								</div>
							</div>
						</div>
					</div>
			@endif
		</div>
	</div>
</div>