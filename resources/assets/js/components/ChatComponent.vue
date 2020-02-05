<template>
	<div class="wb-chat-messages">
		<div class="wb-chat-log-wrapper">
			<div class="wb-chat-msg"
				:class="{ 'right': message.user_id == myUserId, 'left': message.user_id !== myUserId }"
				v-for="(message, index) in chatMessages">
				<div class="wb-chat-img-wrapper">
					<img class="wb-chat-img" v-if="message.user_id == myUserId"
						:src="myAvatar ? myAvatar : '/assets/images/couple-placeholder.jpg'">
					
					<img class="wb-chat-img" v-else
						:src="recipientAvatar ? recipientAvatar : '/assets/images/couple-placeholder.jpg'">
					
					<span 
						class="wb-chat-name text-right" v-if="message.user_id == myUserId"
					>
						{{ title }}
					</span>
					<span class="wb-chat-name text-right" v-else>
						{{ recipient }}
					</span>

					<div class="wb-chat-timestamp">
						<span>{{ formatDate(message.created_at) }}</span> <br/>
						<a class="wb-chat-btn" v-if="message.user_id == myUserId" @click="deleteMessage(message, index)"><u>Delete</u></a>
					</div>

				</div>
				<div class="wb-chat-text" v-if="message.type === 'image'">
					<a :href="message.body" data-lightbox="image-1">
					   <img class="wb-chat-attach-img image-msg" :src="message.body" style="max-width: 120px!important;">
					</a>
				</div>
				<div class="wb-chat-text" v-else-if="message.type === 'text'">
					{{ message.body }}
				</div>
				<div class="wb-chat-text" v-else>
					<a :href="message.body" target="_blank">
					   <i class="fa fa-file"></i> Open File
					</a>
				</div>
			</div>
		</div>
		<div class="wb-chat-title" v-show="someoneIsTyping && conversationId">
			<span class="name">{{ userThatIsTyping }}</span>
			<span class="details">is typing...</span>
		</div>
		<div class="wb-chat-composer" v-if="conversationId">
			<input @change="onFileChange" type="file" name="user_file" id="user-file" class="hidden">
			<label for="user-file" type="button" class="btn btn-clear attach"><i class="fa fa-paperclip"></i></label>
			<input type="text" placeholder="Type your message" @keydown="isTyping()" v-model="message" @keyup.enter="send()">
			<button @click.prevent="send()" type="button" class="btn btn-primary btn-rnd send"><i class="fa fa-paper-plane"></i></button>
		</div>
	</div>
</template>

<script>
	import Moment from 'moment';

	export default {
		props: ['myAvatar', 'myUserId', 'conversationId', 'title', 'messages', 'recipientAvatar', 'recipient'],
		data() {
			return {
				message: '',
				chatMessages: [],
				someoneIsTyping: false,
				userThatIsTyping: ''
			}
		},
		methods: {
			onFileChange(event) {
				let self = this;
				let form = new FormData();
				let file = event.target.files[0];
				let type = null;

				if (!file && file.type.split('/')[0]) {
					alert('Invalid file.');
					return false;
				}

				type = file.type.split('/')[0];

				if (!type) {
					alert('Invalid file.');
				}

				if (type === "text") {
					type = 'file';
				}

				NProgress.start();

				form.append('messageType', type);
				form.append('message', file);
				form.append('conversationId', self.conversationId);

				axios.post('/dashboard/messages', form)
				.then(function (response) {
					self.chatMessages.push({
						user_id: response.data.user_id,
						type: response.data.type,
						body: response.data.body,
						time: self.formatDate(response.data.created_at)
					});
					self.done();
				});
			},
			send() {
				let self = this;

				if (!this.message) {
					return false;
				}

				NProgress.start();

				axios.post('/dashboard/messages', {
					message: self.message,
					conversationId: self.conversationId
					})
					.then(function (response) {
						self.chatMessages.push({
							user_id: response.data.user_id,
							body: response.data.body,
							type: response.data.type,
							time: self.formatDate(response.data.created_at)
						});
						self.done();
					});
			},
			getMessage(msgId) {
				let self = this;

				NProgress.start();

				axios.get('/dashboard/messages/'+msgId)
					.then(function (response) {
						self.chatMessages.push({
							user_id: response.data.user_id,
							body: response.data.body,
							type: response.data.type,
							time: self.formatDate(response.data.created_at)
						});
						self.done();
						document.getElementById('new-message').play();
					});
			},
			isTyping() {
				const self = this;
				setTimeout(function() {
					Echo.private(`conversation.${self.conversationId}`)
					.whisper('typing', {
						name: self.title,
					});
				}, 300);
			},
			done() {
				this.message = '';
				$('#user-file').val('');
				NProgress.done();
				$(".wb-chat-log-wrapper")
				.stop().
				animate({ scrollTop: $(".wb-chat-log-wrapper")[0].scrollHeight}, 1000);
			},
			formatDate(d) {
				return Moment(d).format('DD/MM/YY - h:mm a');
			},
			deleteMessage(message, msgIndex) {
				let self = this;

				swal({
					title: 'Are you sure?',
					text: "You are about to delete this message!",
					type: 'warning',
					width: 600,
					padding: '3em',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes understood!'
				}).then((result) => {
					if (result.value) {
						NProgress.start();

						axios.post('/dashboard/messages/delete', {
							messageId: message.id,
							conversationId: self.conversationId
							})
							.then(function (response) {
								self.chatMessages.splice(msgIndex, 1);
								self.done();
							});
					}
				});
			},
		},
		mounted() {
			if (!this.conversationId) {
				return false;
			}
			const self = this;

			let messages = JSON.parse(this.messages);

			if (messages) {
				self.chatMessages = messages;
			}

			Echo.private(`conversation.${self.conversationId}`)
			.listen('MessageSent', (e) => {
				self.getMessage(e.messageId);
			}).listenForWhisper('typing', (e) => {
				self.someoneIsTyping = true;
				self.userThatIsTyping = e.name;
				setTimeout(function(){self.someoneIsTyping = false;}, 5000);
			});
		},
		updated() {
			$(".wb-chat-log-wrapper")
			.stop().
			animate({ scrollTop: $(".wb-chat-log-wrapper")[0].scrollHeight}, 1000);
		}
	}
</script>

<style scoped>
.wb-chat-name {
	display: block;
	font-size: 14px;
	font-weight: bold;
	font-family: 'Josefin Slab';
	color: #353554;
    max-width: 135px;
}
</style>