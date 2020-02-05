<h4 class="error-message">
	<h3 class="text-primary text-case-up" style="font-family: Josefin Slab;">PLEASE VERIFY YOUR EMAIL ADDRESS...</h3>
	To make sure we've got your correct details, we've sent you a quick verification email. Please check your email inbox.
	<br />
	<br />
</h4>
<form action="{{ url('verify-email/resend') }}" method="POST">
	{{ csrf_field() }}
	<button type="submit" class="btn wb-btn-orange">
		Resend Email Verification Link
	</button>
</form>