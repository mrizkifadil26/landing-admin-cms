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

      <b-dropdown-item @click="$router.push('profile')"><i class="fas fa-user" /> Profile</b-dropdown-item>
      <b-dropdown-item>
        <logout @click="this.$emit('logout')" />
      </b-dropdown-item>

    </template>
  </AppHeaderDropdown>
</template>

<script>

import { HeaderDropdown as AppHeaderDropdown } from '@coreui/vue'
import Logout from '../auth/Logout'

export default {
  name: 'Account',
  components: {
    AppHeaderDropdown,
    'logout': Logout
  },
  methods: {
    logout() {
      this.$store.commit('authentication/LOGOUT')
      this.$router.push('/login')
    }
  },
  computed: {
    user() {
      return this.$store.getters['authentication/currentUser']
    }
  }
}

</script>
