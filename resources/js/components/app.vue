<template>

  <div id="wrapper">
    <nav id="sidebar"
      v-show="$route.path === '/' || $route.path === '/register' || $route.path === '/forgotPassword' || !show() ? false : true"
      style="display: none">
      <!-- Sidebar -->
      <ul class="navbar-nav sidebar sidebar-light accordion" :class="{ active: isSidebarActive }" id="accordionSidebar">
        <a class="sidebar-brand d-flex align-items-center justify-content-center">
          <div class="sidebar-brand-icon">
            <img src="../../../public/backend/img/logo.png" style="max-height: 70px;" </div>
        </a>
        <hr class="sidebar-divider my-0">
        <li class="nav-item active">
          <router-link class="nav-link" to="/home">
            <i class="fa-solid fa-house"></i>
            <span>{{ $t("main.Dashboard") }}</span></router-link>
        </li>
        <li class="nav-item active" style="margin-top: 10px;">
          <router-link class="nav-link" to="/pos">
            <i class="fa-solid fa-cart-plus"></i>
            <span>{{ $t("pos.POS") }}</span></router-link>
        </li>
        <hr class="sidebar-divider">
        <div class="sidebar-heading">
          {{ $t("main.FEATURES") }}
        </div>
        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseEmployee"
            aria-expanded="true" aria-controls="collapseEmployee">
            <i class="fa-solid fa-user"></i>
            <span>{{ $t("main.Employee") }}</span>
          </a>
          <div id="collapseEmployee" class="collapse" aria-labelledby="headingBootstrap"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <!-- <h6 class="collapse-header">Bootstrap UI</h6> -->
              <router-link to="/employees" class="collapse-item">{{ $t("main.All Employees") }}</router-link>
              <router-link to="/addEmployee" class="collapse-item">{{ $t("main.Add Employee") }}</router-link>
            </div>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSupplies"
            aria-expanded="true" aria-controls="collapseSupplies">
            <i class="fa-solid fa-user"></i>
            <span>{{ $t("main.Suppliers") }}</span>
          </a>
          <div id="collapseSupplies" class="collapse" aria-labelledby="headingBootstrap"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <!-- <h6 class="collapse-header">Bootstrap UI</h6> -->
              <router-link to="/suppliers" class="collapse-item">{{ $t("main.All Suppliers") }}</router-link>
              <router-link to="/addSupplier" class="collapse-item">{{ $t("main.Add Supplier") }}</router-link>
            </div>
          </div>
        </li>

        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCustomers"
            aria-expanded="true" aria-controls="collapseCustomers">
            <i class="fa-solid fa-users"></i>
            <span>{{ $t("main.Customers") }}</span>
          </a>
          <div id="collapseCustomers" class="collapse" aria-labelledby="headingBootstrap"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <!-- <h6 class="collapse-header">Bootstrap UI</h6> -->
              <router-link to="/Customers" class="collapse-item">{{ $t("main.All Customers") }}</router-link>
              <router-link to="/addCustomer" class="collapse-item">{{ $t("main.Add Customer") }}</router-link>
            </div>
          </div>
        </li>

        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCategories"
            aria-expanded="true" aria-controls="collapseCategories">
            <i class="fa-solid fa-layer-group"></i>
            <span>{{ $t("main.Categories") }}</span>
          </a>
          <div id="collapseCategories" class="collapse" aria-labelledby="headingBootstrap"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <!-- <h6 class="collapse-header">Bootstrap UI</h6> -->
              <router-link to="/categories" class="collapse-item">{{ $t("main.All Categories") }}</router-link>
              <router-link to="/addCategory" class="collapse-item">{{ $t("main.Add Category") }}</router-link>
            </div>
          </div>
        </li>

        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProducts"
            aria-expanded="true" aria-controls="collapseProducts">
            <i class="fa-brands fa-product-hunt"></i>
            <span>{{ $t("main.Products") }}</span>
          </a>
          <div id="collapseProducts" class="collapse" aria-labelledby="headingBootstrap"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <!-- <h6 class="collapse-header">Bootstrap UI</h6> -->
              <router-link to="/products" class="collapse-item">{{ $t("main.All Products") }}</router-link>
              <router-link to="/addProduct" class="collapse-item">{{ $t("main.Add Product") }}</router-link>
            </div>
          </div>
        </li>


        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseExpenses"
            aria-expanded="true" aria-controls="collapseExpenses">
            <i class="far fa-fw fa-window-maximize"></i>
            <span>{{ $t("main.Expenses") }}</span>
          </a>
          <div id="collapseExpenses" class="collapse" aria-labelledby="headingBootstrap"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <!-- <h6 class="collapse-header">Bootstrap UI</h6> -->
              <router-link to="/Expenses" class="collapse-item">{{ $t("main.All Expenses") }}</router-link>
              <router-link to="/addExpense" class="collapse-item">{{ $t("main.Add Expense") }}</router-link>
            </div>
          </div>
        </li>


        <li class="nav-item">
          <router-link to="/stock" class="nav-link">
            <i class="fa-solid fa-cart-shopping"></i>
            <span>{{ $t("main.Stock") }}</span>
          </router-link>
        </li>

        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOrders"
            aria-expanded="true" aria-controls="collapseOrders">
            <i class="far fa-fw fa-window-maximize"></i>
            <span>{{ $t("main.Orders") }}</span>
          </a>
          <div id="collapseOrders" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <!-- <h6 class="collapse-header">Bootstrap UI</h6> -->
              <router-link to="/orders" class="collapse-item">{{ $t("main.All Orders") }}</router-link>
              <router-link to="/todayOrders" class="collapse-item">{{ $t("main.Today's Orders") }}</router-link>
            </div>
          </div>
        </li>

      </ul>
      <!-- Sidebar -->
    </nav>
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- TopBar -->
        <nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top" :class="{ active: isSidebarActive }"
          v-show="$route.path === '/' || $route.path === '/register' || $route.path === '/forgotPassword' || !show() ? false : true"
          style="display: none">
          <img v-if="isSidebarActive" src="../../../public/backend/img/icon.png" style="max-height: 70px;left: -16px;position: relative;">
          <button id="sidebarToggleTop" @click="toggleSidebar" class="btn btn-link rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
          <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                aria-labelledby="searchDropdown">
                <form class="navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-1 small"
                      placeholder="What do you want to look for?" aria-label="Search" aria-describedby="basic-addon2"
                      style="border-color: #3f51b5;">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <span class="badge badge-danger badge-counter">3+</span>
              </a>
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                  Alerts Center
                </h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-primary">
                      <i class="fas fa-file-alt text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 12, 2019</div>
                    <span class="font-weight-bold">A new monthly report is ready to download!</span>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-success">
                      <i class="fas fa-donate text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 7, 2019</div>
                    $290.29 has been deposited into your account!
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-warning">
                      <i class="fas fa-exclamation-triangle text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 2, 2019</div>
                    Spending Alert: We've noticed unusually high spending for your account.
                  </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
              </div>
            </li>
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope fa-fw"></i>
                <span class="badge badge-warning badge-counter">2</span>
              </a>
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header">
                  Message Center
                </h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="../../../public/backend/img/man.png" style="max-width: 60px"
                      alt="">
                    <div class="status-indicator bg-success"></div>
                  </div>
                  <div class="font-weight-bold">
                    <div class="text-truncate">Hi there! I am wondering if you can help me with a problem I've been
                      having.</div>
                    <div class="small text-gray-500">Udin Cilok · 58m</div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="../../../public/backend/img/girl.png" style="max-width: 60px"
                      alt="">
                    <div class="status-indicator bg-default"></div>
                  </div>
                  <div>
                    <div class="text-truncate">Am I a good boy? The reason I ask is because someone told me that people
                      say this to all dogs, even if they aren't good...</div>
                    <div class="small text-gray-500">Jaenab · 2w</div>
                  </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
              </div>
            </li>
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-tasks fa-fw"></i>
                <span class="badge badge-success badge-counter">3</span>
              </a>
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header">
                  Task
                </h6>
                <a class="dropdown-item align-items-center" href="#">
                  <div class="mb-3">
                    <div class="small text-gray-500">Design Button
                      <div class="small float-right"><b>50%</b></div>
                    </div>
                    <div class="progress" style="height: 12px;">
                      <div class="progress-bar bg-success" role="progressbar" style="width: 50%" aria-valuenow="50"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                </a>
                <a class="dropdown-item align-items-center" href="#">
                  <div class="mb-3">
                    <div class="small text-gray-500">Make Beautiful Transitions
                      <div class="small float-right"><b>30%</b></div>
                    </div>
                    <div class="progress" style="height: 12px;">
                      <div class="progress-bar bg-warning" role="progressbar" style="width: 30%" aria-valuenow="30"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                </a>
                <a class="dropdown-item align-items-center" href="#">
                  <div class="mb-3">
                    <div class="small text-gray-500">Create Pie Chart
                      <div class="small float-right"><b>75%</b></div>
                    </div>
                    <div class="progress" style="height: 12px;">
                      <div class="progress-bar bg-danger" role="progressbar" style="width: 75%" aria-valuenow="75"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">View All Taks</a>
              </div>
            </li>


            <div class="topbar-divider d-none d-sm-block"></div>
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <img class="img-profile rounded-circle" src="../../../public/backend/img/boy2.png"
                  style="max-width: 60px">
                <span class="ml-2 d-none d-lg-inline text-white small">{{ (this.Name) ? (this.Name).split(' ')[0] : false
                  }}</span>
              </a>
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <router-link to="/profile" class="dropdown-item">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  {{ $t('main.Profile') }}
                </router-link>
                <div id="language">
                  <a class="dropdown-item language" href="#" style="background-color: white;">
                    <i class="fa-solid fa-language fa-lg mr-2 text-gray-400"></i>
                    {{ $t('main.Languages') }}
                    <div class="lang">
                      <a class="dropdown-item dropdown-content" @click="changeLanguage('en')" href="#">
                        <span class="fi fi-gb"></span>
                        English</a>
                      <a class="dropdown-item dropdown-content" @click="changeLanguage('es')" href="#">
                        <span class="fi fi-es"></span>
                        Española</a>
                      <a class="dropdown-item dropdown-content" @click="changeLanguage('it')" href="#">
                        <span class="fi fi-it"></span>
                        Italiano</a>
                      <a class="dropdown-item dropdown-content" @click="changeLanguage('ar')" href="#">
                        <span class="fi fi-sa"></span>
                        العربية</a>
                    </div>
                  </a>

                </div>
                <div class="dropdown-divider"></div>

                <router-link to="/logout" class="dropdown-item">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  {{ $t('auth.Logout') }}
                </router-link>
              </div>
            </li>
          </ul>
        </nav>
        <!-- Topbar -->
        <notifications position="mid right" />
        <router-view v-on:refreshUserName="UserName"></router-view>

      </div>
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>{{ $t("main.copyright") }} © {{ this.date }} - {{ $t("main.developed by") }}
              <b>(3bghany)</b>
              <p>{{ $t("main.Do you like this template ? you can download from") }} <a style="color: white;"
                  href="https://github.com/indrijunanda/RuangAdmin" class="btn btn-primary btn-sm" target="_blank"><i
                    class="fab fa-fw fa-github"></i>&nbsp;GitHub</a></p>
            </span>
          </div>
        </div>
      </footer>
    </div>

  </div>

