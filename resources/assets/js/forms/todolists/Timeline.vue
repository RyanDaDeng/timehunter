<template>

    <el-container>


        <el-main>

            <div v-for="v,k in allDoneTodos ">
                <timeline  >
                    <timeline-title>{{k}}</timeline-title>
                    <div v-for="t in v ">
                        <timeline-item color="#9dd8e0">{{t.time}}: {{t.name}}</timeline-item>
                        <!--<timeline-item :hollow="true">{{t.time}}</timeline-item>-->
                    </div>
                </timeline>
            </div>

        </el-main>
    </el-container>




</template>


<script>
    import { Timeline, TimelineItem, TimelineTitle } from 'vue-cute-timeline'

    export default {
        components: {
            Timeline,
            TimelineItem,
            TimelineTitle
        },
        data: function () {

            return {
                allDoneTodos:[],
            };

        },
        mounted() {
            this.getNotDoneTodos();
        },
        methods: {
            getNotDoneTodos(){
                var app=this;
                app.loading = true;
                api.get('/api/todolists/v1/timeline/alldone')
                        .then(function (resp) {

                            app.allDoneTodos = resp.data.results;
                            app.loading = false;
                        })
                        .catch(function (resp) {
                            console.log(resp);
                            app.$message({
                                type: 'error',
                                message: 'Not Todos cannot be retrieved.'
                            });
                            app.loading = false;
                        });

            }
        }
    }
</script>


