<template>
  <div class="animated fadeIn">
    <b-row>
      <b-col>
        <b-card>
          <div slot="header">
            <i class="fas fa-image"></i> <strong>Gallery</strong>
          </div>
          <b-row>
            <b-col md="4" sm="4" class="mb-3">
              <b-button variant="success"><i class="fas fa-upload"></i> Upload Image</b-button>
            </b-col>
            <b-col md="2" sm="4" class="mb-3 ml-auto text-right">
              <h6>Total Image: {{ images.length }}</h6>
            </b-col>
            <b-col md="12" class="text-center">
              <spinner v-if="loading"></spinner>
              <b-row>
                <b-col v-for="image in displayedPosts" :key="image.id" md="6">
                  <b-card
                    :img-src="image.image_link"
                    :img-alt="image.image_name"
                    img-top>
                    <b-row>
                      <b-col md="9" sm="8" class="text-left">
                        <b-form-input 
                          v-if="isEditing"
                          v-model="image_name"
                          :value="image.image_name" 
                          type="text" 
                          placeholder="Image Name" />
                        <h5 v-else>{{ image.image_name }}</h5>
                      </b-col>
                      <b-col md="3" sm="4">
                        <b-button 
                          v-if="isEditing"
                          variant="success" 
                          @click="updateImage(image.id)">
                          <i class="fas fa-check"></i>
                        </b-button>
                        <b-button-group v-else>
                          <b-button variant="success" @click="editImage()"><i class="fas fa-pencil-alt"></i></b-button>
                          <b-button variant="danger" @click="deleteImage(image.id)"><i class="fas fa-trash"></i></b-button>
                        </b-button-group>
                      </b-col>
                    </b-row>                    
                  </b-card>
                </b-col>
              </b-row>
            </b-col>
            <b-col class="text-center">
              <b-button-group size="lg">
                <b-button variant="primary" aria-label="Prev" :disabled="page <= 1" @click.prevent="page--">
                  <span aria-hidden="true">Prev</span>
                  <span class="sr-only">Prev</span>
                </b-button>
                <b-button variant="primary" aria-label="Next" :disabled="page >= pages.length" @click.prevent="page++">
                  <span aria-hidden="true">Next</span>
                  <span class="sr-only">Next</span>
                </b-button>
              </b-button-group>
            </b-col>
          </b-row>
        </b-card>
      </b-col>
    </b-row>
  </div>
</template>

<script>

import Swal from 'sweetalert2'

export default {
  name: 'Gallery',
  data () {
    return {
      loading: false,
      isEditing: false,

      image_name: '',

      images: [],
      currentPage: 1,
      perPage: 4,
      page: 1,
      pages: [],
      lazyProps: {
        blank: true,
        blankColor: '#bbb',
        fluid: true,
        width: '512',
        height: '224',
        class: 'mb-3',
      }
    }
  },
  methods: {
    showLightbox (e) {
      console.log(e.target.src)
    },
    getImages () {
      this.loading = true
      window.axios.get('/api/images')
        .then(response => {
          this.loading = false
          this.images = response.data.data
          console.log(response)
        })
        .catch(error => {
          this.loading = false
          console.log(error)
        })
    },
    editImage(id) {
      this.isEditing = true
    },
    updateImage(id) {
      this.isEditing = !this.isEditing
      Swal.fire({
        title: 'Are you sure?',
        text: "You will update the selected image.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Update'
      })
      .then((result) => {
        if (result.value) {
          window.axios.patch(`/api/images/${id}`, {
            image_name: this.image_name
            })
            .then(response => {
              Swal.fire(
                'Updated!',
                'This image has been deleted.',
                'success'
              )
            })
            .catch(error => {
              Swal.fire(
                'Error!',
                'Error updating image',
                'error'
              )
            })
        }
      })
    },
    deleteImage(id) {
      Swal.fire({
        title: 'Are you sure?',
        text: "You will delete the selected image.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Delete'
      })
      .then((result) => {
        if (result.value) {
          window.axios.delete(`/api/images/${id}`)
            .then(response => {
              Swal.fire(
                'Deleted!',
                'This image has been deleted.',
                'success'
              )
              const index = this.images.findIndex(image => image.id === id)
              if (~index) {
                this.images.splice(index, 1)
              }
            })
            .catch(error => {
              Swal.fire(
                'Error!',
                'Error deleting image',
                'error'
              )
            })
        }
      })
    },
    setPages () {
      let numberOfPages = Math.ceil(this.images.length / this.perPage)
      for(let i = 1; i <= numberOfPages; i++) {
        this.pages.push(i)
      }
    },
    paginate(images) {
      let page = this.page
      let perPage = this.perPage
      let from = (page * perPage) - perPage
      let to = (page * perPage)
      return images.slice(from, to)
    },
  },
  computed: {
    displayedPosts() {
      return this.paginate(this.images)
    }
  },
  watch: {
    images() {
      this.setPages()
    },
    '$route': 'getImages'
  }, 
  created () {
    this.getImages()
  }
}

</script>

