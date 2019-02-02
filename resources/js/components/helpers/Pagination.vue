<template>
  <ul class="pagination justify-content-center">
    <li class="page-item">
      <a class="page-link" href="#" aria-label="Previous" :disabled="pagination.current_page < pagination.last_page"  @click.prevent="changePage(pagination.current_page + 1)">
        <span aria-hidden="true">Newest Posts</span>
        <span class="sr-only">Newest Posts</span>
      </a>
    </li>
    <li class="page-item">
      <a class="page-link" href="#" aria-label="Next" :disabled="page.current_page > 1" @click.prevent="changePage(pagination.current_page - 1)">
        <span aria-hidden="true">Older Posts</span>
        <span class="sr-only">Older Posts</span>
      </a>
    </li>
  </ul>
</template>

<script>

export default {
  props: {
    pagination: {
      type: Object,
      required: true
    },
    offset: {
      type: Number,
      default: 3
    }
  },
  computed: {
    pagesNumber() {
      if (!this.pagination.to) {
        return [];
      }

      let from = this.pagination.current_page - this.offset;
      if (from < 1) {
        from = 1;
      }

      let to = from + this.offset;
      if (to >= this.pagination.last_page) {
        to = this.pagination.last_page;
      }
      
      let pagesArray = [];
      for (let page = from; page <= to; page++) {
        pagesArray.push(page);
      }
      
      return pagesArray;
    }
  },
  methods: {
    changePage(page) {
      this.$emit('paginate', page);
    }
  }
}

</script>

