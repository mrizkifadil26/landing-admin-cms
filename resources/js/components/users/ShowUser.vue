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
                  <b-img rounded="circle" thumbnail fluid :src="user.data.avatar" alt="Thumbnail" />
                </b-col>
              </b-row>
            </b-col>

            <b-col md="8" class="mb-3">
              <b-table 
                stacked
                :items="user">
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
      fields: ['name', 'username', 'roles'],
      user: null
    }
  },
  created() {
    const paramUrl = this.$route.params.id
    axios.get(`/api/users/${paramUrl}`)
      .then(response => {
        console.log(response.data)
        this.user = response.data
        console.log(this.user)
      })
      .catch(error => {
        console.log(error)
      })
  }
}
</script>

