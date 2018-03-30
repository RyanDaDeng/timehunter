<template>


    <div v-loading.fullscreen.lock="fullscreenLoading">
        <el-row :gutter="24">
            <el-col :span="12" :offset="6"><div class="grid-content bg-purple">


            <el-card class="box-card">

                <div slot="header" class="clearfix" style="text-align: center;">

                    <h3>
                        Tick-Tock
                    </h3>
                    <small class="text-muted">v1.0.0</small>
                    <!--<i class="fas fa-clock fa-8x" style="color: red;"></i>-->
                </div>

                    <el-form :model="ruleForm2" status-icon :rules="rules2" ref="ruleForm2" label-width="100px" class="demo-ruleForm">
                        <el-form-item prop="email" label="Email">
                            <el-input v-model="ruleForm2.email"></el-input>
                        </el-form-item>
                        <el-form-item label="Password" prop="pass">
                            <el-input type="password" v-model="ruleForm2.pass" auto-complete="off"></el-input>
                        </el-form-item>
                        <el-form-item>
                            <el-button type="primary" @click="submitForm('ruleForm2')">Sign in</el-button>
                        </el-form-item>
                    </el-form>
        </el-card>
            </div>
            </el-col>
        </el-row>
    </div>
</template>

<script>
    export default {
        data() {
            return {
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
        methods: {
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