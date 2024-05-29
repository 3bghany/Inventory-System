<template>
  <div>

    <div class="row" style="position: relative;left: 25px;">
      <router-link to="/addEmployee" class="btn btn-primary">{{ $t("main.Add Employee") }} </router-link>

    </div>

    <br>
    <input type="text" v-model="searchTerm" class="form-control" style="width: 500px;" 
    :placeholder=" $t('main.Search by')+' '+$t('main.Name')+', '+$t('main.Salary')+', '+$t('main.Phone')+', '+$t('main.Joining Date')">
    <br>

    <div class="row justify-content-center">
      <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="row">
          <div class="col-lg-12 mb-4">
            <!-- Simple Tables -->
            <div class="card">
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">{{ $t("main.Employee List") }}</h6>
              </div>
              <div class="table-responsive">
                <table class="table align-items-center table-flush">
                  <thead class="thead-light">
                    <tr>
                      <th>{{ $t("main.Name") }}</th>
                      <th>{{ $t("main.Photo") }}</th>
                      <th>{{ $t("main.Phone") }}</th>
                      <th>{{ $t("main.Salary") }}</th>
                      <th>{{ $t("main.Joining Date") }}</th>
                      <th>{{ $t("main.Action") }}</th>
                      <th>{{ $t("main.Salary Payment") }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="employee in filtersearch" :key="employee.id">
                      <td > {{ employee.name }} </td>
                      <td><img :src="employee.photo" id="em_photo"></td>
                      <td>{{ employee.phone }}</td>
                      <td>{{ employee.salary }}</td>
                      <td>{{ employee.joining_date }}</td>
                      <td>
                        <router-link :to="{ path: '/editEmployee/' + employee.id }"
                          class="btn btn-sm btn-primary">{{ $t("main.Edit") }}</router-link>

                        <a @click="deleteEmployee(employee.id)" class="btn btn-sm btn-danger green del"
                          style="color: #ffffff;">{{ $t("main.Delete") }}</a>
                      </td>
                      <td><router-link :to="{ path: '/paySalary/' + employee.id }" class="btn btn-bg"
                          style="background-color: #66bb6a; color: #ffffff; width:120px;">{{ $t("main.Pay") }}</router-link></td>

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
import { trans } from 'laravel-vue-i18n';
export default {
  
  created() {
    if (!User.loggedIn()) {
      this.$router.push('/')
    } else {
      this.allEmployee();

    }

  },
  data() {
    return {
      employees: [],
      searchTerm: ''
    }
  },
  computed: {
    filtersearch() {
      return this.employees.filter(employee => {
        if (employee.name.toLowerCase().match(this.searchTerm.toLowerCase())
          || employee.salary.toLowerCase().match(this.searchTerm.toLowerCase()) 
          || employee.joining_date.toLowerCase().match(this.searchTerm.toLowerCase()) 
          || employee.phone.toLowerCase().match(this.searchTerm.toLowerCase()))
          return employee;
      })
    }
  },

  methods: {
    allEmployee() {
      axios.get('/api/employees')
        .then(({ data }) => { this.employees = data.data })
        .catch()
    },
    deleteEmployee(id) {
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: trans('main.Delete'),
      }).then((result) => {
        if (result.value) {
          axios.delete('/api/employees/' + id)
            .then(() => { this.employees = this.employees.filter(employee => { return employee.id != id }) })
            .catch(() => {
              this.$router.push('/employee')
            })
          Swal.fire(
            'Deleted!',
            'Your file has been deleted.',
            'success'
          )
        }
      })
    },
  }
}


</script>

<style type="text/css">
#em_photo {
  height: 40px;
  width: 40px;
}

.del {
  cursor: pointer;
  right: -5px;
  position: relative;
}
</style>