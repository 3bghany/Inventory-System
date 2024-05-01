<template>

    
    <div>
  
  <div class="row" style="position: relative;left: 25px;">
   <router-link to="/suppliers" class="btn btn-primary">All Suppliers </router-link>
    
  </div>
  
  
   
    <div class="row justify-content-center">
       <div class="col-xl-12 col-lg-12 col-md-12">
         <div class="card shadow-sm my-5">
           <div class="card-body p-0">
             <div class="row">
               <div class="col-lg-12">
                 <div class="login-form">
                   <div class="text-center">
                     <h1 class="h4 text-gray-900 mb-4">Update Supplier</h1>
                   </div>
  
       <form class="user" @submit.prevent="editSupplier()" enctype="multipart/form-data">
  
         <div class="form-group">
  
           <div class="form-row">
             <div class="col-md-6">
          <input type="text" class="form-control" id="exampleInputFirstName" placeholder="Enter Full Name" v-model="supplier.name">
        <!-- <small class="text-danger" v-if="errors.name"> {{ errors.name[0] }} </small> -->
             </div>
  
  
      <div class="col-md-6">
          <input type="email" class="form-control" id="exampleInputFirstName" placeholder="Enter Email" v-model="supplier.email">
          <!-- <small class="text-danger" v-if="errors.email"> {{ errors.email[0] }} </small> -->
             </div>     
             
           </div>
         </div>
        
         
          <div class="form-group">
  
           <div class="form-row">
             <div class="col-md-6">
          <input type="text" class="form-control" id="exampleInputFirstName" placeholder="Enter Address" v-model="supplier.address">
          <!-- <small class="text-danger" v-if="errors.address"> {{ errors.address[0] }} </small> -->
             </div>
  
  
      <div class="col-md-6">
          <input type="text" class="form-control" id="exampleInputFirstName" placeholder="Enter Shop Name" v-model="supplier.shopname">
          <!-- <small class="text-danger" v-if="errors.sallery"> {{ errors.sallery[0] }} </small> -->
             </div>     
             
           </div>
         </div>
  
  
  
         <div class="form-group">
  
           <div class="form-row">
             <div class="col-md-6">
          <input type="text" class="form-control" id="exampleInputFirstName" placeholder="Enter phone Number" v-model="supplier.phone">
          <!-- <small class="text-danger" v-if="errors.phone"> {{ errors.phone[0] }} </small> -->
             </div>
  
  
      <div class="col-md-6">
         
             </div>     
             
           </div>
         </div>
  
  
          <div class="form-group">

           <div class="form-row">
             <div class="col-md-6">
    <input type="file" class="custom-file-input" id="customFile" @change="OnFileSelect">
  
   <!-- <small class="text-danger" v-if="errors.photo"> {{ errors.photo[0] }} </small> -->
        <label class="custom-file-label" for="customFile">Choose file</label>
             </div>
  
      <div class="col-md-6">
        <img :src="supplier.newPhoto ? supplier.newPhoto : (supplier.photo?supplier.photo:'/backend/img/boy.png')"  style="height: 100px; width: 100px;" class="image_employee">       
  
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
            axios.get('/api/suppliers/'+id)
            .then(({data}) => {this.supplier = data.data[0];})
        }
      },
      data(){
      return {
        supplier:{
          name: '',
          email: '',
          phone: '',
          shopname: '',
          address: '',
          photo: '',
          newPhoto:'',
        },
        errors:{}
      }
    },
    methods:{
      OnFileSelect(event){
        let file = event.target.files[0];
        if(file.size > 1048770)
          {this.$notify({type: "error",text: "Image Size more than 1MB ",duration: 3000,})
            this.supplier.newPhoto=null;
          }
        else{
          let reader = new FileReader();
        reader.onload = event =>{
          this.supplier.newPhoto = event.target.result;
          let f=this.supplier.newPhoto.indexOf("/");
          let l=this.supplier.newPhoto.indexOf(";") - f;
          let ext = this.supplier.newPhoto.substr(f+1, l-1);
          if(ext != "png" && ext != "jpeg" && ext != "jpg"){
                  Toast.fire({icon: 'info',title: 'Allowed Types(png,jpg,jpeg)'})
                  this.supplier.newPhoto=null;
                      }
                  };
                  reader.readAsDataURL(file);
        }
      },
      editSupplier(){
        let id =this.$route.params.id;
        axios.put('/api/suppliers/'+id,this.supplier)
      .then(() =>{
        Toast.fire({ icon: "success", title: "supplier updated successfully"});
        this.$router.push("/suppliers");
      })
      .catch(error => console.log(error.response.data))
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