<template>

        <div class="container-fluid">

            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Users</h1>
            </div>

            <div class="row">

                <!-- Area Chart -->
                <div class="col-xl-12 col-lg-12">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Create user</h6>
                            <b-button id="show-btn" @click="showNewUserModel">Create User</b-button>
                        </div>

                        <b-modal ref="newUserModel" hide-footer title="create new user">
                            <div class="form" v-on:submit.prevent="createUser" style="margin: 10px">
                                <form>
                                    <div class="form-group">
                                        <label for="first_name">First Name</label>
                                        <input type="text" v-model="userData.first_name" class="form-control" id="first_name">
                                    </div>
                                    <div class="form-group">
                                        <label for="last_name">Last Name</label>
                                        <input type="text" class="form-control" v-model="userData.last_name" id="last_name">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" v-model="userData.email" class="form-control" id="email">
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Phone</label>
                                        <input type="number" v-model="userData.phone" class="form-control" id="phone">
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" v-model="userData.password" class="form-control" id="password">
                                    </div>

                                    <div class="form-group">
                                        <label for="role">Role</label>
                                        <select id="role" v-model="userData.role" class="form-control">
                                            <option v-for="(role, index) in roles" v-bind:value="role.name">
                                                {{ role.name }}
                                            </option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-success">save</button>
                                </form>
                            </div>
                        </b-modal>


                        <div class="card shadow mb-4">

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                        <tr>
                                            <th>S.no</th>
                                            <th>First Name</th>
                                            <th>Last name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Role</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-if="users" v-for="(user,index) in users" :key="index">
                                            <td>{{index+1}}</td>
                                            <td>{{user.first_name}}</td>
                                            <td>{{user.last_name}}</td>
                                            <td>{{user.email}}</td>
                                            <td>{{user.phone}}</td>
                                            <td v-if="user.roles" v-for="(role,index) in user.roles" :key="index">
                                                {{role.name}}
                                            </td>
                                            <td>
<!--                                                <router-link :to="{ name: 'user-detail', params: { id: user.id }}"-->
<!--                                                             class="btn btn-info btn-circle btn-sm">-->
<!--                                                    <i class="fas fa-eye"></i>-->
<!--                                                </router-link>-->
                                                <button v-on:click="deleteUser(user)" class="btn btn-danger btn-circle btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

</template>

<script>
    import * as userService from '../services/user_service';
    import * as roleService from '../services/role_service';

    export default {
        name: "User",
        data() {
            return {
                users: [],
                roles: [],
                userData: {
                    first_name: '',
                    last_name: '',
                    email: '',
                    phone: '',
                    password: '',
                    role: '',
                },
                errors: {}
            }
        },
        mounted() {
            this.getUsers();
            this.getRoles();
        },
        methods: {
            hideNewUserModel() {
                this.$refs.newUserModel.hide();
            },
            showNewUserModel() {
                this.$refs.newUserModel.show();
            },
            getRoles: async function () {
                try {
                    const response = await roleService.getRoles();
                    this.roles = response.data.data;
                } catch (error) {
                    this.flashMessage.error({
                        message: 'Some error occured',
                        time: 5000
                    });
                }
            },
            getUsers: async function () {
                try {
                    const response = await userService.getUsers();
                    this.users = response.data.data;
                } catch (error) {
                    this.flashMessage.error({
                        message: 'Some error occured',
                        time: 5000
                    });
                }
            },
            createUser: async function () {
                let formData = new FormData();
                formData.append('first_name', this.userData.first_name);
                formData.append('last_name', this.userData.last_name);
                formData.append('email', this.userData.email);
                formData.append('phone', this.userData.phone);
                formData.append('password', this.userData.password);
                formData.append('role', this.userData.role);
                try {
                    const response = await userService.createUser(formData);
                    this.errors = {};
                    this.users.unshift(response.data);
                    this.hideNewUserModel();
                    this.flashMessage.success({
                        title: 'User Successfully Created',
                    });

                } catch (error) {
                    switch (error.response.status) {
                        case 422:
                            this.flashMessage.error({
                                message: error.response.data.errors,
                                time: 5000
                            });
                            break;
                        case 500:
                            this.flashMessage.error({
                                message: error.response.data.message,
                                time: 5000
                            });
                            break;
                        default:
                            this.flashMessage.error({
                                message: error.response.data.message,
                                time: 5000
                            });
                    }
                }
            },
            deleteUser: async function(user){

                this.$confirm({
                        title:'Are you sure?',
                        message: `you want to delete ${user.first_name} ${user.last_name}?`,
                        button: {
                            no: 'No',
                            yes: 'Yes'
                        },
                        /**
                         * Callback Function
                         * @param {Boolean} confirm
                         */
                        callback: confirm => {
                            if (confirm) {
                                try {
                                    userService.deleteUser(user.id);
                                    this.users = this.users.filter(obj => {
                                        return obj.id != user.id;
                                    });

                                } catch (error) {
                                    this.flashMessage.error({
                                        message: error.response.data.message,
                                        time: 5000
                                    });

                                }
                            }
                        }
                    });
            }
        }
    }

</script>


<style scoped>

</style>
