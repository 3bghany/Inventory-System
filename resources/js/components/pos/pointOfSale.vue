<template>
    <div>
        <div class="container-fluid" id="container-wrapper">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">{{ $t("pos.POS") }} {{ $t("main.Dashboard") }}</h1>
            </div>
            <Teleport to="body">
                <div class="modl" v-if="openModal">
                    <div class="modal-dialog" style="top: 130px;max-width: 600px;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">{{ $t("pos.Add Customer") }}</h5>
                                <button type="button" class="btn-close" style="font-size: 20px;"
                                    @click="openModal = false,this.customerFormErrors={}"><strong>×</strong></button>
                            </div>
                            <div class="modal-body">
                                <form class="user">

                                    <div class="form-group">

                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" id="exampleInputFirstName"
                                                    :placeholder="$t('main.Enter')+' '+$t('main.Full Name')" v-model="form.name">
                                                <small class="text-danger" v-if="customerFormErrors.name"> {{ customerFormErrors.name[0] }} </small>
                                            </div>


                                            <div class="col-md-6">
                                                <input type="email" class="form-control" id="exampleInputFirstName"
                                                    :placeholder="$t('main.Enter')+' '+$t('main.Email')" v-model="form.email">
                                                <small class="text-danger" v-if="customerFormErrors.email"> {{ customerFormErrors.email[0] }} </small>
                                            </div>

                                        </div>
                                    </div>


                                    <div class="form-group">

                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" id="exampleInputFirstName"
                                                    :placeholder="$t('main.Enter')+' '+$t('main.Address')" v-model="form.address">
                                                <small class="text-danger" v-if="customerFormErrors.address"> {{ customerFormErrors.address[0] }} </small>
                                            </div>


                                            <div class="col-md-6">
                                                <input type="text" class="form-control" id="exampleInputFirstName"
                                                    :placeholder="$t('main.Enter')+' '+$t('main.Phone')+' '+$t('main.Number')" v-model="form.phone">
                                                <small class="text-danger" v-if="customerFormErrors.phone"> {{ customerFormErrors.phone[0] }} </small>
                                            </div>

                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" @click="openModal = false,this.customerFormErrors={}"
                                    style="color: #ffffff;">{{$t('main.Close')}}</button>
                                <button type="button" class="btn btn-primary" @click="insertCustomer()"
                                    style="color: #ffffff;">{{$t('pos.Add')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </Teleport>
            <div class="row mb-3">

                <!-- Area Chart -->
                <div class="col-xl-5 col-lg-5">
                    <div class="card mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">{{$t('pos.Cart')}}</h6>
                            <button type="button" class="btn btn-info" @click="openModal = true"
                                style="color: #ffffff;">{{$t('pos.Add Customer')}}</button>
                        </div>
                        <div class="table-responsive" style="font-size: 12px;">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light" style="display: table;
  width: 100%;
  table-layout: fixed;">
                                    <tr>
                                        <th>{{$t('pos.Name')}}</th>
                                        <th>{{$t('pos.Qty')}}</th>
                                        <th>{{$t('pos.Unit')}}</th>
                                        <th>{{$t('pos.Total')}}</th>
                                        <th>{{$t('pos.Action')}}</th>
                                    </tr>
                                </thead>
                                <tbody style="max-height: 200px;overflow-y: scroll;display: block;">
                                    <tr v-for="cart in carts" :key="cart.id" style="display: table;
  width: 100%;
  table-layout: fixed;">
                                        <td class="recordOverflow"><a href="#">{{ cart.product_name }}</a></td>
                                        <td style="width: 100px;"><input type="text" readonly style="width: 30px;"
                                                :value="cart.product_quantity">
                                            <button class="btn btn-sm btn-success" @click="increment(cart.id)"
                                                style="margin-left: 3px;">+</button>
                                            <button class="btn btn-sm btn-danger" @click="decrement(cart.id)"
                                                style="margin-left: 3px;">-</button>
                                        </td>
                                        <td
                                            style="text-overflow: ellipsis;width: 100px; overflow: hidden; white-space: nowrap;">
                                            {{ cart.product_price }} $</td>
                                        <td class="recordOverflow">{{ cart.sub_total }} $</td>
                                        <td><a @click="removeItem(cart.id)"
                                                style="position: relative;left: 15px; color: #ffffff; cursor: pointer;"
                                                class="btn btn-sm btn-primary">X</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{$t('pos.Total Quantity')}}:
                                    <strong>{{ total[0] }} </strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{$t('pos.Sub Total')}}:
                                    <strong>{{ total[1] }} $</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{$t('pos.Vat')}}:
                                    <strong>14%</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{$t('pos.Total')}}:
                                    <strong>{{ total[2] }} $</strong>
                                </li>

                            </ul>
                            <br>
                            <form @submit.prevent="orderDone">
                                <label>{{$t('pos.Customer Name')}}</label>
                                <select class="form-control" required v-model="customer_id">
                                    <option :value="Customer.id" v-for="Customer in customers">{{ Customer.name }}
                                    </option>
                                </select>
                                <div>
                                <label>{{$t('pos.Pay')}}</label>
                                <input type="text" class="form-control" required v-model="pay">
                                    <small class="text-danger" v-if="errors.pay"> {{ errors.pay[0] }} </small>
                                </div>
                                <div>
                                <label>{{$t('pos.Due')}}</label>
                                <input type="text" class="form-control" v-model="due">
                                    <small class="text-danger" v-if="errors.due"> {{ errors.due[0] }} </small>
                                </div>
                                <label>{{$t('pos.Pay By')}}</label>
                                <select class="form-control" v-model="payBy">
                                    <option value="HandCash">{{$t('pos.HandCash')}}</option>
                                    <option value="Cheaqe">{{$t('pos.Cheaqe')}}e</option>
                                    <option value="GiftCard">{{$t('pos.GiftCard')}}</option>
                                </select>
                                <br>
                                <button type="submit" class="btn btn-success" style="color:#ffffff">{{$t('main.Submit')}}</button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Pie Chart -->
                <div class="col-xl-7 col-lg-7">
                    <div class="card mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">{{$t('pos.Products in the Stock')}}</h6>
                        </div>
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home"
                                    role="tab" aria-controls="pills-home" aria-selected="true">{{$t('pos.All Products')}}</a>
                            </li>
                            <li class="nav-item" v-for="category in categories.slice(0, 4)">
                                <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile"
                                    role="tab" aria-controls="pills-profile" aria-selected="false"
                                    @click="SubProducts(category.id), searchSubProducts = '',catPage = 1">{{ category.name }}</a>
                            </li>
                            <li class="nav-item dropdown" v-if="categories.length>5">
    <a style="color:black;" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{$t('pos.Dropdown')}}</a>
    <div class="dropdown-menu">
      <a id="pills-profile-tab" data-toggle="pill" href="#pills-profile"
        role="tab" aria-controls="pills-profile" class="dropdown-item"
         v-for="category in categories.slice(4, categories.length)"
       @click="SubProducts(category.id), searchSubProducts = '',catPage = 1">{{category.name}}</a>
    </div>
  </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                aria-labelledby="pills-home-tab">
                                <div class="card-body">
                                    <input type="text" v-model="searchAllProducts" class="form-control"
                                        style="width: 300px;" :placeholder="$t('main.Search here')">
                                    <br>
                                    <div class="text-center" v-if="recordsLength>1">
                                        <v-container>
                                            <v-row justify="center">
                                                <v-col cols="8">
                                                    <v-container class="max-width" style="padding: 0px;">
                                                        <v-pagination v-model="page" :length="recordsLength"
                                                            class="my-4" next-icon="fa-solid fa-arrow-right"
                                                            prev-icon="fa-solid fa-arrow-left"
                                                            :onclick="paginationProducts"></v-pagination>
                                                    </v-container>
                                                </v-col>
                                            </v-row>
                                        </v-container>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-6" v-for="product in pageProducts"
                                            :key="product.id">
                                            <button class="btn btn-sm" @click.prevent="AddToCart(product.id)">
                                                <div class="card" style="width: 8.5rem; margin-bottom: 5px;">
                                                    <img :src="product.photo" id="em_photo">
                                                    <div class="card-body">
                                                        <h6 class="card-title recordOverflow">{{ product.name }}</h6>
                                                        <span class="badge badge-success recordOverflow"
                                                            v-if="product.quantity >= 1">{{$t('main.Available')}} {{product.quantity }}</span>
                                                        <span class="badge badge-danger" v-else="">{{$t('main.Stock Out')}}</span>
                                                    </div>
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                                aria-labelledby="pills-profile-tab">
                                <div class="card-body">
                                    <input type="text" v-model="searchSubProducts" class="form-control"
                                        style="width: 300px;" :placeholder="$t('main.Search here')">
                                    <br>
                                    <div class="text-center" v-if="catRecordsLength>1">
                                        <v-container>
                                            <v-row justify="center">
                                                <v-col cols="8">
                                                    <v-container class="max-width" style="padding: 0px;">
                                                        <v-pagination v-model="catPage" :length="catRecordsLength"
                                                            class="my-4" next-icon="fa-solid fa-arrow-right"
                                                            prev-icon="fa-solid fa-arrow-left"
                                                            :onclick="paginationSubProducts"></v-pagination>
                                                    </v-container>
                                                </v-col>
                                            </v-row>
                                        </v-container>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-6"
                                            v-for="product in pageSubProducts" :key="product.id">
                                            <button class="btn btn-sm" @click.prevent="AddToCart(product.id)">
                                                <div class="card" style="width: 8.5rem; margin-bottom: 5px;">
                                                    <img :src="product.photo" id="em_photo">
                                                    <div class="card-body">
                                                        <h6 class="card-title recordOverflow">{{ product.name }}</h6>
                                                        <span class="badge badge-success recordOverflow"
                                                            v-if="product.quantity >= 1">{{$t('main.Available')}} {{product.quantity }}</span>
                                                        <span class="badge badge-danger " v-else="">{{$t('main.Stock Out')}}</span>
                                                    </div>
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--Row-->



        </div>

    </div>

