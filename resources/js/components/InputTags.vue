<template>
  <div>
    <vue-tags-input
        v-model="tag"
        placeholder="Add tags ..."
        :tags="tags"
        :autocomplete-items="filteredItems"
        :max-tags=20
        :maxlength=150
        @tags-changed="newTags => tags = newTags"
    />
    <input type="hidden" id="tags" name="tags" :value="JSON.stringify(tags)">
  </div>
</template>

<script>
import axios from 'axios';
import VueTagsInput from '@johmun/vue-tags-input';

export default {
    components: {
        VueTagsInput,
    },

    data() {
        return {
            tag: '',
            tags: [],
            autocompleteItems: [],
            currentPath: '',
        };
    },

    created(){
        this.fetchPostsTags();
        this.fetchAllTags();
    },

    computed: {
        filteredItems() {
            return this.autocompleteItems.filter(i => {
                return i.text.toLowerCase().indexOf(this.tag.toLowerCase()) !== -1;
            });
        },
    },

    methods: {
        fetchPostsTags() {
            // Get the current path
            // Check if user is creating or editing post
            this.currentPath = window.location.pathname;

            if(this.currentPath.includes('edit')) {
                const arr = this.currentPath.split('/');
                axios.get('/tags?p=' + arr[arr.length - 2])
                    .then(response => {
                        this.tags = response.data
                        console.log('oldtags');
                        console.log(this.tags);
                });
            }
        },

        fetchAllTags() {
            // Get all tags for autocomplete
            axios.get('/tags')
                .then(response => {
                    this.autocompleteItems = response.data
                    console.log('tags');
                    console.log(this.autocompleteItems);
            })
            .catch((error)=>{
                this.errorMsg = 'Could not reach the API. ' + error
                console.log(this.errorMsg)
            });
        },
    },
    
}
</script>

<style lang="css">
@import url('https://fonts.googleapis.com/css2?family=Benne&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;500&display=swap');

.ti-new-tag-input{
    font-family: 'Roboto', sans-serif;
    font-weight: 300;
}

/* default styles for all the tags */
.vue-tags-input .ti-tag {
  position: relative;
  background: #1e87f0;
}

/* the selected item in the autocomplete layer, should be highlighted */
.vue-tags-input .ti-item.ti-selected-item {
  background: #1e87f0;
}

  /* style the placeholders color across all browser */
.vue-tags-input ::-webkit-input-placeholder {
  color: #999;

}

.vue-tags-input ::-moz-placeholder {
  color: #999;

}

.vue-tags-input :-ms-input-placeholder {
  color: #999;

}

.vue-tags-input :-moz-placeholder {
  color: #999;
}

.vue-tags-input {
  max-width: 530px !important;
}
</style>
