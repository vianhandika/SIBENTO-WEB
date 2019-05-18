import middleware, { auth } from './middleware'
import AdminApp from './components/AdminApp'
import Index from './components/Index'
import ExampleComponent from './components/ExampleComponent'
import Login from './components/Login'
// import AdminApp from './components/Admin/AdminApp'
import AdminDashboard from './components/Admin/AdminDashboard'
import AdminEmployee from './components/Admin/AdminEmployee'
import AdminUser from './components/Admin/AdminUser'
import AdminService from './components/Admin/AdminService'
import AdminSparepart from './components/Admin/AdminSparepart'
import AdminSupplier from './components/Admin/AdminSupplier'
import AdminSales from './components/Admin/AdminSales'
import AdminCustomer from './components/Admin/AdminCustomer'
import AdminBranch from './components/Admin/AdminBranch'
import AdminMotorBrand from './components/Admin/AdminMotorBrand'
import AdminMotorType from './components/Admin/AdminMotorType'
import AdminProcurement from './components/Admin/AdminProcurement'
import AdminTransaction from './components/Admin/AdminTransaction'
import AdminPayment from './components/Admin/AdminPayment'
import CustomerIndex from './components/Customer/CustomerIndex'


 
export const routes = [
    {
        path: '/',
        name: 'Index',
        component: CustomerIndex,
        
    },
    {
        path: '/panel/login',
        name: 'Login',
        component: Login,
        meta: {
            page: 'login', 
        }
        
    },
    {
        path: '/welcome',
        name: 'welcome',
        component: ExampleComponent,
        
    },
     //ADMIN AREA
    {
        path: '/admin',
        name: 'AdminDashboard',
        component: AdminDashboard,
        meta: {
            role: [
                'Admin',
                'Customer Service',
                'Cashier',
            ],
            menu: 1, 
        },
        beforeEnter: middleware([
            auth
        ]) 
    },
    {
        path: '/admin/employee',
        name: 'AdminEmployee',
        component: AdminEmployee,
        meta: {
            role: [
                'Admin',
            ],
            menu: 2, 
        },
        beforeEnter: middleware([
            auth
        ]) 
    },
    {
        path: '/admin/user',
        name: 'AdminUser',
        component: AdminUser,
        meta: {
            role: [
                'Admin',
            ],
            menu: 3, 
        },
        beforeEnter: middleware([
            auth
        ]) 
    },
    {
        path: '/admin/service',
        name: 'AdminService',
        component: AdminService,
        meta: {
            role: [
                'Admin',
            ],
            menu: 4, 
        },
        beforeEnter: middleware([
            auth
        ]) 
    },   
    {
        path: '/admin/sparepart',
        name: 'AdminSparepart',
        component: AdminSparepart,
        meta: {
            role: [
                'Admin',
            ],
            menu: 5, 
        },
        beforeEnter: middleware([
            auth
        ]) 
    },  
    {
        path: '/admin/supplier',
        name: 'AdminSupplier',
        component: AdminSupplier,
        meta: {
            role: [
                'Admin',
            ],
            menu: 6, 
        },
        beforeEnter: middleware([
            auth
        ]) 
    },
    {
        path: '/admin/sales',
        name: 'AdminSales',
        component: AdminSales,
        meta: {
            role: [
                'Admin',
            ],
            menu: 7, 
        },
        beforeEnter: middleware([
            auth
        ]) 
    },
    {
        path: '/admin/customer',
        name: 'AdminCustomer',
        component: AdminCustomer,
        meta: {
            role: [
                'Admin',
            ],
            menu: 8, 
        },
        beforeEnter: middleware([
            auth
        ]) 
    }, 
    {
        path: '/admin/branch',
        name: 'AdminBranch',
        component: AdminBranch,
        meta: {
            role: [
                'Admin',
            ],
            menu: 9, 
        },
        beforeEnter: middleware([
            auth
        ]) 
    },

    {
        path: '/admin/motorbrand',
        name: 'AdminMotorBrand',
        component: AdminMotorBrand,
        meta: {
            role: [
                'Admin',
            ],
            menu: 10, 
        },
        beforeEnter: middleware([
            auth
        ]) 
    },

    {
        path: '/admin/motortype',
        name: 'AdminMotorType',
        component: AdminMotorType,
        meta: {
            role: [
                'Admin',
            ],
            menu: 11, 
        },
        beforeEnter: middleware([
            auth
        ]) 
    },         
    {
        path: '/admin/procurement',
        name: 'AdminProcurement',
        component: AdminProcurement,
        meta: {
            role: [
                'Admin',
            ],
            menu: 12, 
        },
        beforeEnter: middleware([
            auth
        ]) 
    },       
    {
        path: '/admin/transaction',
        name: 'AdminTransaction',
        component: AdminTransaction,
        meta: {
            role: [
                'Admin',
                'Customer Service',
                
            ],
            menu: 13, 
        },
        beforeEnter: middleware([
            auth
        ]) 
    },            
    {
        path: '/admin/payment',
        name: 'AdminPayment',
        component: AdminPayment,
        meta: {
            role: [
                'Admin',
                'Cashier'
                
            ],
            menu: 14, 
        },
        beforeEnter: middleware([
            auth
        ]) 
    },        
    //  {
    //     path: '/admin',
    //     name: 'Admin',
    //     component: AdminApp,
    //     children: [
    //         {
    //             path: '/admin',
    //             name: 'AdminDashboard',
    //             component: AdminDashboard,
    //         }, 
    //         {
    //             path: '/admin/employee',
    //             name: 'AdminEmployee',
    //             component: AdminEmployee,
    //         }, 
    //         {
    //             path: '/admin/user',
    //             name: 'AdminUser',
    //             component: AdminUser,
    //         }, 
            

    //     ]
    // },
    
];