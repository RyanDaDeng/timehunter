<template>


    <div v-loading.fullscreen.lock="fullscreenLoading">
        <el-row :gutter="24">
            <el-col :span="12" :offset="6"><div class="grid-content bg-purple">


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
                            Sign up
                        </h3>
                    </div>


                    <!--<i class="fas fa-clock fa-8x" style="color: red;"></i>-->
                </div>

                    <el-form :model="ruleForm2" status-icon :rules="rules2" ref="ruleForm2" label-width="150px"  class="demo-ruleForm" size="medium">
                        <el-form-item prop="email" label="Email">
                            <el-input v-model="ruleForm2.email" placeholder="Please enter your email address."></el-input>
                        </el-form-item>
                        <el-form-item label="Password" prop="pass">
                            <el-input type="password" v-model="ruleForm2.pass" auto-complete="off" placeholder="Please enter your password."></el-input>
                        </el-form-item>
                        <el-form-item label="Confirm Password" prop="checkPass">
                            <el-input type="password" v-model="ruleForm2.checkPass" placeholder="Please type your password again." auto-complete="off"></el-input>
                        </el-form-item>
                        <el-form-item label="Timezone" prop="timezone"  >
                            <el-select filterable v-model="ruleForm2.timezone" placeholder="Please enter your local timezone.">

                                <el-option
                                        v-for="item in timezones"
                                        :label="item"
                                        :key="item"
                                        :value="item">
                                </el-option>


                            </el-select>

                        </el-form-item>
                        <el-form-item style="text-align: right;">
                            <el-button type="text" @click="showSignin();" round>Sign in now</el-button>
                            <el-button type="success" @click="submitForm('ruleForm2')" round>Register</el-button>
                        </el-form-item>
                    </el-form>


        </el-card>
            </div>
            </el-col>
        </el-row>


    </div>
</template>

<script>
    import momentTimezone from 'moment-timezone';
    export default {
        data() {
            var validatePass = (rule, value, callback) => {
                if (this.ruleForm2.checkPass !== '') {
                    this.$refs.ruleForm2.validateField('checkPass');
                }
                callback();

            };
            var validatePass2 = (rule, value, callback) => {
               if (value !== this.ruleForm2.pass) {
                    callback(new Error('Password does not match the confirm password.'));
                } else {
                    callback();
                }
            };
            return {
                timezones: [],
                fullscreenLoading: false,
                ruleForm2: {
                    pass: '',
                    checkPass: '',
                    email:'',
                    timezone:''
                },
                rules2: {
                    checkPass: [
                        { required: true, message: 'Confirm Password is required.', trigger: 'blur' },
                        { validator: validatePass2, trigger: 'blur' }
                    ],
                    pass: [
                        { required: true, message: 'Password is required.', trigger: 'blur' },
                        { validator: validatePass, trigger: 'blur' }
                    ],
                    timezone: [
                        { required: true, message: 'Timezone is required.', trigger: 'blur' }
                    ],
                    email:[
                        { required: true, message: 'Email is required.', trigger: 'blur' },
                        { type: 'email', message: 'Email format is invalid.', trigger: 'blur,change' }
                    ]
                }
            };
        },
        mounted() {
            this.getTimezones();
        },
        methods: {
            getTimezones(){
                this.timezones =  momentTimezone.tz.names();
            },
            showSignin(){
                this.$router.push('/signin');
            },
            submitForm(formName) {

                var app= this;
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                     //   this.fullscreenLoading = true;
                        let data = {
                            email: this.ruleForm2.email,
                            password: this.ruleForm2.pass,
                            checkPass: this.ruleForm2.checkPass,
                            timezone:this.ruleForm2.timezone,
                        };

                        app.fullscreenLoading = true;
                        axios.post('/api/register', data)
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