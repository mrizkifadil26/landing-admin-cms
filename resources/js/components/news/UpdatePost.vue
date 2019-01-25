<template>
  <div class="animated fadeIn">
    <b-row>
      <b-col>
        <b-card>
          <div slot="header">
            <strong><i class="fas fa-pencil" />Edit Post</strong>
          </div>
          <b-row>
            <b-col>
              <b-form-group
                label="Title"
                label-for="title"
                :label-cols="3"
                :horizontal="true">
                <b-form-input id="title" type="text" :value="this.title"></b-form-input>
              </b-form-group>

              <b-form-group
                label="Description"
                label-for="description"
                :label-cols="3"
                :horizontal="true">
                <b-form-input id="description" type="text" :value="this.description"></b-form-input>
              </b-form-group>

              <b-form-group
                label="Category"
                label-for="category"
                :label-cols="3"
                :horizontal="true">
                <b-form-input id="category" type="text" :value="this.category"></b-form-input>
              </b-form-group>

              <b-form-group
                label="Content"
                label-for="content"
                :label-cols="3"
                :horizontal="true">
              </b-form-group>
              <vue-editor v-model="post.content" class="mb-3" :value="this.content"></vue-editor>

              <b-button variant="primary">Publish</b-button>
              <b-button variant="warning">Save As Draft</b-button>

            </b-col>
          </b-row>
        </b-card>
      </b-col>
    </b-row>
  </div>
</template>

<script>

import { VueEditor } from 'vue2-editor'

export default {
  name: 'UpdatePost',
  components: {
    VueEditor
  },
  data () {
    return {
      post: {
        title: '',
        description: '',

      }
    }
  }
}
</script>

