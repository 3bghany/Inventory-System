<template>

    
    <div>
  
  <div class="row" style="position: relative;left: 25px;">
   <router-link to="/customers" class="btn btn-primary">{{ $t("main.All Customers") }} </router-link>
    
  </div>
  
  
   
    <div class="row justify-content-center">
       <div class="col-xl-12 col-lg-12 col-md-12">
         <div class="card shadow-sm my-5">
           <div class="card-body p-0">
             <div class="row">
               <div class="col-lg-12">
                 <div class="login-form">
                   <div class="text-center">
                     <h1 class="h4 text-gray-900 mb-4">{{ $t("main.Update Customer") }}</h1>
                   </div>
  
       <form class="user" @submit.prevent="editCustomer()" enctype="multipart/form-data">
  
         <div class="form-group">
  
           <div class="form-row">
             <div class="col-md-6">
          <input type="text" class="form-control" id="exampleInputFirstName" :placeholder="$t('main.Enter')+' '+$t('main.Full Name')" v-model="customer.name">
        <small class="text-danger" v-if="errors.name"> {{ errors.name[0] }} </small>
             </div>
  
  
      <div class="col-md-6">
          <input type="email" class="form-control" id="exampleInputFirstName" :placeholder="$t('main.Enter')+' '+$t('main.Email')" v-model="customer.email">
          <small class="text-danger" v-if="errors.email"> {{ errors.email[0] }} </small>
             </div>     
             
           </div>
         </div>
        
         
          <div class="form-group">
  
           <div class="form-row">
             <div class="col-md-6">
          <input type="text" class="form-control" id="exampleInputFirstName" :placeholder=" $t('main.Enter')+' '+$t('main.Address')" v-model="customer.address">
          <small class="text-danger" v-if="errors.address"> {{ errors.address[0] }} </small>
             </div>
  
             <div class="col-md-6">
          <input type="text" class="form-control" id="exampleInputFirstName" :placeholder=" $t('main.Enter')+' '+$t('main.Phone')+' '+$t('main.Number')" v-model="customer.phone">
          <small class="text-danger" v-if="errors.phone"> {{ errors.phone[0] }} </small>
             </div> 
           
             
           </div>
         </div>  
          <div class="form-group" style="margin-top: 70px;">

           <div class="form-row">
             <div class="col-md-6">
    <input type="file" class="custom-file-input" id="customFile" @change="OnFileSelect">
  
        <label class="custom-file-label" for="customFile">{{ $t("main.Choose file") }}</label>
             </div>
  
      <div class="col-md-6">
        <img :src="customer.newPhoto ? customer.newPhoto : (customer.photo?customer.photo:'/backend/img/boy.png')"  style="height: 100px; width: 100px;" class="image_employee">       
  
             </div>     
             
           </div>
         </div>
  
         <div class="form-group">
           <button type="submit" class="btn btn-primary btn-block" style="color:#ffffff">{{ $t("main.Update") }}</button>
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
            axios.get('/api/customers/'+id)
            .then(({data}) => {this.customer = data.data[0];})
        }
      },
      data(){
      return {
        customer:{
          name: '',
          email: '',
          phone: '',
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
            this.customer.newPhoto=null;
          }
        else{
          let reader = new FileReader();
        reader.onload = event =>{
          this.customer.newPhoto = event.target.result;
          let f=this.customer.newPhoto.indexOf("/");
          let l=this.customer.newPhoto.indexOf(";") - f;
          let ext = this.customer.newPhoto.substr(f+1, l-1);
          if(ext != "png" && ext != "jpeg" && ext != "jpg"){
                  Toast.fire({icon: 'info',title: 'Allowed Types(png,jpg,jpeg)'})
                  this.customer.newPhoto=null;
                      }
                  };
                  reader.readAsDataURL(file);
        }
      },
      editCustomer(){
        let id =this.$route.params.id;
        axios.put('/api/customers/'+id,this.customer)
      .then(() =>{
        Toast.fire({ icon: "success", title: "customer updated successfully"});
        this.$router.push("/customers");
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