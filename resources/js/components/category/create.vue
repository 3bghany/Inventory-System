<template>

    
    <div>
  
  <div class="row" style="position: relative;left: 25px;">
   <router-link to="/categories" class="btn btn-primary">{{ $t("main.All Categories") }} </router-link>
    
  </div>
  
  
   
    <div class="row justify-content-center">
       <div class="col-xl-12 col-lg-12 col-md-12">
         <div class="card shadow-sm my-5">
           <div class="card-body p-0">
             <div class="row">
               <div class="col-lg-12">
                 <div class="login-form">
                   <div class="text-center">
                     <h1 class="h4 text-gray-900 mb-4">{{ $t("main.Add Category") }}</h1>
                   </div>
  
       <form class="user" @submit.prevent="insertCategory()" enctype="multipart/form-data">
  
         <div class="form-group">
  
           <div class="form-row">
             <div class="col-md-12">
          <input type="text" class="form-control" id="exampleInputFirstName" :placeholder="$t('main.Enter')+' '+$t('main.Category\'s Name')" v-model="form.name">
        <small class="text-danger" v-if="errors.name"> {{ errors.name[0] }} </small>
             </div> 
             
           </div>
         </div>
        
  
  
         <div class="form-group">
           <button type="submit" class="btn btn-primary btn-block" style="color:#ffffff">{{ $t("main.Submit") }}</button>
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
        }
      },
      data(){
      return {
        form:{
          name: null,
        },
        errors:{}
      }
    },
    methods:{
      insertCategory(){
        axios.post('/api/categories',this.form)
      .then(() =>{
        Toast.fire({ icon: "success", title: "Category added successfully"});
        this.$router.push("/categories");
      })
      .catch(error => this.errors=error.response.data.errors)
      },
    }
  }
  
  
  </script>