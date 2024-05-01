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
                    <h1 class="h4 text-gray-900 mb-4">Verify Your Email</h1>
                    <h6>We have sent an email to <b style="color: black;">{{ this.user.email }}</b></h6>
                  </div>
                  <form class="user" @submit.prevent="verify()">
                    <div class="form-group">
                      <input type="text" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp"
                        placeholder="Enter code" v-model="form.OTP">
                    </div>
    
                    <div class="form-group">
                      <button style="color: white;" type="submit" class="btn btn-primary btn-block">Verify</button>
                    </div>
                  </form>
                  <hr>
                  <div class="text-center">
                    <button :disabled="this.timer>0" @click="this.sendMail()" class="btn btn-success" > Send another code <span v-if="this.timer>0">({{ expiretimer }})</span></button>
                  </div>
                  <hr>
                  <div class="text-center">
                    <router-link to="/" class="font-weight-bold small" >Already have an account?</router-link>
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
  props:{
    id:{type: String}
  },
  created(){
    if(User.loggedIn()){
      this.$router.push('/home')
      }else{

        axios.get('/api/auth/verifyEmail/'+this.id)
        .then(({data}) => {
          this.user = data.data[0]
          this.deadline = Math.floor(new Date(this.user.updated_at).getTime()/1000)+120; 
          this.timer = this.deadline- Math.floor(new Date().getTime()/1000) ; 
          console.log(this.deadline);
          console.log(this.timer);
        })
        .catch()
      }
  },
  computed:{
    expiretimer(){
      if(this.timer>0){
        setTimeout(() => {
                       this.timer -= 1
                   }, 1000)
      }
      
      return this.timer;
    }
  },
  data(){
        return{
          user:[],
          deadline:null,
          timer:null,
          form: {
            email: null,
            OTP: null,
      },
        }
  },
  methods:{
    sendMail(){ 
      axios.post('/api/sendVerificationCode',this.user)
        .then(({data}) => {
          this.user = data.data
          this.deadline = Math.floor(new Date(this.user.updated_at).getTime()/1000)+120; 
          this.timer = this.deadline- Math.floor(new Date().getTime()/1000) ; 
          console.log(this.deadline);
          console.log(this.timer);
        })
        .catch()
    },
    verify(){
      this.form.email=this.user.email
      axios.post('/api/auth/verify',this.form)
        .then((res) => {
          console.log(res);
      Toast.fire({ icon: res.data.status, title: res.data.message});
      this.$router.push('/')
        })
        .catch()
    } 
  }

}

</script>