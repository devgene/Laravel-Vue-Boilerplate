<template>

    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Roles</h1>
        </div>

        <div class="row">

            <!-- Area Chart -->
            <div class="col-xl-12 col-lg-12">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Create role</h6>
                    <b-button id="show-btn" @click="showNewRoleModel">Create Role</b-button>
                </div>

                <b-modal ref="newRoleModel" hide-footer title="create new role">
                    <div class="form" v-on:submit.prevent="createRole" style="margin: 10px">
                        <form>
                            <div class="form-group">
                                <label for="role_name">Role Name</label>
                                <input type="text" v-model="roleData.role_name" class="form-control" id="role_name">
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
                                    <th>Role Name</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-if="roles" v-for="(role,index) in roles" :key="index">
                                    <td>{{index+1}}</td>
                                    <td>{{role.name}}</td>
                                    <td>
                                        <!--                                                <router-link :to="{ name: 'user-detail', params: { id: user.id }}"-->
                                        <!--                                                             class="btn btn-info btn-circle btn-sm">-->
                                        <!--                                                    <i class="fas fa-eye"></i>-->
                                        <!--                                                </router-link>-->
                                        <button v-on:click="deleteRole(role)" class="btn btn-danger btn-circle btn-sm">
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

</template>

<script>
    import * as roleService from '../services/role_service';

    export default {
        name: "Role",
        data() {
            return {
                roles: [],
                roleData: {
                    role_name: '',
                },
                errors: {}
            }
        },
        mounted() {
            this.getRoles();
        },
        methods: {
            hideNewRoleModel() {
                this.$refs.newRoleModel.hide();
            },
            showNewRoleModel() {
                this.$refs.newRoleModel.show();
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
            createRole: async function () {
                let formData = new FormData();
                formData.append('name', this.roleData.role_name);
                try {
                    const response = await roleService.createRole(formData);
                    this.errors = {};
                    this.roles.unshift(response.data);
                    this.hideNewRoleModel();
                    this.flashMessage.success({
                        title: 'Role Successfully Created',
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
            deleteRole: async function (role) {

                this.$confirm({
                    title: 'Are you sure?',
                    message: `You want to delete ${role.name} ?`,
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
                                roleService.deleteRole(role.id);
                                this.roles = this.roles.filter(obj => {
                                    return obj.id != role.id;
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
