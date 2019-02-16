<template>
  <div class="animated fadeIn">
    <b-row>
      <b-col>        
        <b-card>
          <div slot="header">
            <i class="fas fa-list"></i> <strong> Complaint Details</strong>
          </div>
          <b-row>
            <b-col md="12" class="mb-3">
              <b-table
                stacked 
                :items="[complaints]"
                :fields="fields">
                <template slot="status" slot-scope="data">
                  <b-badge :variant="getBadge(data.item.status)">{{ data.item.status }}</b-badge>
                </template>
                <template slot="complaint_by.name" slot-scope="data">
                  <b-link :to="{ path: `/admin/users/show/${ data.item.complaint_by.id }` }">{{ data.item.complaint_by.name }}</b-link>
                </template>
              </b-table>
            </b-col>

            <b-col md="12" class="mb-3">
              <b-row class="text-center mb-3">
                <b-col>
                  <h3 class="mb-3">Photos</h3>
                  <b-row>
                    <b-col>
                      <b-img-lazy 
                        fluid 
                        :src="complaints.image.image_link" 
                        :alt="complaints.image.image_name" />
                    </b-col>
                  </b-row>
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

import Maps from '../helpers/Maps'

export default {
  name: 'ShowComplaint',
  components: {
    'map-view': Maps,
  },
  data () {
    return {
      fields: [
        { key: 'complaint', sortable: true }, 
        { key: 'description' }, 
        { key: 'full_name' },
        { key: 'address' },
        { key: 'category.complaint_category', label: 'Category', sortable: true }, 
        { key: 'status' }, 
        { key: 'complaint_by.name', label: 'Complained by', sortable: true }
      ],
      complaints: {},
    }
  },
  methods: {
    getBadge(status) {
      return status === 'Handled' ? 'success' : 'danger'
    },
    getComplaints() {
      const complaintId = this.$route.params.id
      axios.get(`/api/complaints/${complaintId}`)
        .then(response => {
          this.complaints = response.data.data
          console.log(this.complaints)
        })
        .catch(error => {
          console.error(error)
        })
    }
  },
  created() {
    this.getComplaints()
  }
}
</script>

