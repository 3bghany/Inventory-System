<template>

    
    <div>
  
  <div class="row" style="position: relative;left: 25px;">
   <router-link to="/expenses" class="btn btn-primary">{{ $t("main.All Expenses") }} </router-link>
    
  </div>
  
  
   
    <div class="row justify-content-center">
       <div class="col-xl-12 col-lg-12 col-md-12">
         <div class="card shadow-sm my-5">
           <div class="card-body p-0">
             <div class="row">
               <div class="col-lg-12">
                 <div class="login-form">
                   <div class="text-center">
                     <h1 class="h4 text-gray-900 mb-4">{{ $t("main.Add Expense") }}</h1>
                   </div>
  
       <form class="user" @submit.prevent="insertExpense()" enctype="multipart/form-data">
  
         <div class="form-group">
  
           <div class="form-row">
             <div class="col-md-12">
              <label for="exampleInputFirstName" style="margin-right: 10px;"> {{ $t("main.Expense") }} {{ $t("main.Details") }}</label>
        <small class="text-danger" v-if="errors.details"> {{ errors.details[0] }} </small>

          <textarea style="min-height:100px;  max-height:200px;"  maxlength="255" class="form-control" id="exampleInputFirstName" :placeholder="$t('main.Details')" v-model="form.details"></textarea>
             </div>
      
             
           </div>
         </div>
         
         <div class="form-group">
  
           <div class="form-row">
             <div class="col-md-12">
              <label for="exampleInputFirstName" style="margin-right: 10px;"> {{ $t("main.Expense") }} {{ $t("main.Amount") }}</label>
          <small class="text-danger" v-if="errors.amount"> {{ errors.amount[0] }} </small>
          <input type="text" class="form-control" id="exampleInputFirstName" :placeholder="$t('main.Enter')+' '+$t('main.Amount')" v-model="form.amount">
             </div>
  
  
      <div class="col-md-6">
         
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
          amount: null,
          details: null,
        },
        errors:{}
      }
    },
    methods:{
      insertExpense(){
        axios.post('/api/expenses',this.form)
      .then(() =>{
        Toast.fire({ icon: "success", title: "Expense added successfully"});
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