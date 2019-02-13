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
          <b-modal title="Buat Aduan" size="xl" class="modal-primary" ref="complaintModalRef">
            <b-alert variant="success" dismissible :show="showMessage">Success</b-alert>
            <b-form>
              <b-row>
                <b-col md="6" sm="12">

                  <b-form-group
                    label="Complaint"
                    label-for="complaint"
                    :label-cols="4"
                    :horizontal="true">
                    <b-form-input id="complaint" type="text" v-model="complaint.complaint"></b-form-input>
                  </b-form-group>

                  <b-form-group
                    label="Description"
                    label-for="description"
                    :label-cols="4"
                    :horizontal="true">
                    <b-form-textarea
                      id="description"
                      v-model.trim="complaint.description"
                      :rows="4">
                    </b-form-textarea>
                  </b-form-group>

                </b-col>

                <b-col md="6" sm="12">

                  <b-form-group
                    label="Nama Lengkap"
                    label-for="nama"
                    :label-cols="3"
                    :horizontal="true">
                    <b-form-input id="nama" type="text" v-model="complaint.complaint_by"></b-form-input>
                  </b-form-group>

                  <b-form-group
                    label="Category"
                    label-for="category"
                    :label-cols="3"
                    :horizontal="true">
                    <b-form-select v-model="selected" :plain="true" class="mb-3">
                      <option :value="null">-- Please select an option --</option>
                      <option v-for="category in this.categories.data" :key="category.id" :value="category.id">{{ category.complaint_category }}</option>
                    </b-form-select>
                  </b-form-group>

                </b-col>
              </b-row>
              <b-row>
                <b-col>
                  <b-form-group
                    label="Image"
                    label-for="image"
                    :label-cols="3"
                    :horizontal="true">
                  </b-form-group>
                  <vue-dropzone
                      id="dropzoneUpload"
                      ref="dropzoneUploadRef"
                      :options="dropzoneOptions" 
                      class="mb-3"></vue-dropzone>
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

import VueDropzone from 'vue2-dropzone'
import Swal from 'sweetalert2'

export default {
  name: 'Complaint',
  components: {
    'vue-dropzone': VueDropzone
  },
  data() {
    return {
      showMessage: false,
      complaint: {
        complaint: '',
        description: '',
        address: '',
        image_id: '',
        category_id: '',
        complaint_by: ''
      },
      selected: null,
      categories: [],
      dropzoneOptions: {
        url: '/api/images',
        thumbnailWidth: 200,
        autoProcessQueue: false,
        addRemoveLinks: true,
        dictDefaultMessage: "<i class='fas fa-upload'></i> Drop here to upload",
        accept(file, done) {
          done()
        }
      }
    }
  },
  mounted() {
    this.getCategories()
  },
  computed: {
    isLoggedIn: function () {
      return this.$store.getters['authentication/isLoggedIn']
    }
  },
  methods: {
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

    getCategories: () => {
      axios.get('/api/complaint-categories')
      .then(response => {
        this.categories = response.data
      })
      .catch(error => {
        console.log(error)
      })
    }
  }
}
</script>

<style lang="scss" scoped>

@import '../../../../sass/landing.scss';

</style>