<template>

    <el-container>
        <el-header style="text-align: left;">


            <el-alert
                    title="Dashboard - Not implemented yet. Please wait for site announcement. The following charts are not related to any data of your account."
                    type="error"
                    show-icon>
            </el-alert>
            <!--<monthly-income />-->
            <!--<pie-chart />-->



        </el-header>

        <el-main>


            <el-row :gutter="20">
                <el-col :span="12"><div class="grid-content bg-purple">

                    <el-card class="box-card gap-margin">
                        <i class="fa fa-calendar-check fa-4x"></i> 78 hours worked yesterday

                        <i class="fa fa-list-ol fa-4x"></i> 5 todos not completed from past

                        <i class="fa fa-check-circle fa-4x"></i> 81 todos done from past
                    </el-card>


                    <el-card class="box-card gap-margin">

                        <el-table
                                :data="tableData2"
                                >
                            <el-table-column
                                    prop="todo"
                                    label="Todo"
                                  >
                            </el-table-column>
                            <el-table-column
                                    prop="tag"
                                    label="Tag(s)"
                            >
                            </el-table-column>
                        </el-table>
                    </el-card>


                </div></el-col>

                <el-col :span="12"><div class="grid-content bg-purple">


                    <el-card class="box-card">
                        <bar-chart />
                    </el-card>


                </div></el-col>


            </el-row>


        </el-main>
    </el-container>




</template>


<script>
    import BarChart from '@/components/charts/BarChart.vue'
    import LineChart from '@/components/charts/LineChart.vue'
    import PieChart from '@/components/charts/PieChart.vue'
    export default {
        components: { BarChart,LineChart,PieChart },
        data: function () {

            return {
                tableData2: [{
                    todo: 'I need to sleep well......sfsdf..fd'
                }, {
                    todo: 'I need to sleep well......sfsdf..fd'
                }, {
                    todo: 'I need to sleep well......sfsdf..fd'
                }, {
                    todo: 'I need to sleep well......sfsdf..fd'
                }]
            };

        },
        mounted () {
        },
        methods: {

        }
    }
</script>



<style scoped>
    .gap-margin {
        margin-bottom: 40px;
    }
    .item {
        margin-top: 10px;
        margin-right: 40px;
    }
</style>