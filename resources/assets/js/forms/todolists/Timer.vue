<template>


    <el-container>

        <el-main>

            <div v-infinite-scroll="loadMore" infinite-scroll-disabled="busy" infinite-scroll-distance="2">

            <div v-for="k in timers" :key="k.id" class="text item">


                <el-card class="box-card card-gap">
                    <div slot="header" class="clearfix">
                        <span><b>{{k.date_name | dateName}}</b></span>
                        <p style="float: right; padding: 3px 0;" type="text">Total Time: {{k.total_seconds | hhmmss}}
                        </p>
                    </div>

                    <div v-for="b,index in k.timers" :key="index" class="text item">
                    <div>
                        <div class="text item">
                            <el-row :gutter="22" type="flex" >
                                <el-col :span="10">
                                    <div class="grid-content bg-purple">{{b.name}}</div>
                                </el-col>
                                <el-col :span="5" :offset=2>
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
                                    <el-button-group>
                                        <el-button size="small" type="primary" icon="el-icon-edit" circle @click="handleEdit(index, b)"></el-button>
                                        <el-button size="small" type="danger" icon="el-icon-delete" circle  @click="handleDelete(index, b)"></el-button>
                                        <el-button size="small" type="warning" icon="el-icon-time" circle  @click="handleStart(index, b)"></el-button>
                                    </el-button-group>
                               </el-col>
                            </el-row>

                        </div>
                    </div>
                        <div><hr></div>
                    </div>
                </el-card>

            </div>


            </div>


            <el-dialog :title="editTodoTitle" :visible.sync="editFormVisible">
                <el-form :model="editForm" status-icon :rules="rules2" ref="editForm" label-width="100px" class="demo-ruleForm">
                    <el-form-item prop="name" label="Name" :label-width="formLabelWidth">
                        <el-input v-model="editForm.name" auto-complete="off"></el-input>
                    </el-form-item>
                    <el-form-item label="Started At" prop="started_at" :label-width="formLabelWidth">
                        <el-col>
                            <el-date-picker type="datetime"  placeholder="Select Date Time" v-model="editForm.started_at"></el-date-picker>
                        </el-col>
                    </el-form-item>

                    <el-form-item label="Stopped At" prop="stopped_at" :label-width="formLabelWidth">
                        <el-col>
                            <el-date-picker type="datetime"  placeholder="Select Date Time" v-model="editForm.stopped_at"></el-date-picker>
                        </el-col>
                    </el-form-item>

                </el-form>
                <div slot="footer" class="dialog-footer">
                    <el-button @click="editFormVisible = false">Cancel</el-button>
                    <el-button type="primary" @click="submitEditForm('editForm')" :loading="editLoading">Submit</el-button>
                </div>
            </el-dialog>



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
                editForm:{},
                editLoading: false,
                editFormVisible:false,
                formLabelWidth: '120px',
                editTodoTitle: '',
                dateIndexMap:{},
                timers: {},
                timerIdToDateMap:{},
                temps:[],
                list:[],
                limit:7,
                offset:0,
                busy: false,
                hasData: true,
                loading: false,
                rules2: {
                    due_date_time: [
                        { required: true, message: 'Due Date Time is required.', trigger: 'blur' }
                    ],
                    name:[
                        { required: true, message: 'Name is required.', trigger: 'blur' }
                    ]
                }
            }
        },
        mounted() {
            Event.$on('timerStopped', (temp) => {
                console.log('on');
                console.log(temp);
                this.normaliseData([temp]);
//          this.timers =[];
//            this.limit = 7;
//            this.offset =0;
//            var app = this;
//            if(this.$route.name == 'Timers'){
//                app.busy = false;
//            }
        });

        },
        filters: {
            dateName: function (date) {
                return moment(date).format('MMMM Do YYYY');
            },
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
            handleEdit(index, row) {
                //console.log(index, row);
                this.editLoading = false;
                this.editFormVisible = false;
                this.editTodoTitle = 'Edit '+'#'+row.id +' todo: '+row.name;
                this.editFormVisible = true;
                this.editForm = JSON.parse(JSON.stringify(row));
//                this.editForm.due_date_time = new Date(row.due_date_time);
            },
            submitEditForm(formName) {
                this.editLoading = true;
                console.log(this.editForm);
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        let data = this.editForm;

                        axios.put('/api/todolists/v1/timers/'+this.editForm.id,data)
                                .then(response => {
                            console.log(response.data.results);
//                            this.todos[this.editForm.tableIndex] = response.data.results;

                        this.$message({
                            type: 'success',
                            message: response.data.message
                        });
                        this.editFormVisible = false;

                        this.normaliseData([response.data.results]);
//                        this.getTodos();
                    })
                    .catch(error => {
                            this.$message({
                            type: 'error',
                            message: error.response.data.message
                        });
                    });

                        this.$refs[formName].clearValidate();
                    } else {
                        console.log('error submit!!');
                return false;
            }
            });
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
                                app.normaliseData(resp.data.results);
