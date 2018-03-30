<template>

    <div>

        <el-header class="fixed-top">
            <el-menu :default-active="activeIndex" class="el-menu-demo" mode="horizontal" @select="handleSelect">

                <el-menu-item index="0" disabled><i class="fas fa-clock fa-2x fa-spin" style="color: red;"></i></el-menu-item>
                <el-menu-item index="1">Tick-Tock</el-menu-item>
                <el-menu-item index="2">About Me</el-menu-item>
                <el-menu-item index="3">Support Forum</el-menu-item>
                <!--<el-submenu index="4" :show-timeout=100>-->
                    <!--<template slot="title">Products</template>-->
                    <!--<el-menu-item index="4-1">Time Management</el-menu-item>-->
                <!--</el-submenu>-->


                <el-menu-item index="5" disabled>me@ryandeng.com</el-menu-item>

                <el-submenu v-if="authenticated && user != null" index="5" :show-timeout=100 style="float: right;">
                   <template slot="title"> ({{ user.timezone }})  {{ user.name }}</template>
                    <el-menu-item  index="usersetting" >User Setting</el-menu-item>
                    <el-menu-item  index="advancedsetting" >Advanced Setting</el-menu-item>
                    <el-menu-item v-loading.fullscreen.lock="fullscreenLoading" @click="logout" index="logout" >Logout</el-menu-item>
                </el-submenu>

            </el-menu>
        </el-header>
        <el-main class="container-gap" >
            <div v-if="activeIndex === '1'" >
                <div v-if="authenticated && user != null">
                    <AuthControl></AuthControl>
                </div>

                <Login v-else>Login</Login>
            </div>
            <div v-else>
                Not implemented.
            </div>
        </el-main>
    </div>
</template>

<script>
    import AuthControl from '@/forms/public/AuthControl.vue';
    import Login from '@/forms/public/Login.vue';
    export default {
        components: {
            AuthControl,
            Login
        },
        mounted() {
            Event.$on('userLoggedIn', () => {
                this.authenticated = true;
            this.user = auth.user;
        });

            Event.$on('userLoggedOut', () => {
                this.authenticated = false;
            this.user =null;
        });
        },
        data() {
            return {
                fullscreenLoading: false,
                activeIndex: '1',
                authenticated: auth.check(),
                user: auth.user
            };
        },
        methods: {
            logout() {
                var app = this;
                app.fullscreenLoading = true;
                axios.post('/api/logout')
                        .then(function (resp) {
                            console.log(resp.data);
                            auth.logout();
                            app.activeIndex = '1';
                            app.fullscreenLoading = false;
                        })
                        .catch(function (resp) {
                            console.log(resp);
                            app.fullscreenLoading = false;
                            alert("Could not logout");
                        });
            },
            handleSelect(key, keyPath) {
                this.activeIndex = key;
                if(key == 'logout'){
                    this.activeIndex = '1'
                }
                console.log(key)
            }
        }
    }
</script>

<style>
    .container-gap {
        margin-top: 60px;
    }
</style>