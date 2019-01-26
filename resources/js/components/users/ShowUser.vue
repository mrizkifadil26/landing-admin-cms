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
                  <b-img rounded="circle" thumbnail fluid src="https://picsum.photos/200/200/?image=54" alt="Thumbnail" />
                </b-col>
              </b-row>
            </b-col>

            <b-col md="8" class="mb-3">
              <!-- <b-form-group
                label="Name"
                label-for="name"
                :label-cols="3"
                :horizontal="true">
                <b-form-input v-model="detail.name" id="name" type="text" :value="detail.name" disabled></b-form-input>
              </b-form-group>

              <b-form-group
                label="Username"
                label-for="username"
                :label-cols="3"
                :horizontal="true">
                <b-form-input v-model="detail.username" id="username" type="text" :value="detail.username" disabled></b-form-input>
              </b-form-group>

              <b-form-group
                label="Roles"
                label-for="roles"
                :label-cols="3"
                :horizontal="true">
                <b-form-input v-model="detail.roles" id="roles" type="text" :value="detail.roles" disabled></b-form-input>
              </b-form-group> -->

              <b-table 
                stacked
                :items="detail">
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
      detail: [
        {
          name: 'Muhammad Rizki',
          username: 'mrizkifadil26',
          roles: 'Admin'
        }
      ]
    }
  }
}
</script>

