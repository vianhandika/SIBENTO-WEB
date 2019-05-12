import Vue from 'vue'
import VueRouter from 'vue-router'
import Vuetify from 'vuetify';
import axios from 'axios';
import VueAxios from 'vue-axios';
import Vuelidate from 'vuelidate';
import { routes } from './routes'
import { setupComponents } from './setup-components';
import Controller from './httpController'
import store from './store'

import 'vuetify/dist/vuetify.min.css';
import 'font-awesome/css/font-awesome.css';                    
import 'material-design-icons-iconfont/dist/material-design-icons.css'


import App  from './components/App'

setupComponents(Vue);
Vue.use(VueRouter);
Vue.use(Vuetify);
Vue.use(Vuelidate);
Vue.use(VueAxios, axios);



const router = new VueRouter({
    mode: 'history',
    routes,
});

Vue.router = router

new Vue({
    el: '#app',
    router,
    store,
    data: {
        themeColor: '#1E88E5',
    },
    render: h => h(App)
})
.$mount('#app');