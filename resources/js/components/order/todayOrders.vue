<template>
    <div>
  <br>
  <input type="text" v-model="searchTerm" class="form-control" style="width: 500px;" placeholder="Search by Customer Name, Pay By, Total Price">
  
  <br>
  
    <div class="row justify-content-center">
       <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="row">
              <div class="col-lg-12 mb-4">
                <!-- DataTable with Hover -->
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Today's Orders</h6>
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
              :onclick="paginationOrders"
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
                        <th>Customer Name</th>
                          <th>Total</th>
                          <th>Pay</th>
                          <th>Due</th>
                          <th>Pay by</th>
                          <th>Action</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>Customer Name</th>
                          <th>Total</th>
                          <th>Pay</th>
                          <th>Due</th>
                          <th>Pay by</th>
                          <th>Action</th>
                      </tr>
                    </tfoot>
                    <tbody>
                      <tr v-for="order in subOrders" :key="order.id">
                        <td>{{ order.customer_name }} </td>
                          <td> {{ order.total }} </td>
                          <td> {{ order.pay }} </td>
                          <td><span class="recOverflow" style="width: 100px;">{{ order.due }}</span></td>
                          <td> {{ order.payBy }} </td>
              <td>
     <router-link :to="{path:'/viewOrder/'+order.id}" class="btn btn-sm btn-primary">View</router-link>
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
          this.allOrders();
          console.log(this.orders)
        }
        
      },
      data(){
        return{
          orders:[],
          filteredOrders:[],
          subOrders:[],
          searchTerm:'',
          page:1,
          length:null,
          records:5,
        }
      },
      computed:{
        recordsLength(){
          this.filteredOrders = this.orders.filter(order => {
              if(order.customer_name.toLowerCase().match(this.searchTerm.toLowerCase())
              ||order.total.toLowerCase().match(this.searchTerm.toLowerCase())
              ||order.payBy.toLowerCase().match(this.searchTerm.toLowerCase()))
                return order;
          });
            this.length= Math.ceil(this.filteredOrders.length/this.records)
            this.paginationOrders()
            return this.length
        },
      },
    methods:{
      allOrders(){
        axios.get('/api/todayorders')
        .then(({data}) => {
          this.orders = data.data
        })
        .catch()
      },
      paginationOrders(){
            let begin= (this.page - 1)* this.records
            let end  = (this.page * this.records) 
            this.subOrders=(this.filteredOrders).slice(begin, end)
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