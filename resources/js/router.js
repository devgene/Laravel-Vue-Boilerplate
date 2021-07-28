import Vue from 'vue';
import Router from 'vue-router';
import Home from "./views/Home";
import * as auth from './services/auth_service'

Vue.use(Router);

const routes = [
    {
        path: '/home',
        name: 'home',
        component: Home,
        children:[
            {
                path: '',
                name: 'dashboard',
                component: () =>import('./views/Dashboard.vue'),
                meta: {
                    requiresAuth: true,
                    role : 'administrator'
                }
            },
            {
                path: '/user',
                name: 'user',
                component: () =>import('./views/User.vue')
            },
            {
                path: '/roles',
                name: 'roles',
                component: () =>import('./views/Role.vue')
            },
        ],
        beforeEnter(to, from, next){
            if (!auth.isLoggedIn()){
                next('/login')
            }
            else {
                // this.$router.push('home')
                next();
            }
        }
    },
    {
        path: '/register',
        name: 'register',
        component: () =>import('./views/auth/Register.vue')
    },
    {
        path: '/login',
        name: 'login',
        component: () =>import('./views/auth/Login.vue'),
        beforeEnter(to, from, next){
            if (!auth.isLoggedIn()){
                next();
            }else if (auth.getRole() === 'administrator'){
                next('/home');
            }else {
                next();
            }
        }
    },
    {
        path: '/',
        name: 'home',
        component: () =>import('./views/Home.vue'),
    },
    {
        path: '/reset-password',
        name: 'reset-password',
        component: () =>import('./views/auth/ResetPassword.vue')
    }
];

const router = new Router({
    mode: 'history',
    routes:routes,
    linkActiveClass:'active'
});
export default router;
