<template>
  <h2>Add Book Details</h2>
  
    <div>
      <form v-on:submit.prevent="AddBook">
        <label for="bookname">Enter Book Name:</label>
        <input type="text" v-model="form.name" id="bookname" required placeholder="Type here..." />

        <label for="bookprice">Enter Book Price:</label>
        <input type="number" v-model="form.price" id="bookprice" placeholder="Type here..." />

        <label for="booklaunch">Enter Book Launch Details:</label>
        <input type="number" v-model="form.launch" id="booklaunch" placeholder="Type here..." />

        <button>Add Book</button>

      </form>
    </div>

    <div>
      <p>Shopping list:</p>
      <ul>
        <li v-for="book in bookList" :key="book.name">{{ book.name }}, {{ book.price}}, {{ book.launch}}</li>
      </ul>
    </div>
      

  </template>
  
  <script>
  import { useForm } from '@inertiajs/vue3';

export default {
  //props: ['books'],
  emits: ['book-added'], // Declare the 'book-added' event here
    data() {
        return {
            form: useForm({
                name: "",
                price: "",
                launch: ""
            }),
            bookList: []
        };
    },
    methods: {
        AddBook() {
          this.$emit('book-added', { ...this.form });
            this.form.post('/', {
              
                onSuccess: () => {
                  //this.$emit('book-added', { ...this.form }); // Emit book data to parent
                    //this.bookList.push({ ...this.form }); // Add to the list
                    
                  this.form.reset(); // Reset the form
                },
                onError: (errors) => {
                    console.error('Form submission error:', errors); // Log any validation errors
                }
            });
        }
    }
};
  </script>
  
  <style scoped>
    /* Add any custom styles here */
  </style>
  