<template>


    <div>
        <el-row :gutter="24">
            <el-col :span="20" :offset="2">
                <div class="grid-content bg-purple">


                    <el-card class="box-card">

                        <div slot="header" class="clearfix">


                            <div style="text-align: center;">

                                <h3>Version Information</h3>
                                <p>Tick-Tock is a product that allows you to track your tasks, todos and works easily.</p>
                            </div>

                            <!--<i class="fas fa-clock fa-8x" style="color: red;"></i>-->
                        </div>
                        <div>

                            <p><b style="color:blue;">v0.1.2</b> - 1st April 2018</p>

                            <ul>- Supported Task Deletion, Task Creation and Task Edition.</ul>
                            <ul> - Implemented Task table page.</ul>
                            <ul> - Added Timers list page.</ul>
                            <ul> - Added Timing toggle in nav bar.</ul>
                            <ul> - Added About Product information page.</ul>
                            <p><b style="color:blue;">v0.1.1</b> - 28th March 2018</p>

                            <ul> - Implemented pages for User Sign up and User Sign in.</ul>

                            <p><b style="color:blue;">v0.0.1</b>  - 18th March 2018</p>
                            <ul>- Added loading animation.</ul>
                            <ul>- Added top nav bar.</ul>
                            <ul>- Added spinner icon.</ul>



                        </div>

                    </el-card>
                </div>
            </el-col>
        </el-row>


    </div>
</template>

<script>

    export default {
        data() {
            return {};
        },
        mounted() {

        },
        methods: {}
    }
</script>


<style>
    h3 {
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
    };

</style>