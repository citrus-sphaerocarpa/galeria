<template>
    <div>
        <button class="uk-button uk-button-link notification-icon" id="notifications">
            <!-- <i class="far fa-bell fa-2x"></i> -->
            <span uk-icon="icon: bell; ratio: 1.3"></span>
            <span class="uk-badge notification-badge" v-text="notifications.length"></span>
        </button>
        <div uk-dropdown="mode: click">
            <ul v-if="notifications.length > 0" class="uk-list" id="notificationsMenu">
                <li v-for="(notification, index) in notifications.slice(0, 10)" :key="index" class="uk-active uk-alert-primary notification-list" uk-alert>
                    <a v-if="notification.type === newFollower" :href="'/profile/' + notification.data.sender_username + '?read=' + notification.id" class="uk-link-reset"><span class="uk-text-bold">{{ notification.data.sender_username }}</span> {{ $t("followed you.") }}</a>
                    <a v-else-if="notification.type === newPrivateMessage" :href="'/chat/private/' + notification.data.sender_username + '?read=' + notification.id" class="uk-link-reset"><span class="uk-text-bold">{{ notification.data.sender_username }}</span> {{ $t("sent you a message.") }}</a>
                </li>
            </ul>
            <ul v-else class="uk-list uk-margin-remove">
                <li class="uk-active uk-alert-default notification-list" uk-alert>{{ $t("No notifications.") }}</li>
            </ul>
            <div v-if="notifications.length > 0" class="uk-text-center">
                <a class="uk-link-muted" href="/notifications">{{ $t("See All") }}</a>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    export default {

        props: ['userId'],

        created: function() {
            this.fetchNotifications();
        },

        mounted() {
            Echo.private('follow.' + this.userId)
                .listen('UserFollowed', (e) => {
                    this.fetchNotifications();
                });
        },

        data: function() {
            return {
                polling: undefined,
                notifications: [],
                newFollower: 'App\\Notifications\\NewFollower',
                newPrivateMessage: 'App\\Notifications\\NewPrivateMessage',
                currentPath: '',
            }
        },

        methods: {
            // Get latest notifications from your API
            fetchNotifications() {
                this.currentPath = { path: window.location.pathname };
                console.log(window.location.pathname.split('/')[1]);
                axios.get('/notifications/fetch', {params: this.currentPath})
                    .then(response => {
                        this.notifications = response.data;
                    });
            },
        },
        
    }
</script>
