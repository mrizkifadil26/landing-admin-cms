<template>
  <div class="animated fadeIn">
    <b-row>
      <b-col>
        <b-card>
          <div slot="header">
            <i class="fas fa-list"></i><strong> Complaint Categories</strong>
          </div>
          <b-row class="mb-3">
            <b-col md="3" sm="4 mb-3">
              <b-button variant="primary" @click="addComplaintCategory"><i class="fas fa-plus"></i> Add Category</b-button>
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
                :items="complaintCategories" 
                :fields="fields" 
                :current-page="currentPage" 
                :per-page="perPage"
                :filter="filter"
                @filtered="onFiltered">
                <template slot="actions" slot-scope="data">
                  <b-button class="mb-1" variant="warning" @click="showComplaintCategory(data.item)">Edit</b-button>
                  <b-button class="mb-1" variant="danger" @click="deleteComplaintCategory(data.item.id)">Delete</b-button>
                </template>
              </b-table>
              <spinner v-show="loading"></spinner>
              <b-modal id="complaintCategoriesModal"
                ref="showComplaintCategory"
                :title="!isEditing ? 'Add Complaint Category' : 'Change Complaint Category'" 
                size="md" 
                :class="!isEditing ? 'modal-primary' : 'modal-warning'" 
                @ok.prevent="!isEditing ? storeComplaintCategory() : updateComplaintCategory(updateComplaintCategories.id)"
                @hidden="isEditing = false"
                :ok-title="!isEditing ? 'Add' : 'Change'">
                <b-form-group
                  label="Category Name"
                  label-for="complaintCategory"
                  :label-cols="4"
                  :horizontal="true">
                  <b-form-input id="complaintCategory"
                    name="complaintCategory"
                    v-model="complaintCategory"
                    :value="!isEditing ? '' : updateComplaintCategories.complaintCategory"></b-form-input>
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
  name: 'ComplaintCategories',  
  data() {
    return {
      loading: false,
      currentPage: 1,
      perPage: 10,
      filter: null,

      isEditing: false,

      complaintCategories: [],
      complaintCategory: '',
      updateComplaintCategories: {
        id: null,
        complaintCategory: '',
      },
      fields: [
        { key: 'complaint_category', sortable: true },
        { key: 'actions' }
      ],
    }
  },
  methods: {
    getComplaintCategories() {
      this.loading = true
      axios.get('/api/complaint-categories')
      .then(response => {
        this.loading = false
        this.complaintCategories = response.data.data
        console.log(this.complaintCategories)
      })
      .catch(error => {
        this.loading = false
        console.log(error)
      })
    },
    addComplaintCategory () {
      this.isEditing = false
      this.$refs.showComplaintCategory.show()
    },
    storeComplaintCategory () {
      Swal.fire({
        title: 'Are you sure?',
        text: "You will add the selected category.",
        type: 'warning',
        showCancelButton: true,
      })
      .then(result => {
        if (result.value) {
          window.axios.post(`/api/complaint-categories/`, { complaint_category: this.complaintCategory })
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
    showComplaintCategory (item) {
      this.isEditing = true
      this.$refs.showComplaintCategory.show()  
      this.updateComplaintCategories.id = item.id
      this.updateComplaintCategories.complaintCategory = item.complaint_category
    },
    updateComplaintCategory (id) {
      Swal.fire({
        title: 'Are you sure?',
        text: "You will change the selected category.",
        type: 'warning',
        showCancelButton: true,
      })
      .then(result => {
        if (result.value) {
          window.axios.patch(`/api/complaint-categories/${id}`, { complaint_category: this.complaintCategory })
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
    deleteComplaintCategory (id) {
      Swal.fire({
        title: 'Are you sure?',
        text: "You will delete the selected category.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Delete'
      })
      .then((result) => {
        if (result.value) {
          window.axios.delete(`/api/complaint-categories/${id}`)
            .then(response => {
              Swal.fire(
                'Deleted!',
                'This category has been deleted.',
                'success'
              )
              const index = this.complaintCategories.findIndex(complaintCategory => complaintCategory.id === id)
              if (~index) {
                this.complaintCategories.splice(index, 1)
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
    this.getComplaintCategories()
  },
  computed: {
    totalRows: function() {
      return this.complaintCategories.length
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