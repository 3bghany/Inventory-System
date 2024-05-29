<template>
  <div>
    <div class="row" style="position: relative; left: 25px">
      <router-link to="/products" class="btn btn-primary">{{ $t('main.All Products') }}
      </router-link>
    </div>

    <div class="row justify-content-center">
      <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">
                      {{ $t("main.Add Product") }}
                    </h1>
                  </div>

                  <form class="user" @submit.prevent="insertProduct()" enctype="multipart/form-data">
                    <div class="form-group">
                      <div class="form-row">
                        <div class="col-md-6">
                          <input type="text" class="form-control" id="exampleInputFirstName"
                          :placeholder="$t('main.Enter')+' '+$t('main.Full Name')" v-model="form.name" />
                          <small class="text-danger" v-if="errors.name"> {{ errors.name[0] }} </small>
                        </div>

                        <div class="col-md-6">
                          <input type="text" class="form-control" id="exampleInputFirstName"
                          :placeholder="$t('main.Enter')+' '+$t('main.Product')+' '+$t('main.Code')" v-model="form.code" />
                          <small class="text-danger" v-if="errors.code"> {{ errors.code[0] }} </small>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="form-row">
                        <div class="col-md-6">
                          <label for="exampleFormControlSelect1">{{ $t("main.Product") }} {{ $t("main.Category") }}</label>
                          <select class="form-control" id="exampleFormControlSelect1"  v-model="form.category_id">
                            <option :value="null" selected>{{ $t("main.Choose from here") }}</option>
                            <option v-for="category in categories" :value="category.id" >{{ category.name }}</option>
                          </select>
                          <small class="text-danger" v-if="errors.category_id"> {{ errors.category_id[0] }} </small>
                        </div>

                        <div class="col-md-6">
                          <label for="exampleFormControlSelect1">{{ $t("main.Product") }} {{ $t("main.Supplier") }}</label>
                          <select class="form-control" id="exampleFormControlSelect1" v-model="form.supplier_id">
                            <option :value="null" selected>{{ $t("main.Choose from here") }}</option>
                            <option v-for="supplier in suppliers" :value="supplier.id">{{ supplier.name }}</option>
                          </select>
                          <small class="text-danger" v-if="errors.supplier_id"> {{ errors.supplier_id[0] }} </small>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="form-row">
                        <div class="col-md-4">
                          <input type="text" class="form-control" id="exampleInputFirstName"
                          :placeholder="$t('main.Enter')+' '+$t('main.Product')+' '+$t('main.Root')" v-model="form.root" />
                          <small class="text-danger" v-if="errors.root"> {{ errors.root[0] }} </small>
                        </div>

                        <div class="col-md-4">
                          <input type="text" class="form-control" id="exampleInputFirstName"
                          :placeholder="$t('main.Product')+' '+$t('main.Buying Price')" v-model="form.buying_price
                    " />
                          <small class="text-danger" v-if="errors.buying_price"> {{ errors.buying_price[0] }} </small>
                        </div>

                        <div class="col-md-4">
                          <input type="text" class="form-control" id="exampleInputFirstName"
                          :placeholder="$t('main.Product')+' '+$t('main.Selling Price')" v-model="form.selling_price
                    " />
                          <small class="text-danger" v-if="errors.selling_price"> {{ errors.selling_price[0] }} </small>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="form-row">
                        <div class="col-md-6">
                          <label for="exampleFormControlSelect1">{{ $t("main.Buying Date") }}</label>
                          <input type="date" class="form-control" id="exampleInputFirstName"
                           v-model="form.buying_date" />
                          <small class="text-danger" v-if="errors.buying_date"> {{ errors.buying_date[0] }} </small>
                        </div>

                        <div class="col-md-6">
                          <label for="exampleFormControlSelect1">{{ $t("main.Product Quantity")}}</label>
                          <input type="text" class="form-control" id="exampleInputFirstName"
                            :placeholder="$t('main.Product Quantity')" v-model="form.quantity" />
                          <small class="text-danger" v-if="errors.quantity"> {{ errors.quantity[0] }} </small>
                        </div>
                      </div>
                    </div>
                    <div class="form-group" style="margin-top: 5rem">
                      <div class="form-row">
                        <div class="col-md-6">
                          <input type="file" class="custom-file-input" id="customFile" @change="OnFileSelect" />

                          <label class="custom-file-label" for="customFile">{{ $t("main.Choose file") }}</label>
                        </div>

                        <div class="col-md-6">
                          <img :src="form.photo
                    ? form.photo
                    : '/backend/img/product.png'
                    " style="
                                                            height: 100px;
                                                            width: 100px;
                                                        " class="image_employee" />
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <button type="submit" class="btn btn-primary btn-block" style="color:#ffffff">
                        {{ $t("main.Submit") }}
                      </button>
                    </div>
                  </form>
                  <hr />
                  <div class="text-center"></div>
                  <div class="text-center"></div>
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
      this.$router.push("/");
    } else {
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
      form: {
        name: null,
        code: null,
        root: null,
        buying_price: null,
        selling_price: null,
        supplier_id: null,
        category_id: null,
        buying_date: null,
        quantity: null,
        photo: null,
      },
      categories: {},
      suppliers: {},
      errors: {},
    };
  },
  methods: {
    OnFileSelect(event) {
      let file = event.target.files[0];
      if (file.size > 1048770) {
        this.$notify({
          type: "error",
          text: "Image Size more than 1MB ",
          duration: 3000,
        });
        this.form.photo = null;
      } else {
        let reader = new FileReader();
        reader.onload = (event) => {
          this.form.photo = event.target.result;
          let f = this.form.photo.indexOf("/");
          let l = this.form.photo.indexOf(";") - f;
          let ext = this.form.photo.substr(f + 1, l - 1);
          if (ext != "png" && ext != "jpeg" && ext != "jpg") {
            Toast.fire({
              icon: "info",
              title: "Allowed Types(png,jpg,jpeg)",
            });
            this.form.photo = null;
          }
        };
        reader.readAsDataURL(file);
      }
    },
    insertProduct() {
      axios
        .post("/api/products", this.form)
        .then(() => {
          Toast.fire({
            icon: "success",
            title: "Product added successfully",
          });
          this.$router.push("/products");
        })
        .catch((error) => this.errors=error.response.data.errors);
    },
  },
};
</script>

<style>
.image_employee {
  position: absolute;
  top: -63px;
}
</style>
