<template>
    <div>
        <p v-if="path.match(/search/) && total == 1" class="uk-width-1-1">{{ total }} {{ $t("result") }}</p>
        <p v-if="path.match(/search/) && total > 1" class="uk-width-1-1 uk-margin-small">{{ $t("About") }} {{ total }} {{ $t("results") }}</p>

        <div class="uk-flex uk-flex-wrap uk-grid-small" uk-grid>
            <div v-for="post in posts" :key="post.index" class="uk-width-1-3">
                <a :href="'/p/' + post.id">
                    <img :src="'/storage/' + post.image" alt="" class="uk-responsive-width">
                </a>                                                         
            </div>
        </div>

        <infinite-loading @infinite="infiniteHandler" spinner="spiral">
            <div class="uk-margin-top uk-margin-bottom" slot="no-more"></div>
            <div class="uk-margin-xlarge-top uk-margin-bottom" slot="no-results">{{ $t("No posts found.") }}</div>
        </infinite-loading>

        <div class="uk-placeholder"></div>
    </div>
</template>

<script>
    import InfiniteLoading from 'vue-infinite-loading';
    import axios from 'axios';

    export default {
         props: ['path', 'data'],

        data() {
            return {
                page: 1,
                posts: [],
                total: '',
                api: '',
            };
        },
        
        methods: {
            infiniteHandler($state) {
                if(this.path == 'profile') {
                    this.api = '/' + this.path + '/' + this.data + '/posts';
                } else if(this.path == 'p') {
                    this.api = '/' + this.path +'/following';
                } else if(this.path == 'favoriting') {
                    this.api = '/p/' + this.path;
                } else if(this.path == 'search') {
                    this.api = '/search/fetch/' + this.data;
                } else if(this.path == 'searchTag') {
                    this.api = '/search/tag/fetch/' + this.data;
                }
                axios.get(this.api, {
                    params: {
                        page: this.page,
                    },
                }).then(({ data }) => {
                    this.total = data.total;
                    //Load posts data per second
                    setTimeout(() => {

                        if (this.page <= data.last_page) {
                            this.page += 1
                            this.posts.push(...data.data)
                            $state.loaded()
                        } else {
                            $state.complete()
                        }
                    }, 1000)
                }).catch((err) => {
                    $state.complete()
                })
            },
        }
    }
</script>
