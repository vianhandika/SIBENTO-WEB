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

 
export const routes = [
    {
        path: '/',
        name: 'Login',
        component: Login,
        
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
            menu: 1, 
        }
    },
    {
        path: '/admin/employee',
        name: 'AdminEmployee',
        component: AdminEmployee,
        meta: {
            menu: 2, 
        }
    },
    {
        path: '/admin/user',
        name: 'AdminUser',
        component: AdminUser,
        meta: {
            menu: 3, 
        }
    },
    {
        path: '/admin/service',
        name: 'AdminService',
        component: AdminService,
        meta: {
            menu: 4, 
        }
    },   
    {
        path: '/admin/sparepart',
        name: 'AdminSparepart',
        component: AdminSparepart,
        meta: {
            menu: 5, 
        }
    },  
    {
        path: '/admin/supplier',
        name: 'AdminSupplier',
        component: AdminSupplier,
        meta: {
            menu: 6, 
        }
    },
    {
        path: '/admin/sales',
        name: 'AdminSales',
        component: AdminSales,
        meta: {
            menu: 7, 
        }
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