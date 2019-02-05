<template>
  <div class="animated fadeIn">
    <b-row>
      <b-col>        
        <b-card>
          <div slot="header">
            <i class="fas fa-user"></i> <strong> Create User</strong>
          </div>
          <b-form @submit.prevent="addUser" @reset.prevent="resetForm">
            <b-row>
              <b-col md="4" class="mb-3">
                <b-alert :variant="success.isSuccess ? 'success' : 'danger' " :show="success.isSuccess" dismissible>{{ success.message }}</b-alert>
                <b-row class="text-center mb-3">
                  <b-col>
                    <b-img rounded="circle" thumbnail width="256" :src="avatar.avatar_link" :alt="avatar.avatar_name" />
                  </b-col>
                </b-row>
                <b-row class="text-center">
                  <b-col>
                    <b-button variant="success" type="button" v-b-modal="'uploadAvatar'">Upload Avatar</b-button>
                  </b-col>
                  <b-modal 
                    ref="uploadAvatarRef"
                    title="Upload Avatar" 
                    size="lg" 
                    class="modal-success" 
                    id="uploadAvatar"
                    ok-variant="success"
                    cancel-variant="danger"
                    ok-title="Upload"
                    @ok="uploadAvatar()">
                    <b-row class="mb-5">
                      <b-col md="6">
                        <vue-croppie
                          ref="croppieRef"
                          :enableOrientation="true"
                          :enableResize="false"
                          :enableExif="false"
                          :viewport="{ width: 300, height: 300 }"
                          :boundary="{ width: 350, height: 350 }"
                          @result="uploadResult"
                          @update="uploadUpdate">
                        </vue-croppie>
                      </b-col>
                      <b-col md="6">
                        <b-img :src="cropped"/>
                      </b-col>
                    </b-row>
                    <b-row>
                      <b-col>
                        <b-form-file ref="browseImageRef" id="browseImage" @change="changeAvatar" class="mb-3" v-model="file" :state="Boolean(file)" placeholder="Change Avatar">Change Avatar</b-form-file>
                        <b-button @click.prevent="rotate(-90)" variant="primary">Rotate Left</b-button>
                        <b-button @click.prevent="rotate(90)" variant="primary">Rotate Right</b-button>
                        <b-button @click.prevent="cropAvatar()" variant="primary">Crop</b-button>
                      </b-col>
                    </b-row>
                  </b-modal>
                </b-row>
              </b-col>

              <b-col md="8" class="mb-3">
                <b-form-group
                  label="Name"
                  label-for="name"
                  :label-cols="3"
                  :horizontal="true">
                  <b-form-input id="name" type="text" v-model="user.name"></b-form-input>
                </b-form-group>

                <b-form-group
                  label="Username"
                  label-for="username"
                  :label-cols="3"
                  :horizontal="true">
                <b-form-input id="username" type="text" v-model="user.username"></b-form-input>
                </b-form-group>

                <b-form-group
                  label="Password"
                  label-for="password"
                  :label-cols="3"
                  :horizontal="true">
                  <b-form-input id="password" type="password" v-model="user.password"></b-form-input>
                </b-form-group>

                <b-form-group
                  label="Confirm Password"
                  label-for="confirmPassword"
                  :label-cols="3"
                  :horizontal="true">
                  <b-form-input id="confirmPassword" type="password" v-model="user.password_conf"></b-form-input>
                </b-form-group>

                <b-form-group
                  label="Roles"
                  label-for="roles"
                  :label-cols="3"
                  :horizontal="true">
                  <b-form-select id="roles"
                    :plain="true"
                    v-model="selected"
                    :options="options"
                    value="Select Role">
                  </b-form-select>
                </b-form-group>

                <b-button size="lg" type="reset" class="mt-2" variant="danger">Reset</b-button>
                <b-button size="lg" type="submit" class="float-right mt-2" variant="primary">Create</b-button>

              </b-col>
            </b-row>
          </b-form>
        </b-card>
      </b-col>
    </b-row>
  </div>
</template>

<script>

export default {
  name: 'CreateUser',
  data () {
    return {
      user: {
        name: '',
        password: '',
        password_conf: '',
      },
      cropped: null,
      file: null,
      avatar: {
        avatar_id: null,
        avatar_name: 'default.jpg',
        avatar_link: '/storage/avatars/default.png',
      },
      selected: null,
      options: [
        { value: null, text: 'Select Role' },
        { value: 1, text: 'Admin' },
        { value: 2, text: 'User' },
      ],
      showMessage: false,
      success: {
        isSuccess: false,
        message: ''
      },
      error: {
        isError: false,
        message: '',
      },
    }
  },
  mounted () {
    this.$refs.croppieRef.bind({
      url: this.avatar.avatar_link
    })
  },
  methods: {
    resetForm: function () {
      this.user.username = ''
      this.user.name = ''
      this.user.password = ''
      this.user.password_conf = ''
      this.selected = null
      this.avatar.avatar_name = 'default.png'
      this.avatar.avatar_link = '/storage/avatars/default.png'
      this.avatar.avatar_id = null
      this.cropped = null
      this.file = null
    },
    addUser: function () {
      this.loaded = true
      axios.post('/api/users', {
        name: this.user.name,
        username: this.user.username,
        password: this.user.password,
        // password_conf: this.user.password_conf,
        avatar_id: this.avatar.avatar_id,
        role_id: this.selected
      })
      .then(response => {
        this.success.isSuccess = true
        this.success.message = 'User successfully added'

        this.resetForm()
      })
      .catch(error => {
        this.error.isError = true
        this.error.message = 'Error adding user'
      })

      console.log({
        name: this.user.name,
        username: this.user.username,
        password: this.user.password,
        password_conf: this.user.password_conf,
        avatar_id: this.avatar.avatar_id,
        roles: this.selected
      })
    },
    uploadAvatar: function () {
      
      let data = new FormData()
      data.append('file', this.cropped)
      axios.post('/api/avatars', data, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      })
      .then(response => {
        this.avatar.avatar_id = response.data.data.id
        this.avatar.avatar_name = response.data.data.avatar_name
        this.avatar.avatar_link = response.data.data.avatar_link
      })
      .catch(error => {
        console.error(error)
      })
    },
    changeAvatar: function (input) {
      // this.$emit('input', e.target.files[0])
      // console.log(e)
      let reader = new FileReader()
      reader.readAsDataURL(input.target.files[0])
      reader.onload = () => {
        this.dialog = true
        this.$refs.croppieRef.bind({
          url: reader.result
        })
        input.target.value = null
      }
      reader.onerror = (error) => {
        console.log(error)
      }
    },
    cropAvatar: function () {
      let options = {
        type: 'base64',
        size: 'viewport',
        format: 'png',
      }
      this.$refs.croppieRef.result(options, (output) => {
        this.cropped = output
      })
    },
    uploadResult: function (output) {
      this.cropped = output
    },
    uploadUpdate: function (value) {
      // console.log(value)
    },
    rotate: function (angle) {
      this.$refs.croppieRef.rotate(angle)
    }
  }
}
</script>

