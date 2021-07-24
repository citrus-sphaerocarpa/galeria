<template>
    <li><a class="uk-link-muted" @click="favoritePost"><i :class="[ this.status ? 'fas ' + 'fa-heart fa-lg favorite-icon' : 'far ' + 'fa-heart fa-lg']"></i></a></li>
</template>

<script>
    import axios from 'axios';
    export default {
        props: ['postId', 'favorites'],

        mounted() {
            console.log('Component mounted.')
        },

        data: function() {
            return {
                status: this.favorites,
            }
        },

        methods: {
            favoritePost() {
                axios.post('/favorite/' + this.postId)
                    .then(response => {
                        console.log(this.postId);
                        var hoge = JSON.stringify(this.status);
                        console.log('1:' + hoge);
                        this.status = ! this.status;
                        console.log('2:' + this.status);
                    })
                    .catch(errors => {
                        if (errors.response.status == 401) {
                            window.location = '/login';
                        }
                    });
            }
        },
    }
</script>
