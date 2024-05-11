<template>
    <div>
  
  <div class="row" style="position: relative;left: 25px;">
   <router-link to="/addCategory" class="btn btn-primary">{{ $t("main.Add Category") }} </router-link>
    
  </div>
  
  <br>
  <form class="navbar-search"><div class="input-group" style="width: 400px;"><input type="text" v-model="searchTerm" class="form-control bg-light border-1 small" placeholder="Search Here"style="border-color: rgb(63, 81, 181);"><div class="input-group-append"><button class="btn btn-primary" @click="search()" style="color: #ffffff;" type="button"><i class="fas fa-search fa-sm"></i></button></div></div></form>
  <br>
  
    <div class="row justify-content-center">
       <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="row">
              <div class="col-lg-12 mb-4">
                <!-- Simple Tables -->
                <div class="card">
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $t("main.Categories List") }}</h6>
                  </div>
                  <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                      <thead class="thead-light">
                        <tr>
                          <th>{{ $t("main.Name") }}</th>
                          <th>{{ $t("main.Action") }}</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="category in categories" :key="category.id">
                          <td> {{ category.name }} </td>
              <td>
     <router-link :to="{path:'/editCategory/'+category.id}" class="btn btn-sm btn-primary">{{ $t("main.Edit") }}</router-link>
  
   <a @click="deleteCategory(category.id)" class="btn btn-sm btn-danger del" style="color: #ffffff;">{{ $t("main.Delete") }}</a>
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
          this.allCategories();
          
        }
        
      },
      data(){
        return{
          categories:[],
          searchTerm:''
        }
      },
      computed:{
        filtersearch(){
        return this.categories.filter(category => {
           return category.name.match(this.searchTerm)
        }) 
        }
      },
   
    methods:{
      allCategories(){
        axios.get('/api/categories')
        .then(({data}) => {this.categories = data.data})
        .catch()
      },
      deleteCategory(id){
               Swal.fire({
                title: 'Notice!!!',
                text: "THAT ALL PRODUCTS RELATED TO THAT CATEGORY WILL BE DELETED!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
              }).then((result) => {
                if (result.value) {
                  axios.delete('/api/categories/'+id)
                 .then(() => {this.categories = this.categories.filter(employee => {return employee.id != id})})
                 .catch(() => {
                  this.$router.push('/categories')
                 })
                  Swal.fire(
                    'Deleted!',
                    'successfully deleted.',
                    'success'
                  )
                }
              })
            },
      search(){
        if(this.searchTerm !='')
        axios.get('/api/search/categories/'+this.searchTerm)
        .then(({data}) => {this.categories = data.data})
        .catch();
        else
        this.allCategories()
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