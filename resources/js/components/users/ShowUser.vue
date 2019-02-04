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
                  <b-img-lazy rounded="circle" thumbnail fluid :src="user[0].data.avatar.avatar_link" :alt="user[0].data.avatar.avatar_name" />
                </b-col>
              </b-row>
            </b-col>

            <b-col md="8" class="mb-3">
              <b-table 
                stacked
                :items="user"
                :fields="fields">
                <template slot="data.role.name" slot-scope="data">
                  <b-badge :variant="getBadge(data.item.data.role.name)">{{ data.item.data.role.name | capitalize }}</b-badge>
                </template>
              </b-table>
            </b-col>

          </b-row>
        </b-card>
      </b-col>
    </b-row>
  </div>
</template>

<script>
export default {
  name: 'ShowUser',
  data () {
    return {
      fields: [
        { key: 'data.name', label: 'Name' },        
        { key: 'data.username', label: 'Username' },
        { key: 'data.role.name', label: 'Role' },
      ],
      user: []
    }
  },
  created() {
    const paramUrl = this.$route.params.id
    axios.get(`/api/users/${paramUrl}`)
      .then(response => {
        console.log(response.data)
        this.user.push(response.data) 
        console.log(this.user[0])
      })
      .catch(error => {
        console.log(error)
      })
  },
  filters: {
    capitalize: function(value) {
      if (!value) return ''
      value.toString()
      return value.charAt(0).toUpperCase() + value.slice(1)
    }
  },
  methods: {
    getBadge (role) {
      return role === 'admin' ? 'primary' : 'danger';
    },
  }
}
</script>

