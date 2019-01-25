<template>
  <div class="animated fadeIn">
    <b-row>
      <b-col>
        <b-card>
          <div slot="header">
            <strong>Create User</strong> <small>Muhammad Rizki Fadillah</small>
          </div>
          <b-row>
            <b-col>
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
}
</script>

