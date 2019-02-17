<template>
  <div class="animated fadeIn">
    <b-row>
      <b-col>
        <b-card>
          <div slot="header">
            <strong><i class="fas fa-pencil-alt" /> Update Location</strong>
          </div>
          <b-row>
            <b-col>
              <b-form @submit.prevent="updateLocation(id)">
                <b-row>
                  <b-col md="6" sm="12">
                    <b-form-group
                      label="Location Name"
                      label-for="location"
                      :label-cols="3"
                      :horizontal="true">
                      <b-form-input id="location" 
                        type="text" 
                        v-model="location.location"></b-form-input>
                    </b-form-group>

                    <b-form-group
                      label="Description"
                      label-for="description"
                      :label-cols="3"
                      :horizontal="true">
                      <b-form-input id="description" 
                        type="text" 
                        v-model="location.description"></b-form-input>
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

                    <b-form-group
                      label="Address"
                      label-for="address"
                      :label-cols="3"
                      :horizontal="true">
                      <b-form-textarea id="address"
                        name="address"
                        rows="3"
                        max-rows="6" 
                        v-model="location.address"></b-form-textarea>
                    </b-form-group>

                  </b-col>
                  <b-col>
                    <b-form-group
                      label="Photos"
                      label-for="photos">
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
                  </b-col>
                </b-row>

                <b-button variant="primary" class="float-right">Update</b-button>

              </b-form>
            </b-col>
          </b-row>
        </b-card>
      </b-col>
    </b-row>
  </div>
</template>

<script>

import VueUploadMultipleImage from 'vue-upload-multiple-image'
import VueTagsInput from '@johmun/vue-tags-input'
import Swal from 'sweetalert2'

export default {
  name: 'UpdateLocation',
  components: {
    VueTagsInput,
    VueUploadMultipleImage
  },
  data () {
    return {
      location: {
        location: '',
        description: '',
        address: '',
      },
      photos: [],
      tag: '',
      tags: [],
      autoCompleteItems: [],
      debounce: null,

      locationId: this.$route.params.id
    }
  },
  created () {
    this.getLocations(this.locationId)
  },
  computed: {
    user () {
      return this.$store.getters['authentication/currentUser']
    },
  },
  methods: {
    getLocations (id) {
      window.axios.get(`/api/locations/${id}`)
        .then(response => {
          this.location = response.data.data
          this.tags = this.location.category.map(i => {
            return { text: i.location_category }
          })
          console.log(this.location)
        })
        .catch(error => {
          console.error(error)
        }) 
    },

    getCategories: function () {
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
    
    updateLocation (id) {
      Swal.fire({
        type: 'warning',
        title: 'Are you sure want to change this location?',
        text: 'This location will be changed.',
        showCancelButton: true
      })
      .then(result => {
        if (result.value) {
          window.axios.patch('/api/locations', {
            location: this.location.name,
            description: this.location.description,
            address: this.location.address,
            category: this.tags.map(i => {
              return i.id
            }),
            photos: this.photos,
            posted_by: this.user.id,
          })
          .then(response => {
            Swal.fire('Publish success!', 'Location successfully published.', 'success')
            console.log(response)
            return this.$router.back()
          })
          .catch(error => {
            Swal.fire('Error!', 'Error publishing event.', 'error')
            console.log(error)
          })
        }
      })
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

    updateTag(newTag) {
      this.autoCompleteItems = [],
      this.tags = newTag
    },
  },
  watch: {
    'tag': 'getCategories'
  }
}
</script>