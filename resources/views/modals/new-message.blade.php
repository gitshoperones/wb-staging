<div id="wb-modal-message" class="modal wb-modal-message" style="display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<div class="user-wrapper">
					<div class="item-wrapper">
						@if (count($contactList) > 0)
							@foreach ($contactList as $list)
							<div class="item">
								<a href="{{ url(sprintf('/%s/%s', Auth::user()->account === 'couple' ? 'vendors' : 'couples', $list->id)) }}">
									<img alt="message user image"
										class="avatar"
										@if ($list->profile_avatar)
											src="{{ $list->profile_avatar }}"
										@else
											src="https://placeimg.com/300/300/people"
										@endif
										>
									<div class="name">
										@vendor
											{{ $list->title }}
										@endvendor
										@couple
											{{ $list->business_name }}
										@endcouple
									</div>
									<a href="{{ url(sprintf('/dashboard/messages?recipient_user_id=%s', $list->user_id)) }}"
										class="btn btn-primary btn-message">
										Message
									</a>
								</a>
							</div>
							@endforeach
						@else
							<h3 class="text-center">
							You don't have any contacts yet. You can message users once you have an open quote or booking with them.
							</h3>
						@endif
					</div><!-- /.item-wrapper -->
				</div><!-- /.user-wrapper -->
			</div>
		</div>
	</div>
</div>