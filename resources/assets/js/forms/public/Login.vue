<template>



    <div v-loading.fullscreen.lock="fullscreenLoading">

        <div v-if="login == true">

            <el-row :gutter="24">
                <el-col :span="12" :offset="6"><div class="grid-content bg-purple">
                    <div>
                        <el-alert
                                title="Site is under implementation."
                                type="warning"
                                description="Please be aware that a few buttons are not responsive."
                                :closable = "false"
                                show-icon>
                        </el-alert>
                    </div>

                <el-card class="box-card">


                    <div slot="header" class="clearfix" >


                        <div>
                            <small  class="text-muted" style="font-size: 10px;vertical-align: text-top;">Tick-Tock</small> <sup><small class="text-muted">v0.1.2</small></sup>

                        </div>

                        <div style="text-align: center;">

                            <div>


                                <i class="fas fa-clock fa-6x fa-spin" style="color: red;"></i>
                            </div >
                            <h3>
                                Member login
                            </h3>
                        </div>


                        <!--<i class="fas fa-clock fa-8x" style="color: red;"></i>-->
                    </div>

                        <el-form :model="ruleForm2" status-icon :rules="rules2" ref="ruleForm2" label-width="100px" class="demo-ruleForm">
                            <el-form-item prop="email" label="Email">
                                <el-input v-model="ruleForm2.email"></el-input>
                            </el-form-item>
                            <el-form-item label="Password" prop="pass">
                                <el-input type="password" v-model="ruleForm2.pass" auto-complete="off"></el-input>
                            </el-form-item>
                            <el-form-item style="text-align: right;">

                                <el-button type="text"  @click="showForgotPassword('ruleForm2')"  round>Forgot the password?</el-button>
                                <el-button type="text" @click="showSignup()" round>Sign up</el-button>
                                <el-button type="success" @click="submitForm('ruleForm2')" round>Sign in</el-button>
                            </el-form-item>
                        </el-form>
            </el-card>
                </div>
                </el-col>
            </el-row>

        </div>

        <div v-if="signup == true">
            <router-view to="/signup"></router-view>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                login: true,
                signup: false,
                fullscreenLoading: false,
                ruleForm2: {
                    pass: '',
                    email:''
                },
                rules2: {
                    pass: [
                        { required: true, message: 'Password is required.', trigger: 'blur' }
                    ],
                    email:[
                        { required: true, message: 'Email is required.', trigger: 'blur' },
                        { type: 'email', message: 'Email format is invalid.', trigger: 'blur,change' }
                    ]
                }
            };
        },
        mounted(){
            this.$notify({
                title: 'Information',
                type:'info',
                message: 'Quick! Quick! Time is running!',
                position:'bottom-right'
            });
        },
        methods: {
            showSignup(){
              this.$router.push('/signup');
            },
            showForgotPassword(){
                this.$notify({
                    title: 'Warning',
                    type:'warning',
                    message: 'This function is not implemented. Please wait for site news.'
                });
            },
            submitForm(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        this.fullscreenLoading = true;
                        let data = {
                            email: this.ruleForm2.email,
                            password: this.ruleForm2.pass
                        };

                        axios.post('/api/login', data)
                                .then(({data}) => {
                            auth.login(data.token, data.user);
                        this.fullscreenLoading = false;
                        this.$router.push('/');
                    })
                    .catch(({response}) => {
                            this.$notify({
                            title: 'Error',
                            type:'error',
                            message: response.data.error
                        });
                            this.fullscreenLoading = false;
                    });
                    } else {
                        console.log('error submit!!');
                return false;
            }
            });
            }
        }
    }
</script>


<style>
    h3 {
        font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
    }
</style>