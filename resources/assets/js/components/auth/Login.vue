<template>


    <div>
            <el-row :gutter="24">
                <el-col :span="12" :offset="8"><div class="grid-content bg-purple">

                    <h1>Login</h1>

                    <p>
                        <label for="email">Email</label>

                        <input type="text" name="email" v-model="email">
                    </p>

                    <p>
                        <label for="password">Password</label>

                        <input type="password" name="password" v-model="password">
                    </p>

                    <el-button @click="login">Login</el-button>
                </div>
                </el-col>
            </el-row>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                activeIndex: '1',
                email: '',
                password: '',
            };
        },

        methods: {
            login() {
                let data = {
                    email: this.email,
                    password: this.password
                };

                axios.post('/api/login', data)
                        .then(({data}) => {
                    auth.login(data.token, data.user);

                this.$router.push('/dashboard');
            })
            .catch(({response}) => {
                    alert(response.data.message);
            });
            }
        }
    }
</script>