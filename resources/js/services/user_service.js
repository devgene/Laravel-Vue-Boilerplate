import {http} from './http_service'

export function createUser(data) {
    return http().post('/users',data);
}

export function deleteUser(id) {
    return http().delete(`/users/${id}`);
}

export function updateUser(id,data) {
    return http().post(`/users/${id}`,data);
}

export function getUsers() {
    return http().get('/users');
}
