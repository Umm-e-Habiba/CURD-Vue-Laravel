<template>
  <h2> ALL Book Details</h2>
  
    <div >
      <table>
        <thead>
          <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Price</th>
          <th>Launch</th>
          </tr>
        </thead>
      <tbody>
        <tr v-for="(data, index) in bookList" :key="index">
          <td>{{ data.id }}</td>
          <td>{{ data.name }}</td>
          <td>{{ data.price }}</td>
          <td>{{ data.launch }}</td>
          <td><button class="updatebook" id="{{ data.id }}"  @click="UpdateBook(data)">Update</button></td>
          <td><button class="deletebook" id="{{ data.id }}" @click="DeleteBook(data)">Delete</button></td>
          
      </tr>
      </tbody>
      
      </table>
    </div>

  <!--Show Model for dialog-->  
  <div>
  <!--<b-button v-b-modal.modal-prevent-closing>Open Modal</b-button>
  <b-button @click="$bvModal.show('modal-prevent-closing')">Open Modal</b-button>-->
  

 <!-- <div class="mt-3">
    Submitted Names:
    <div v-if="submittedNames.length === 0">--</div>
    <ul v-else class="mb-0 pl-3">
      <li v-for="name in submittedNames">{{ name }}</li>
    </ul>
  </div>
-->

<b-modal
    id="modal-prevent-closing"
    v-model="showModal"
    title="Update Book Details"
    @show="resetModal"
    @hidden="resetModal"
    @ok="handleOk"
    v-if="selectedBook" 
>
    <form ref="form" @submit.stop.prevent="handleSubmit">
        <b-form-group
            label="Name"
            label-for="name-input"
            invalid-feedback="Name is required"
            :state="nameState"
        >
            <b-form-input
                id="name-input"
                v-model="this.selectedBook.name"
                :state="nameState"
                required
                
            ></b-form-input>
        </b-form-group>
        <b-form-group
            label="Price"
            label-for="price-input"
            invalid-feedback="Price is required"
        >
            <b-form-input
                id="price-input"
                v-model="selectedBook.price"
                
                required
            ></b-form-input>
        </b-form-group>
        <b-form-group
            label="Launch Date"
            label-for="launch-input"
        >
            <b-form-input
                id="launch-input"
                v-model="selectedBook.launch"
                required
            ></b-form-input>
        </b-form-group>
    </form>
</b-modal>
</div>  

  </template>
  
  <script>

//import { Inertia } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3'
import { Inertia } from '@inertiajs/inertia';
export default {
  
props: {
  books: Array

},
mounted() {
  
      console.log(this.books); // Check if data is passed correctly
  },
  data(){
    return{
      name: '',
      nameState: null,
      showModal: false,  // Controls the modal visibility
      selectedBook: {}, // Holds the book data for updating
      submittedNames: [],
          bookList: [...this.books], // Create a local, modifiable copy of `books`
      
      };
  },
  watch: {
      // Update `bookList` if `books` changes in the parent
      books: {
          immediate: true,
          handler(newBooks) {
              this.bookList = [...newBooks];
          },
      },
      selectedBook: {
        immediate: true,
        deep: true,
        handler(newVal) {
          console.log("selectedBook updated:", newVal); // Log to verify the watcher is triggered
          
        }
      },
  },
  methods: {
  DeleteBook(book) {
      // Confirm before deletion (optional)
      if (!confirm(`Are you sure you want to delete "${book.name}"?`)) {
          return;
      }
      this.bookList = this.bookList.filter(b => b.id !== book.id);
      // Call Inertia delete route with the book ID
      router.delete(`/books/${book.id}`, {
          preserveState: true,
          onSuccess: () => {
              // Filter out the deleted book from the books array
              
              //alert("Book deleted successfully!");
          }
      });
  },

  UpdateBook(book) {
      // Confirm before deletion (optional)
      this.selectedBook = { ...book }; // Clone the book data
      alert(JSON.stringify(this.selectedBook));
      
        
      this.showModal = true;
      
      //this.bookList = this.bookList.filter(b => b.id !== book.id);
      // Call Inertia delete route with the book ID
     /* router.update(`/books/${book.id}`, {
          preserveState: true,
          onSuccess: () => {
              // Filter out the deleted book from the books array
              
              //alert("Book deleted successfully!");
          }
      });*/
  },
  checkFormValidity() {
      const valid = this.$refs.form.checkValidity()
      this.nameState = valid
      return valid
    },
    resetModal() {
    this.name = '';
    this.nameState = null;
    //this.selectedBook = {}; // Reset selectedBook
},
    handleOk(bvModalEvent) {
      // Prevent modal from closing
      bvModalEvent.preventDefault()
      // Trigger submit handler
      this.handleSubmit()
    },
    handleSubmit() {
      
    // Find the index of the selected book in the bookList
    this.showModal = false;
    const index = this.bookList.findIndex(book => book.id === this.selectedBook.id);
    if (index !== -1) {
        // Update the book in bookList with the modified data from selectedBook
        this.bookList.splice(index, 1, { ...this.selectedBook });
        
    // Use Inertia.put to update the book on the server
    
      Inertia.put(`/books/${this.selectedBook.id}`, this.selectedBook, {
        preserveState: true,
        onSuccess: () => {
          alert("Book updated successfully!");
        },
        onError: (errors) => {
          console.error("Error updating book:", errors);
        }
      });
      

    }
  
     // Close the modal
    this.selectedBook = {};
      
    },
},
};
  </script>
  
  <style scoped>
  
    /* Add any custom styles here */
    table {
border-collapse: collapse;
border-spacing: 0;
width: 100%;
border: 1px solid #ddd;
}

th, td {
text-align: left;
padding: 16px;
}

tr:nth-child(even) {
background-color: #f2f2f2;
}
.deletebook{
background-color: RED;
}
.updatebook{
background-color: blue;
}
  </style>
  