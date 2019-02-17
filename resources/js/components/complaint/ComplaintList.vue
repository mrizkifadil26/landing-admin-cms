<template>
  <div class="animated fadeIn">
    <b-row>
      <b-col>
        <b-card>
          <div slot="header">
            <i class="fas fa-list"></i> <strong>Complaint List</strong>
          </div>
          <b-row class="mb-3">
            <b-col md="3" sm="3">
              <!-- <b-button variant="primary"><i class="fas fa-download"></i> Export</b-button> -->
            </b-col>
            <b-col md="4 ml-auto" sm="6 ml-auto">
              <b-form-group>
                <b-input-group>
                  <b-form-input type="text"></b-form-input>
                  <b-input-group-append>
                    <b-button variant="primary">Search</b-button>
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
                :items="this.complaints" 
                :fields="fields" 
                :current-page="currentPage" 
                :per-page="perPage">
                <template slot="complaint" slot-scope="data">
                  {{ data.item.complaint }}
                  <p><small>{{ data.item.created_at }}</small></p>
                </template>
                <template slot="category.complaint_category" slot-scope="data">
                  <b-badge variant="warning">{{ data.item.category.complaint_category }}</b-badge>
                </template>
                <template slot="status" slot-scope="data">
                  <b-badge :variant="data.item.status === 'Handled' ? 'success' : 'danger' ">{{ data.item.status }}</b-badge>
                </template>
                <template slot="actions" slot-scope="data">
                  <b-button class="mb-1" variant="warning" @click="showChangeModal(data.item)">{{ data.value = "Change Status" }}</b-button>
                  <b-button variant="success" :to="{ path: `complaints/show/${data.item.id}`, label: 'Complaint Details' }">{{ data.value = "Details" }}</b-button>
                </template>
              </b-table>
              <spinner v-if="loading"></spinner>
              <b-modal id="statusChange"
                ref="changeStatusModal"
                title="Change Status" 
                size="md" 
                class="modal-warning" 
                @ok="changeStatus(status.id)"
                ok-title="Change">
                <b-form-group
                  label="Status"
                  label-for="status"
                  :label-cols="4"
                  :horizontal="true">
                  <b-form-select id="selectStatus" 
                    v-model="selected"
                    :plain="true" 
                    class="mb-3">
                    <option :value="null">-- Please select an option --</option>
                    <option value="Handled">Handled</option>
                    <option value="Pending">Pending</option>
                  </b-form-select>
                </b-form-group>
              </b-modal>
              <b-row>
                <b-col>
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
                <b-col md="4" class="ml-auto">
                  <h5 class="float-right">Total: {{ complaints.length }}</h5>
                </b-col>
              </b-row>
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
  name: 'ComplaintList',
  data () {
    return {
      loading: false,

      currentPage: 1,
      perPage: 10,
      complaints: [],
      status: {
        id: null,
        status: '',
      },
      fields: [
        { key: 'full_name', sortable: true },
        { key: 'complaint', label: 'Complaint', sortable: true},
        { key: 'address', sortable: true },
        { key: 'category.complaint_category', label: 'Category', sortable: true },
        { key: 'status', sortable: true },
        { key: 'actions' }
      ],
      selected: null
    }
  },
  created () {
    this.getComplaints()
  },
  computed: {
    totalRows: function () {
      return this.getRowCount()
    }
  },
  methods: {
    showChangeModal(item) {      
      this.$refs.changeStatusModal.show()
      this.status.id = item.id
      this.selected = item.status
    },
    changeStatus (id) {
      window.axios.patch(`/api/complaints/${id}`, { status: this.selected })
        .then(response => {
          Swal.fire('Status changed!', 'Successfully changed the status.', 'success')
          this.$router.go(0)
        })
        .catch(error => {
          console.log(error)
        })
    },
    getRowCount: function () {
      return this.complaints.length
    },
    getComplaints: function () {
      this.loading = true
      axios.get('/api/complaints')
        .then(response => {
          this.loading = false
          this.complaints = response.data.data
          console.log(this.complaints)
        })
        .catch(error => {
          this.loading = false
          console.log(error)
        })
    }
  }
}
</script>
