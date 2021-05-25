<template>

    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Users</h1>
        </div>

        <div class="row">

            <!-- Area Chart -->
            <div class="col-xl-12 col-lg-12">

                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Create user</h6>
                    <b-button id="show-btn" @click="showNewUserModel">Create User</b-button>
                </div>

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
                                        <button v-on:click="editUser(user)" class="btn btn-info btn-circle btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </button>
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
                            <hr>
                            <div class="text-right">
                                <button type="button" class="btn btn-default" v-on:click="hideNewUserModel">Cancel</button>
                                <button type="submit" class="btn btn-success">Save</button>

                            </div>
                        </form>
                    </div>
                </b-modal>
                <b-modal ref="editUserModel" hide-footer title="create edit user">
                    <div class="form" v-on:submit.prevent="updateUser" style="margin: 10px">
                        <form>
                            <div class="form-group">
                                <label for="edit_first_name">First Name</label>
                                <input type="text" v-model="editUserData.first_name" class="form-control" id="edit_first_name">
                            </div>
                            <div class="form-group">
                                <label for="edit_last_name">Last Name</label>
                                <input type="text" class="form-control" v-model="editUserData.last_name" id="edit_last_name">
                            </div>
                            <div class="form-group">
                                <label for="edit_email">Email</label>
                                <input type="email" v-model="editUserData.email" class="form-control" id="edit_email">
                            </div>
                            <div class="form-group">
                                <label for="edit_phone">Phone</label>
                                <input type="number" v-model="editUserData.phone" class="form-control" id="edit_phone">
                            </div>

                            <div class="form-group">
                                <label for="edit_role">Role</label>
                                <select  id="edit_role" class="form-control" v-if="editUserData.roles" v-model="editUserData.roles[0].name">
                                    <option v-for="role in roles" v-bind:value="role.name" >{{ role.name }}</option>
                                </select>
                            </div>
                            <hr>
                            <div class="text-right">
                                <button type="button" class="btn btn-default" v-on:click="hideEditUserModel">Cancel</button>
                                <button type="submit" class="btn btn-success">Update</button>

                            </div>
                        </form>
                    </div>
                </b-modal>

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
                editUserData:{},
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
            hideEditUserModel() {
                this.$refs.editUserModel.hide();
            },
            showEditUserModel() {
                this.$refs.editUserModel.show();
            },
            editUser(user) {
                this.editUserData=user;
                this.showEditUserModel();
            },
            updateUser: async function () {
                let formData = new FormData();
                formData.append('first_name', this.editUserData.first_name);
                formData.append('last_name', this.editUserData.last_name);
                formData.append('email', this.editUserData.email);
                formData.append('phone', this.editUserData.phone);
                formData.append('role', this.editUserData.roles[0].name);
                formData.append('_method','put');
                console.log( this.editUserData.role);
                try {
                    const response = await userService.updateUser(this.editUserData.id,formData);
                    this.users.map(user=>{
                        if(user.id == response.data.id){
                            user=response.data;
                        }
                    });
                    this.hideEditUserModel();
                    this.flashMessage.success({
                        title: 'User Successfully Updated',
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
            deleteUser: async function (user) {

                this.$confirm({
                    title: 'Are you sure?',
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
