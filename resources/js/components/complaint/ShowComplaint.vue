<template>
  <div class="animated fadeIn">
    <b-row>
      <b-col>        
        <b-card>
          <div slot="header">
            <i class="fas fa-user"></i> <strong> User Details</strong>
          </div>
          <b-row>
            
            <b-col md="4" class="mb-3">
              <b-row class="text-center mb-3">
                <b-col>
                  <b-img rounded="square" fluid src="https://picsum.photos/200/200/?image=54" alt="Image" />
                </b-col>
              </b-row>
            </b-col>

            <b-col md="8" class="mb-3">
              
              <b-table 
                stacked
                :items="items">
                <template slot="status" slot-scope="data">
                  <b-badge :variant="getBadge(data.item.status)">{{ data.item.status }}</b-badge>
                </template>
              </b-table>
            </b-col>
          </b-row>

          <b-row>
            <b-col>
              <h1>Location</h1>
              <map-view></map-view>
            </b-col>
          </b-row>

        </b-card>
      </b-col>
    </b-row>
  </div>
</template>

<script>

import Maps from '../helpers/Maps'

const data = () => [
        {
          title: 'Broken Bridge',
          description: 'in Montana',
          category: 'Infrastructure',
          status: 'Handled',
          complaintBy: 'Muhammad Rizki'
        }
      ]

export default {
  name: 'ShowComplaint',
  components: {
    'map-view': Maps,
  },
  data () {
    return {
      fields: ['title', 'description', 'category', 'status', 'complaint_by'],
      items: data,
    }
  },
  methods: {
    getBadge(status) {
      return status === 'Handled' ? 'success' : 'danger'
    }
  }
}
</script>

