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
                component: () =>import('./views/Dashboard.vue')
            },
        ],
        beforeEnter(to, from, next){
            if (!auth.isLoggedIn()){
                next('/login')
            }else {
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
            }else {
                next('/home');
            }
        }
    },
    {
        path: '/',
        name: 'login',
        component: () =>import('./views/auth/Login.vue'),
        beforeEnter(to, from, next){
            if (!auth.isLoggedIn()){
                next();
            }else {
                next('/home');
            }
        }
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
