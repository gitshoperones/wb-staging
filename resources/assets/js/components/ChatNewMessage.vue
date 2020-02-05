<template>
    <span v-if="unread" class="contact-list-new-message">new message</span>
    <span v-else class="contact-last-read">{{ lastRead }}</span>
</template>

<script>
import Moment from 'moment'

export default {
    props: {
        userId: {
            type: Number,
            required: true
        },
        conversationId: {
            type: String|Number
        }
    },
    data () {
        return { 
            unread: true,
            lastRead: ''
        }
    },
    async created () {
        await this.checkMessage()
    },
    methods: {
        checkMessage () {
            const self = this,
                inputs = {
                    user_id: self.userId,
                    conversation_id: self.conversationId
                }

            axios.post('/dashboard/message-new', inputs)
                .then(response => response.data)
                .then(response => {
                    if (self.conversationId) {
                        self.unread = response.data.unread
                        self.lastRead = (response.data.last_read != null) 
                                        ? Moment(response.data.created_at).format('DD/MM/YYYY')
                                        : ''
                    }
                })
        }
    }
}
</script>

<style scoped>
.contact-last-read {
    color: #000000;
}
</style>