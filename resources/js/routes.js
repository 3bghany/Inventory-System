import {createRouter, createWebHistory} from 'vue-router'


//Auth
import login from "./components/auth/login.vue"
import register from "./components/auth/register.vue"
import forgotPassword from "./components/auth/forgotPassword.vue"
import verifyEmail from "./components/auth/verifyPassword.vue"

//Employee
import addEmployee from "./components/employee/create.vue"
import allEmployees from "./components/employee/index.vue"
import editEmployee from"./components/employee/edit.vue"

//Supplier
import addSupplier from "./components/supplier/create.vue"
import allSuppliers from "./components/supplier/index.vue"
import editSupplier from "./components/supplier/edit.vue"

//Category
import addCategory from "./components/category/create.vue"
import allCategories from "./components/category/index.vue"
import editCategory from "./components/category/edit.vue"

//Product
import addProduct from "./components/product/create.vue"
import allProducts from "./components/product/index.vue"
import editProduct from "./components/product/edit.vue"

//Expense
import addExpense from "./components/expense/create.vue"
import allExpenses from "./components/expense/index.vue"
import editExpense from "./components/expense/edit.vue"

//customer
import addCustomer from "./components/customer/create.vue"
import allCustomers from "./components/customer/index.vue"
import editCustomer from "./components/customer/edit.vue"

//POS
import pos from "./components/pos/pointOfSale.vue"


//Salary
import paySalary from "./components/salary/paySalary.vue"

//Stock
import stock from "./components/product/stock.vue"

//Order
import orders from "./components/order/orders.vue"
import todayOrders from "./components/order/todayOrders.vue"
import viewOrder from "./components/order/viewOrder.vue"

//Other
import pageNotFound from "./components/pageNotFound.vue"
import home from "./components/home.vue"
import logout from "./components/auth/logout.vue"
import profile from "./components/profile.vue"

const  routes=[
    //Auth
    {path:'/', component:login, name:login},
    {path:'/register', component:register, name:register},
    {path:'/forgotPassword', component:forgotPassword, name:forgotPassword},   
    {path:'/verifyEmail/:id', component:verifyEmail, name:verifyEmail ,props:true},

    //Employees
    {path:'/addEmployee', component:addEmployee, name:addEmployee},
    {path:'/employees', component:allEmployees, name:allEmployees},
    {path:'/editEmployee/:id', component:editEmployee, name:editEmployee},
    
    //Suppliers
    {path:'/addSupplier', component:addSupplier, name:addSupplier},
    {path:'/suppliers', component:allSuppliers, name:allSuppliers},
    {path:'/editSupplier/:id', component:editSupplier, name:editSupplier},

    //Category
    {path:'/addCategory', component:addCategory, name:addCategory},
    {path:'/categories', component:allCategories, name:allCategories},
    {path:'/editCategory/:id', component:editCategory, name:editCategory},

    //Product
    {path:'/addProduct', component:addProduct, name:addProduct},
    {path:'/products', component:allProducts, name:allProducts},
    {path:'/editProduct/:id', component:editProduct, name:editProduct},

    //Expense
    {path:'/addExpense', component:addExpense, name:addExpense},
    {path:'/expenses', component:allExpenses, name:allExpenses},
    {path:'/editExpense/:id', component:editExpense, name:editExpense},

    //Customer
    {path:'/addCustomer', component:addCustomer, name:addCustomer},
    {path:'/customers', component:allCustomers, name:allCustomers},
    {path:'/editCustomer/:id', component:editCustomer, name:editCustomer},

    //POS
    {path:'/pos', component:pos, name:pos},

    //Salary
    {path:'/paySalary/:id', component:paySalary, name:paySalary},

    //Stock
    {path:'/stock', component:stock, name:stock},

    //Order
    {path:'/orders', component:orders, name:orders},
    {path:'/todayOrders', component:todayOrders, name:todayOrders},
    {path:'/viewOrder/:id', component:viewOrder, name:viewOrder},

    //Other
    {path:'/home', component:home, name:home},
    {path:'/logout', component:logout, name:logout},
    {path:'/:pathMatch(.*)*', component:pageNotFound, name:pageNotFound},
    {path:'/profile', component:profile, name:profile},
]




const router =createRouter({
    history:createWebHistory(),
    routes,
})
export default router;