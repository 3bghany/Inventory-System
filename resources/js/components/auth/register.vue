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
                    <h1 class="h4 text-gray-900 mb-4">{{ $t("auth.Register") }}</h1>
                  </div>
                  <form @submit.prevent="register">
                    <div class="form-group">
                      <input type="text" class="form-control" id="exampleInputFirstName" :placeholder="$t('main.Enter')+' '+$t('main.Full Name')" v-model="form.name">
                      <small class="text-danger" v-if="errors.name"> {{ errors.name[0] }} </small>
                    </div>

                    <div class="form-group">
                      <input type="email" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp"
                      :placeholder="$t('main.Enter')+' '+$t('main.Email')" v-model="form.email">
                      <small class="text-danger" v-if="errors.email"> {{ errors.email[0] }} </small>
                    </div>
                    <div class="form-group password-container">
                      <input :type="showPassword?'':'password'" class="form-control" id="exampleInputPassword" :placeholder="$t('main.Password')" v-model="form.password">
                      <span class="toggle-password" @click="toggleToShowPassword">
                                <i :class="showPassword ? 'fa fa-eye-slash' : 'fa fa-eye'"></i></span>
                      <small class="text-danger" v-if="errors.password"> {{ errors.password[0] }} </small>
                    </div>
                    <div class="form-group password-container">
                      <input :type="showConfirmPassword?'':'password'" class="form-control" id="exampleInputPasswordRepeat"
                        :placeholder="$t('auth.Confirm Password')" v-model="form.password_confirmation">
                      <span class="toggle-password" @click="toggleToShowConfirmPassword">
                              <i :class="showConfirmPassword ? 'fa fa-eye-slash' : 'fa fa-eye'"></i></span>
                    </div>
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary btn-block" style="color: #ffffff;">{{ $t("auth.Register") }}</button>
                    </div>
                  </form>
                  <hr>
                  <div class="text-center">
                    <router-link to="/" class="font-weight-bold small" >{{ $t("auth.Already have an account?") }}</router-link>
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

export default{
  created(){
    if(User.loggedIn()){
      this.$router.push('/home')
      }
  },
  data(){
  return{
    showPassword:false,
    showConfirmPassword:false,
    form:{
      name:null,
      email:null,
      password:null,
      password_confirmation:null,
    },
    errors:{},
  }
},
methods:{
  register(){
    axios.post('/api/auth/signup',this.form)
    .then(response =>{
    this.errors={};
      Toast.fire({ icon: response.data.status, title: response.data.message});
      if(response.data.type == 'verify'){
      this.$router.push('/verifyEmail/'+response.data.data.id)
      }
    })
    .catch(error => {
      if(error.response.data.errors)
      this.errors=error.response.data.errors;
    })
  },
  toggleToShowPassword(){
    this.showPassword=!(this.showPassword);
  },
  toggleToShowConfirmPassword(){
    this.showConfirmPassword=!(this.showConfirmPassword);
  },
}
}

</script>


<style scoped>

.password-container {
            position: relative;
        }
        .password-container input {
            padding-right: 30px; /* Space for the icon */
        }
        .password-container .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }

</style>