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
              <b-button variant="primary" @click="addPostCategory"><i class="fas fa-plus"></i> Add Category</b-button>
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
                :items="postCategories" 
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
              <b-modal id="postCategoriesModal"
                ref="showPostCategory"
                :title="!isEditing ? 'Add Post Category' : 'Change Post Category'" 
                size="md" 
                :class="!isEditing ? 'modal-primary' : 'modal-warning'"  
                @ok.prevent="!isEditing ? storePostCategory() : updatePostCategory(updatePostCategories.id)"
                @hidden="isEditing = false"
                :ok-title="!isEditing ? 'Add' : 'Change'">
                <b-form-group
                  label="Category Name"
                  label-for="postCategory"
                  :label-cols="4"
                  :horizontal="true">
                  <b-form-input id="postCategory"
                    name="postCategory"
                    v-model="postCategory"
                    :value="!isEditing ? '' : updatePostCategories.postCategory"></b-form-input>
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

      isEditing: false,

      postCategories: [],
      postCategory: '',
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
    addPostCategory () {
      this.isEditing = false
      this.$refs.showPostCategory.show()
    },
    storePostCategory () {
      Swal.fire({
        title: 'Are you sure?',
        text: "You will add the selected category.",
        type: 'warning',
        showCancelButton: true,
      })
      .then(result => {
        if (result.value) {
          window.axios.post(`/api/post-categories/`, { post_category: this.postCategory })
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
    showPostCategory (item) {
      this.isEditing = true
      this.$refs.showPostCategory.show()
      this.updatePostCategories.id = item.id
      this.updatePostCategories.postCategory = item.post_category
    },
    updatePostCategory (id) {
      Swal.fire({
        title: 'Are you sure?',
        text: "You will change the selected category.",
        type: 'warning',
        showCancelButton: true,
      })
      .then(result => {
        if (result.value) {
          window.axios.patch(`/api/post-categories/${id}`, { post_category: this.postCategory })
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
  },
  watch: {
    '$route': 'getPostCategories'
  }
}
</script>