<template>
  <div class="app flex-row align-items-center">
    <div class="container">
      <b-row class="justify-content-center">
        <b-col md="8">         
          <b-card-group>
            <b-card no-body class="p-4">
              <b-card-body>
                <b-form @submit.prevent="authenticate">
                  <h1>Login</h1>
                  <b-row>
                    <b-col>
                      <p class="text-muted">Sign in to your account</p>
                    </b-col>
                    <b-col md="4" sm="3" class="ml-auto text-right">
                      <b-link :to="'/'"><i class="fas fa-long-arrow-alt-left"></i> Back</b-link>  
                    </b-col>            
                  </b-row>
                  <b-input-group class="mb-3" validated="false">
                    <b-input-group-prepend><b-input-group-text><i class="fas fa-user"></i></b-input-group-text></b-input-group-prepend>
                    <b-form-input name="username" type="text" :class="{ 'form-control': true, 'is-invalid': errors.has('username') }" placeholder="Username" autocomplete="username" v-model="login.username" v-validate="'required'" />
                    <b-form-invalid-feedback v-show="errors.has('username')">
                      {{ errors.first('username') }}
                    </b-form-invalid-feedback>
                  </b-input-group>
                  <b-input-group class="mb-3" validated="false">
                    <b-input-group-prepend><b-input-group-text><i class="fas fa-lock"></i></b-input-group-text></b-input-group-prepend>
                    <b-form-input name="password" type="password" :class="{ 'form-control': true, 'is-invalid': errors.has('password') }" placeholder="Password" autocomplete="current-password" v-model="login.password" v-validate="'required'" />
                    <b-form-invalid-feedback v-if="errors.has('password')">
                      {{ errors.first('password') }}
                    </b-form-invalid-feedback>
                  </b-input-group>
                  <b-input-group class="mb-3">
                    <b-form-checkbox id="rememberMe">
                      Remember Me
                    </b-form-checkbox>
                  </b-input-group>
                  <b-row>
                    <b-col cols="6">
                      <b-button type="submit" variant="primary" class="px-4">Login</b-button>
                    </b-col>
                    <b-col cols="6" class="text-right">
                      <b-button variant="link" class="px-0">Forgot password?</b-button>
                    </b-col>
                  </b-row>
                </b-form>
              </b-card-body>
            </b-card>
            <b-card no-body class="text-white bg-primary py-5 d-md-down-none" style="width:20%">
              <b-card-body class="text-center">
                <div>
                  <h2>Sign up</h2>
                  <p>Create an account to access some feature in Cilegon SmartCity.</p>
                  <b-button variant="primary" class="active mt-3" :to="{ path: '/register' }">Register Now!</b-button>
                </div>
              </b-card-body>
            </b-card>
          </b-card-group> 
        </b-col>
      </b-row>
    </div>
  </div>
</template>

<script>

import Swal from 'sweetalert2'

export default {
  name: 'Login',
  data () {
    return {
      login: {
        username: '',
        password: '',
      },
      submitted: false,
    }
  },
  methods: {
    authenticate () {
      this.submitted = true
      this.$validator.validateAll()
      .then((result) => {
        if (result) {
          this.$store.dispatch('authentication/login', this.login)
          .then(response => {
            Swal.fire({
              type: 'success',
              title: 'Login Success',
              text: 'Logging in...',
              backdrop: 'rgba(0, 0, 0, 0.5)',
              showConfirmButton: false,
            })
            this.$router.push('/admin')
          })
          .catch(error => {
            Swal.fire({
              type: 'error',
              title: 'Error Authentication',
              text: 'Please try again.'
            })
            console.log(error)
          })
        } else {
          Swal.fire({
            type: 'error',
            title: 'Login Error',
            text: 'Wrong Username/Password',
            backdrop: 'rgba(0, 0, 0, 0.5)',
          })
        }
      })
    }
  },
  computed: {
    authError() {
      return this.$store.getters['authentication/authError']
    },
    registeredUser() {
      return this.$store.getters['authentication/registeredUser']
    }
  }
}
</script>
