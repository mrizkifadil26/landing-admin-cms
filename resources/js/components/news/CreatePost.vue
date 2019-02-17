<template>
  <div class="animated fadeIn">
    <b-row>
      <b-col>
        <b-card>
          <div slot="header">
            <strong><i class="fas fa-pencil" />Add Post</strong>
          </div>
          <b-row>
            <b-col>
              <b-form @submit.prevent="publishPost" @reset.prevent="resetForm">
                <b-row>
                  <b-col md="6" sm="12">
                    <b-form-group
                      label="Title"
                      label-for="title"
                      :label-cols="3"
                      :horizontal="true">
                      <b-form-input id="title" type="text" v-model="post.title"></b-form-input>
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
                  <div class="dropzone">
                    <vue-upload-multiple-image
                      dragText="Upload your file here"
                      browseText="or click to Upload"
                      primaryText="Main Image"
                      markIsPrimaryText="Set as main image"
                      popupText=""
                      @upload-success="uploadImageSuccess"
                      @before-remove="beforeRemove"
                      @edit-image="editImage"
                      @data-change="dataChange"
                      :data-images="images"></vue-upload-multiple-image>
                  </div>
                </b-form-group>

                <b-form-group
                  label="Content"
                  label-for="content">
                  <vue-editor v-model="post.content" class="mb-3"></vue-editor>
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

import { VueEditor, Quill } from 'vue2-editor'
import VueTagsInput from '@johmun/vue-tags-input'
import VueUploadMultipleImage from 'vue-upload-multiple-image'
import Swal from 'sweetalert2'

export default {
  name: 'CreatePost',
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
        image_id: '',
        content: '',
        posted_by: ''
      },
      images: [],
      selected: null,
      tags: [],
      tag: '',
      autoCompleteItems: [],
      debounce: null
    }
  },
  computed: {
    user () {
      return this.$store.getters['authentication/currentUser']
    }
  },
  created () {
    
  },
  methods: {
    publishPost: function() {
      Swal.fire({
        type: 'warning',
        title: 'Are you sure want to publish this post?',
        text: 'Your post will be published.',
        showCancelButton: true
      })
      .then(result => {
        if (result.value) {
          this.$validator.validate()
            .then(result => {
              if (result) {
                window.axios.post(`/api/posts`, {
                  title: this.post.title,
                  category: this.tags.map(i => {
                    return i.id
                  }),
                  image_id: this.post.image_id,
                  content: this.post.content,
                  posted_by: this.user.id
                }).then(result => {
                  Swal.fire('Publish success!', 'This post successfully published.', 'success')
                  console.log(response)
                  return this.$router.back()
                }).catch(error => {
                  Swal.fire('Error!', 'Error publishing post.', 'error')
                  console.log(error)
                })
              } else {
                Swal.fire('Error!', 'Try again later.', 'error')
                console.log(error)
              }
            })
          
        }
      })
      // console.log({
      //   title: this.post.title,
      //   category: this.tags.map(i => {
      //     return i.id
      //   }),
      //   image_id: this.post.image_id,
      //   content: this.post.content,
      //   posted_by: this.user.id
      // })
    },
    getCategories: function() {
      if (this.tag.length < 2) return;
      clearTimeout(this.debounce)
      this.debounce = setTimeout(() => {
        window.axios.get('/api/post-categories')
        .then(response => {
          this.autoCompleteItems = response.data.data.map(i => {
            return {
              id: i.id,
              text: i.post_category
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
    uploadImageSuccess(formData, index, fileList) {
      console.log('data', formData, index, fileList)
      window.axios.post('/api/images', formData).then(response => {
        this.post.image_id = response.data.data.id
      })
    },
    beforeRemove (index, done, fileList) {
      console.log('index', index, fileList)
      var r = confirm("remove image")
      if (r == true) {
        done()
      } else {
      }
    },
    editImage (formData, index, fileList) {
      console.log('edit data', formData, index, fileList)
    },
    dataChange (data) {
      console.log(data)
    }
  },
  watch: {
    'tag': 'getCategories'
  }
}
</script>

<style scoped>

.dropzone {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  text-align: center;
}

</style>
