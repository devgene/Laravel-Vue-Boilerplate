<template>

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>
                            <form class="user" v-on:submit.prevent="register">
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text"
                                               v-model="user.first_name"
                                               class="form-control form-control-user"
                                               id="first_name"
                                               placeholder="First Name">
                                        <div class="invalid-feedback" v-if="errors.first_name">{{errors.first_name[0]}}</div>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text"
                                               v-model="user.last_name"
                                               class="form-control form-control-user"
                                               id="last_name"
                                               placeholder="Last Name">
                                        <div class="invalid-feedback" v-if="errors.last_name">{{errors.last_name[0]}}</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="email"
                                           v-model="user.email"
                                           class="form-control form-control-user"
                                           id="email"
                                           placeholder="Email Address">
                                    <div class="invalid-feedback" v-if="errors.email">{{errors.email[0]}}</div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password"
                                               v-model="user.password"
                                               class="form-control form-control-user"
                                               id="exampleInputPassword" placeholder="Password">
                                        <div class="invalid-feedback" v-if="errors.password">{{errors.password[0]}}</div>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password"
                                               v-model="user.password_confirmation"
                                               class="form-control form-control-user"
                                               id="password_confirmation" placeholder="Repeat Password">
                                        <div class="invalid-feedback" v-if="errors.password">{{errors.password[0]}}</div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Register Account
                                </button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <router-link to="/reset-password" class="small">Forgot Password?</router-link>
                            </div>
                            <div class="text-center">
                                <router-link to="/login" class="small" >Already have an account? Login!</router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</template>

<script>
    import * as auth from '../../services/auth_service';
    export default {
        name:'Register',
        created() {
            document.querySelector('body').style.backgroundColor = '#284FC2';
        },
        data(){
            return{
                user:{
                    first_name:'',
                    last_name:'',
                    email:'',
                    password:'',
                    password_confirmation:''
                },
                errors:{}
            }
        },
        methods:{
            register: async function(){
                try {
                    await auth.register(this.user);
                    this.errors={};
                    this.$router.push('/login');
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
            }
        }
    }
</script>
