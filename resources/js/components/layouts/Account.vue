<template>
  <AppHeaderDropdown right no-caret>
    <template slot="header">
      <img 
        src="http://placehold.it/200x200" 
        alt="avatar"
        class="img-avatar">
    </template>\
    <template slot="dropdown">
      <b-dropdown-header 
        tag="div" 
        class="text-center">
        <strong>Account</strong>
      </b-dropdown-header>

      <b-dropdown-item>{{ user.name }}</b-dropdown-item>
      <b-dropdown-item><i class="fas fa-user" /> Profile</b-dropdown-item>
      <b-dropdown-divider />
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
      
    }
  },
  computed: {
    user() {
      return this.$store.getters.currentUser
    }
  }
}

</script>
