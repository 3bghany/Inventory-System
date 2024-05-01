<template>
    <div>
  
  <div class="row" style="position: relative;left: 25px;">
   <router-link to="/addCustomer" class="btn btn-primary">Add Customer </router-link>
    
  </div>
  
  <br>
     <input type="text" v-model="searchTerm" class="form-control" style="width: 300px;" placeholder="Search Here">
  <br>
  
    <div class="row justify-content-center">
       <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="row">
              <div class="col-lg-12 mb-4">
                <!-- Simple Tables -->
                <div class="card">
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Customers List</h6>
                  </div>
                  <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                      <thead class="thead-light">
                        <tr>
                          <th>Name</th>
                          <th>Photo</th>
                          <th>Phone</th>
                          <th>Address</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="customer in filtersearch" :key="customer.id">
                          <td> {{ customer.name }} </td>
                          <td><img :src="customer.photo" id="em_photo"></td>
                          <td>{{ customer.phone }}</td>
                          <td>{{ customer.address }}</td>
              <td>
     <router-link :to="{path:'/editcustomer/'+customer.id}" class="btn btn-sm btn-primary">Edit</router-link>
  
   <a @click="deleteCustomer(supplier.id)" class="btn btn-sm btn-danger del" style="color: #ffffff;">Delete</a>
              </td>
                        </tr>
                      
                      </tbody>
                    </table>
                  </div>
                  <div class="card-footer"></div>
                </div>
              </div>
            </div>
            <!--Row-->
       </div>
     </div>
   </div>
  
  </template>
  
  <script>
  export default {
      created(){
        if (!User.loggedIn()) {
          this.$router.push('/')
        }else
        {
          this.allCustomer();
          
        }
        
      },
      data(){
        return{
          customers:[],
          searchTerm:''
        }
      },
      computed:{
        filtersearch(){
        return this.customers.filter(customer => {
          if(customer.name.toLowerCase().match(this.searchTerm.toLowerCase())
            ||customer.phone.toLowerCase().match(this.searchTerm.toLowerCase())
            ||customer.address.toLowerCase().match(this.searchTerm.toLowerCase()))
           return customer;
        }) 
        }
      },
   
    methods:{
      allCustomer(){
        axios.get('/api/customers')
        .then(({data}) => {this.customers = data.data})
        .catch()
      },
      deleteCustomer(id){
               Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
              }).then((result) => {
                if (result.value) {
                  axios.delete('/api/customers/'+id)
                 .then(() => {this.customers = this.customers.filter(employee => {return employee.id != id})})
                 .catch(() => {
                  this.$router.push('/customers')
                 })
                  Swal.fire(
                    'Deleted!',
                    'successfully deleted.',
                    'success'
                  )
                }
              })
            },
    }
  }
  
  
  </script>
  
  <style type="text/css">
    #em_photo{
      height: 40px;
      width: 40px;
    }
    .del{
      cursor: pointer;
      right: -5px;
      position: relative;
    }
  </style>