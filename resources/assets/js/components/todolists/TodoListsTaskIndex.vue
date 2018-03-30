<template>
    <div>
        <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
            <router-link :to="{name: 'TodoListsTaskCreate'}" class="btn btn-success">Create new task</router-link>

            <div class="btn-group" role="group">
                <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Reports
                </button>
                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                    <router-link class="dropdown-item" :to="{name: 'TodoListsTaskCreate'}" >Summary Report</router-link>
                </div>
            </div>
        </div>
        <hr>

        <div class="fixed-bottom">
            <div v-if="hasRunningTimer == true" class="card-body">
                <table class="table table-striped table-condensed table-bordered">
                    <tbody>
                    <tr>
                        <td>{{ runningTimer.name }}</td>
                        <td>{{ activeTimerString }}</td>
                        <td width="100"><button class="btn btn-default btn-primary pull-left"  @click="stopTimerById(runningTimer.id)">
                            Stop <i class="fas fa-stop-circle"></i>
                        </button></td>

                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card ">

            <div class="card-header">
                Running Timer
            </div>

            <div v-if="hasRunningTimer == true" class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Task Name</th>
                        <th>Start From</th>
                        <th>Timer</th>
                        <th width="100">Action(s)</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{ runningTimer.name }}</td>
                        <td>{{ runningTimer.started_at | moment}}</td>
                        <td>{{ activeTimerString }}</td>
                       <td><button class="btn btn-default btn-primary pull-left"  @click="stopTimerById(runningTimer.id)">
                           Stop <i class="fas fa-stop-circle"></i>
                       </button></td>

                    </tr>
                    </tbody>
                </table>
            </div>
            <div v-else>
                You have no running task.
            </div>
        </div>
        <hr>
        <div class="card">

            <div class="card-header">
                Today's Report
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Started At</th>
                        <th>Stopped At</th>
                        <th>Total Duration</th>
                        <th width="100">Action(s)</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="timer, index in timers">
                        <td>{{ timer.name }}</td>
                        <td>{{ timer.started_at | moment}}</td>
                        <td>{{ timer.stopped_at | moment}}</td>
                        <td>{{ timer.total_duration }}</td>
                        <td>
                            <router-link :to="{name: 'TodoListsTimerEdit', params: {id: timer.id}}" class="btn btn-info">
                                Edit
                            </router-link>
                            <a href="#"
                               class="btn btn-xs btn-danger"
                               v-on:click="deleteTimer(timer.id, index)">
                                Delete
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>


            </div>
        </div>
        <hr>
        <div class="card">

        <div class="card-header">
            Tasks list
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th width="100">Action(s)</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="task, index in tasks">
                    <td>{{ task.name }}</td>
                    <td>{{ task.description }}</td>
                    <td>
                        <router-link :to="{name: 'TodoListsTaskEdit', params: {id: task.id}}" class="btn btn-info">
                            Edit
                        </router-link>
                        <a href="#"
                           class="btn btn-xs btn-danger"
                           v-on:click="deleteEntry(task.id, index)">
                            Delete
                        </a>
                        <button class="btn btn-default btn-primary pull-left"  data-toggle="modal" data-target="#timerCreate"  @click="selectedTask = task.id">
                            Start <i class="fas fa-arrow-circle-right"></i>

                        </button>
                    </td>
                </tr>
                </tbody>
            </table>

            <div id="timerCreate" class="modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Start Task</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <label for="example-datetime-local-input" class="col-2 col-form-label">Date</label>
                                <div class="col-10">
                                    <input class="form-control" type="datetime-local" value="2011-08-19T13:45:00" id="example-datetime-local-input">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button data-dismiss="modal" class="btn btn-primary"  @click="createTimer(selectedTask)" type="submit" >Start</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>
</template>

<script>
    import moment from 'moment'
    export default {
        data: function () {
            return {
                tasks: [],
                timers: [],
                hasRunningTimer: false,
                runningTimer:{name:'',started_at:''},
                counter: {seconds: 0, timer: null},
                activeTimerString: 'Calculating...',
            }
        },
        mounted() {
            var app = this;
            axios.get('/api/todolists/v1/tasks')
                    .then(function (resp) {
                        app.tasks = resp.data.results;
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Could not load tasks");
                    });
            axios.get('/api/todolists/v1/timers')
                    .then(function (resp) {
                        app.timers = resp.data;
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Could not load timers");
                    });
            axios.get('/api/todolists/v1/runningtasktimer')
                    .then(function (resp) {
                        console.log(resp.data);
                        if( resp.data != null &&  resp.data != [] &&  resp.data !=''){
                            app.runningTimer = resp.data;
                            app.hasRunningTimer = true;
                            app.startTimer(resp.data)
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
            _padNumber: number =>  (number > 9 || number === 0) ? number : "0" + number,

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
            deleteEntry(id, index) {
                if (confirm("Do you really want to delete it?")) {
                    var app = this;
                    axios.delete('/api/todolists/v1/tasks/' + id)
                            .then(function (resp) {
                                app.tasks.splice(index, 1);
                            })
                            .catch(function (resp) {
                                alert("Could not delete tasks");
                            });
                }
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
            stopTimerById: function(timerId){
                var app = this;
                console.log(timerId)
                axios.post('/api/todolists/v1/timers/' + timerId + '/stop').then(function (resp) {
                    console.log('stopped');
                    app.hasRunningTimer = false;
                    app.timers.push(resp.data);
                    clearInterval(app.counter.ticker);
                    app.counter = { seconds: 0, timer: null };
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
                    vm.counter = { seconds: 0, timer: null };
                    vm.activeTimerString = 'Calculating...';

                    vm.startTimer(resp.data);
                    vm.runningTimer = resp.data;
                    vm.hasRunningTimer = true;
                }).catch(function (resp) {
                    alert("Could not start timer by task");
                });

            },
            /**
             * Start counting the timer. Tick tock.
             */
            startTimer: function (timer) {
                let vm = this;
                let started = moment(timer.started_at);
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
