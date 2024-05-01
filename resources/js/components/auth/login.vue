<template>
    <div >
    <div class="row justify-content-center">
      <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Login</h1>
                  </div>
                  <form class="user" @submit.prevent="login">
                    <div class="form-group">
                      <input type="email" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp"
                        placeholder="Enter Email Address" v-model="form.email">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control" id="exampleInputPassword" placeholder="Password" v-model="form.password">
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small" style="line-height: 1.5rem;">
                        <input type="checkbox" class="custom-control-input" id="customCheck">
                        <label class="custom-control-label" for="customCheck">Remember
                          Me</label>
                      </div>
                    </div>
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary btn-block" style="color: #ffffff;">Login</button>
                    </div>
                    <hr>
                  </form>
                  <hr>
                  <div class="text-center">
                    <router-link to="/register" class="font-weight-bold small">Create an Account!</router-link>
                  </div>
                  <div class="text-center">
                    <router-link to="/forgotPassword" class="font-weight-bold small">Forgotten password?</router-link>
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
// import { eventBus } from "../../app";
export default{
  created(){
    if(User.loggedIn()){
      this.$router.push('/home')
      }
      else{
      }
  },
  data(){
  return{
    form:{
      email:null,
      password:null,
      id:null,
    }
  }
},
methods:{
  login(){
    axios.post('/api/auth/login',this.form)
    .then(res =>{
      User.responseAfterLogin(res)
      this.$emit("refreshUserName");
      this.$router.push('/home')
      Toast.fire({ icon: res.data.status, title: res.data.message});
    })
    .catch(error => {
      Toast.fire({ icon: error.response.data.status, title: error.response.data.message});
      this.form.id=error.response.data.data;
      axios.post('/api/sendVerificationCode',this.form)
        .then(() => {
        })
        .catch();
      this.$router.push('/verifyEmail/'+error.response.data.data)
    })
  }
}
}

</script>