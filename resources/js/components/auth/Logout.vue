<template>
  <div @click="logout">
    <i class="fas fa-sign-out-alt" /> Logout
  </div>
</template>

<script>

import Swal from 'sweetalert2'

export default {
  name: 'Logout',
  computed: {
    isLoggedIn: function() {
      return this.$store.getters['authentication/isLoggedIn']
    }
  },
  methods: {
    logout: function() {

      Swal.fire({
        title: "Are you sure?",
        text: "You will be logged out.",
        type: 'warning',
        showCancelButton: true,
      })
      .then((logout) => {

        if (logout.value) {
          Swal.fire({
            title: 'Logout Success',
            text: 'Logging out...',
            backdrop: 'rgba(0, 0, 0, 0.5)',
            timer: 1000,
            showConfirmButton: false,
            allowOutsideClick: false,
            preConfirm: () => {
              this.$store.dispatch('authentication/logout')
            }
          }).then(() => {
            this.$router.push('/login')
          }) 
        } 
      })
        // this.$store.dispatch('authentication/logout')
        //   .then(() => {
        //   this.$router.push('/login')
        //   })
        // })
      
    }
  },
  mounted() {
    this.$on('logout', this.logout)
  }
}

</script>

