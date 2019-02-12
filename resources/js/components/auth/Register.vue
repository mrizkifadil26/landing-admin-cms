<template>
  <div class="app flex-row align-items-center">
    <div class="container">
      <b-row class="justify-content-center">
        <b-col md="6">          
          <b-card no-body class="p-4">
            <b-card-body>
              <b-form @submit.prevent="registerForm">
                <h1>Sign Up</h1>
                <b-row>
                  <b-col>
                    <p class="text-muted">Create an account.</p>
                  </b-col>
                  <b-col class="ml-auto text-right">
                    <b-link :to="'/'"><i class="fas fa-long-arrow-alt-left"></i> Back</b-link>  
                  </b-col>            
                </b-row>
                <b-input-group class="mb-3">
                  <b-input-group-prepend><b-input-group-text><i class="fas fa-user"></i></b-input-group-text></b-input-group-prepend>
                  <b-form-input name="name" type="text" :class="{ 'form-control': true, 'is-invalid': errors.has('name') }" placeholder="Full Name" autocomplete="name" v-model="register.name" v-validate="'required'" />
                  <b-form-invalid-feedback v-show="errors.has('name')">
                    {{ errors.first('name') }}
                  </b-form-invalid-feedback>
                </b-input-group>
                <b-input-group class="mb-3">
                  <b-input-group-prepend><b-input-group-text><i class="fas fa-at"></i></b-input-group-text></b-input-group-prepend>
                  <b-form-input name="username" type="text" :class="{ 'form-control': true, 'is-invalid': errors.has('username') }" placeholder="Username" autocomplete="username" v-model="register.username" v-validate="'required|min:6'" />
                  <b-form-invalid-feedback v-show="errors.has('username')">
                    {{ errors.first('username') }}
                  </b-form-invalid-feedback>
                </b-input-group>
                <b-input-group class="mb-3">
                  <b-input-group-prepend><b-input-group-text><i class="fas fa-lock"></i></b-input-group-text></b-input-group-prepend>
                  <b-form-input name="password" type="password" :class="{ 'form-control': true, 'is-invalid': errors.has('password') }" placeholder="Password" autocomplete="current-password" v-model="register.password" v-validate="'required|min:6'" ref="password" />
                  <b-form-invalid-feedback v-show="errors.has('password')">
                    {{ errors.first('password') }}
                  </b-form-invalid-feedback>
                </b-input-group>
                <b-input-group class="mb-3">
                  <b-input-group-prepend><b-input-group-text><i class="fas fa-lock"></i></b-input-group-text></b-input-group-prepend>
                  <b-form-input name="password_confirmation" type="password" :class="{ 'form-control': true, 'is-invalid': errors.has('password_confirmation') }" placeholder="Repeat Password" autocomplete="current-password" v-validate="'required|confirmed:password'" data-vv-as="password" />
                  <b-form-invalid-feedback v-show="errors.has('password_confirmation')">
                    {{ errors.first('password_confirmation') }}
                  </b-form-invalid-feedback>
                </b-input-group>
                <b-input-group class="mb-3">
                  <b-form-checkbox name="agreed" id="termsAgreed" v-validate="'required'">
                    I agreed with terms and conditions.
                  </b-form-checkbox>
                  <b-form-invalid-feedback v-show="errors.has('agreed')">
                    {{ errors.first('agreed') }}
                  </b-form-invalid-feedback>
                </b-input-group>
                <b-row>
                  <b-col class="text-center">
                    <b-button type="submit" variant="primary" block class="px-4 mb-3">Sign Up</b-button>
                    <p class="mb-1">Already have an account?</p>
                    <b-link :to="{ path: '/login' }">Sign in</b-link>
                  </b-col>
                </b-row>
              </b-form>
            </b-card-body>
          </b-card>
        </b-col>
      </b-row>
    </div>
  </div>
</template>

<script>

import Swal from 'sweetalert2'

export default {
  name: 'Register',
  data () {
    return {
      register: {
        username: '',
        name: '',
        password: ''
      },

      submitted: false,
    }
  },
  methods: {
    registerForm () {
      this.submitted = true
      this.$validator.validateAll()
        .then((result) => {
          console.log({
            name: this.name,
            username: this.username,
            password: this.password,
            role_id: 2
          })
        })
        .catch(error => {
          
        })
    }
  }
}

</script>

