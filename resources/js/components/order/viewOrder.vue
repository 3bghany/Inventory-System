<template>
  
    <div>
  
   <div class="row">
    <router-link style="left: 30px;position: relative;" :to="this.$router.options.history.state.back" class="btn btn-primary">{{ $t("main.Go Back") }} </router-link>
     
   </div>
  
  
  
      <div class="row justify-content-center">
        <div class="col-xl-12 col-lg-12 col-md-12">
          <div class="card shadow-sm my-5">
            <div class="card-body p-0">
              <div class="row">
                <div class="col-lg-12">
                  <div class="login-form">
                    <div class="text-center">
                      <h1 class="h4 text-gray-900 mb-4"> {{ $t("main.Order Details") }} </h1>
                    </div>
  
         
  
  <div class="row">
              <div class="col-lg-6 mb-4">
                <!-- Simple Tables -->
                <div class="card">
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $t("main.Customer") }} {{ $t("main.Details") }} </h6>
                  </div>
                  <div class="table-responsive">
                     
          <ul class="list-group">
            <li class="list-group-item"><b>{{ $t("main.Name") }} :</b> {{ order.customer_name }}</li>
            <li class="list-group-item"><b>{{ $t("main.Phone") }} :</b> {{ order.customer_phone }}</li>
            <li class="list-group-item"><b>{{ $t("main.Address") }} :</b> {{ order.customer_address }}</li>
            <li class="list-group-item"><b>{{ $t("main.Date") }} :</b> {{ order.order_date }}</li>
            <li class="list-group-item"><b>{{ $t("main.Pay Through") }} :</b> {{$t('pos.'+order.payBy)}}</li>
          </ul>
  
                    
                  </div>
                  <div class="card-footer"></div>
                </div>
              </div>
  
  
  
  
  <div class="col-lg-6 mb-4">
                <!-- Simple Tables -->
                <div class="card">
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $t("main.Bill Report") }}</h6>
                  </div>
                  <div class="table-responsive">
  
  
            <ul class="list-group">
            <li class="list-group-item"><b>{{ $t("pos.Sub Total") }} :</b> {{ order.sub_total }} $ </li>
            <li class="list-group-item"><b>{{ $t("pos.Vat") }} :</b> 14%</li>
            <li class="list-group-item"><b>{{ $t("pos.Total") }} :</b> {{ order.total }} $</li>
            <li class="list-group-item"><b>{{ $t("pos.Pay") }} {{ $t("main.Amount") }} :</b> {{ order.pay }} $</li>
            <li class="list-group-item"><b>{{ $t("pos.Due") }} {{ $t("main.Amount") }} :</b> {{ order.due }} $</li>
          </ul>
  
  
  
                  </div>
                  <div class="card-footer"></div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12 mb-4">
                <!-- DataTable with Hover -->
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="z-index: 1;width: 150px;">
                  <h6 class="m-0 font-weight-bold text-primary">{{ $t("main.Products") }}</h6>
                </div>
                <div class="text-center" v-if="recordsLength>1">
    <v-container style="position: absolute;top: -25px;">
      <v-row justify="center">
        <v-col cols="8">
          <v-container class="max-width" style="height: 0px;">
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
                <br>
                <div class="table-responsive p-3">                
                  <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                      <tr>
                        <th>{{ $t("main.Name") }}</th>
                        <th>{{ $t("main.Code") }}</th>
                        <th>{{ $t("main.Photo") }}</th>
                        <th>{{ $t("main.Quantity") }}</th>
                        <th>{{ $t("pos.Unit Price") }}</th>
                        <th>{{ $t("pos.Total") }}</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>{{ $t("main.Name") }}</th>
                        <th>{{ $t("main.Code") }}</th>
                        <th>{{ $t("main.Photo") }}</th>
                        <th>{{ $t("main.Quantity") }}</th>
                        <th>{{ $t("pos.Unit Price") }}</th>
                        <th>{{ $t("pos.Total") }}</th>
                      </tr>
                    </tfoot>
                    <tbody>
                      <tr v-for="order in subOrders" :key="order.id">
                        <td><span  :class="(order.product_name)? '':'badge badge-danger'">{{ (order.product_name)?(order.product_name) : $t('main.Product')+' '+$t('main.Deleted!')}} </span></td>
                        <td><span :class="(order.product_code)? '':'badge badge-danger'">{{ (order.product_code)?(order.product_code) : $t('main.Product')+' '+$t('main.Deleted!') }}</span> </td>
                          <td><img :src="order.product_photo" id="em_photo"></td>
                          <td> {{ order.product_quantity }} </td>
                          <td><span class="recOverflow" style="width: 100px;">{{ order.product_price }} $</span></td>
                          <td> {{ order.sub_total }} $</td>
                      </tr>
                    </tbody>
                  </table>
                  
                </div>
                
              </div>
              
            </div>
                
              </div>
            </div>
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
        }else
        {
            
          this.getOrder();
          this.allOrderDetails();
        }
        
      },
      data(){
        return{
          order:[],
          orderDetails:[],
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
          this.filteredOrders = this.orderDetails
            this.length= Math.ceil(this.filteredOrders.length/this.records)
            this.paginationOrders()
            return this.length
        },
      },
    methods:{
        getOrder(){
            let id =this.$route.params.id;
            axios.get('/api/orders/'+id)
            .then(({data}) => {
            this.order = data.data[0]
        })
        .catch()
      },
      allOrderDetails(){
        let id =this.$route.params.id;
        axios.get('/api/order-details-by-order-id/'+id)
        .then(({data}) => {
          this.orderDetails = data.data
          console.log(this.orderDetails);
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

<style>

</style>
