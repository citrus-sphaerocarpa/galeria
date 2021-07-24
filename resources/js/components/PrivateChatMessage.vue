<template>
    <div>
        <div style="height: 80px;"></div>
        <div id="messageContainer">
            <ul v-for="(message, index) in allMessages" :key="message.id" class="uk-list uk-comment" ref="messages">

                <!-- Date Separator -->
                <h1 v-if="index == 0" class="uk-h6 uk-heading-line uk-text-center uk-text-muted uk-margin-top">
                    <span>{{ format(new Date(message.created_at), 'PPPP') }}</span>
                </h1>
                <h1 v-if="index !== 0 && !compareDates(message.created_at, allMessages[index - 1].created_at)"
                    class="uk-h6 uk-heading-line uk-text-center uk-text-muted">
                    <span>{{ format(new Date(message.created_at), 'PPPP') }}</span>
                </h1>
                <!-- User -->
                <li v-if="user.id == message.user_id" class="uk-flex uk-flex-right">
                    <div class="balloon-right">
                        <div class="uk-text-small uk-margin-small-right">
                            {{ format(new Date(message.created_at), 'HH:mm') }}
                        </div>
                        <div class="message-right">
                            
                            <p class="new-line">{{ message.message }}</p>
                        </div>
                    </div>
                </li>

                <!-- Friend -->
                <li v-else class="uk-flex uk-flex-left">
                    <div class="balloon-left">
                        <div class="faceicon">
                            <img :src="friendProfileImage" alt="" >
                        </div>
                        <div class="message-left">
                            <p class="new-line">{{ message.message }}</p>
                        </div>
                        <div class="uk-text-small uk-margin-small-left">
                            {{ format(new Date(message.created_at), 'HH:mm') }}
                        </div>
                    </div>
                </li>

            </ul>

        </div>
        <div class="uk-container uk-height-medium"></div>

        <div class="uk-flex uk-flex-center navbar-bottom uk-navbar-container uk-animation-slide-bottom uk-navbar-transparent postbar-background" uk-navbar>
            <div class="uk-width-1-2@s uk-padding-small">
                <input type="hidden" name="_token" :value="csrf">
                <div class="uk-text-right">
                    <textarea v-model="message" class="uk-textarea @error('message') is-invalid @enderror"
                    name="message" placeholder="Write a message..."></textarea>
                    <div v-if="errorMessage" class="uk-text-left">
                        <span class="uk-form-danger">
                            <strong>{{ errorMessage }}</strong>
                        </span>
                    </div>
                    <button class="uk-button uk-button-small uk-text-bold uk-margin-small-top" @click="sendPrivateMessage">{{ $t("Send") }}</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import { format, parseISO } from 'date-fns';
    export default {
        props: ['user', 'friendId', 'friendProfileImage', 'roomNumber'],
        data: function() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                format,
                message: '',
                allMessages: [],
                errorMessage: '',
            }
        },

        created: function() {
            this.fetchPrivateMessages();
        },

        mounted: function() {
            // Once the MessageSent event is broadcast, we need to listen for this event so we can update the chat messages with the newly sent message. 
            Echo.private('pchat.' + this.roomNumber)
                .listen('PrivateMessageSent', (e) => {
                    this.allMessages.push(e.message);
                    setTimeout(this.scrollToEnd, 100);
                });
        },

        setup() {
            // Scroll to the latest message
            const latestMessage = ref(null)
            
            onUpdated(() => {
            latestMessage.value.scrollTop = latestMessage.value.scrollHeight
            })

            return latestMessage;
        },

        methods: {
            
            fetchPrivateMessages() {
                axios.get('/privatemessages/' + this.roomNumber)
                    .then(response => {
                        this.allMessages = response.data;
                        setTimeout(this.scrollToEnd, 100);
                    });
            },

            sendPrivateMessage() {
                // Check if there is a message
                if (!this.message) {
                    return this.errorMessage = 'Please enter message.';
                } else if (this.message.length >= 500) {
                    return this.errorMessage = 'The message must not be greater than 500 characters.';
                }
                
                this.allMessages.push(this.message);
                // Send Post request
                axios.post('/privatemessages/' + this.roomNumber, { 
                    roomNumber: this.roomNumber,
                    friendId: this.friendId,
                    message: this.message })
                    .catch(response =>  {
                        console.log(response.data.errors.message);
                    })
                    .then(response => {
                        this.errorMessage = '';
                        this.message = '';
                        this.fetchPrivateMessages();
                        setTimeout(this.scrollToEnd, 100);
                    });
            },

            compareDates(currentDate, anotherDate) {
                const d1 = format(new Date(currentDate), 'yyyyMMdd');
                const d2 = format(new Date(anotherDate), 'yyyyMMdd');

                if(d1 == d2) {
                    return true;
                } else {
                    return false;
                }
            },
            
            scrollToEnd() {
                let messageContainer = document.getElementById('messageContainer');
 
                if(messageContainer.lastChild) {
                    let lastElementHeight = messageContainer.lastChild.clientHeight + 380;
                    window.scrollTo({top: document.body.scrollHeight - lastElementHeight || document.documentElement.scrollHeight - lastElementHeight});
                }
            },
        },
    }
</script>