<template>
  <HeaderDropdown right no-caret>
    <template slot="header">
      <img src="" alt="">
    </template>\
    <template slot="dropdown">
      <b-dropdown-header tag="div" class="text-center">
        <strong>Account</strong>
      </b-dropdown-header>

      <b-dropdown-item>
        <i class="fas fa-sign-out"> Logout</i>
      </b-dropdown-item>

    </template>
  </HeaderDropdown>
</template>

<script>

import HeaderDropdown from '@coreui/vue'

export default {
  name: 'Account',
  components : {
    HeaderDropdown
  },
}
</script>
