<template>
  <AppHeaderDropdown right no-caret>
    <template slot="header">
      <img 
        :src="user.avatar.avatar_link" 
        :alt="user.avatar.avatar_name"
        class="img-avatar" />
    </template>
    <template slot="dropdown">
      <b-dropdown-header 
        tag="div" 
        class="text-center">
        <strong>Account</strong>
      </b-dropdown-header>

      <b-dropdown-item disabled>
        <b-row>
          <b-col class="text-center mb-3">
            <img 
              :src="user.avatar.avatar_link" 
              :alt="user.avatar.avatar_name"
              class="img-avatar">
          </b-col>
          <b-col class="text-center">
            <strong>{{ user.name }}</strong>
            <p>@{{ user.username }}</p>
          </b-col>
        </b-row>
      </b-dropdown-item>

      <b-dropdown-item @click="$router.push('/admin/profile')"><i class="fas fa-user" /> Profile</b-dropdown-item>
      <b-dropdown-item @click="logout">
        <i class="fas fa-sign-out-alt" /> Logout
      </b-dropdown-item>

    </template>
  </AppHeaderDropdown>
</template>

<script>

import { HeaderDropdown as AppHeaderDropdown } from '@coreui/vue'
import Swal from 'sweetalert2'

export default {
  name: 'Account',
  components: {
    AppHeaderDropdown,
  },
  methods: {
    logout() {
      Swal.fire({
        title: "Are you sure?",
        text: "You will be logged out.",
        type: 'warning',
        showCancelButton: true,
      }).then((result) => {
        if (result.value) {
          this.$store.dispatch('authentication/logout')
          Swal.fire({
            title: 'Logout Success',
            text: 'Logging out...',
            backdrop: 'rgba(0, 0, 0, 0.5)',
            showConfirmButton: false,
          })
          return this.$router.push('/login')
        } 
      })
    }
  },
  computed: {
    user() {
      return this.$store.getters['authentication/currentUser']
    }
  }
}

</script>
