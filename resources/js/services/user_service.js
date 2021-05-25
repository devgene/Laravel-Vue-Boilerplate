import {http} from './http_service'

export function createUser(data) {
    return http().post('/users',data);
}

export function deleteUser(id) {
    return http().delete(`/users/${id}`);
}

export function getUsers() {
    return http().get('/users');
}
