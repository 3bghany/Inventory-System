<template>


  <div>

    <div class="row" style="position: relative;left: 25px;">
      <router-link to="/products" class="btn btn-primary">All Products </router-link>

    </div>
    <div class="row justify-content-center">
      <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Update Product</h1>
                  </div>

                  <form class="user" @submit.prevent="editProduct()" enctype="multipart/form-data">

                    <div class="form-group">
                      <div class="form-row">
                        <div class="col-md-6">
                          <input type="text" class="form-control" id="exampleInputFirstName"
                            placeholder="Enter Full Name" v-model="product.name" />
                          <!-- <small class="text-danger" v-if="errors.name"> {{ errors.name[0] }} </small> -->
                        </div>

                        <div class="col-md-6">
                          <input type="text" class="form-control" id="exampleInputFirstName"
                            placeholder="Enter Product code" v-model="product.code" />
                          <!-- <small class="text-danger" v-if="errors.code"> {{ errors.code[0] }} </small> -->
                        </div>
                      </div>
                    </div>


                    <div class="form-group">
                      <div class="form-row">
                        <div class="col-md-6">
                          <label for="exampleFormControlSelect1">Product Category</label>
                          <select class="form-control" id="exampleFormControlSelect1" v-model="product.category_id">
                            <option selected>Choose from here</option>
                            <option v-for="category in categories" :value="category.id">{{ category.name }}</option>
                          </select>
                        </div>

                        <div class="col-md-6">
                          <label for="exampleFormControlSelect1">Product Supplier</label>
                          <select class="form-control" id="exampleFormControlSelect1" v-model="product.supplier_id">
                            <option selected>Choose from here</option>
                            <option v-for="supplier in suppliers" :value="supplier.id">{{ supplier.name }}</option>
                          </select>
                        </div>
                      </div>
                    </div>



                    <div class="form-group">
                      <div class="form-row">
                        <div class="col-md-4">
                          <input type="text" class="form-control" id="exampleInputFirstName"
                            placeholder="Enter Product Root" v-model="product.root" />
                          <!-- <small class="text-danger" v-if="errors.root"> {{ errors.root[0] }} </small> -->
                        </div>

                        <div class="col-md-4">
                          <input type="text" class="form-control" id="exampleInputFirstName"
                            placeholder="Product Buying Price" v-model="product.buying_price
                    " />
                          <!-- <small class="text-danger" v-if="errors.buying_price"> {{ errors.buying_price[0] }} </small> -->
                        </div>

                        <div class="col-md-4">
                          <input type="text" class="form-control" id="exampleInputFirstName"
                            placeholder="Product Selling Price" v-model="product.selling_price
                    " />
                          <!-- <small class="text-danger" v-if="errors.selling_price"> {{ errors.selling_price[0] }} </small> -->
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="form-row">
                        <div class="col-md-6">
                          <label for="exampleFormControlSelect1">Buying Date</label>
                          <input type="date" class="form-control" id="exampleInputFirstName"
                            placeholder="Enter Joining Date" v-model="product.buying_date
                    " />
                          <!-- <small class="text-danger" v-if="errors.buying_date"> {{ errors.buying_date[0] }} </small> -->
                        </div>

                        <div class="col-md-6">
                          <label for="exampleFormControlSelect1">Product Quantity</label>
                          <input type="text" class="form-control" id="exampleInputFirstName"
                            placeholder="Product Quantity" v-model="product.quantity" />
                          <!-- <small class="text-danger" v-if="errors.quantity"> {{ errors.quantity[0] }} </small> -->
                        </div>
                      </div>
                    </div>


                    <div class="form-group" style="margin-top: 5rem">

                      <div class="form-row">
                        <div class="col-md-6">
                          <input type="file" class="custom-file-input" id="customFile" @change="OnFileSelect">

                          <!-- <small class="text-danger" v-if="errors.photo"> {{ errors.photo[0] }} </small> -->
                          <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>

                        <div class="col-md-6">
                          <img :src="product.newPhoto ? product.newPhoto: product.photo" style="height: 100px; width: 100px;" class="image_employee">
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
  created() {
    if (!User.loggedIn()) {
      this.$router.push('/')
    } else {
      let id = this.$route.params.id;
      axios.get('/api/products/' + id)
        .then(({ data }) => { this.product = data.data[0]; })

      axios
        .get("/api/categories")
        .then(({ data }) => {
          this.categories = data.data;
        })
        .catch();
      axios
        .get("/api/suppliers")
        .then(({ data }) => {
          this.suppliers = data.data;
        })
        .catch();
    }
  },
  data() {
    return {
      product: {
        name: '',
        code: '',
        root: '',
        buying_price: '',
        selling_price: '',
        supplier_id: '',
        newPhoto: '',
        photo: '',
        quantity: '',
        category_id: '',
        buying_date: '',
        prevRoute:'gg',
      },
      categories: {},
      suppliers: {},
      errors: {}
    }
  },
  methods: {
    OnFileSelect(event) {
      let file = event.target.files[0];
      if (file.size > 1048770) {
        this.$notify({ type: "error", text: "Image Size more than 1MB ", duration: 3000, })
        this.product.newPhoto = null;
      }
      else {
        let reader = new FileReader();
        reader.onload = event => {
          this.product.newPhoto = event.target.result;
          let f = this.product.newPhoto.indexOf("/");
          let l = this.product.newPhoto.indexOf(";") - f;
          let ext = this.product.newPhoto.substr(f + 1, l - 1);
          if (ext != "png" && ext != "jpeg" && ext != "jpg") {
            Toast.fire({ icon: 'info', title: 'Allowed Types(png,jpg,jpeg)' })
            this.product.newPhoto = null;
          }
        };
        reader.readAsDataURL(file);
      }
    },
    editProduct() {
      let id = this.$route.params.id;
      axios.put('/api/products/' + id, this.product)
        .then(() => {
          Toast.fire({ icon: "success", title: "products updated successfully" });
          this.$router.push(this.$router.options.history.state.back);
        })
        .catch(error => console.log(error.response.data))
    },

  }
}


</script>

<style>
.image_employee {
  position: absolute;
  top: -63px;
}
</style>