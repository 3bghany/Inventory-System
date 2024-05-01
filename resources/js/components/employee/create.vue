<template>


  <div>

    <div class="row" style="position: relative;left: 25px;">
      <router-link to="/employees" class="btn btn-primary">All Employee </router-link>

    </div>



    <div class="row justify-content-center">
      <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Add Employee</h1>
                  </div>

                  <form class="user" @submit.prevent="insertEmployee()" enctype="multipart/form-data">

                    <div class="form-group">

                      <div class="form-row">
                        <div class="col-md-6">
                          <input type="text" class="form-control" id="exampleInputFirstName"
                            placeholder="Enter Full Name" v-model="form.name">
                          <!-- <small class="text-danger" v-if="errors.name"> {{ errors.name[0] }} </small> -->
                        </div>


                        <div class="col-md-6">
                          <input type="email" class="form-control" id="exampleInputFirstName" placeholder="Enter Email"
                            v-model="form.email">
                          <!-- <small class="text-danger" v-if="errors.email"> {{ errors.email[0] }} </small> -->
                        </div>

                      </div>
                    </div>


                    <div class="form-group">

                      <div class="form-row">
                        <div class="col-md-6">
                          <input type="text" class="form-control" id="exampleInputFirstName" placeholder="Enter Address"
                            v-model="form.address">
                          <!-- <small class="text-danger" v-if="errors.address"> {{ errors.address[0] }} </small> -->
                        </div>


                        <div class="col-md-6">
                          <input type="text" class="form-control" id="exampleInputFirstName" placeholder="Enter salary"
                            v-model="form.salary">
                          <!-- <small class="text-danger" v-if="errors.salary"> {{ errors.salary[0] }} </small> -->
                        </div>

                      </div>
                    </div>





                    <div class="form-group">

                      <div class="form-row">
                        <div class="col-md-6">
                          <input type="date" class="form-control" id="exampleInputFirstName"
                            placeholder="Enter Joining Date" v-model="form.joining_date">
                          <!-- <small class="text-danger" v-if="errors.joining_date"> {{ errors.joining_date[0] }} </small> -->
                        </div>


                        <div class="col-md-6">
                          <input type="text" class="form-control" id="exampleInputFirstName" placeholder="Enter Nid"
                            v-model="form.nid">
                          <!-- <small class="text-danger" v-if="errors.nid"> {{ errors.nid[0] }} </small> -->
                        </div>

                      </div>
                    </div>



                    <div class="form-group">

                      <div class="form-row">
                        <div class="col-md-6">
                          <input type="text" class="form-control" id="exampleInputFirstName"
                            placeholder="Enter phone Number" v-model="form.phone">
                          <!-- <small class="text-danger" v-if="errors.phone"> {{ errors.phone[0] }} </small> -->
                        </div>


                        <div class="col-md-6">

                        </div>

                      </div>
                    </div>


                    <div class="form-group">

                      <div class="form-row">
                        <div class="col-md-6">
                          <input type="file" class="custom-file-input" id="customFile" @change="OnFileSelect">

                          <!-- <small class="text-danger" v-if="errors.photo"> {{ errors.photo[0] }} </small> -->
                          <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>

                        <div class="col-md-6">
                          <img :src="form.photo ? form.photo : '/backend/img/boy.png'"
                            style="height: 100px; width: 100px;" class="image_employee">

                        </div>

                      </div>
                    </div>




                    <div class="form-group">
                      <button type="submit" class="btn btn-primary btn-block" style="color:#ffffff">Submit</button>
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
    }
  },
  data() {
    return {
      form: {
        name: null,
        email: null,
        phone: null,
        salary: null,
        address: null,
        photo: null,
        nid: null,
        joining_date: null
      },
      errors: {}
    }
  },
  methods: {
    OnFileSelect(event) {
      let file = event.target.files[0];
      if (file.size > 1048770) {
        this.$notify({ type: "error", text: "Image Size more than 1MB ", duration: 3000, })
        this.form.photo = null
      }
      else {
        let reader = new FileReader();
        reader.onload = event => {
          this.form.photo = event.target.result;
          let f = this.form.photo.indexOf("/");
          let l = this.form.photo.indexOf(";") - f;
          let ext = this.form.photo.substr(f + 1, l - 1);
          if (ext != "png" && ext != "jpeg" && ext != "jpg") {
            Toast.fire({ icon: 'info', title: 'Allowed Types(png,jpg,jpeg)' })
            this.form.photo = null;
          }
        };
        reader.readAsDataURL(file);
      }
    },
    insertEmployee() {
      axios.post('/api/employees', this.form)
        .then(() => {
          Toast.fire({ icon: "success", title: "employee added successfully" });
          this.$router.push("/employees");
        })
        .catch(error => {
          this.errors = error.response.data.errors
          if (this.errors.email) {
            this.$notify({ type: "error", text: this.errors.email, duration: 2000, })
          }
          if (this.errors.joining_date) {
            this.$notify({ type: "error", text: this.errors.joining_date, duration: 2000, })
          }
          if (this.errors.address) {
            this.$notify({ type: "error", text: this.errors.address, duration: 2000, })
          } if (this.errors.name) {
            this.$notify({ type: "error", text: this.errors.name, duration: 2000, })
          } if (this.errors.phone) {
            this.$notify({ type: "error", text: this.errors.phone, duration: 2000, })
          } if (this.errors.salary) {
            this.$notify({ type: "error", text: this.errors.salary, duration: 2000, })
          }if (this.errors.nid) {
            this.$notify({ type: "error", text: this.errors.nid, duration: 2000, })
          }

        })
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