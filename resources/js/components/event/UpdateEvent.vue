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
                <vue-tags-input
                    v-model="post.category"
                    :tags="tags"
                    @tags-changed="newTags => tags = newTags"></vue-tags-input>
              </b-form-group>

              <b-form-group
                  label="Main Image"
                  label-for="image"
                  :label-cols="3"
                  :horizontal="true">
              </b-form-group>
              <vue-dropzone id="dropzone" :options="dropzoneOptions" class="mb-3"></vue-dropzone>

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
import VueTagsInput from '@johmun/vue-tags-input'
import VueDropzone from 'vue2-dropzone'

export default {
  name: 'UpdateEvent',
  components: {
    VueEditor,
    'vue-tags-input': VueTagsInput,
    'vue-dropzone': VueDropzone,
  },
  data () {
    return {
      post: {
        title: '',
        description: '',
        category: '',
        content: '',
      },
      tags: [],
      dropzoneOptions: {
        url: 'https://httpbin.org/post',
        thumbnailWidth: 200,
        addRemoveLinks: true,
        dictDefaultMessage: "<i class='fas fa-upload'></i> CLICK TO UPLOAD"
      },
    }
  }
}
</script>

