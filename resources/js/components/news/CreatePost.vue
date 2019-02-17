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
        category_id: '',
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
  mounted () {
    window.axios.get(`/api/post-categories`)
      .then(response => {
        this.categories = response.data
        console.log(this.categories)
      }).catch(error => {
        console.log(error)
      })

    console.log(this.post.category_id)
    console.log(this.$refs.dropzoneUploadRef)
  },
  methods: {
    publishPost: function() {
      axios.post(`/api/posts`, {
        title: this.post.title,
        description: this.post.description,
        category_id: this.selected,
        image_id: this.post.image_id,
        content: this.post.content,
        posted_by: localStorage.getItem('user_id')
      }).then(result => {
        console.log(result)
        this.showBadge = true
        this.success.isSuccess = true
        this.success.message = 'Post successfully published'
        this.resetForm()
        this.$router.go(-1)
      }).catch(error => {
        console.log(error)
      })
    },
    setImage: function(e) {
      if (this.file.fileAdded == true) {
        this.showDropzone = true
        this.$refs.dropzoneUploadRef.processQueue()
        this.image.display = true
        this.showImage = true
        console.log(`Progress: ${this.file.myProgress}`)
      }
      console.log(`Display: ${this.image.display}`)
      console.log(this.file.uploadProgress)
    },
    removeImage: function(file, xhr, error) {
      this.showDropzone = true
      this.showImage = false
      this.$refs.dropzoneUploadRef.removeFile(file)
      if (this.image.display === true) {
        let id = this.image.image_id
        axios.delete(`/api/images/${id}`)
          .then(response => console.log(response))
          .catch(error => console.log(error))
        this.image.display = false
        this.file.success = false
        console.log(`Display: ${this.image.display}`)
        console.log(file)
      }
    },
    resetForm: function() {
      this.post.title = '',
      this.post.description = '',
      this.post.image_id = null,
      this.post.content = '',
      this.post.posted_by = null
      this.selected = null

      this.showForm = false;
      this.showBadge = true;

      this.success.isSuccess = true;
      this.success.message = 'Form resetted'
      this.errors.isError = false;
      this.errors.message = null;

      this.$nextTick(() => { this.showForm = true })
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
      // Upload image api
      // axios.post('http://your-url-upload', formData).then(response => {
      //   console.log(response)
      // })
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
