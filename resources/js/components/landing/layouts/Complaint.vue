<template>
  <section id="complaint" class="bg-white">

    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <h2 class="section-heading">Kolom Aduan</h2>
          <hr class="my-4">
        </div>
      </div>

      <div class="container">
        <div class="row">
          <div class="col-lg-12 text-center">
            <button class="btn btn-primary btn-xl" @click="!isLoggedIn ? showAlert() : showComplaint()">Buat Aduan</button>
          </div>
          <b-modal title="Buat Aduan" size="xl" class="modal-primary" ref="complaintModalRef" ok-title="Send Complaint" @ok.prevent="sendComplaint">
            <b-form>
              <b-row>
                <b-col md="6" sm="12">

                  <b-form-group
                    label="Complaint"
                    label-for="complaint"
                    :label-cols="4"
                    :horizontal="true"
                    :state="!errors.has('complaint') ? null : false"
                    :invalid-feedback="errors.first('complaint')">
                    <b-form-input id="complaint"
                      type="text"
                      name="complaint" 
                      class="form-control"
                      :state="!errors.has('complaint') ? null : false"
                      v-model="complaint.complaint"
                      v-validate="'required'"></b-form-input>
                  </b-form-group>

                  <b-form-group
                    label="Description"
                    label-for="description"
                    :label-cols="4"
                    :horizontal="true"
                    :state="!errors.has('description') ? null : false"
                    :invalid-feedback="errors.first('description')">
                    <b-form-textarea id="description"
                      name="description"
                      :state="!errors.has('description') ? null : false"
                      v-model="complaint.description"
                      v-validate="'required'"
                      rows="3"
                      max-rows="6">
                    </b-form-textarea>
                  </b-form-group>

                </b-col>

                <b-col md="6" sm="12">

                  <b-form-group
                    label="Full Name"
                    label-for="fullName"
                    :state="!errors.has('full-name') ? null : false" 
                    :invalid-feedback="errors.first('full-name')"
                    :label-cols="4"
                    :horizontal="true">
                    <b-form-input id="fullName"
                      name="full-name" 
                      type="text"
                      :state="!errors.has('full-name') ? null : false" 
                      v-model="complaint.fullName"
                      v-validate="'required'"></b-form-input>
                  </b-form-group>

                  <b-form-group
                    label="Address"
                    label-for="address"
                    :state="!errors.has('address') ? null : false" 
                    :invalid-feedback="errors.first('address')"
                    :label-cols="4"
                    :horizontal="true">
                    <b-form-textarea id="address"
                      name="address" 
                      :state="!errors.has('address') ? null : false" 
                      v-model="complaint.address"
                      v-validate="'required'"></b-form-textarea>
                  </b-form-group>

                  <b-form-group
                    label="Category"
                    label-for="category"
                    :label-cols="4"
                    :state="!errors.has('category') ? null : false" 
                    :invalid-feedback="errors.first('category')"
                    :horizontal="true">
                    <b-form-select
                      id="category"
                      name="category" 
                      v-model="selected"
                      :state="!errors.has('category') ? null : false" 
                      v-validate="'required'"
                      :plain="true" 
                      class="mb-3">
                      <option :value="null">-- Please select an option --</option>
                      <option v-for="category in this.categories" :key="category.id" :value="category.id">{{ category.complaint_category }}</option>
                    </b-form-select>
                  </b-form-group>

                </b-col>
              </b-row>
              <b-row>
                <b-col>
                  <b-form-group
                    label="Image"
                    label-for="image"
                    :label-cols="4"
                    :horizontal="true">
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
            </b-form>
          </b-modal>
        </div>
      </div>

    </div>
  </section>
</template>

<script>

import VueUploadMultipleImage from 'vue-upload-multiple-image'
import Swal from 'sweetalert2'

export default {
  name: 'Complaint',
  components: {
    VueUploadMultipleImage
  },
  data() {
    return {
      loading: false,
      complaint: {
        complaint: '',
        description: '',
        fullName: '',
        address: '',
        category_id: '',
        complaint_by: ''
      },
      selected: null,
      categories: [],
      images: [],
    }
  },
  created () {
    this.getCategories()
  },
  computed: {
    isLoggedIn () {
      return this.$store.getters['authentication/isLoggedIn']
    },
    user () {
      return this.$store.getters['authentication/currentUser']
    }
  },
  methods: {
    sendComplaint () {
      Swal.fire({
        type: 'warning',
        title: 'Are you sure to sending this complaint?',
        text: 'This complaint will be sent.',
        showCancelButton: true
      })
      .then(result => {
        if (result.value) {
          window.axios.post('/api/complaints', {
            complaint: this.complaint.complaint,
            description: this.complaint.description,
            full_name: this.complaint.fullName,
            address: this.complaint.address,
            category_id: this.selected,
            photos: this.photos,
            complaint_by: this.user.id,
          })
          .then(response => {
            Swal.fire('Complaint success!', 'Complaint successfully sent.', 'success')
            console.log(response)
          })
          .catch(error => {
            Swal.fire('Error!', 'Error sending complaint.', 'error')
            console.log(error)
          })
          console.log({
            complaint: this.complaint.complaint,
            description: this.complaint.description,
            fullName: this.complaint.fullName,
            address: this.complaint.address,
            category_id: this.selected,
            photos: this.photos,
            complaint_by: this.user.name,
          }) 
        }
      })
      .catch(error => {
        Swal.fire('Error!', 'Try again later.', 'error')
        console.log(error)
      })
    },

    showAlert () {
      Swal.fire({
        type: 'error',
        title: 'Oops...',
        text: 'You must login first!',
      })
    },

    showComplaint () {
      this.$refs.complaintModalRef.show()
    },

    getCategories () {
      this.loading = true
      window.axios.get('/api/complaint-categories')
      .then(response => {
        this.loading = false
        this.categories = response.data.data
        console.log(this.categories)
      })
      .catch(error => {
        this.loading = false
        console.log(error)
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
          Swal.fire('Removed!', 'Your image has removed', 'success')
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
  }
}
</script>

<style lang="scss" scoped>

@import '../../../../sass/landing.scss';

</style>