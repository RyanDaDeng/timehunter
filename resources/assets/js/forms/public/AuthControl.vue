<template>
    <div>

        <el-container style="height: 700px;">

            <el-aside width="200px">
                <FloatTimer></FloatTimer>
                <el-menu
                        :default-active=activeIndex
                        class="el-menu-vertical-demo"
                        @select="handleSelect"
                        @open="handleOpen"
                        @close="handleClose"

                >

                    <el-menu-item index="Dashboard">
                        <i class="fa fa-home fa-lg"></i>
                        <span slot="title">&nbsp;&nbsp;&nbsp;Dashboard</span>
                    </el-menu-item>


                    <el-menu-item index="Timers">
                        <i class="far fa-clock fa-lg"></i>
                        <span slot="title">&nbsp;&nbsp;&nbsp;Timers</span>
                    </el-menu-item>


                    <el-menu-item index="Tasks">
                        <i class="fas fa-tasks fa-lg"></i>
                        <span slot="title">&nbsp;&nbsp;&nbsp;Tasks</span>
                    </el-menu-item>


                    <el-submenu index="Todos">
                        <template slot="title">
                            <i class="far fa-calendar-check fa-lg"></i>
                            <span>&nbsp;&nbsp;&nbsp;Todos</span>
                        </template>
                        <el-menu-item-group>
                            <el-menu-item index="TodosInbox">Inbox</el-menu-item>
                            <el-menu-item index="TodosToday">Today</el-menu-item>
                            <el-menu-item index="calendar">Calendar</el-menu-item>
                        </el-menu-item-group>

                    </el-submenu>

                    <el-menu-item index="Projects">
                        <i class="far fa-folder-open fa-lg"></i>
                        <span slot="title">&nbsp;&nbsp;&nbsp;Projects</span>
                    </el-menu-item>

                    <el-menu-item index="Reports">
                        <i class="fas fa-chart-bar fa-lg"></i>
                        <span slot="title">&nbsp;&nbsp;&nbsp;Reports</span>
                    </el-menu-item>
                </el-menu>
            </el-aside>

            <router-view></router-view>

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
                activeIndex: 'dashboard'
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

                switch (this.activeIndex) {
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
                    case 'Todos':
                        this.$router.push('/todos');
                        break;
                    case 'Projects':
                        this.$router.push('/projects');
                        break;
                    case 'TodosInbox':
                        this.$router.push('/todos/inbox');
                        break;
                    case 'TodosToday':
                        this.$router.push('/todos/today');
                        break;
                    default:
                        break;
                }

            },
            getRouteName(){
                switch (this.$route.name) {
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
                    case 'TodosInbox':
                        this.activeIndex = 'TodosInbox';
                        break;
                    case 'TodosToday':
                        this.activeIndex = 'TodosToday';
                        break;
                    case 'Projects':
                        this.activeIndex = 'Projects';
                        break;
                    default:
                        break;
                }
            }
        }
    }
</script>