</template>
<script>

export default {
  created() {
    this.UserName();
    this.date = new Date;
    this.date = this.date.getFullYear()

    axios.interceptors.response.use(null, (error) => {
    if (error.response.status === 401  && error.response.data.status === 'user inactivity') {
      if(User.loggedIn()){

            axios.post('/api/auth/logout')
            .then(() => {
                User.logOut();
                this.$router.push('/');
                Toast.fire({ icon: 'warning', title: 'Logged out due to inactivity' });
            }).catch();
            }
    }
    return Promise.reject(error);
});

  },
  data() {
    return {
      Name: '',
      date: '',
      k: false,
      isSidebarActive: false,
    }
  },
  methods: {
    show() {
      if (localStorage.getItem('token'))
        return true;
      return false;
    },
    UserName() {
      this.Name = localStorage.getItem('user');
    },
    changeLanguage(lang) {
      axios.get('/api/language/' + lang)
        .then(() => {
          location.reload();
        })
        .catch(error => { })
    },
    toggleSidebar() {
      this.isSidebarActive = !this.isSidebarActive;
    }
  }
}

</script>

<style scoped>
#language:hover .lang {
  display: block;
}

.lang {
  display: none;
  z-index: 1;
  position: absolute;
  background-color: white;
  right: 158px;
  top: 40px;
}

.sidebar {
  left: 0;
  /* Show the sidebar */
  position: block;
}

.sidebar.active {
  width: 200px;
  height: 100%;
  position: fixed;
  top: 0;
  left: -250px;
  /* Initially hide the sidebar */
  transition: left 0.3s ease;
}

.topbar.active {

}
</style>