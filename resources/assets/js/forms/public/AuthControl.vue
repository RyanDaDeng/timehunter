<template>
    <div>

        <el-container style="height: 600px; border: 1px solid #eee">

            <el-aside width="200px" >
                <FloatTimer></FloatTimer>
                <el-menu
                        :default-active=activeIndex
                        class="el-menu-vertical-demo"
                        @select="handleSelect"
                        @open="handleOpen"
                        @close="handleClose">

                    <el-menu-item index="Dashboard">
                        <i class="fab fa-fort-awesome"></i>

                        <i class="fas fa-home fa-lg" ></i>
                        <span slot="title">&nbsp;&nbsp;&nbsp;Dashboard</span>
                    </el-menu-item>


                    <el-menu-item index="Timers">
                        <i class="fas fa-clock fa-lg" ></i>
                        <span slot="title">&nbsp;&nbsp;&nbsp;Timers</span>
                    </el-menu-item>



                    <el-menu-item index="Tasks">
                        <i class="fas fa-list-ol fa-lg"></i>
                        <span slot="title">&nbsp;&nbsp;&nbsp;Tasks</span>
                    </el-menu-item>
                    <el-menu-item index="Reports">
                        <i class="fas fa-chart-bar fa-lg"></i>
                        <span slot="title">&nbsp;&nbsp;&nbsp;Reports</span>
                    </el-menu-item>
                </el-menu>
            </el-aside>

            <router-view ></router-view>

        </el-container>

        </div>

</template>

<script>
    import FloatTimer from '@/forms/todolists/FloatTimer.vue';

    export default {
        components: {
            FloatTimer
        },
        data() {
            return {
                activeIndex:'dashboard'
            };
        },
        mounted(){
            this.getRouteName();
        },
        methods: {
            handleOpen(key, keyPath) {
                console.log(key, keyPath);
            },
            handleClose(key, keyPath) {
                console.log(key, keyPath);
            },
            handleSelect(key, keyPath) {
                console.log(key, keyPath);
                this.activeIndex = key;

                switch(this.activeIndex){
                    case 'Timers':
                        this.$router.push('/timers');
                        break;
                    case 'Tasks':
                        this.$router.push('/tasks');
                        break;
                    case 'Dashboard':
                        this.$router.push('/dashboard');
                        break;
                    case 'Reports':
                        this.$router.push('/reports');
                        break;
                    default:
                        break;
                }

            },
            getRouteName(){
                switch(this.$route.name){
                    case 'Tasks':
                        this.activeIndex = 'Tasks';
                        break;
                    case 'Timers':
                        this.activeIndex = 'Timers';
                        break;
                    case 'Dashboard':
                        this.activeIndex = 'Dashboard';
                        break;
                    case 'Reports':
                        this.activeIndex = 'Reports';
                        break;
                    default:
                        break;
                }
            }
        }
    }
</script>

