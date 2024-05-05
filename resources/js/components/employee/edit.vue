<template>

    
    <div>
  
  <div class="row" style="position: relative;left: 25px;">
   <router-link to="/employees" class="btn btn-primary">All Employees </router-link>
    
  </div>
  
  
   
    <div class="row justify-content-center">
       <div class="col-xl-12 col-lg-12 col-md-12">
         <div class="card shadow-sm my-5">
           <div class="card-body p-0">
             <div class="row">
               <div class="col-lg-12">
                 <div class="login-form">
                   <div class="text-center">
                     <h1 class="h4 text-gray-900 mb-4">Update Employee</h1>
                   </div>
  
       <form class="user" @submit.prevent="editEmployee()" enctype="multipart/form-data">
  
         <div class="form-group">
  
           <div class="form-row">
             <div class="col-md-6">
          <input type="text" class="form-control" id="exampleInputFirstName" placeholder="Enter Full Name" v-model="employee.name">
        <small class="text-danger" v-if="errors.name"> {{ errors.name[0] }} </small>
             </div>
  
  
      <div class="col-md-6">
          <input type="email" class="form-control" id="exampleInputFirstName" placeholder="Enter Email" v-model="employee.email">
          <small class="text-danger" v-if="errors.email"> {{ errors.email[0] }} </small>
             </div>     
             
           </div>
         </div>
        
         
          <div class="form-group">
  
           <div class="form-row">
             <div class="col-md-6">
          <input type="text" class="form-control" id="exampleInputFirstName" placeholder="Enter Address" v-model="employee.address">
          <small class="text-danger" v-if="errors.address"> {{ errors.address[0] }} </small>
             </div>
  
  
      <div class="col-md-6">
          <input type="text" class="form-control" id="exampleInputFirstName" placeholder="Enter salary" v-model="employee.salary">
          <small class="text-danger" v-if="errors.salary"> {{ errors.salary[0] }} </small>
             </div>     
             
           </div>
         </div>
  
        
  
  
  
         <div class="form-group">
  
           <div class="form-row">
             <div class="col-md-6">
          <input type="date" class="form-control" id="exampleInputFirstName" placeholder="Enter Joining Date" v-model="employee.joining_date">
   <small class="text-danger" v-if="errors.joining_date"> {{ errors.joining_date[0] }} </small>
             </div>
  
  
      <div class="col-md-6">
          <input type="text" class="form-control" id="exampleInputFirstName" placeholder="Enter Nid" v-model="employee.nid">
          <small class="text-danger" v-if="errors.nid"> {{ errors.nid[0] }} </small>
             </div>     
             
           </div>
         </div>
  
  
  
         <div class="form-group">
  
           <div class="form-row">
             <div class="col-md-6">
          <input type="text" class="form-control" id="exampleInputFirstName" placeholder="Enter phone Number" v-model="employee.phone">
          <small class="text-danger" v-if="errors.phone"> {{ errors.phone[0] }} </small>
             </div>
  
  
      <div class="col-md-6">
         
             </div>     
             
           </div>
         </div>
  
  
          <div class="form-group">

           <div class="form-row">
             <div class="col-md-6">
    <input type="file" class="custom-file-input" id="customFile" @change="OnFileSelect">
  
   <small class="text-danger" v-if="errors.photo"> {{ errors.photo[0] }} </small>
        <label class="custom-file-label" for="customFile">Choose file</label>
             </div>
  
      <div class="col-md-6">
        <img :src="employee.newPhoto ? employee.newPhoto : (employee.photo?employee.photo:'/backend/img/boy.png')"  style="height: 100px; width: 100px;" class="image_employee">       
  
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
            axios.get('/api/employees/'+id)
            .then(({data}) => {this.employee = data.data[0];})
        }
      },
      data(){
      return {
        employee:{
          name: '',
          email: '',
          phone: '',
          salary: '',
          address: '',
          photo: '',
          newPhoto:'',
          nid: '',
          joining_date: ''
        },
        errors:{}
      }
    },
    methods:{
      OnFileSelect(event){
        let file = event.target.files[0];
        if(file.size > 1048770)
          {this.$notify({type: "error",text: "Image Size more than 1MB ",duration: 3000,})
            this.employee.newPhoto=null;
          }
        else{
          let reader = new FileReader();
        reader.onload = event =>{
          this.employee.newPhoto = event.target.result;
          let f=this.employee.newPhoto.indexOf("/");
          let l=this.employee.newPhoto.indexOf(";") - f;
          let ext = this.employee.newPhoto.substr(f+1, l-1);
          if(ext != "png" && ext != "jpeg" && ext != "jpg"){
                  Toast.fire({icon: 'info',title: 'Allowed Types(png,jpg,jpeg)'})
                  this.employee.newPhoto=null;
                      }
                  };
                  reader.readAsDataURL(file);
        }
      },
      editEmployee(){
        let id =this.$route.params.id;
        axios.put('/api/employees/'+id,this.employee)
      .then(() =>{
        Toast.fire({ icon: "success", title: "employee updated successfully"});
        this.$router.push("/employees");
      })
      .catch(error => {this.errors=error.response.data.errors})
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