<template>
    <div class="row justify-content-center">

        <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                </div>
                                <p id="error"></p>
                                <form class="user" v-on:submit.prevent="login">
                                    <div class="form-group">
                                        <input type="email"
                                               v-model="user.email"
                                               class="form-control form-control-user"
                                               id="exampleInputEmail" aria-describedby="emailHelp"
                                               placeholder="Enter Email Address...">
                                        <div class="invalid-feedback" v-if="errors.email">{{errors.email[0]}}</div>
                                    </div>
                                    <div class="form-group">
                                        <input type="password"
                                               v-model="user.password"
                                               class="form-control form-control-user"
                                               id="exampleInputPassword" placeholder="Password">
                                        <div class="invalid-feedback" v-if="errors.password">{{errors.password[0]}}</div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox small">
                                            <input type="checkbox"
                                                   v-model="user.remember_me"
                                                   class="custom-control-input" id="customCheck">
                                            <label class="custom-control-label" for="customCheck">Remember
                                                Me</label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Login
                                    </button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <router-link to="/reset-password" class="small">Forgot Password?</router-link>
                                </div>
                                <div class="text-center">
                                    <router-link to="/register" class="small">Create an Account!</router-link>
                                </div>
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
        name:'Login',
        created() {
            document.querySelector('body').style.backgroundColor = '#284FC2';
        },
        data(){
            return{
                user:{
                    email:'',
                    password:'',
                    remember_me:''
                },
                errors:{},
            }
        },
        methods: {
            login: async function(){
                try {
                    const response = await auth.login(this.user);
                    console.log(response);
                    if (response.role === 'administrator'){
                        this.$router.push('/home');
                   }else {
                        this.flashMessage.error({
                            message: response.role +' is not allowed to login',
                            time: 5000
                        });
                    }
                }catch (error) {
                    switch (error.response.status) {
                        case 422:
                            this.flashMessage.error({
                                message: error.response.data.errors,
                                time: 5000
                            });
                            break;
                        case 401:
                            this.flashMessage.error({
                                message: error.response.data.message,
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
