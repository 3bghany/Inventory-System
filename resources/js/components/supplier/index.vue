<template>
    <div>
  
  <div class="row" style="position: relative;left: 25px;">
   <router-link to="/addSupplier" class="btn btn-primary">{{ $t("main.Add Suplier") }} </router-link>
    
  </div>
  
  <br>
     <input type="text" v-model="searchTerm" class="form-control" style="width: 300px;" :placeholder=" $t('main.Search here')">
  <br>
  
    <div class="row justify-content-center">
       <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="row">
              <div class="col-lg-12 mb-4">
                <!-- Simple Tables -->
                <div class="card">
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $t("main.Suppliers List") }}</h6>
                  </div>
                  <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                      <thead class="thead-light">
                        <tr>
                          <th>{{ $t("main.Name") }}</th>
                          <th>{{ $t("main.Photo") }}</th>
                          <th>{{ $t("main.Phone") }}</th>
                          <th>{{ $t("main.Shop Name") }}</th>
                          <th>{{ $t("main.Action") }}</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="supplier in filtersearch" :key="supplier.id">
                          <td > {{ supplier.name }} </td>
                          <td><img :src="supplier.photo" id="em_photo"></td>
                          <td>{{ supplier.phone }}</td>
                          <td>{{ supplier.shopname }}</td>
              <td>
     <router-link :to="{path:'/editSupplier/'+supplier.id}" class="btn btn-sm btn-primary">{{ $t("main.Edit") }}</router-link>
  
   <a @click="deleteSupplier(supplier.id)" class="btn btn-sm btn-danger del" style="color: #ffffff;">{{ $t("main.Delete") }}</a>
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
          this.allSuppliers();
          
        }
        
      },
      data(){
        return{
          suppliers:[],
          searchTerm:''
        }
      },
      computed:{
        filtersearch(){
        return this.suppliers.filter(supplier => {
           return supplier.name.match(this.searchTerm)
        }) 
        }
      },
   
    methods:{
      allSuppliers(){
        axios.get('/api/suppliers')
        .then(({data}) => {this.suppliers = data.data})
        .catch()
      },
      deleteSupplier(id){
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
                  axios.delete('/api/suppliers/'+id)
                 .then(() => {this.suppliers = this.suppliers.filter(employee => {return employee.id != id})})
                 .catch(() => {
                  this.$router.push('/suppliers')
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