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

                    <el-menu-item index="1">
                        <i class="fas fa-clock fa-lg" ></i>
                        <span slot="title">&nbsp;&nbsp;&nbsp;Timer</span>
                    </el-menu-item>



                    <el-menu-item index="2">
                        <i class="fas fa-list-ol fa-lg"></i>
                        <span slot="title">&nbsp;&nbsp;&nbsp;Tasks</span>
                    </el-menu-item>
                    <el-menu-item index="3">
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
                activeIndex:'1'
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
                    case '1':
                        this.$router.push('/timers');
                        break;
                    case '2':
                        this.$router.push('/tasks');
                        break;
                    default:
                        break;
                }

            },
            getRouteName(){
                switch(this.$route.name){
                    case 'Task':
                        this.activeIndex = '2';
                        break;
                    case 'Timer':
                        this.activeIndex = '1';
                        break;
                    default:
                        break;
                }
            }
        }
    }
</script>

