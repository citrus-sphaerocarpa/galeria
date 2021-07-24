<template>
    <div>
        <a class="uk-link-muted" @click="followUser"><i :class="[ this.status ? 'fa-user-check' : 'fa-user-plus', 'fas' ]"></i></a>
    </div>

</template>

<script>
    import axios from 'axios';
    export default {
        props: ['userId', 'follows'],

        mounted() {
            console.log('Component mounted.')
        },

        data: function() {
            return {
                status: this.follows,
            }
        },

        methods: {
            followUser() {
                axios.post('/follow/' + this.userId)
                    .then(response => {
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

        // computed: {
        //     buttonText() {
        //         console.log('3:' + this.status);
        //         // return (this.status) ? 'Unfollow' : 'Follow';
        //         return this.status;
        //     }
        // }
    }
</script>
