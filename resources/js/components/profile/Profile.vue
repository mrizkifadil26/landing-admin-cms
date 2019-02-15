<template>
  <div class="animated fadeIn">
    <b-row>
      <b-col>
        <b-card>
          <div slot="header">
            <i class="fas fa-user"></i><strong> Profile</strong>
          </div>
          <b-row>
            <b-col md="4" class="mb-3 text-center">
              <b-img-lazy
                v-bind="avatarProps"
                class="mb-3"
                rounded="circle"
                :alt="user.avatar.avatar_name"
                :src="user.avatar.avatar_link"
                width="256" />
              <br>
              <input
                @change="onFileChange($event.target.name, $event.target.files)" 
                name="file"
                type="file"
                ref="avatar" 
                style="display: none" />
              <b-button variant="success" @click="changeAvatar()">Change Avatar</b-button>
            </b-col>
            <b-col md="8">
              <b-table
                stacked
                :items="[user]"
                :fields="fields"></b-table>
            </b-col>
          </b-row>
        </b-card>
      </b-col>
    </b-row>
  </div>
</template>

<script>

export default {
  name: 'Profile',
  data () {
    return {
      avatar: null,
      maxSize: 1024,
      fields: [
        { key: 'name'},
        { key: 'username' },
        { key: 'role.name', label: 'Role' },
        { key: 'posts.length', label: 'Posts' },
        { key: 'comments.length', label: 'Comments' },
        { key: 'complaints.length', label: 'Complaints' }
      ],
      avatarProps: {
        blank: true,
        blankColor: '#bbb'
      }
    }
  },
  methods: {
    onFileChange (fieldName, file) {
      const { maxSize } = this
      let imageFile = file[0]

      if (file.length > 0) {
        let size =imageFile.size / maxSize / maxSize
        if (!imageFile.type.match('image.*')) {
          console.log('Error: choose an image file')
        } else if (size > 1) {
          console.log('Error: file is too big!')
        } else {
          let formData = new FormData()
          let imageURL = URL.createObjectURL(imageFile)
          formData.append(fieldName, imageFile)
          this.$emit('input', { formData, imageURL })
          console.log(formData)
        }
      }
    },
    changeAvatar () {
      this.$refs.avatar.click()
    }
  },
  computed: {
    user () {
      return this.$store.getters['authentication/currentUser']
    }
  }
}

</script>
