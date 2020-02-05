@extends('layouts.dashboard')

@section('content')
<section class="content dashboard-container">
	<div class="container-fluid">
		<div class="wb-tab-messages">
			<div class="tab-content" style="margin-top: 0;">
				<div class="tab-pane active">
					<div class="wb-chat-container" id="wedbooker-chat-container">
						<div class="wb-chat-contacts">
							<ul class="contact-list">
								@foreach($contactHistory as $contact)
								<li class="{{ $contact->id === (int) $recipientUserId ? 'active' : ''}}">
									@php
										$getConversation = Chat::getConversationBetween(auth()->user()->id, $contact->id);

										$isRead = ($message_notification = auth()->user()->notifications
											->where('type', 'Musonza\Chat\Notifications\MessageSent')
											->where('data.conversation_id', $getConversation->id)
											->first()) ? $message_notification->read_at : true;

										if ($isRead) {
											$get_date = optional(DB::table('mc_messages')
												->where('conversation_id', $getConversation->id)
												->orderBy('created_at', 'desc')
												->first())->created_at;
											$isRead = ($get_date) ? date('d/m/Y', strtotime($get_date)) : ' ';
										}
									@endphp
									@if ($contact->vendorProfile)
									   @include(
                                            'partials.messages.contact',
                                            [
                                                'type' => 'vendors',
                                                'contact' => $contact,
												'profile' => $contact->vendorProfile,
												'read' => $isRead,
                                            ]
                                        )
									@elseif ($contact->coupleA)
									   @include(
                                            'partials.messages.contact',
                                            [
                                                'type' => 'couples',
                                                'contact' => $contact,
                                                'profile' => $contact->coupleA,
												'read' => $isRead,
                                            ]
                                        )
                                    @elseif ($contact->coupleB)
                                        @include(
                                            'partials.messages.contact',
                                            [
                                                'type' => 'couples',
                                                'contact' => $contact,
                                                'profile' => $contact->coupleB,
												'read' => $isRead,
                                            ]
                                        )
                                    @endif
								</li>
								@endforeach
							</ul>
						</div>

						<chat conversation-id="{{ isset($conversation) ? $conversation->id : '' }}"
							my-avatar="{{ $loggedInUserProfile->profile_avatar }}"
							recipient-avatar="{{ $recipientAvatar }}"
							my-user-id="{{ Auth::user()->id }}"
							messages="{{ json_encode($messages) }}"
							title="{{ $title }}"
							recipient="{{ $recipient }}"
							></chat>
						<audio id="new-message" src="/assets/media/new-message.mp3" class="hidden"></audio>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@include('modals.new-message')
@endsection


