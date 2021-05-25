import {http} from './http_service'

export function createRole(data) {
    return http().post('/roles',data);
}

export function getRoles() {
    return http().get('/roles');
}
