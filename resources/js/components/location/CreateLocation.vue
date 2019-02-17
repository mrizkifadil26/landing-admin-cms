<template>
  <div class="animated fadeIn">
    <b-row>
      <b-col>
        <b-card>
          <div slot="header">
            <strong><i class="fas fa-pencil" />Add Location</strong>
          </div>
          <b-row>
            <b-col>
              <b-form @submit.prevent="addLocation">
                <b-row>
                  <b-col md="6" sm="12">
                    <b-form-group
                      label="Location Name"
                      label-for="location"
                      :label-cols="3"
                      :horizontal="true"
                      :state="!errors.has('location') ? null : false"
                      :invalid-feedback="errors.first('location')">
                      <b-form-input id="location"
                        name="location" 
                        type="text"
                        v-model="location.name"
                        :state="!errors.has('location') ? null : false" 
                        v-validate="'required'"></b-form-input>
                    </b-form-group>

                    <b-form-group
                      label="Description"
                      label-for="description"
                      :label-cols="3"
                      :horizontal="true"
                      :state="!errors.has('description') ? null : false"
                      :invalid-feedback="errors.first('description')">
                      <b-form-textarea id="description"
                        name="description"
                        rows="3"
                        max-rows="6" 
                        v-model="location.description"
                        :state="!errors.has('description') ? null : false" 
                        v-validate="'required'"></b-form-textarea>
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
                      :horizontal="true"
                      :state="!errors.has('address') ? null : false"
                      :invalid-feedback="errors.first('address')">
                      <b-form-textarea id="address"
                        name="address"
                        rows="3"
                        max-rows="6" 
                        v-model="location.address"
                        :state="!errors.has('address') ? null : false" 
                        v-validate="'required'"></b-form-textarea>
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

                <b-button type="submit" variant="primary" md="3" class="float-right">Create</b-button>

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
import { clearTimeout, setTimeout } from 'timers';

export default {
  name: 'CreateLocation',
  components: {
    VueTagsInput,
    VueUploadMultipleImage
  },
  data () {
    return {
      location: {
        name: '',
        description: '',
        address: '',
        posted_by: null,
      },
      images: [],
      photos: [],
      tag: '',
      tags: [],
      autoCompleteItems: [],
      debounce: null
    }
  },
  computed: {
    user () {
      return this.$store.getters['authentication/currentUser']
    }
  },
  methods: {
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
    addLocation: function() {
      Swal.fire({
        type: 'warning',
        title: 'Are you sure want to add this location?',
        text: 'This location will be published.',
        showCancelButton: true
      })
      .then(result => {
        if (result.value) {
          this.$validator.validate()
          .then((result) => {
            if (result) {
              window.axios.post('/api/locations', {
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
            } else {
              Swal.fire('Error!', 'Try again later.', 'error')
              console.log(error)
            }
          })
        }
      })
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
    }
  },
  computed: {
    user () {
      return this.$store.getters['authentication/currentUser']
    }
  },
  watch: {
    'tag': 'getCategories'
  }
}
</script>