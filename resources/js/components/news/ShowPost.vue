<template>
  <div class="animated fadeIn">
    <b-row>
      <b-col>
        <b-card>
          <strong></strong>
        </b-card>
        <b-row class="mb-3">
          <b-col md="3">
            <b-button><i class="fas fa-arrow-left" /> Back</b-button>
          </b-col>
        </b-row>
        <b-row>
          <b-col>
            <div class="display-4">{{ post.title }}</div>
            <hr>
            <p>Posted {{ post.created_at }} by {{ post.created_by }}</p>
            <p>Category <a href="#">{{ post.category }}</a></p>
            <br>
            <p>{{ post.content }}</p>
            <hr>
          </b-col>
        </b-row>
      </b-col>
    </b-row>
  </div>
</template>

<script>
export default {
  name: 'ShowPost',
  data () {
    return {
      post: {
        title: '',
        category: '',
        created_by: '',
        created_at: '',
        content: '',
      }
    }
  }
}
</script>