</template>

<script>
export default {
    created() {
        if (!User.loggedIn()) {
            this.$router.push('/')
        } else {
            this.allProducts();
            this.allCategories();
            this.allCustomers();
            this.Cart();
        }

    },
    data() {
        return {
            products: [],
            filteredProducts:[],
            pageProducts:[],
            categories: [],
            subProducts: [],
            filteredSubProducts: [],
            pageSubProducts: [],
            customers: [],
            searchAllProducts: '',
            searchSubProducts: '',
            carts: [],
            pay: 0,
            due: 0,
            payBy: 'HandCash',
            openModal: false,
            page: 1,
            catPage: 1,
            length: null,
            catLength: null,
            records: 12,
            form: {
                name: null,
                email: null,
                phone: null,
                address: null,
            },
            customerFormErrors:{},
            errors: {},
        }
    },
    computed: {
        total() {
            let qty = 0;
            let total = 0;
            let net = 0;
            this.carts.forEach(cart => {
                qty += parseFloat(cart.product_quantity);
                total += parseFloat(cart.sub_total);
            })
            net = (total + (total * 0.14)).toFixed(2);
            this.due = net - this.pay;
            return [qty, total, net];
        },
        recordsLength(){
          this.filteredProducts = this.products.filter(product => {
              if(product.name.toLowerCase().match(this.searchAllProducts.toLowerCase())
                ||product.code.toLowerCase().match(this.searchAllProducts.toLowerCase())
                ||product.category_name.toLowerCase().match(this.searchAllProducts.toLowerCase())
                ||product.buying_price.toLowerCase().match(this.searchAllProducts.toLowerCase())
                ||product.selling_price.toLowerCase().match(this.searchAllProducts.toLowerCase())
                ||product.root.toLowerCase().match(this.searchAllProducts.toLowerCase()))
                return product;
          });
            this.length= Math.ceil(this.filteredProducts.length/this.records)
            this.paginationProducts()
            return this.length
        },
        catRecordsLength(){
          this.filteredSubProducts = this.subProducts.filter(product => {
              if(product.name.toLowerCase().match(this.searchSubProducts.toLowerCase())
                ||product.code.toLowerCase().match(this.searchSubProducts.toLowerCase())
                ||product.category_name.toLowerCase().match(this.searchSubProducts.toLowerCase())
                ||product.buying_price.toLowerCase().match(this.searchSubProducts.toLowerCase())
                ||product.selling_price.toLowerCase().match(this.searchSubProducts.toLowerCase())
                ||product.root.toLowerCase().match(this.searchSubProducts.toLowerCase()))
                return product;
          });
            this.catLength= Math.ceil(this.filteredSubProducts.length/this.records)
            this.paginationSubProducts()
            return this.catLength
        },
    },

    methods: {
        allProducts() {
            axios.get('/api/get-products/'+true)
                .then(({ data }) => { this.products = data.data })
                .catch()
        },

        allCategories() {
            axios.get('/api/categories')
                .then(({ data }) => { this.categories = data.data })
                .catch()
        },
        allCustomers() {
            axios.get('/api/customers')
                .then(({ data }) => { this.customers = data.data })
                .catch()
        },
        Cart() {
            axios.get('/api/cart/get')
                .then(({ data }) => { this.carts = data.data })
                .catch()
        },
        SubProducts(id) {
            //Not very efficient due to frequent requests
            // axios.get('/api/products/getByCategory/'+id)
            //     .then(({ data }) => { this.subProducts = data.data })
            //     .catch()

            this.subProducts = this.products.filter((product) => product.category_id == id);
            console.log(this.subProducts)

        },
        AddToCart(id) {
            axios.post('/api/cart/add/' + id)
                .then(({ data }) => {
                    this.$notify({ type: data.status, text: data.message, duration: 1000, })
                    this.Cart();
                })
                .catch()
        },
        removeItem(id) {
            axios.delete('/api/cart/delete/' + id)
                .then(({ }) => {
                    this.$notify({ type: 'success', text: 'item deleted successfully', duration: 1000, })
                    this.Cart();
                })
                .catch()
        },
        increment(id) {
            axios.put('/api/cart/increment/' + id)
                .then(({ data }) => {
                    if (data)
                        this.$notify({ type: data.status, text: data.message, duration: 1000, })
                    this.Cart();
                })
                .catch()
        },
        decrement(id) {
            axios.put('/api/cart/decrement/' + id)
                .then(({ }) => {
                    this.Cart();
                })
                .catch()
        },
        orderDone() {
            var form = {
                quantity: this.total[0], sub_total: this.total[1], total: this.total[2], customer_id: this.customer_id,
                payBy: this.payBy, pay: this.pay, due: this.due,
            }
            if (this.carts.length > 0)
                axios.post('/api/orders/', form)
                    .then(({ data }) => {
                        Toast.fire({ icon: data.status, title: data.message });
                        if(data.status == 'success')
                            this.$router.push('/home');
                    })
                    .catch(error => {this.errors=error.response.data.errors})
            else
                Toast.fire({ icon: 'error', title: 'No product has been chosen to order' });
        },
        insertCustomer() {
            axios.post('/api/customers', this.form)
                .then(() => {
                    Toast.fire({ icon: "success", title: "Customer added successfully" });
                    this.allCustomers();
                    this.openModal = false;
                    this.form.name = null;
                    this.form.email = null;
                    this.form.address = null;
                    this.form.phone = null;
                })
                .catch(error => this.customerFormErrors=error.response.data.errors)
        },
        paginationProducts(){
            let begin= (this.page - 1)* this.records
            let end  = (this.page * this.records) 
            this.pageProducts=(this.filteredProducts).slice(begin, end)
        },
        paginationSubProducts(){
            let begin= (this.catPage - 1)* this.records
            let end  = (this.catPage * this.records) 
            this.pageSubProducts=(this.filteredSubProducts).slice(begin, end)
        },

    }
}
</script>

<style type="text/css" scoped>
#em_photo {
    height: 100px;
    width: 135px;
}

.del {
    cursor: pointer;
    right: -5px;
    position: relative;
}

.modl {
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1060;
    width: 100%;
    height: 100%;
    overflow-x: hidden;
    overflow-y: auto;
    outline: 0;
    /* transition: transform .3s ease-out; */
    background-color: rgba(0, 0, 0, 0.5);
}
</style>