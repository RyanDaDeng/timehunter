<template>


    <el-container>

        <el-main>

            <div v-infinite-scroll="loadMore" infinite-scroll-disabled="busy" infinite-scroll-distance="2">

            <div v-for="k in timers" :key="k.id" class="text item">


                <el-card class="box-card card-gap">
                    <div slot="header" class="clearfix">
                        <span><b>{{k.date_name}}</b></span>
                        <p style="float: right; padding: 3px 0;" type="text">Total Time: {{k.total_seconds | hhmmss}}
                        </p>
                    </div>

                    <div v-for="b,index in k.timers" :key="b.id" class="text item">
                    <div>
                        <div class="text item">
                            <el-row :gutter="22">
                                <el-col :span="12">
                                    <div class="grid-content bg-purple">Task Name: {{b.name}}</div>
                                </el-col>
                                <el-col :span="3" :offset=2>
                                    <div class="grid-content bg-purple">{{b.started_at | hour}} - {{b.stopped_at
                                        |hour}}
                                    </div>
                                </el-col>
                                <el-col :span="3">
                                    <div class="grid-content bg-purple" style="float: right; padding: 3px 0"
                                         type="text">{{b.total_duration}}
                                    </div>
                                </el-col>
                                <el-col :span="4">
                                    <el-button style="float: right;" type="text" icon="el-icon-caret-right"></el-button>
                                    <el-button style="float: right;"  type="text" icon="el-icon-edit"></el-button>
                                    <el-button style="float: right; " type="text" icon="el-icon-delete"></el-button>
                               </el-col>
                            </el-row>
                        </div>
                    </div>
                        <div v-if="index < k.timers.length-1 "><hr></div>
                    </div>
                </el-card>

            </div>


            </div>

            <div v-if="loading == true && hasData == true" style="text-align: center;">
                <i  class="fa fa-spinner fa-4x fa-spin" style="color: grey;"></i>
            </div>
            <div v-else-if="hasData == false" style="text-align: center;">
                :( No more data.
            </div>
            <div v-else style="text-align: center;">
                <el-button @click="loadMore()">Load More</el-button>
            </div>
        </el-main>
    </el-container>


</template>

<script>
    import moment from 'moment';
    import infiniteScroll from 'vue-infinite-scroll';

    export default {
        directives:{
            infiniteScroll
        },
        data: function () {
            return {
                timers: [],
                list:[],
                limit:7,
                offset:0,
                busy: false,
                hasData: true,
                loading: false
            }
        },
        mounted() {

        },
        filters: {
            moment: function (date) {
                return moment(date).format('hh:mm:ss A, MMMM Do YYYY');
            },
            hour: function (date) {
                return moment(date).format('hh:mm:ss A');
            },
            hhmmss: function(secs) {
                var minutes = Math.floor(secs / 60);
                secs = secs % 60;
                var hours = Math.floor(minutes / 60)
                minutes = minutes % 60;
                return ("0" + hours).slice(-2) + ":" + ("0" + minutes).slice(-2) + ":" + ("0" + secs).slice(-2);
            },
        },
        methods: {
            startLoading: function(){

            },
            loadMore: function() {
                var app = this;

                app.loading = true;
//                setTimeout(() => {
                app.busy = true;


                    axios.get('/api/todolists/v1/timers', {
                            params: {
                                'limit': app.limit,
                                'offset': app.offset
                            }
                        })
                        .then(function (resp) {

                            if (resp.data.results.length>0) {
                                app.timers = app.timers.concat(resp.data.results);
                                console.log(1);
                            }else{
                                app.hasData = false;
                                app.busy = true;
                                console.log(2);
                            }
                            app.offset += app.limit;
                        })
                        .catch(function (resp) {
                            console.log(resp);
                            alert("Could not load timers");
                        });
                app.loading = false;
//            }, 2000);

            },

            deleteTimer(id, index) {
                if (confirm("Do you really want to delete it?")) {
                    var app = this;
                    axios.delete('/api/todolists/v1/timers/' + id)
                            .then(function (resp) {
                                app.timers.splice(index, 1);
                            })
                            .catch(function (resp) {
                                alert("Could not delete timers");
                            });
                }
            },
            stopTimerById: function (timerId) {
                var app = this;
                console.log(timerId)
                axios.post('/api/todolists/v1/timers/' + timerId + '/stop').then(function (resp) {
                    console.log('stopped');
                    app.hasRunningTimer = false;
                    app.timers.push(resp.data);
                    clearInterval(app.counter.ticker);
                    app.counter = {seconds: 0, timer: null};
                    app.activeTimerString = 'Calculating...';
                }).catch(function (resp) {
                    console.log(resp);
                    alert("Could not stop timer by timer id");
                });
            },
            /**
             * Create a new timer.
             */
            createTimer: function (taskId) {
                console.log(taskId);
                let vm = this;
                axios.post('/api/todolists/v1/tasks/' + taskId + '/start').then(function (resp) {
                    clearInterval(vm.counter.ticker);

                    // Reset the counter and timer string
                    vm.counter = {seconds: 0, timer: null};
                    vm.activeTimerString = 'Calculating...';

                    vm.startTimer(resp.data);
                    vm.runningTimer = resp.data;
                    vm.hasRunningTimer = true;
                }).catch(function (resp) {
                    alert("Could not start timer by task");
                });

            }
        }
    }
</script>


<style>
    .text {
        font-size: 13px;
    }

    .item {
        margin-bottom: 0px;
    }

    .card-gap {
        margin-bottom: 30px;
    }

    .clearfix:before,
    .clearfix:after {
        display: table;
        content: "";
    }

    .clearfix:after {
        clear: both
    }


</style>