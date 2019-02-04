<template>
  <div class="animated fadeIn">
    <b-row>
      <b-col>        
        <b-card>
          <div slot="header">
            <i class="fas fa-user"></i> <strong> Create User</strong>
          </div>
          <b-form @submit.prevent="addUser" @reset.prevent="resetForm">
            <b-row>
              <b-col md="4" class="mb-3">
                <b-row class="text-center mb-3">
                  <b-col>
                    <b-img rounded="circle" thumbnail width="256" :src="'/' + image.image_link" :alt="user.name" />
                  </b-col>
                </b-row>
                <b-row class="text-center">
                  <b-col>
                    <b-button variant="success" type="button" @click.prevent="uploadAvatar">Upload Avatar</b-button>
                  </b-col>
                </b-row>
              </b-col>

              <b-col md="8" class="mb-3">
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
                  label="Confirm Password"
                  label-for="confirmPassword"
                  :label-cols="3"
                  :horizontal="true">
                  <b-form-input id="confirmPassword" type="password" v-model="user.password_conf"></b-form-input>
                </b-form-group>

                <b-form-group
                  label="Roles"
                  label-for="roles"
                  :label-cols="3"
                  :horizontal="true">
                  <b-form-select id="roles"
                    :plain="true"
                    v-model="selected"
                    :options="options"
                    value="Select Role">
                  </b-form-select>
                </b-form-group>

                <b-button size="lg" type="reset" class="mt-2" variant="danger">Reset</b-button>
                <b-button size="lg" type="submit" class="float-right mt-2" variant="primary">Create</b-button>

              </b-col>
            </b-row>
          </b-form>
        </b-card>
      </b-col>
    </b-row>
  </div>
</template>

<script>

export default {
  name: 'CreateUser',
  data () {
    return {
      user: {
        name: '',
        password: '',
        password_conf: '',
        avatar: '',
        // roles: '',
      },
      image: {
        image_name: '',
        image_link: 'images/default.png',
      },
      selected: null,
      options: [
        { value: null, text: 'Select Role' },
        { value: 1, text: 'Admin' },
        { value: 2, text: 'User' },
      ],
      showMessage: false,
      success: {
        isSuccess: false,
        message: ''
      },
      error: {
        isError: false,
        message: '',
      }
    }
  },
  methods: {
    addUser: function() {
      console.log({
        name: this.user.name,
        username: this.user.username,
        password: this.user.password,
        image_id: this.user.image_id,
        roles: this.selected
      })
    },
    uploadAvatar: function() {
      console.log({
        image_id: this.image.id,
        image_name: this.image.image_name,
        image_link: this.image.image_link
      })
    }
  }
}
</script>

