<template>

    
    <div>
  
  <div class="row" style="position: relative;left: 25px;">
   <router-link to="/categories" class="btn btn-primary">All Categories </router-link>
    
  </div>
  
  
   
    <div class="row justify-content-center">
       <div class="col-xl-12 col-lg-12 col-md-12">
         <div class="card shadow-sm my-5">
           <div class="card-body p-0">
             <div class="row">
               <div class="col-lg-12">
                 <div class="login-form">
                   <div class="text-center">
                     <h1 class="h4 text-gray-900 mb-4">Update Category</h1>
                   </div>
  
       <form class="user" @submit.prevent="editCategory()" enctype="multipart/form-data">
  
         <div class="form-group">
  
           <div class="form-row">
             <div class="col-md-12">
          <input type="text" class="form-control" id="exampleInputFirstName" placeholder="Enter Full Name" v-model="category.name">
        <small class="text-danger" v-if="errors.name"> {{ errors.name[0] }} </small>
             </div>
           </div>
         </div>
        
  
  
         <div class="form-group">
           <button type="submit" class="btn btn-primary btn-block" style="color:#ffffff">Update</button>
         </div>
         
       </form>
                   <hr>
                   <div class="text-center">
   
   
                   </div>
                   <div class="text-center">
                   </div>
                 </div>
               </div>
             </div>
           </div>
         </div>
       </div>
     </div>
   </div>
  
  </template>
  
  <script>
  export default {
      created(){
        if (!User.loggedIn()) {
          this.$router.push('/')
        }else{
            let id =this.$route.params.id;
            axios.get('/api/categories/'+id)
            .then(({data}) => {this.category = data.data[0];})
        }
      },
      data(){
      return {
        category:{
          name: '',

        },
        errors:{}
      }
    },
    methods:{
      editCategory(){
        let id =this.$route.params.id;
        axios.put('/api/categories/'+id,this.category)
      .then(() =>{
        Toast.fire({ icon: "success", title: "Category updated successfully"});
        this.$router.push("/categories");
      })
      .catch(error => this.errors=error.response.data.errors)
      },

    }
  }
  
  
  </script>