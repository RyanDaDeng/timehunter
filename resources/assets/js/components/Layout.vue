<template>
    <div>

        <div v-if="authenticated && user">
            <p>Hello, {{ user.name }}</p>

            <button  @click="logout">Logout</button>
        </div>

        <router-link to="/login" v-else>Login</router-link>

        <div style="margin-top: 2rem">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                authenticated: auth.check(),
                user: auth.user
            };
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
        methods: {
            logout() {
                var app = this;
                axios.post('/api/logout')
                        .then(function (resp) {
                            console.log(resp.data);
                            auth.logout();
                            app.$router.push('/login');
                        })
                        .catch(function (resp) {
                            console.log(resp);
                            alert("Could not logout");
                        });
            }
        }
    }
</script>