<template>
  <div class="animated fadeIn">
    <b-row>
      <b-col>
        <b-card>
          <div slot="header">
            <i class="fas fa-list"></i><strong> Post Categories</strong>
          </div>
          <b-row class="mb-3">
            <b-col md="3" sm="4 mb-3">
              <b-button variant="primary"><i class="fas fa-plus"></i> Add Category</b-button>
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
                :items="this.postCategories" 
                :fields="fields" 
                :current-page="currentPage" 
                :per-page="perPage"
                :filter="filter"
                @filtered="onFiltered">
                <template slot="actions" slot-scope="data">
                  <b-button class="mb-1" variant="warning" @click="showPostCategory(data.item)">Edit</b-button>
                  <b-button class="mb-1" variant="danger" @click="deletePostCategory(data.item.id)">Delete</b-button>
                </template>
              </b-table>
              <spinner v-show="loading"></spinner>
              <b-modal id="statusChange"
                ref="showPostCategory"
                title="Change Post Category" 
                size="md" 
                class="modal-warning" 
                @ok="updatePostCategory(updatePostCategory.id)"
                ok-title="Change">
                <b-form-group
                  label="Category Name"
                  label-for="postCategory"
                  :label-cols="4"
                  :horizontal="true">
                  <b-form-input id="postCategory"
                    name="postCategory"
                    v-model="updatePostCategory.postCategory"></b-form-input>
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
  name: 'PostCategories',  
  data() {
    return {
      loading: false,
      currentPage: 1,
      perPage: 10,
      filter: null,

      postCategories: [],
      updatePostCategories: {
        id: null,
        postCategory: '',
      },

      fields: [
        { key: 'post_category', sortable: true },
        { key: 'actions' }
      ]
    }
  },
  methods: {
    getPostCategories() {
      this.loading = true
      axios.get('/api/post-categories')
      .then(response => {
        this.loading = false
        this.postCategories = response.data.data
        console.log(this.postCategories)
      })
      .catch(error => {
        this.loading = false
        console.log(error)
      })
    },
    showPostCategory (item) {
      this.$refs.showPostCategory.show()
      this.postCategory.id = item.id
      this.postCategory.postCategory = item.post_category
    },
    updatePostCategory (id) {

    },
    deletePostCategory (id) {
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
            window.axios.delete(`/api/post-categories/${id}`)
              .then(response => {
                Swal.fire(
                  'Deleted!',
                  'This category has been deleted.',
                  'success'
                )
                const index = this.postCategories.findIndex(postCategory => postCategory.id === id)
                if (~index) {
                  this.postCategories.splice(index, 1)
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
    },
    getRowCount () {
      return this.postCategories.length
    },
  },
  created() {
    this.getPostCategories()
  },
  computed: {
    totalRows () {
      return this.getRowCount()
    },
    sortOptions() {
      return this.fields
        .filter(f => f.sortable)
        .map(f => {
          return { text: f.label, value: f.key }
        })
    },    
  }
}
</script>