<div id="vendors" class="tab-pane">
	<div class="container">
		<div id="accordion" role="tablist" aria-multiselectable="true" class="panel-group">
			@foreach($business['questions'] as $key => $question)
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
						@foreach($business['answers'] as $answer)
							{!! (substr($answer->meta_key, strpos($answer->meta_key, "_") + 1) == substr($question->meta_key, strpos($question->meta_key, "_") + 1)) ? $answer->meta_value : "" !!}
						@endforeach
					</div>
				</div>
			</div>
			@endforeach
	
	@if(count($business['questions']) <= 0)
	<div class="panel panel-default"><div role="tab" id="heading1" class="panel-heading">
			<h4 class="panel-title">
				<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse1" aria-expanded="false" aria-controls="collapse1">
					What is wedBooker?
					<span class="pull-right"><i class="fa fa-chevron-right"></i></span>
					<span class="pull-right"><i class="fa fa-chevron-down"></i></span>
				</a>
			</h4>
		</div>
		<div id="collapse1" role="tabpanel" aria-labelledby="heading1" class="panel-collapse collapse">
			<div class="panel-body">
				wedBooker is an online marketplace helping wedding couples to efficiently book talented Suppliers and beautiful Venues around Australia. wedBooker is Australia’s first end-to-end platform for Couples to search trusted and reviewed wedding businesses, compare quotes, make bookings and pay securely. wedBooker is the first and only platform for talented wedding businesses to advertise their services for free, search for work suited to their skills, and quote on that work for free. We are changing the way that Australian’s book weddings.
			</div>
		</div>
	</div>
	<div class="panel panel-default">
		<div role="tab" id="heading2" class="panel-heading">
			<h4 class="panel-title">
				<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse2" aria-expanded="false" aria-controls="collapse2">
					What makes wedBooker different?
					<span class="pull-right"><i class="fa fa-chevron-right"></i></span>
					<span class="pull-right"><i class="fa fa-chevron-down"></i></span>
				</a>
			</h4>
		</div>
		<div id="collapse2" role="tabpanel" aria-labelledby="heading2" class="panel-collapse collapse">
			<div class="panel-body">
				<ol>

					<li>Advertise your business for free with no up-front costs</li>
					<li>A market of real-time wedding jobs in your area</li>
					<li>Get notified of work that suits your business</li>
					<li>Get reviewed for the amazing work you do</li>
					<li>There are no fees to list your business, quote on jobs or make bookings. You only need to cover the small 1.2% Payment Gateway fee on bookings you win.</li>
				</ol>
			</div>
		</div>
	</div>
	<div class="panel panel-default">
		<div role="tab" id="heading3" class="panel-heading">
			<h4 class="panel-title">
				<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse3" aria-expanded="false" aria-controls="collapse3">
					How does wedBooker work for Suppliers & Venues?
					<span class="pull-right"><i class="fa fa-chevron-right"></i></span>
					<span class="pull-right"><i class="fa fa-chevron-down"></i></span>
				</a>
			</h4>
		</div>
		<div id="collapse3" role="tabpanel" aria-labelledby="heading3" class="panel-collapse collapse">
			<div class="panel-body">
				<ol>
					<li>
						<u>List your business for FREE</u>. Join wedBooker, create your business profile and start advertising your services for free. Let us know what you specialise in, and which locations you're looking for work in, so we can automatically notify you of jobs that are suited to your business.
					</li>
					<li>
						<u>Quote on jobs for FREE</u>. For jobs that suit your availability, you can quickly and easily submit a quote to the Couple using our easy quoting templates. You can customise your quotes to include your business logo, terms & conditions, and any other important details. Using our business planner, you can track the status of any jobs you've quoted on, to see if they've been accepted
					</li>
					<li>
						<u>Confirm bookings & get paid</u>. When a Couple accepts your quote, they'll make payment on your invoice into your nominated bank account, using our secure payment gateway. If there is a remaining balance to be paid, we'll send them a reminder according to your payment terms, so that you don't need to be chasing invoices.
					</li>
					<li>
						<u>Get reviewed & grow your business</u>. We want you to be rewarded for the amazing work you do. Our rating system allows Couples that have booked your services to leave honest reviews after their big day so future Couples can be assured of your skills. By growing your wedBooker star rating, you can secure more work and grow your business.
					</li>
				</ol>
			</div>
		</div>
	</div>
	<div class="panel panel-default">
		<div role="tab" id="heading20" class="panel-heading">
			<h4 class="panel-title">
				<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse20" aria-expanded="false" aria-controls="collapse20">
					What is the cost to list my business?
					<span class="pull-right"><i class="fa fa-chevron-right"></i></span>
					<span class="pull-right"><i class="fa fa-chevron-down"></i></span>
				</a>
			</h4>
		</div>
		<div id="collapse20" role="tabpanel" aria-labelledby="heading20" class="panel-collapse collapse">
			<div class="panel-body">
				There is no cost to advertise your business, quote on jobs or book work with wedBooker. You simply need to cover the payment gateway fee of 1.2% for bookings that you secure through the platform. There are no other hidden fees and no lock in period. You can read more about our Fees <a href="{{ url('/fees') }}"><u>here</u></a>.
			</div>
		</div>
	</div>


	<div class="panel panel-default">
		<div role="tab" id="heading26" class="panel-heading">
			<h4 class="panel-title">
				<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse26" aria-expanded="false" aria-controls="collapse26">
					Is there any lock in period that I should be aware of?
					<span class="pull-right"><i class="fa fa-chevron-right"></i></span>
					<span class="pull-right"><i class="fa fa-chevron-down"></i></span>
				</a>
			</h4>
		</div>
		<div id="collapse26" role="tabpanel" aria-labelledby="heading26" class="panel-collapse collapse">
			<div class="panel-body">
				No, there is no lock in period with wedBooker. You can advertise with us for free, for as long as you'd like to. It's as simple as that. If you no longer find wedBooker helpful, you can cancel your account at any time.
			</div>
		</div>
	</div>

	<div class="panel panel-default">
		<div role="tab" id="heading4" class="panel-heading">
			<h4 class="panel-title">
				<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse4" aria-expanded="false" aria-controls="collapse4">
					How do I sign up?
					<span class="pull-right">
						<i class="fa fa-chevron-right"></i></span>
						<span class="pull-right"><i class="fa fa-chevron-down"></i></span>
					</a>
				</h4>
			</div>
			<div id="collapse4" role="tabpanel" aria-labelledby="heading4" class="panel-collapse collapse">
				<div class="panel-body">
					Simply click <a href="{{ url('/sign-up') }}" style="color: rgb(255, 255, 255); font-weight: 600;">here</a> - it takes less than 2 minutes.
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div role="tab" id="heading5" class="panel-heading">
				<h4 class="panel-title">
					<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse5" aria-expanded="false" aria-controls="collapse5">
						How Do I Get Paid/How Does Payment Work?
						<span class="pull-right"><i class="fa fa-chevron-right"></i></span>
						<span class="pull-right"><i class="fa fa-chevron-down"></i></span>
					</a>
				</h4>
			</div>
			<div id="collapse5" role="tabpanel" aria-labelledby="heading5" class="panel-collapse collapse">
				<div class="panel-body">
					When a Couple selects your quote, they will be directed to pay in accordance with your quote. We will notify you once they have paid and payment should be in your bank account within 2 working days.
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div role="tab" id="heading7" class="panel-heading">
				<h4 class="panel-title">
					<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse7" aria-expanded="false" aria-controls="collapse7">
						How long does it take for my business profile to be approved?
						<span class="pull-right"><i class="fa fa-chevron-right"></i></span>
						<span class="pull-right"><i class="fa fa-chevron-down"></i></span>
					</a>
				</h4>
			</div>
			<div id="collapse7" role="tabpanel" aria-labelledby="heading7" class="panel-collapse collapse">
				<div class="panel-body">
					We will approve your profile within 24 hours.
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div role="tab" id="heading8" class="panel-heading">
				<h4 class="panel-title">
					<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse8" aria-expanded="false" aria-controls="collapse8">
						Tips for getting your profile noticed
						<span class="pull-right"><i class="fa fa-chevron-right"></i></span>
						<span class="pull-right"><i class="fa fa-chevron-down"></i></span>
					</a>
				</h4>
			</div>
			<div id="collapse8" role="tabpanel" aria-labelledby="heading8" class="panel-collapse collapse">
				<div class="panel-body">
					Be sure to upload any professional photos you have that showcase your work. The more work you win, the more reviews you will get.
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div role="tab" id="heading9" class="panel-heading">
				<h4 class="panel-title">
					<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse9" aria-expanded="false" aria-controls="collapse9">
						How do I find out about jobs suited to my business?
						<span class="pull-right"><i class="fa fa-chevron-right"></i></span>
						<span class="pull-right"><i class="fa fa-chevron-down"></i></span>
					</a>
				</h4>
			</div>
			<div id="collapse9" role="tabpanel" aria-labelledby="heading9" class="panel-collapse collapse">
				<div class="panel-body">
					We will notify you of jobs suited to your profile. You can also visit the find work page when logged in to search jobs that work for you.
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div role="tab" id="heading10" class="panel-heading">
				<h4 class="panel-title">
					<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse10" aria-expanded="false" aria-controls="collapse10">
						How do I quote on a wedding job?
						<span class="pull-right"><i class="fa fa-chevron-right"></i></span>
						<span class="pull-right"><i class="fa fa-chevron-down"></i></span>
					</a>
				</h4>
			</div>
			<div id="collapse10" role="tabpanel" aria-labelledby="heading10" class="panel-collapse collapse">
				<div class="panel-body">
					Simply click “Quote on Job” and it will take you to an easy quoting template.
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div role="tab" id="heading11" class="panel-heading">
				<h4 class="panel-title">
					<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse11" aria-expanded="false" aria-controls="collapse11">
						What happens after I’ve quoted on a wedding job?
						<span class="pull-right"><i class="fa fa-chevron-right"></i></span>
						<span class="pull-right"><i class="fa fa-chevron-down"></i></span>
					</a>
				</h4>
			</div>
			<div id="collapse11" role="tabpanel" aria-labelledby="heading11" class="panel-collapse collapse">
				<div class="panel-body">
					It will be sent directly to the couple for their review. You will be notified when they accept or decline your quote. All quotes will be saved in your Dashboard for easy tracking.
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div role="tab" id="heading13" class="panel-heading">
				<h4 class="panel-title">
					<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse13" aria-expanded="false" aria-controls="collapse13">
						How will I know if my quote was successful?
						<span class="pull-right"><i class="fa fa-chevron-right"></i></span>
						<span class="pull-right"><i class="fa fa-chevron-down"></i></span>
					</a>
				</h4>
			</div>
			<div id="collapse13" role="tabpanel" aria-labelledby="heading13" class="panel-collapse collapse">
				<div class="panel-body">
					We will notify you in your dashboard and via email.
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div role="tab" id="heading14" class="panel-heading">
				<h4 class="panel-title">
					<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse14" aria-expanded="false" aria-controls="collapse14">
						How do I receive reviews?
						<span class="pull-right"><i class="fa fa-chevron-right"></i></span>
						<span class="pull-right"><i class="fa fa-chevron-down"></i></span>
					</a>
				</h4>
			</div>
			<div id="collapse14" role="tabpanel" aria-labelledby="heading14" class="panel-collapse collapse">
				<div class="panel-body">
					When you complete work on wedBooker we will encourage Couples to leave you a review.
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div role="tab" id="heading12" class="panel-heading">
				<h4 class="panel-title">
					<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse12" aria-expanded="false" aria-controls="collapse12">
						Having trouble logging in?
						<span class="pull-right"><i class="fa fa-chevron-right"></i></span>
						<span class="pull-right"><i class="fa fa-chevron-down"></i></span>
					</a>
				</h4>
			</div>
			<div id="collapse12" role="tabpanel" aria-labelledby="heading12" class="panel-collapse collapse">
				<div class="panel-body">
					Use our “reset password” function on the login page and we will send you an email to reset your password . If you’ve forgotten which email address you signed up with, you can contact us at <a href="mailto:hello@wedbooker.com">hello@wedbooker.com</a> and we will help you out!
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div role="tab" id="heading15" class="panel-heading">
				<h4 class="panel-title">
					<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse15" aria-expanded="false" aria-controls="collapse15">
						How do I report an issue?
						<span class="pull-right"><i class="fa fa-chevron-right"></i></span>
						<span class="pull-right"><i class="fa fa-chevron-down"></i></span>
					</a>
				</h4>
			</div>
			<div id="collapse15" role="tabpanel" aria-labelledby="heading15" class="panel-collapse collapse">
				<div class="panel-body">
					If  you’re experiencing any issues, please contact us at <a href="mailto:hello@wedbooker.com">hello@wedbooker.com</a> and we will help you out!
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div role="tab" id="heading16" class="panel-heading">
				<h4 class="panel-title">
					<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse16" aria-expanded="false" aria-controls="collapse16">
						How do I communicate with a wedding couple?
						<span class="pull-right"><i class="fa fa-chevron-right"></i></span>
						<span class="pull-right"><i class="fa fa-chevron-down"></i></span>
					</a>
				</h4>
			</div>
			<div id="collapse16" role="tabpanel" aria-labelledby="heading16" class="panel-collapse collapse">
				<div class="panel-body">
					Use wedBooker’s integrated messaging system so all your messages are saved in the one place and linked to the applicable job.
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div role="tab" id="heading17" class="panel-heading">
				<h4 class="panel-title">
					<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse17" aria-expanded="false" aria-controls="collapse17">
						Where do I find my invoices?
						<span class="pull-right"><i class="fa fa-chevron-right"></i></span>
						<span class="pull-right"><i class="fa fa-chevron-down"></i></span>
					</a>
				</h4>
			</div>
			<div id="collapse17" role="tabpanel" aria-labelledby="heading17" class="panel-collapse collapse">
				<div class="panel-body">
					All invoices are saved in your dashboard under “payments”.
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div role="tab" id="heading18" class="panel-heading">
				<h4 class="panel-title">
					<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse18" aria-expanded="false" aria-controls="collapse18">
						How do I upload my payment details?
						<span class="pull-right"><i class="fa fa-chevron-right"></i></span>
						<span class="pull-right"><i class="fa fa-chevron-down"></i></span>
					</a>
				</h4>
			</div>
			<div id="collapse18" role="tabpanel" aria-labelledby="heading18" class="panel-collapse collapse">
				<div class="panel-body">
					Go to your “payment settings” in your dashboard.
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div role="tab" id="heading19" class="panel-heading">
				<h4 class="panel-title">
					<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse19" aria-expanded="false" aria-controls="collapse19">
						I want to cancel my profile, how do I do This?
						<span class="pull-right"><i class="fa fa-chevron-right"></i></span>
						<span class="pull-right"><i class="fa fa-chevron-down"></i></span>
					</a>
				</h4>
			</div>
			<div id="collapse19" role="tabpanel" aria-labelledby="heading19" class="panel-collapse collapse">
				<div class="panel-body">
					We are sad to hear you are leaving. Please send us an email at <a href="mailto:hello@wedbooker.com">hello@wedbooker.com</a> and we will remove your profile for you. Thanks for joining the wedBooker community – we have loved having you. Come back any time!
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div role="tab" id="heading21" class="panel-heading">
				<h4 class="panel-title">
					<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse21" aria-expanded="false" aria-controls="collapse21">
						Do you list all Suppliers & Venues?
						<span class="pull-right"><i class="fa fa-chevron-right"></i></span>
						<span class="pull-right"><i class="fa fa-chevron-down"></i></span>
					</a>
				</h4>
			</div>
			<div id="collapse21" role="tabpanel" aria-labelledby="heading21" class="panel-collapse collapse">
				<div class="panel-body">
					No, we have a pre-vetting process to ensure the integrity of our professional community.
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div role="tab" id="heading22" class="panel-heading">
				<h4 class="panel-title">
					<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse22" aria-expanded="false" aria-controls="collapse22">
						How do I access information about the couple?
						<span class="pull-right"><i class="fa fa-chevron-right"></i></span>
						<span class="pull-right"><i class="fa fa-chevron-down"></i></span>
					</a>
				</h4>
			</div>
			<div id="collapse22" role="tabpanel" aria-labelledby="heading22" class="panel-collapse collapse">
				<div class="panel-body">
					Visit their profile page on wedBooker.
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div role="tab" id="heading23" class="panel-heading">
				<h4 class="panel-title">
					<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse23" aria-expanded="false" aria-controls="collapse23">
						Can I edit my profile?
						<span class="pull-right"><i class="fa fa-chevron-right"></i></span>
						<span class="pull-right"><i class="fa fa-chevron-down"></i></span>
					</a>
				</h4>
			</div>
			<div id="collapse23" role="tabpanel" aria-labelledby="heading23" class="panel-collapse collapse">
				<div class="panel-body">
					Yes, simply click “edit profile” in your dashboard. We are always on hand to assist you to build and improve your profile so you can access more work.
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div role="tab" id="heading24" class="panel-heading">
				<h4 class="panel-title">
					<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse24" aria-expanded="false" aria-controls="collapse24">
						Do I need insurance?
						<span class="pull-right"><i class="fa fa-chevron-right"></i></span>
						<span class="pull-right"><i class="fa fa-chevron-down"></i></span>
					</a>
				</h4>
			</div>
			<div id="collapse24" role="tabpanel" aria-labelledby="heading24" class="panel-collapse collapse">
				<div class="panel-body">
					This will depend on the service you are providing. We encourage you to seek advice from an insurance broker to ensure you are covered.
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div role="tab" id="heading25" class="panel-heading">
				<h4 class="panel-title">
					<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse25" aria-expanded="false" aria-controls="collapse25">
						What if I don’t have any professional photos that I am happy with for my profile?
						<span class="pull-right"><i class="fa fa-chevron-right"></i></span>
						<span class="pull-right"><i class="fa fa-chevron-down"></i></span>
					</a>
				</h4>
			</div>
			<div id="collapse25" role="tabpanel" aria-labelledby="heading25" class="panel-collapse collapse">
				<div class="panel-body">
					Not a problem, we can help you out! contact our team by emailing <a href="mailto:hello@wedbooker.com">hello@wedbooker.com</a> and we will arrange for a photographer to come and visit you for a small fee to get photos you can use not only on wedBooker but on your own website and marketing material.
				</div>
			</div>
		</div>

		<div class="panel panel-default">
			<div role="tab" id="heading28" class="panel-heading">
				<h4 class="panel-title">
					<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse28" aria-expanded="false" aria-controls="collapse28">
						 How do wedBooker’s verified reviews work? How will my business be reviewed on the platform?
						<span class="pull-right"><i class="fa fa-chevron-right"></i></span>
						<span class="pull-right"><i class="fa fa-chevron-down"></i></span>
					</a>
				</h4>
			</div>
			<div id="collapse28" role="tabpanel" aria-labelledby="heading28" class="panel-collapse collapse">
				<div class="panel-body">
					You can learn all about how our Verified Review System works <a style="color: #fff;" href="{{ url('/review-policy') }}">here</a>.
				</div>
			</div>
		</div>

		<div class="panel panel-default">
						<div role="tab" id="heading29" class="panel-heading">
							<h4 class="panel-title">
								<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse29" aria-expanded="false" aria-controls="collapse29">
									What is wedBooker's Content Policy?
									<span class="pull-right"><i class="fa fa-chevron-right"></i></span>
									<span class="pull-right"><i class="fa fa-chevron-down"></i></span>
								</a>
							</h4>
						</div>
						<div id="collapse29" role="tabpanel" aria-labelledby="heading29" class="panel-collapse collapse">
							<div class="panel-body">
								You can view our Content Policy <a style="color: #fff;" href="{{ url('/content-policy') }}">here</a>.
							</div>
						</div>
					</div>

	</div>
	@endif
</div>
</div>