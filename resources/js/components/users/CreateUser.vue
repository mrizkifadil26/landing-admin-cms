<template>
  <div class="animated fadeIn">
    <b-row>
      <b-col>        
        <b-card>
          <div slot="header">
            <i class="fas fa-user"></i> <strong> Create User</strong>
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

            <b-col md="8" class="mb-3">
              <b-form-group
                label="Name"
                label-for="name"
                :label-cols="3"
                :horizontal="true">
              <b-form-input id="name" type="text"></b-form-input>
              </b-form-group>

              <b-form-group
                label="Username"
                label-for="username"
                :label-cols="3"
                :horizontal="true">
              <b-form-input id="username" type="text"></b-form-input>
              </b-form-group>

              <b-form-group
                label="Password"
                label-for="password"
                :label-cols="3"
                :horizontal="true">
              <b-form-input id="password" type="password"></b-form-input>
              </b-form-group>

              <b-form-group
                label="Roles"
                label-for="roles"
                :label-cols="3"
                :horizontal="true">
                <b-form-select id="roles"
                  :plain="true"
                  :options="['Select Role','Admin', 'User']"
                  value="Select Role">
                </b-form-select>
              </b-form-group>

              <b-button size="lg" class="float-right mt-2" variant="primary">Create</b-button>

            </b-col>

          </b-row>
        </b-card>
      </b-col>
    </b-row>
  </div>
</template>

<script>

export default {
  name: 'CreateUser',
}
</script>