//                                app.normaliseData2(app.temps)
//                                console.log(app.timerIdToDateMap);
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
            handleDelete(index, row) {
                console.log(index, row);
                this.$confirm('Are you sure you want to delete this timer?', 'Delete a timer', {
                    confirmButtonText: 'Confirm',
                    cancelButtonText: 'Cancel',
                    type: 'warning',
                    center: true
                }).then(() => {

                    axios.delete('/api/todolists/v1/timers/' + row.id)
                        .then(response => {
//                    this.tasks.splice(index, 1);
                    this.removeData(row.id)
                this.$message({
                    type: 'success',
                    message: response.data.message
                });
            })
            .catch(error => {
                    this.$message({
                    type: 'error',
                    message: error.response.data.message
                });
            });


            }).catch(() => {
                    this.$message({
                    type: 'info',
                    message: 'Action Cancelled'
                });
            });
            },

            removeData(id){
                var tempData={};
                var tempMap = {};
                tempData = JSON.parse(JSON.stringify(this.timers));
                tempMap = JSON.parse(JSON.stringify(this.timerIdToDateMap));

                var dateToRemove = tempMap[id];

                var totalSeconds = tempData[dateToRemove].total_seconds;
                var oldRowSeconds = tempData[dateToRemove].timers[id].total_seconds;
                tempData[dateToRemove].total_seconds = totalSeconds - oldRowSeconds;
                delete tempData[dateToRemove].timers[id];
                delete tempMap[id];

                if(Object.keys(tempData[dateToRemove].timers).length === 0){
                    delete tempData[dateToRemove];
                }

                this.timers = this.sortKeys(tempData);
                this.timerIdToDateMap = tempMap;

            },
            normaliseData(temps){

                var tempData={};
                var tempMap = {};
                tempData = JSON.parse(JSON.stringify(this.timers));
                tempMap = JSON.parse(JSON.stringify(this.timerIdToDateMap));
                for(var k in temps) {
                    var temp = temps[k];
                    if (!(temp.date in tempData)) {
                        tempData[temp.date] = {
                            'total_seconds': 0,
                            'timers': {}
                        };
                    }

                    var beforeDate = tempMap[temp.id];
                    var newDate = temp.date;

                    // remove

                    if (typeof beforeDate !== 'undefined' && beforeDate != newDate) {
                        var totalSeconds = tempData[beforeDate].total_seconds;
                        var oldRowSeconds = tempData[beforeDate].timers[temp.id].total_seconds;
                        tempData[beforeDate].total_seconds = totalSeconds - oldRowSeconds;
                        delete tempData[beforeDate].timers[temp.id];
//                        this.removeData(temp.id);

                        if(Object.keys(tempData[beforeDate].timers).length === 0){
                            delete tempData[beforeDate];
                        }
                    }


                    if (temp.id in tempData[temp.date].timers) {
                        var totalSeconds = tempData[temp.date].total_seconds;
                        var oldRowSeconds = tempData[temp.date].timers[temp.id].total_seconds;
                        tempData[temp.date].total_seconds = totalSeconds - oldRowSeconds + temp.total_seconds;
                        tempData[temp.date].date_name = temp.date;
                        tempData[temp.date].timers[temp.id] = temp;
                    } else {
                        tempData[temp.date].date_name = temp.date;
                        tempData[temp.date].total_seconds += temp.total_seconds;
                        tempData[temp.date].timers[temp.id] = temp;
                    }



                    tempMap[temp.id] = temp.date;
                }

                this.timers = this.sortKeys(tempData);
                this.timerIdToDateMap = tempMap;
            },
            sortKeys(obj){
                return Object.keys(obj).sort((a,b) => a < b).reduce((result, key) => {
                    result[key] = obj[key];
                return result;
            }, {});
            },
            normaliseData2(temps){

                console.log(1)
                var tempData = {};
                for(var k in temps){

                    if( !(temps[k].date in tempData)){
                        tempData[temps[k].date] = {
                            'total_seconds': 0,
                            'timers':{}
                        };
                    }
                    tempData[temps[k].date].date_name = temps[k].date;
                    tempData[temps[k].date].total_seconds += temps[k].total_seconds;
                    tempData[temps[k].date].timers[temps[k].id] = temps[k];
//                    this.timers.push({
//
//                    });

                }
//                for(var c in tempData){
//                    this.timers.push(tempData[c])
//                }

                this.timers = tempData;

                console.log(this.timers);
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
            handleStart(index, row) {
                console.log(index, row);
                this.$confirm('Are you sure you want to start this todo?', 'Time a todo', {
                    confirmButtonText: 'Confirm',
                    cancelButtonText: 'Cancel',
                    type: 'warning',
                    center: true
                }).then(() => {


                    axios.post('/api/todolists/v1/timers/' + row.id + '/start')
                        .then(response => {
                    Event.$emit('newTaskStarted',response);

                this.$message({
                    type: 'success',
                    message: response.data.message
                });
            })
            .catch(error => {
                    this.$message({
                    type: 'error',
                    message: error.response.data.message ?error.response.data.message : 'Internal System Error. Please contact adminstrator.'
                });
            });


            }).catch(() => {
                    this.$message({
                    type: 'info',
                    message: 'Action Cancelled'
                });
            });
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