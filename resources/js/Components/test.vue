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
          <td><button class="updatebook" id="{{ data.id }}" @click="UpdateBook(data)">Update</button></td>
          <td><button class="deletebook" id="{{ data.id }}" @click="DeleteBook(data)">Delete</button></td>
          
      </tr>
      </tbody>
      
      </table>
    </div>

  <!--Show Model for dialog-->  
  <div>
  <b-button v-b-modal.modal-prevent-closing>Open Modal</b-button>

  <div class="mt-3">
    Submitted Names:
    <div v-if="submittedNames.length === 0">--</div>
    <ul v-else class="mb-0 pl-3">
      <li v-for="name in submittedNames">{{ name }}</li>
    </ul>
  </div>

  <b-modal
    id="modal-prevent-closing"
    ref="modal"
    title="Submit Your Name"
    @show="resetModal"
    @hidden="resetModal"
    @ok="handleOk"
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
          v-model="name"
          :state="nameState"
          required
        ></b-form-input>
      </b-form-group>
    </form>
  </b-modal>
</div>  

  </template>
  
  <script>

//import { useForm } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3'
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

      if (!confirm(`Are you sure you want to Update Data "${book.name}"?`)) {
          return;
      }
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
      this.name = ''
      this.nameState = null
    },
    handleOk(bvModalEvent) {
      // Prevent modal from closing
      bvModalEvent.preventDefault()
      // Trigger submit handler
      this.handleSubmit()
    },
    handleSubmit() {
      // Exit when the form isn't valid
      if (!this.checkFormValidity()) {
        return
      }
      // Push the name to submitted names
      this.submittedNames.push(this.name)
      // Hide the modal manually
      this.$nextTick(() => {
        this.$bvModal.hide('modal-prevent-closing')
      })
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
  