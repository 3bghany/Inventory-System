<template>

    
    <div>
  
  <div class="row" style="position: relative;left: 25px;">
   <router-link to="/employees" class="btn btn-primary">{{ $t("main.All Employees") }} </router-link>
    
  </div>
  
  
   
    <div class="row justify-content-center">
       <div class="col-xl-12 col-lg-12 col-md-12">
         <div class="card shadow-sm my-5">
           <div class="card-body p-0">
             <div class="row">
               <div class="col-lg-12">
                 <div class="login-form">
                   <div class="text-center">
                     <h1 class="h4 text-gray-900 mb-4">{{ $t("main.Pay Salary") }}</h1>
                   </div>
  
       <form class="user" @submit.prevent="paySalary()" enctype="multipart/form-data">
  
         <div class="form-group">
  
           <div class="form-row">
             <div class="col-md-6">
              <label for="exampleInputFirstName">{{ $t("main.Name") }}</label>
          <input type="text" readonly class="form-control" id="exampleInputFirstName" placeholder="Enter Full Name" v-model="employee.name">
             </div>
  
  
      <div class="col-md-6">
        <label for="exampleInputFirstName"> {{ $t("main.Email") }}</label>
          <input type="email" readonly class="form-control" id="exampleInputFirstName" placeholder="Enter Email" v-model="employee.email">
             </div>     
             
           </div>
         </div>
        
         
          <div class="form-group">
  
           <div class="form-row">
             <div class="col-md-6">
              <label for="exampleInputFirstName"> {{ $t("main.Month") }}</label>
          <select class="form-control" id="exampleInputFirstName" v-model="employee.salary_month">
            <option value="January">{{ $t("main.January") }}</option>
            <option value="February">{{ $t("main.February") }}</option>
            <option value="March">{{ $t("main.March") }}</option>
            <option value="April">{{ $t("main.April") }}</option>
            <option value="May">{{ $t("main.May") }}</option>
            <option value="June">{{ $t("main.June") }}</option>
            <option value="July">{{ $t("main.July") }}</option>
            <option value="August">{{ $t("main.August") }}</option>
            <option value="September">{{ $t("main.September") }}</option>
            <option value="October">{{ $t("main.October") }}</option>
            <option value="November">{{ $t("main.November") }}</option>
            <option value="December">{{ $t("main.December") }}</option>
          </select>
          <small class="text-danger" v-if="errors.salary_month"> {{ errors.salary_month[0] }} </small>
             </div>
  
  
      <div class="col-md-6">
        <label for="exampleInputFirstName">{{ $t("main.Salary") }}</label>
          <input type="text" class="form-control" id="exampleInputFirstName" :placeholder=" $t('main.Enter')+' '+$t('main.Salary')" v-model="employee.salary">
          <small class="text-danger" v-if="errors.salary"> {{ errors.salary[0] }} </small>
             </div>     
             
           </div>
         </div>
    
  
         <div class="form-group">
           <button type="submit" class="btn btn-primary btn-block" style="color:#ffffff">{{ $t("main.Pay Now") }}</button>
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
            axios.get('/api/employees/'+id)
            .then(({data}) => {this.employee = data.data[0];})
        }
      },
      data(){
      return {
        employee:{
          name: '',
          email: '',
          salary_month: '',
          salary: '',
        },
        errors:{}
      }
    },
    methods:{
      paySalary(){
        let id =this.$route.params.id;
        axios.post('/api/salary/pay/'+id,this.employee)
      .then((data) =>{
        Toast.fire({ icon: data.data.status, title: data.data.message});
        this.$router.push("/employees");
      })
      .catch(error => {
        this.errors=error.response.data.errors;
          console.log(error.response.data.errors)
        })
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