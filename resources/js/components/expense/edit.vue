<template>

    
    <div>
  
  <div class="row" style="position: relative;left: 25px;">
   <router-link to="/expenses" class="btn btn-primary">All Expenses </router-link>
    
  </div>
  
  
   
    <div class="row justify-content-center">
       <div class="col-xl-12 col-lg-12 col-md-12">
         <div class="card shadow-sm my-5">
           <div class="card-body p-0">
             <div class="row">
               <div class="col-lg-12">
                 <div class="login-form">
                   <div class="text-center">
                     <h1 class="h4 text-gray-900 mb-4">Update Expense</h1>
                   </div>
  
       <form class="user" @submit.prevent="editExpense()" enctype="multipart/form-data">
  
         <div class="form-group">
  
           <div class="form-row">
             <div class="col-md-12">
              <label for="exampleInputFirstName" style="margin-right: 10px;"> Expense details  </label>
              <small class="text-danger" v-if="errors.details"> {{ errors.details[0] }} </small>
          <textarea style="min-height:100px;  max-height:200px;"  maxlength="255" class="form-control" id="exampleInputFirstName" placeholder="Details" v-model="expense.details"></textarea>
        
             </div>    
             
           </div>
         </div>
        
         <div class="form-group">
  
           <div class="form-row">
             <div class="col-md-12">
              <label for="exampleInputFirstName" style="margin-right: 10px;"> Expense Amount  </label>
          <small class="text-danger" v-if="errors.amount"> {{ errors.amount[0] }} </small>

          <input type="text" class="form-control" id="exampleInputFirstName" placeholder="Enter the Amount" v-model="expense.amount">
             </div>
  
  
      <div class="col-md-6">
         
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
            axios.get('/api/expenses/'+id)
            .then(({data}) => {this.expense = data.data[0];})
        }
      },
      data(){
      return {
        expense:{
          details: '',
          amount: '',
        },
        errors:{}
      }
    },
    methods:{
      editExpense(){
        let id =this.$route.params.id;
        axios.put('/api/expenses/'+id,this.expense)
      .then(() =>{
        Toast.fire({ icon: "success", title: "Expense updated successfully"});
        this.$router.push("/expenses");
      })
      .catch(error => this.errors=error.response.data.errors)
      },

    }
  }
  
  
  </script>
  
  <style>
  
  .image_employee{
    position: absolute;
    top: -63px;
  }
  </style>