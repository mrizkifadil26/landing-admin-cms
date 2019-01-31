<template>
  <div class="animated fadeIn">
    <b-row>
      <b-col>
        <b-card>
          <div slot="header">
            <i class="fas fa-user"></i>
            <strong> Edit User</strong>
          </div>
          <b-row>

            <b-col md="4" class="mb-3">
              <b-row class="text-center mb-3">
                <b-col>
                  <b-img rounded="circle" thumbnail fluid src="https://picsum.photos/200/200/?image=54" alt="Thumbnail" />
                </b-col>
              </b-row>
              <b-row class="text-center">
                <b-col>
                  <b-button variant="success">Upload Avatar</b-button>
                </b-col>
              </b-row>
            </b-col>

            <b-col md="8">
              <b-form-group
                label="Name"
                label-for="name"
                :label-cols="3"
                :horizontal="true">
              <b-form-input id="name" type="text" v-model="user.name"></b-form-input>
              </b-form-group>

              <b-form-group
                label="Username"
                label-for="username"
                :label-cols="3"
                :horizontal="true">
                <b-form-input id="username" type="text" v-model="user.username"></b-form-input>
              </b-form-group>

              <b-form-group
                label="Password"
                label-for="password"
                :label-cols="3"
                :horizontal="true">
                <b-form-input id="password" type="password" v-model="user.password"></b-form-input>
              </b-form-group>

              <b-form-group
                label="Password Confirmation"
                label-for="password_confirmation"
                :label-cols="3"
                :horizontal="true">
                <b-form-input id="password_confirmation" type="password" v-model="user.passwordConf"></b-form-input>
              </b-form-group>

              <b-form-group
                label="Roles"
                label-for="roles"
                :label-cols="3"
                :horizontal="true">
                <b-form-select id="roles"
                  :plain="true"
                  :options="['Select Role','Admin', 'User']"
                  value="Select Role"
                  v-model="user.role">
                </b-form-select>
              </b-form-group>

              <b-button variant="danger">Reset</b-button>
              <b-button variant="primary">Update</b-button>

            </b-col>
          </b-row>
        </b-card>
      </b-col>
    </b-row>
  </div>
</template>

<script>
export default {
  name: 'UpdateUser',
  data() {
    return {
      user: {
        name: '',
        username: '',
        password: '',
        passwordConf: '',
        role: ''
      }
    }
  }
}
</script>

