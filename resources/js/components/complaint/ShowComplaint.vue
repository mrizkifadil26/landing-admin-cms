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
                  <b-link :to="{ path: `/admin/users/show/${ data.item.complaint_by.id }` }">{{ data.item.complaint_by.name }}</b-link><small> on {{ data.item.created_at }}</small>
                </template>
              </b-table>
              <spinner v-if="loading"></spinner>
            </b-col>

            <b-col md="12" class="mb-3">
              <b-row class="text-center mb-3">
                <b-col>
                  <h3 class="mb-3">Photos</h3>
                  <b-row>
                    <b-col v-if="loading" md="12">
                      <spinner></spinner>
                    </b-col>
                    <b-col class="text-center text-muted" v-if="complaints.photos < 1" md="12" sm="12">
                      <p class="mt-3">No Photos</p>
                    </b-col>
                    <b-col md="12" sm="12" v-else>
                      <b-img-lazy
                        v-for="(photo, index) in complaints.photos" :key="index"
                        class="mr-3 mb-3"
                        blank-color="#bbb"
                        width="330"
                        :src="photo.image_link"
                        :alt="photo.image_name" />
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

export default {
  name: 'ShowComplaint',
  data () {
    return {
      loading: false,
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
    getBadge (status) {
      return status === 'Handled' ? 'success' : 'danger'
    },
    getComplaints () {
      const complaintId = this.$route.params.id
      this.loading = true
      axios.get(`/api/complaints/${complaintId}`)
        .then(response => {
          this.loading = false
          this.complaints = response.data.data
          console.log(this.complaints)
        })
        .catch(error => {
          this.loading = false
          console.error(error)
        })
    }
  },
  created () {
    this.getComplaints()
  }
}
</script>

