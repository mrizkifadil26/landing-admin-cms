<template>
  <div class="animated fadeIn">
    <b-row>
      <b-col>
        <b-card>
          <div slot="header">
            <i class="fas fa-list"></i><strong> Location Categories</strong>
          </div>
          <b-row class="mb-3">
            <b-col md="3" sm="4 mb-3">
              <b-button variant="primary" @click="addLocationCategory"><i class="fas fa-plus"></i> Add Category</b-button>
            </b-col>
            <b-col md="4 ml-auto" sm="6 ml-auto">
              <b-form-group>
                <b-input-group>
                  <b-form-input 
                    type="text" 
                    placeholder="Type to Search"
                    v-model="filter"></b-form-input>
                  <b-input-group-append>
                    <b-button 
                      variant="primary"
                      :disabled="!filter" 
                      @click="filter = ''">Clear</b-button>
                  </b-input-group-append>
                </b-input-group>
              </b-form-group>
            </b-col>
          </b-row>
          <b-row>
            <b-col>
              <b-table
                fixed hover
                responsive="sm" 
                :items="locationCategories" 
                :fields="fields" 
                :current-page="currentPage" 
                :per-page="perPage"
                :filter="filter"
                @filtered="onFiltered">
                <template slot="actions" slot-scope="data">
                  <b-button class="mb-1" variant="warning" @click="showLocationCategory(data.item)">Edit</b-button>
                  <b-button class="mb-1" variant="danger" @click="deleteLocationCategory(data.item.id)">Delete</b-button>
                </template>
              </b-table>
              <spinner v-show="loading"></spinner>
              <b-modal id="locationCategoriesModal"
                ref="showLocationCategory"
                :title="!isEditing ? 'Add Location Category' : 'Change Location Category'"
                size="md" 
                :class="!isEditing ? 'modal-primary' : 'modal-warning'" 
                @ok.prevent="!isEditing ? storeLocationCategory() : updateLocationCategory(updateLocationCategories.id)"
                @hidden="isEditing = false"
                :ok-title="!isEditing ? 'Add' : 'Change'">
                <b-form-group
                  label="Category Name"
                  label-for="locationCategory"
                  :label-cols="4"
                  :horizontal="true">
                  <b-form-input id="locationCategory"
                    name="locationCategory"
                    v-model="locationCategory"
                    :value="!isEditing ? '' : updateLocationCategories.locationCategory"></b-form-input>
                </b-form-group>
              </b-modal>
              <nav>
                <b-pagination
                  :total-rows="totalRows"
                  :per-page="perPage" 
                  v-model="currentPage" 
                  prev-text="Prev" 
                  next-text="Next" 
                  hide-goto-end-buttons>
                </b-pagination>
              </nav>
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
  name: 'LocationCategories',  
  data() {
    return {
      loading: false,
      currentPage: 1,
      perPage: 10,
      filter: null,

      isEditing: false,

      locationCategories: [],
      locationCategory: '',
      updateLocationCategories: {
        id: null,
        locationCategory: '',
      },
      fields: [
        { key: 'location_category', sortable: true },
        { key: 'actions' }
      ]
    }
  },
  methods: {
    getLocationCategories() {
      this.loading = true
      axios.get('/api/location-categories')
      .then(response => {
        this.loading = false
        this.locationCategories = response.data.data
        console.log(this.locationCategories)
      })
      .catch(error => {
        this.loading = false
        console.log(error)
      })
    },
    addLocationCategory () {
      this.isEditing = false
      this.$refs.showLocationCategory.show()
    },
    storeLocationCategory () {
      Swal.fire({
        title: 'Are you sure?',
        text: "You will add the selected category.",
        type: 'warning',
        showCancelButton: true,
      })
      .then(result => {
        if (result.value) {
          window.axios.post(`/api/location-categories/`, { location_category: this.locationCategory })
          .then(response => {
            Swal.fire('Category added!', 'Successfully added the category.', 'success')
            this.$router.go(0)
            console.log(response)
          })
          .catch(error => {
            console.log(error)
          })
        }
      })
    },
    showLocationCategory (item) {
      this.isEditing = true
      this.$refs.showLocationCategory.show()
      this.updateLocationCategories.id = item.id
      this.updateLocationCategories.locationCategory = item.location_category
    },
    updateLocationCategory (id) {
      Swal.fire({
        title: 'Are you sure?',
        text: "You will change the selected category.",
        type: 'warning',
        showCancelButton: true,
      })
      .then(result => {
        if (result.value) {
          window.axios.patch(`/api/location-categories/${id}`, { location_category: this.locationCategory })
          .then(response => {
            Swal.fire('Category changed!', 'Successfully changed the category.', 'success')
            this.$router.go(0)
            console.log(response)
          })
          .catch(error => {
            console.log(error)
          })
        }
      })
    },
    deleteLocationCategory (id) {
      Swal.fire({
        title: 'Are you sure?',
        text: "You will delete the selected location.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Delete'
      })
        .then((result) => {
          if (result.value) {
            window.axios.delete(`/api/location-categories/${id}`)
              .then(response => {
                Swal.fire(
                  'Deleted!',
                  'This location has been deleted.',
                  'success'
                )
                const index = this.locationCategories.findIndex(locationCategory => locationCategory.id === id)
                if (~index) {
                  this.locationCategories.splice(index, 1)
                }
              })
              .catch(error => {
                Swal.fire(
                  'Error!',
                  'Error deleting category',
                  'error'
                )
              })
          }
      })
    },
    onFiltered (filteredItems) {
      this.totalRows = filteredItems.length
      this.currentPage = 1
    }
  },
  created() {
    this.getLocationCategories()
  },
  computed: {
    totalRows: function() {
      return this.locationCategory.length
    },
    sortOptions() {
      return this.fields
        .filter(f => f.sortable)
        .map(f => {
          return { text: f.label, value: f.key }
        })
    }
  }
}

</script>