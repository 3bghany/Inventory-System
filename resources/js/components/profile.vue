<template>
    <div class="main-body">
        <Teleport to="body">
                <div class="modl" v-if="showModal">
                    <div class="modal-dialog" style="top: 130px;max-width: 600px;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">{{ $t("main.Update Profile") }}</h5>
                                <button @click="showModal=false,errors={}" type="button" class="btn-close" style="font-size: 20px;"
                                    ><strong>×</strong></button>
                            </div>
                            <div class="modal-body">
                                <form class="user" @submit.prevent="updateProfile()">

                                    <div class="form-group">

                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" id="exampleInputFirstName"
                                                :placeholder="$t('main.Enter')+' '+$t('main.Full Name')" v-model="form.name">
                                                <small class="text-danger" v-if="errors.name"> {{ errors.name[0] }} </small>
                                            </div>


                                            <div class="col-md-6">
                                                <input disabled type="email" class="form-control" id="exampleInputFirstName"
                                                :placeholder="$t('main.Enter')+' '+$t('main.Email')" v-model="form.email">
                                            </div>

                                        </div>
                                    </div>


                                    <div class="form-group">

                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" id="exampleInputFirstName"
                                                :placeholder=" $t('main.Enter')+' '+$t('main.Address')" v-model="form.address">
                                                <small class="text-danger" v-if="errors.address"> {{ errors.address[0] }} </small>
                                            </div>


                                            <div class="col-md-6">
                                                <input type="text" class="form-control" id="exampleInputFirstName"
                                                :placeholder=" $t('main.Enter')+' '+$t('main.Phone')+' '+$t('main.Number')" v-model="form.phone">
                                                <small class="text-danger" v-if="errors.phone"> {{ errors.phone[0] }} </small>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                <button @click="showModal=false,errors={}" type="button" class="btn btn-secondary" 
                                    style="color: #ffffff;">{{ $t("main.Close") }}</button>
                                <button type="submit" class="btn btn-primary" 
                                    style="color: #ffffff;">{{ $t("main.Update") }}</button>
                            </div>
                                </form>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </Teleport>

<div class="row gutters-sm">
<div class="col-md-4 mb-3">
<div class="card">
<div class="card-body">
<div class="d-flex flex-column align-items-center text-center" >
<img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin" class="rounded-circle" width="150">
<div class="mt-3">
<h4>{{ user.name}}</h4>
<p class=" mb-1"> Store Owner</p>
<p class="text-muted font-size-sm">Bla bla bla bla</p>
</div>
</div>
</div>
</div>
</div>
<div class="col-md-8">
<div class="card mb-3">
<div class="card-body">
<div class="row">
<div class="col-sm-3">
<h6 class="mb-0">{{ $t("main.Full Name") }}</h6>
</div>
<div class="col-sm-9 ">
{{ user.name}}
</div>
</div>
<hr>
<div class="row">
<div class="col-sm-3">
<h6 class="mb-0">{{ $t("main.Email") }}</h6>
</div>
<div class="col-sm-9 ">
{{ user.email}}
</div>
</div>
<hr>
<div class="row">
<div class="col-sm-3">
<h6 class="mb-0">{{ $t("main.Phone") }}</h6>
</div>
<div class="col-sm-9 ">
{{  (user.phone) ? user.phone: '01xxxxxxxxx' }}
</div>
</div>
<hr>
<div class="row">
<div class="col-sm-3">
<h6 class="mb-0">{{ $t("main.Address") }}</h6>
</div>
<div class="col-sm-9 ">
    {{  (user.address) ? user.address: 'Not specified yet' }}
</div>
</div>
<hr>
<div class="row">
<div class="col-sm-3">
<h6 class="mb-0">{{ $t("main.Password") }}</h6>
</div>
<div class="col-sm-9 ">
    ********
</div>
</div>
<hr>
<div class="row">
<div class="col-sm-12">
    <button  @click="openModal()" class="btn btn-sm btn-primary">{{ $t("main.Edit") }}</button>
</div>
</div>
</div>
</div> 
<div class="row gutters-sm" >
<div class="col-sm-6 mb-3" style="min-height: 200px;">
<div class="card h-100">
<div class="card-body">

</div>
</div>
</div>
<div class="col-sm-6 mb-3">
<div class="card h-100">
<div class="card-body">

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
    if(!User.loggedIn()){
      this.$router.push('/')
      }
      else{
        this.GetUser();
        console.log(this.id);
      }
  },
  data() {
        return {
        showModal: false,
        user:{
          name: '',
          email: '',
          phone: '',
          address: '',
        },
        form:{},
        userToken:{
            token:null,
        },
        errors:{}
        }

    },
    methods: {
        GetUser() {
            this.userToken.token=localStorage.getItem('token')
            axios.post('/api/auth/findUserByToken',this.userToken)
                .then(({ data }) => { this.user=data.data[0];})
                .catch()
        },
        openModal(){
            this.showModal=true;
            this.form=JSON.parse(JSON.stringify(this.user))
        },
        updateProfile(){
        axios.put('/api/updateProfile/' + this.form.id, this.form)
        .then(({data}) => {
          Toast.fire({ icon: data.status, title: data.message });
          this.showModal=false;
          this.GetUser();
          console.log(data.data[0].name);
          User.updateUserName(data.data[0].name)
        })
        .catch(error => this.errors=error.response.data.errors)
        },
    }
}
</script>


<style type="text/css" scoped>
    	body{
    margin-top:20px;
    color: #1a202c;
    text-align: left;
    background-color: #e2e8f0;    
}
.main-body {
    padding: 15px;
}
.card {
    box-shadow: 0 1px 3px 0 rgba(0,0,0,.1), 0 1px 2px 0 rgba(0,0,0,.06);
}

.card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 0 solid rgba(0,0,0,.125);
    border-radius: .25rem;
}

.card-body {
    flex: 1 1 auto;
    min-height: 1px;
    padding: 1rem;
}

.gutters-sm {
    margin-right: -8px;
    margin-left: -8px;
}

.gutters-sm>.col, .gutters-sm>[class*=col-] {
    padding-right: 8px;
    padding-left: 8px;
}
.mb-3, .my-3 {
    margin-bottom: 1rem!important;
}

.bg-gray-300 {
    background-color: #e2e8f0;
}
.h-100 {
    height: 100%!important;
}
.shadow-none {
    box-shadow: none!important;
}


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
