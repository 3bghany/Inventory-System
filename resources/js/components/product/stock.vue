<template>
  <div>

<div class="row" style="position: relative;left: 25px;">
 <router-link to="/addProduct" class="btn btn-primary">Add Product </router-link>
  
</div>
<br>
<input type="text" v-model="searchTerm" class="form-control" style="width: 500px;position: relative;left: 15px;" placeholder="Search by Name, Category, Code, Price">

<br>

  <div class="row justify-content-center">
     <div class="col-xl-12 col-lg-12 col-md-12">
      <div class="row">
            <div class="col-lg-12 mb-4">
              <!-- DataTable with Hover -->
          <div class="col-lg-12">
            <div class="card mb-4">
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Stock</h6>
              </div>
              <div class="text-center" v-if="recordsLength>1">
  <v-container style="position: absolute;top: -25px;">
    <v-row justify="center">
      <v-col cols="8">
        <v-container class="max-width">
          <v-pagination
            v-model="page"
            :length="recordsLength"
            class="my-4"
            next-icon = "fa-solid fa-arrow-right"
            prev-icon = "fa-solid fa-arrow-left"
            :onclick="paginationProducts"
          ></v-pagination>
        </v-container>
      </v-col>
    </v-row>
  </v-container>
</div>
              <div class="btn-group mb-1 col-md-1">
                  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" style="color: #ffffff;" aria-haspopup="true" aria-expanded="false">
                    {{records}}
                  </button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item"@click="records=5,page=1">5</a>
                    <a class="dropdown-item"@click="records=10,page=1">10</a>
                    <a class="dropdown-item"@click="records=20,page=1">20</a>
                  </div>
                </div>  
              <div class="table-responsive p-3">                
                <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                  <thead class="thead-light">
                    <tr>
                      <th>Name</th>
                        <th>Code</th>
                        <th>Photo</th>
                        <th>Category</th>
                        <th>Selling Price</th>
                        <th>Status</th>
                        <th>Quantity</th>
                        <th>Action</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Name</th>
                        <th>Code</th>
                        <th>Photo</th>
                        <th>Category</th>
                        <th>Selling Price</th>
                        <th>Status</th>
                        <th>Quantity</th>
                        <th>Action</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <tr v-for="product in subProducts" :key="product.id">
                      <td><span class="recOverflow">{{ product.name }}</span> </td>
                        <td> {{ product.code }} </td>
                        <td><img :src="product.photo" id="em_photo"></td>
                        <td><span class="recOverflow" style="width: 100px;">{{ product.category_name }}</span></td>
                        <td><span class="recOverflow" style="width: 100px;">{{ product.selling_price }} $</span></td>
                        <td> <span class="badge badge-success"
                                                            v-if="product.quantity >= 1">Available</span>
                                                        <span class="badge badge-danger " v-else="">Stock Out</span></td>
                        <td ><span class="recOverflow" style="width: 100px;">{{ product.quantity }}</span></td>
            <td>
   <router-link :to="{path:'/editProduct/'+product.id}" class="btn btn-sm btn-primary">Edit</router-link>
            </td>
                    </tr>
                  </tbody>
                </table>
                
              </div>
              
            </div>
            
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
        this.allProducts();
        
      }
      
    },
    data(){
      return{
        products:[],
        filteredProducts:[],
        subProducts:[],
        searchTerm:'',
        page:1,
        length:null,
        records:5,
      }
    },
    computed:{
      recordsLength(){
        this.filteredProducts = this.products.filter(product => {
            if(product.name.toLowerCase().match(this.searchTerm.toLowerCase())
            ||product.code.toLowerCase().match(this.searchTerm.toLowerCase())
            ||product.category_name.toLowerCase().match(this.searchTerm.toLowerCase())
            ||product.selling_price.toLowerCase().match(this.searchTerm.toLowerCase()))
              return product;
        });
          this.length= Math.ceil(this.filteredProducts.length/this.records)
          this.paginationProducts()
          return this.length
      },
    },
  methods:{
    allProducts(){
      axios.get('/api/products')
      .then(({data}) => {
        this.products = data.data
      })
      .catch()
    },
    paginationProducts(){
          let begin= (this.page - 1)* this.records
          let end  = (this.page * this.records) 
          this.subProducts=(this.filteredProducts).slice(begin, end)
      },
    deleteProduct(id){
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
                axios.delete('/api/products/'+id)
               .then(() => {
                this.products = this.products.filter(product => {return product.id != id})
                this.page=1;
              })
               .catch(() => {
                this.$router.push('/products')
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

<style type="text/css" scoped>
  #em_photo{
    height: 40px;
    width: 40px;
  }
  .del{
    cursor: pointer;
    right: -5px;
    position: relative;
  }
  .recOverflow {
  display: block;
width: 200px;
overflow: hidden;
white-space: nowrap;
text-overflow: ellipsis;
}
</style>