<template>

    <div class="yess">


            <vue-draggable-resizable >

    <div v-if="hasRunningTimer== true">
        <el-dialog
                title="Task Description"
                :visible.sync="centerDialogVisible"
                width="30%"
                center>
            <span><p>Name: {{runningTimerDetails.name}}</p></span>
            <span><p>Description: {{runningTimerDetails.description}}</p></span>
  <span slot="footer" class="dialog-footer">
    <el-button type="primary" @click="centerDialogVisible = false">Close</el-button>
  </span>
        </el-dialog>

    <el-row  style="text-align: center;">
        <el-col >
            <el-card  :body-style="{ padding: '0px' }">


                <div style="padding: 14px;">


                    <div><i class="fas fa-clock fa-4x fa-spin" style="color: red;"></i></div>
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
                        <el-button type="text" circle @click="centerDialogVisible = true"><i class="fas fa-info-circle fa-2x" style="color: cadetblue;"></i></el-button>
                        <el-button type="text" circle @click="stopTimerById(runningTimer.id)"><i class="fas fa-stop-circle fa-2x" style="color: orange;"></i></el-button>
                    </el-row>
                </div>
            </el-card>
        </el-col>
    </el-row>
    </div>

    <div v-else>


        <el-row  style="text-align: center;">
            <el-col >
                <el-card :body-style="{ padding: '0px' }">



                    <div style="padding: 14px;">
                        <el-row disabled><i class="fas fa-clock  fa-4x " style="color: darkgray;"></i></el-row>

                        <div class="bottom clearfix">
                                No running timer. :(

                        </div>
                        <el-row>
                            <!--<el-button type="text" circle><i class="fas fa-pause-circle fa-2x" style="color: darkgreen;"></i></el-button>-->
                      </el-row>
                    </div>
                </el-card>
            </el-col>
        </el-row>




    </div>
            </vue-draggable-resizable>

    </div>
</template>

<script>
    import moment from 'moment'
    import VueDraggableResizable from 'vue-draggable-resizable'
    export default {
        data: function () {
            return {
                centerDialogVisible: false,
                runningTimerDetails: {},
                timezone: auth.user.timezone,
                hasRunningTimer: false,
                runningTimer:{id:null,name:'',started_at:''},
                counter: {seconds: 0, timer: null,ticker:null},
                activeTimerString: 'Calculating...',
                width: 0,
                height: 0,
                x: 0,
                y: 0
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
            app.runningTimerDetails = resp.data.results;
        });


            axios.get('/api/todolists/v1/runningtasktimer')
                    .then(function (resp) {
                        console.log(resp.data.results);
                        if( resp.data.results != null &&  resp.data.results != [] &&  resp.data.results !=''){
                            app.runningTimer = resp.data.results;
                            app.hasRunningTimer = true;
                            app.startTimer(resp.data.results);
                            app.runningTimerDetails = resp.data.results;
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
            onResize: function (x, y, width, height) {
                this.x = x
                this.y = y
                this.width = width
                this.height = height
            },
            onDrag: function (x, y) {
                this.x = x
                this.y = y
            },
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

                    console.log('sss');
                    console.log(resp.data.results);
                    console.log('ssss');
                    Event.$emit('timerStopped',resp.data.results);

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


<style>
    .yess{
        position:fixed;z-index:122222000;overflow: visible;
        left:0px;
        bottom:150px;
    }
</style>