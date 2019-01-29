<template>
  <div class="app flex-row align-items-center">
    <div class="container">
      <b-row class="justify-content-center">
        <b-col md="6">          
          <b-card no-body class="p-4">
            <b-card-body>
              <b-form v-on:submit.prevent="signIn">
                <h1>Login</h1>
                <p class="text-muted">Sign In to your account</p>
                <b-alert show dismissible variant="danger" v-if="error.state === true">{{ error.message }}</b-alert>
                <b-input-group class="mb-3" validated>
                  <b-input-group-prepend><b-input-group-text><i class="fas fa-user"></i></b-input-group-text></b-input-group-prepend>
                  <b-form-input type="text" class="form-control is-valid" placeholder="Username" autocomplete="username" v-model="login.username" />
                  <b-form-valid-feedback>
                    Input is valid.
                  </b-form-valid-feedback>
                </b-input-group>
                <b-input-group class="mb-3" validated>
                  <b-input-group-prepend><b-input-group-text><i class="fas fa-lock"></i></b-input-group-text></b-input-group-prepend>
                  <b-form-input type="password" class="form-control is-invalid" placeholder="Password" autocomplete="current-password" v-model="login.password" />
                  <b-form-invalid-feedback>
                    Input is invalid.
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
        </b-col>
      </b-row>
    </div>
  </div>
</template>

<script>

export default {
  name: 'Login',
  data () {
    return {
      login: {
        username: '',
        password: '',
      },
      error: {
        state: false,
        message: ''
      }
    }
  },
  methods: {
    signIn () {
      
      this.error.state = false;
      let username = this.login.username
      let password = this.login.password

      this.$store.dispatch('login', { username, password })
        .then((res) => {
          this.$router.push('/admin')
        })
        .catch(err => {
          this.error.state = true
          this.error.message = err
          console.log(err)
        })
    }
  }
}
</script>
