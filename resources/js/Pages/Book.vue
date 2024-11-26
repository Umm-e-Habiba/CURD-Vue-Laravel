<template>
  <div v-cloak>
    <h1>Welcome to the Home Page</h1>
    <AddBook @book-added="fetchBooks"/>
    <DisplayBook :books="books" />
  </div>
</template>

<script>
import AddBook from '@/Components/AddBook.vue';
import DisplayBook from '@/Components/DisplayBook.vue';
import { router } from '@inertiajs/vue3'

export default {
  components: {
    AddBook,
    DisplayBook,
  },
  props: {
      books: Array // Expect books as an array from the backend
  },
  methods: {
    fetchBooks() 
    {
          // Fetch data without triggering a full page reload
      router.get('/', {}, {
          preserveState: true,
          only: ['books'],
          onSuccess: (page) => {
              this.books = page.props.books;
          }
      });
    }
  }
};
</script>
<style>
[v-cloak] { display:none; }
</style>