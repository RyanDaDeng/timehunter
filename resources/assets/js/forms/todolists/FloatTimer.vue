<template>

    <el-row v-if="hasRunningTimer== true" style="text-align: center;">
        <el-col >
            <el-card :body-style="{ padding: '0px' }">

                <el-popover
                        ref="popover1"
                        placement="right-start"
                        :title="title"
                        width="200"
                        trigger="hover"
                        :content="content">
                </el-popover>

                <div style="padding: 14px;" v-popover:popover1>
                    <i class="fas fa-clock fa-4x fa-spin" style="color: red;"></i>
                    <div class="bottom clearfix">
                        <div v-if="hasRunningTimer==true">
                            <div v-if="activeTimerString != 'Calculating...'">
                                <time class="time">
                                    {{ activeTimerString }}

                                </time>
                            </div>
                            <div v-else>
                                <i class="el-icon-loading"></i>
                            </div>

                        </div>

                    </div>
                    <el-row>
                        <!--<el-button type="text" circle><i class="fas fa-pause-circle fa-2x" style="color: darkgreen;"></i></el-button>-->
                        <el-button type="text" circle @click="stopTimerById(runningTimer.id)"><i class="fas fa-stop-circle fa-2x" style="color: orange;"></i></el-button>
                    </el-row>
                </div>
            </el-card>
        </el-col>
    </el-row>
</template>

<script>
    import moment from 'moment'
    export default {
        data: function () {
            return {
                title:'',
                content:'',
                timezone: auth.user.timezone,
                hasRunningTimer: false,
                runningTimer:{id:null,name:'',started_at:''},
                counter: {seconds: 0, timer: null,ticker:null},
                activeTimerString: 'Calculating...',
            }
        },
        mounted() {
            var app = this;
            Event.$on('newTaskStarted', (resp) => {
                clearInterval(app.counter.ticker);
            app.counter = { seconds: 0, timer: null };
            app.activeTimerString = 'Calculating...';
                app.runningTimer = resp.data.results;
            app.hasRunningTimer = true;
            app.startTimer(resp.data.results);
            app.title = resp.data.results.name;
            app.content = resp.data.results.description;
        });

            axios.get('/api/todolists/v1/runningtasktimer')
                    .then(function (resp) {
                        console.log(resp.data.results);
                        if( resp.data.results != null &&  resp.data.results != [] &&  resp.data.results !=''){
                            app.runningTimer = resp.data.results;
                            app.hasRunningTimer = true;
                            app.startTimer(resp.data.results);
                            app.title = resp.data.results.name;
                            app.content = resp.data.results.description;
                        }
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Could not load running timer");
                    });
        },
        filters: {
            moment: function (date) {
                return moment(date).format('hh:mm:ss A, MMMM Do YYYY');
            }
        },
        methods: {
            /**
             * Conditionally pads a number with "0"
             */
            _padNumber: number =>  (number > 9) ? number : "0" + number,

            /**
             * Splits seconds into hours, minutes, and seconds.
             */
            _readableTimeFromSeconds: function(seconds) {
                const hours = 3600 > seconds ? 0 : parseInt(seconds / 3600, 10)

                return {
                    hours: this._padNumber(hours),
                    seconds: this._padNumber(seconds % 60),
                    minutes: this._padNumber(parseInt(seconds / 60, 10) % 60),
                }
            },
            stopTimerById: function(timerId){
                var app = this;
                console.log(timerId)
                axios.post('/api/todolists/v1/timers/' + timerId + '/stop').then(function (resp) {
                    console.log('stopped');
                    app.hasRunningTimer = false;
//                    app.timers.push(resp.data);
                    clearInterval(app.counter.ticker);
                    app.counter = { seconds: 0, timer: null };
                    app.activeTimerString = 'Calculating...';
                    app.$message({
                        type: 'success',
                        message: resp.data.message
                    });
                }).catch(function (resp) {
                    console.log(resp);
                    app.$message({
                        type: 'error',
                        message: resp.data.message
                    });
                });
            },
            /**
             * Start counting the timer. Tick tock.
             */
            startTimer: function (timer) {
                let vm = this;
                let started = moment.utc(timer.started_at);
                vm.counter.timer = timer;
                vm.counter.seconds = parseInt(moment.duration(moment().diff(started)).asSeconds())

                vm.counter.ticker = setInterval(() => {
                    const time = vm._readableTimeFromSeconds(++vm.counter.seconds)
                    vm.activeTimerString = `${time.hours}:${time.minutes}:${time.seconds}`
            }, 1000)

                console.log(vm.counter.ticker)
            }
        }
    }
</script>
