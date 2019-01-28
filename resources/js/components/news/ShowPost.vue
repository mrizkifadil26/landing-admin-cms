<template>
  <div class="animated fadeIn">
    <b-row>
      <b-col>
        <b-card>
          <strong></strong>
          <b-row class="mb-3">
            <b-col md="3" sm="3" class="text-left">
              <b-button variant="warning"><i class="fas fa-arrow-left" /> Back</b-button>
            </b-col>
            <b-col md="3 ml-auto" sm="3 ml-auto" class="text-right">
              <b-button variant="warning"><i class="fas fa-eye" /> Preview</b-button>
            </b-col>
          </b-row>
          <b-row>
            <b-col>
              <div class="display-4">{{ post.title }}</div>
              <hr>
              <p>Posted {{ post.created_at }} by {{ post.created_by }}</p>
              <p>Tags: <a href="#">{{ post.category }}</a></p>
              <br>
              <b-img src="http://placehold.it/900x350" center fluid alt="" class="mb-3" />
              <p>{{ post.content }}</p>
              <hr>
            </b-col>
          </b-row>
        </b-card>
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
        title: 'Ahiii',
        category: 'Ashiaapp',
        created_by: 'Atta Halilintar Ia cetak Gol',
        created_at: '2017',
        content: 'wkwkwkwkwkwkwkwkwkwkwkwkwk',
      }
    }
  }
}
</script>
