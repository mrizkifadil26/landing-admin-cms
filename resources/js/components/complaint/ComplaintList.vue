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
                fixed
                responsive="sm" 
                :hover="hover"
                :items="this.complaints.data" 
                :fields="fields" 
                :current-page="currentPage" 
                :per-page="perPage">
                <template slot="status" slot-scope="data">
                  <b-badge :variant="data.item.status === 'Handled' ? 'success' : 'danger' ">{{ data.item.status }}</b-badge>
                </template>
                <template slot="actions" slot-scope="data">
                  <b-button class="mb-1" variant="warning" v-b-modal="'statusChange'">{{ data.value = "Change Status" }}</b-button>
                  <b-button variant="success" :to="{ path: `complaints/show/${data.item.id}`, label: 'Complaint Details' }">{{ data.value = "Complaint Details" }}</b-button>
                </template>
              </b-table>
              <b-modal title="Change Status" size="md" class="modal-warning" id="statusChange">
                <b-alert variant="success" dismissible show>Success</b-alert>
                <b-form>
                  <b-form-group
                    label="Status"
                    label-for="status"
                    :label-cols="4"
                    :horizontal="true">
                    <b-form-select v-model="selected" :plain="true" class="mb-3">
                      <option :value="null">-- Please select an option --</option>
                      <option value="handled">Handled</option>
                      <option value="pending">Pending</option>
                    </b-form-select>
                  </b-form-group>
                </b-form>
              </b-modal>
              <nav>
                <b-pagination
                  :total-rows="totalRows"
                  :per-page="perPage" 
                  v-model="currentPage" 
                  prev-text="Prev" 
                  next-text="Next" 
                  hide-goto-end-buttons
                >
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

export default {
  name: 'ComplaintList',
  props: {
    hover: {
      type: Boolean,
      default: true
    },
    perPage: {
      type: Number,
      default: 5
    },
  },
  data () {
    return {
      currentPage: 1,
      complaints: [],
      fields: [
        { key: 'complaint', label: 'Complaint', sortable: true},
        { key: 'complaint_by.name', label: 'Complaint By' },
        { key: 'category.complaint_category', label: 'Category', sortable: true },
        { key: 'status', sortable: true },
        { key: 'actions' }
      ],
      selected: null
    }
  },
  created () {
    axios.get('/api/complaints')
      .then(response => {
        this.complaints = response.data
        console.log(response)
      })
      .catch(error => {
        console.log(error)
      })
  },
  computed: {
    totalRows: function () {
      return this.getRowCount()
    }
  },
  methods: {
    getRowCount: function () {
      return this.complaints.length
    }
  }
}
</script>
