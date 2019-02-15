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
              <b-form @submit.prevent="publishPost" @reset.prevent="resetForm" v-if="showForm">
                <b-form-group
                  label="Title"
                  label-for="title"
                  :label-cols="3"
                  :horizontal="true">
                  <b-form-input id="title" type="text" v-model="post.title"></b-form-input>
                </b-form-group>

                <b-form-group
                  label="Description"
                  label-for="description"
                  :label-cols="3"
                  :horizontal="true">
                  <b-form-input id="description" type="text" v-model="post.description"></b-form-input>
                </b-form-group>

                <b-form-group
                  label="Category"
                  label-for="category"
                  :label-cols="3"
                  :horizontal="true">
                  <!-- <vue-tags-input
                    v-model="post.category"
                    :tags="tags"
                    @tags-changed="newTags => tags = newTags"
                  ></vue-tags-input> -->
                  <b-form-select @change="onChange" v-model="selected" :plain="true" class="mb-3">
                    <option :value="null">-- Please select an option --</option>
                    <option v-for="category in this.categories.data" :key="category.id" :value="category.id">{{ category.post_category }}</option>
                  </b-form-select>
                </b-form-group>

                <b-form-group
                  label="Main Image"
                  label-for="image"
                  :label-cols="3"
                  :horizontal="true">
                </b-form-group>
                <vue-dropzone
                  id="dropzoneUpload"
                  ref="dropzoneUploadRef"
                  @vdropzone-file-added="vfileAdded"
                  @vdropzone-success="vsuccess"
                  @vdropzone-error="verror"
                  @vdropzone-removed-file="vremoved"
                  @vdropzone-mounted="vmounted"
                  @vdropzone-drop="vdrop"
                  @vdropzone-total-upload-progress="vprogress"
                  :options="dropzoneOptions" 
                  class="mb-3"
                  v-show="showDropzone"></vue-dropzone>
                  <b-col class="text-center">
                    <b-img v-show="showImage" fluid :src="this.image.image_link" class="mb-3 text-center" />
                  </b-col>

                  <b-col class="text-center">
                    <b-button v-if="image.display === false && file.success == false" variant="success" @click.prevent="setImage" @vdropzone-sending="vsending">Set Main Image</b-button>
                    <b-button v-if="image.display === true && file.success == true" variant="danger" @click.prevent="removeImage">Remove Image</b-button>
                  </b-col>

                <b-form-group
                  label="Content"
                  label-for="content"
                  :label-cols="3"
                  :horizontal="true">
                </b-form-group>
                <vue-editor v-model="post.content" class="mb-3"></vue-editor>

                <b-button type="reset" variant="danger" md="3 ml-auto">Reset</b-button>
                <b-button type="submit" variant="primary" md="3 ml-auto">Publish</b-button>

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
// import VueTagsInput from '@johmun/vue-tags-input'
import VueDropzone from 'vue2-dropzone'

export default {
  name: 'CreatePost',
  components: {
    VueEditor,
    // 'vue-tags-input': VueTagsInput,
    'vue-dropzone': VueDropzone,
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
      errors: {
        isError: false,
        message: '',
      },
      success: {
        isSuccess: false,
        message: '',
      },
      image: {
        display: false,
        image_id: null,
        image_name: '',
        image_link: '',
      },
      file: {
        fileAdded: false,
        success: false,
        error: false,
        removedFile: false,
        sending: false,
        uploadProgress: false,
        progress: false,
        myProgress: 0,
        isMounted: false,
        drop: false
      },
      selected: null,
      categories: [],
      dropzoneOptions: {
        url: '/api/images',
        // url: 'http://eprov.id/api/images',
        thumbnailWidth: 200,
        autoProcessQueue: false,
        addRemoveLinks: true,
        maxFiles: 1,
        dictDefaultMessage: "<i class='fas fa-upload'></i> Drop here to upload",
        accept(file, done) {
          done()
        }
      },
      showForm: true,
      showBadge: false,
      showDropzone: true,
      showImage: false
    }
  },
  mounted () {
    axios.get(`/api/post-categories`)
      .then(response => {
        this.categories = response.data
        console.log(this.categories)
      }).catch(error => {
        console.log(error)
      })

    console.log(this.post.category_id)
    console.log(this.$refs.dropzoneUploadRef)
    // axios.post()
  },
  methods: {
    publishPost: function() {
      
      console.log()
      // alert('Processing!')

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
        // this.$router.go(-1)
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
      console.log()
    },
    onChange: function(e) {
      console.log(e)
    },
    vfileAdded(file) {
      this.file.fileAdded = true
      console.log(file)
    },
    vsuccess(file, response) {
      this.file.success = true
      console.log(file)
      this.image.image_id = response.data.id
      this.image.image_name = response.data.image_name
      this.image.image_link  = response.data.image_link
      this.post.image_id = this.image.image_id
      console.log(this.image)
      console.log(this.post)
    },
    verror(file, error) {
      this.file.error = true
      console.log(file)
      console.log(error)
    },
    vremoved(file, xhr, error) {
      this.file.removedFile = true
      console.log(file)
      console.log(error)
    },
    vsending(file, xhr, formData) {
      this.file.sending = true
      console.log(file)
      console.log(formData)
    },
    vprogress(totalProgress, totalBytes, totalBytesSent) {
      this.file.progress = true
      this.file.myProgress = Math.floor(totalProgress)
      console.log(totalProgress)
    },
    vmounted() {
      this.file.isMounted = true
    },
    vdrop() {
      this.file.drop = true
    },
  },
  watch: {
    fileAdded() {
      let that = this.file
      setTimeout(function() {
        that.fileAdded = false
      }, 2000)
    },
    success() {
      let that = this.file
      setTimeout(function() {
        that.success = false
      }, 2000)
    },
    error() {
      let that = this.file
      setTimeout(function() {
        that.error = false
      }, 2000)
    },
    removedFile() {
      let that = this.file
      setTimeout(function() {
        that.removedFile = false
      }, 2000)
    },
    sending() {
      let that = this.file
      setTimeout(function() {
        that.sending = false
      }, 2000)
    },    
    progress() {
      let that = this.file
      setTimeout(function() {
        that.progress = false
      }, 2000)
    },
    isMounted() {
      let that = this.file
      setTimeout(function() {
        that.isMounted = false
      }, 2000)
    },
    drop() {
      let that = this.file
      setTimeout(function() {
        that.drop = false
      }, 2000)
    },
  }
}
</script>

