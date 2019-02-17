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
                    <b-button type="submit" variant="primary" md="3 ml-auto">Update</b-button>
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
import Swal from 'sweetalert2'

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
        category: '',
        content: '',
      },
      tags: [],
      tag: '',
      autoCompleteItems: [],
      debounce: null,

      images: [],

      postId: this.$route.params.id
    }
  },
  methods: {
    getPosts(id) {
      window.axios.get(`/api/posts/${id}`)
        .then(response => {
          this.post = response.data.data
          this.tags = this.post.category.map(i => {
            return { text: i.post_category }
          })
          console.log(this.post)
        })
        .catch(error => {
          console.error(error)
        }) 
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

    uploadImageSuccess(formData, index, fileList) {
      console.log('data', formData, index, fileList)
      window.axios.post('/api/images', formData).then(response => {
        let id = response.data.data.id
        this.photos.push(id)
        console.log(response)
      })
    },
    beforeRemove (index, done, fileList) {
      console.log('index', index, fileList)
      Swal.fire({
        type: 'warning',
        title: 'Are you sure want to remove this image?',
        text: 'This image will be deleted.',
        showCancelButton: true
      })
      .then(result => {
        if (result.value) {
          Swal.fire('Removed!', 'Your image has renoved', 'success')
          done()
        }
      })
    },
    editImage (formData, index, fileList) {
      console.log('edit data', formData, index, fileList)
    },
    dataChange (data) {
      console.log(data)
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

