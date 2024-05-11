<template>
    <div>
  
  <div class="row" style="position: relative;left: 25px;">
   <router-link to="/addExpense" class="btn btn-primary">{{ $t("main.Add Expense") }} </router-link>
    
  </div>
  
  <br>
     <input type="text" v-model="searchTerm" class="form-control" style="width: 300px;" :placeholder="$t('main.Search here') ">
  <br>
  
    <div class="row justify-content-center">
       <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="row">
              <div class="col-lg-12 mb-4">
                <!-- Simple Tables -->
                <div class="card">
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $t("main.Expenses List") }}</h6>
                  </div>
                  <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                      <thead class="thead-light">
                        <tr>
                          <th>{{ $t("main.Details") }}</th>
                          <th>{{ $t("main.Amount") }}</th>
                          <th>{{ $t("main.Date") }}</th>
                          <th>{{ $t("main.Action") }}</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="expense in filtersearch" :key="expense.id">
                          <td> {{ expense.details }} </td>
                          <td>{{ expense.amount }}</td>
                          <td>{{ expense.expense_date }}</td>
              <td>
     <router-link :to="{path:'/editExpense/'+expense.id}" class="btn btn-sm btn-primary">{{ $t("main.Edit") }}</router-link>
  
   <a @click="deleteExpense(expense.id)" class="btn btn-sm btn-danger del" style="color: #ffffff;">{{ $t("main.Delete") }}</a>
              </td>
                        </tr>
                      
                      </tbody>
                    </table>
                  </div>
                  <div class="card-footer"></div>
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
          this.allExpenses();
          
        }
        
      },
      data(){
        return{
          expenses:[],
          searchTerm:''
        }
      },
      computed:{
        filtersearch(){
        return this.expenses.filter(expense => {
          if(expense.details.toLowerCase().match(this.searchTerm.toLowerCase())
            ||expense.amount.toLowerCase().match(this.searchTerm.toLowerCase())
            ||expense.expense_date.toLowerCase().match(this.searchTerm.toLowerCase()))
           return expense;
        }) 
        }
      },
   
    methods:{
      allExpenses(){
        axios.get('/api/expenses')
        .then(({data}) => {this.expenses = data.data})
        .catch()
      },
      deleteExpense(id){
               Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
              }).then((result) => {
                if (result.value) {
                  axios.delete('/api/expenses/'+id)
                 .then(() => {this.expenses = this.expenses.filter(employee => {return employee.id != id})})
                 .catch(() => {
                  this.$router.push('/expenses')
                 })
                  Swal.fire(
                    'Deleted!',
                    'successfully deleted.',
                    'success'
                  )
                }
              })
            },
    }
  }
  
  
  </script>
  
  <style type="text/css">
    #em_photo{
      height: 40px;
      width: 40px;
    }
    .del{
      cursor: pointer;
      right: -5px;
      position: relative;
    }
  </style>