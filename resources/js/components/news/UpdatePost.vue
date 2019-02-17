<template>
  <div class="animated fadeIn">
    <b-row>
      <b-col>
        <b-card>
          <div slot="header">
            <strong><i class="fas fa-pencil" />Edit Post</strong>
          </div>
          <b-row>
            <b-col>
              <b-form @submit.prevent="updatePost(id)" @reset.prevent="resetForm">
                <b-row>
                  <b-col md="6" sm="12">
                    <b-form-group
                      label="Title"
                      label-for="title"
                      :label-cols="3"
                      :horizontal="true">
                      <b-form-input id="title" 
                        type="text" 
                        v-model="post.title"></b-form-input>
                    </b-form-group>
                  </b-col>
                  <b-col md="6" sm="12">
                    <b-form-group
                      label="Category"
                      label-for="category"
                      :label-cols="3"
                      :horizontal="true">
                      <vue-tags-input
                        v-model="tag"
                        :tags="tags"
                        :autocomplete-items="autoCompleteItems"
                        :add-only-from-autocomplete="true"
                        @tags-changed="updateTag"></vue-tags-input>
                    </b-form-group>
                  </b-col>  
                </b-row>
              
                <b-form-group
                  label="Main Image"
                  label-for="image">
                </b-form-group>
                
                <b-form-group
                  label="Content"
                  label-for="content">
                  <vue-editor 
                    v-model="post.content" 
                    class="mb-3"></vue-editor>
                </b-form-group>
                
                <b-row>
                  <b-col></b-col>
                  <b-col class="ml-auto text-right">
                    <b-button type="reset" variant="danger" md="3 ml-auto">Reset</b-button>
                    <b-button type="submit" variant="primary" md="3 ml-auto">Publish</b-button>
                  </b-col>
                </b-row>

              </b-form>

            </b-col>
          </b-row>
        </b-card>
      </b-col>
    </b-row>
  </div>
</template>

<script>

import { VueEditor } from 'vue2-editor'
import VueTagsInput from '@johmun/vue-tags-input'
import VueUploadMultipleImage from 'vue-upload-multiple-image'

export default {
  name: 'UpdatePost',
  components: {
    VueEditor,
    VueTagsInput,
    VueUploadMultipleImage
  },
  data () {
    return {
      post: {
        title: '',
        description: '',
        category: '',
      },
      getPost: {
        title: '',
        category: '',
        content: '',
      },
      tags: [],
      tag: '',
      autoCompleteItems: [],
      debounce: null,

      postId: this.$route.params.id
    }
  },
  methods: {
    getPosts(id) {
      window.axios.get(`/api/posts/${id}`)
        .then(response => {
          this.post = response.data.data
          console.log(this.post)
        })
        .catch(error => {
          console.error(error)
        }) 
    },
    resetForm() {
      this.post = {}
    },
    getCategories: function() {
      if (this.tag.length < 2) return;
      clearTimeout(this.debounce)
      this.debounce = setTimeout(() => {
        axios.get('/api/location-categories')
        .then(response => {
          this.autoCompleteItems = response.data.data.map(i => {
            return {
              id: i.id,
              text: i.location_category
            }
          })
          console.log(this.autoCompleteItems)
        })
        .catch(error => {
          console.log(error)
        })
      }, 600)
    },
    updateTag(newTag) {
      this.autoCompleteItems = [],
      this.tags = newTag
    },
  },
  created () {
    this.getPosts(this.postId)
  },
  watch: {
    'tag': 'getCategories'
  }
}
</script>

