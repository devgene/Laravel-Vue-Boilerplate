import {http} from './http_service';
import jwt from 'jsonwebtoken';

export function register(user) {
    return http().post('/auth/register',user);
}

export function login(user) {
    return http().post('/auth/login',user)
        .then(response=>{
            if(response.status === 200){
                setToken(response.data);
            }
            return response.data;
        })
}

function setToken(user) {
    const token=jwt.sign({user: user},'laravelvueticketbooking');
    localStorage.setItem('laravel-vue-token',token);
   // this.getAccessToken();
}

export function isLoggedIn() {
    const token = localStorage.getItem('laravel-vue-token');
    return token != null;
}

export function getAccessToken() {
    const token = localStorage.getItem('laravel-vue-token');
    if (!token){
        return null;
    }
    const tokenData=jwt.decode(token);
    return tokenData.user.access_token;
}

export function logout() {
    http().get('/auth/logout');
    localStorage.removeItem('laravel-vue-token');
}
