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
                <b-alert :show="error === true" dismissible variant="danger">{{ authError }}</b-alert>
                <b-input-group class="mb-3" :validated="false">
                  <b-input-group-prepend><b-input-group-text><i class="fas fa-user"></i></b-input-group-text></b-input-group-prepend>
                  <b-form-input type="text" class="form-control is-valid" placeholder="Username" autocomplete="username" v-model="register.username" />
                  <b-form-valid-feedback v-if="success.isSuccess === true">
                    Input is valid.
                  </b-form-valid-feedback>
                </b-input-group>
                <b-input-group class="mb-3" :validated="false">
                  <b-input-group-prepend><b-input-group-text><i class="fas fa-user"></i></b-input-group-text></b-input-group-prepend>
                  <b-form-input type="text" class="form-control is-valid" placeholder="Name" autocomplete="name" v-model="register.name" />
                  <b-form-valid-feedback v-if="success.isSuccess === true">{{ success.message }}</b-form-valid-feedback>
                  <b-form-invalid-feedback v-else>{{ error.message }}</b-form-invalid-feedback>
                </b-input-group>
                <b-input-group class="mb-3" :validated="false">
                  <b-input-group-prepend><b-input-group-text><i class="fas fa-lock"></i></b-input-group-text></b-input-group-prepend>
                  <b-form-input type="password" class="form-control is-invalid" placeholder="Password" autocomplete="current-password" v-model="login.password" />
                  <b-form-invalid-feedback v-if="error.isError === false">
                    Input is invalid.
                  </b-form-invalid-feedback>
                </b-input-group>
                <b-input-group class="mb-3" :validated="false">
                  <b-input-group-prepend><b-input-group-text><i class="fas fa-lock"></i></b-input-group-text></b-input-group-prepend>
                  <b-form-input type="password" class="form-control is-invalid" placeholder="Password Confirmation" autocomplete="current-password" />
                  <b-form-invalid-feedback v-if="error.isError === false">
                    Input is invalid.
                  </b-form-invalid-feedback>
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
  name: 'Register'
}

</script>

