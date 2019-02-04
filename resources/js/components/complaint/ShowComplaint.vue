<template>
  <div class="animated fadeIn">
    <b-row>
      <b-col>        
        <b-card>
          <div slot="header">
            <i class="fas fa-list"></i> <strong> Complaint Details</strong>
          </div>
          <b-row>
            
            <b-col md="4" class="mb-3">
              <b-row class="text-center mb-3">
                <b-col>
                  <b-img-lazy rounded="square" thumbnail fluid-grow :src="this.complaints[0].data.image.image_link" :alt="this.complaints[0].data.image.image_name" />
                </b-col>
              </b-row>
            </b-col>

            <b-col md="8" class="mb-3">
              
              <b-table 
                
                :items="this.complaints.data"
                :fields="fields">
                <template slot="status" slot-scope="data">
                  <b-badge :variant="getBadge(data.item.status)">{{ data.item.status }}</b-badge>
                </template>
              </b-table>
            </b-col>
          </b-row>

          <b-row>
            <b-col>
              <!-- <h1>Location</h1> -->
              <!-- <map-view></map-view> -->
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
        { key: 'category.complaint_category', label: 'Category', sortable: true }, 
        { key: 'status' }, 
        { key: 'complaint_by.name', label: 'Category', sortable: true }
      ],
      complaints: [],
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
          this.complaints.push(response.data)
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

