<template>

    <el-container>
        <!--<el-header >-->
            <!--<span><h2>Todo Inbox</h2></span>-->
            <!--<small>&nbsp;&nbsp;&nbsp;- &nbsp;&nbsp;&nbsp;A collection of all your todos.</small>-->
        <!--</el-header>-->

        <el-main >
            <el-button type="success" round @click="handleCreate();">Create a new todo for today</el-button>
            <el-table v-loading="loading"
                      :data="todos"
                      style="width: 100%"
                      :row-class-name="tableRowClassName"
            >

                <el-table-column
                        label="Name"
                >
                    <template slot-scope="scope">
                        <i class="el-icon-time"></i>
                        <span style="margin-left: 10px">{{ scope.row.name }}</span>
                    </template>
                </el-table-column>
                <el-table-column
                        label="Description"
                >
                    <template slot-scope="scope">
                        <i class="el-icon-time"></i>
                        <span style="margin-left: 10px">{{ scope.row.description }}</span>
                    </template>
                </el-table-column>
                <el-table-column
                        label="Notes"
                >
                    <template slot-scope="scope">
                        <span style="margin-left: 10px">{{ scope.row.notes }}</span>
                    </template>

                </el-table-column>

                <el-table-column
                        label="Due Date Time"
                >
                    <template slot-scope="scope">
                        <span style="margin-left: 10px">{{ scope.row.due_date_time |moment}}</span>
                    </template>

                </el-table-column>

                <el-table-column
                        label="Frequency"
                >
                    <template slot-scope="scope">
                        <el-tag  v-if="scope.row.project!=null" size="mini"  type="warning">{{  scope.row.project.name}}</el-tag>
                        <el-tag v-if="scope.row.frequency!=null" size="mini" type="info">{{ scope.row.frequency }}</el-tag>
                        <el-tag v-if="scope.row.is_done != 1" size="mini" type="danger">NOT DONE</el-tag>
                        <el-tag v-else type="success">DONE</el-tag>
                    </template>

                </el-table-column>



                <el-table-column fixed="right" label="Actions" width="180">
                    <template slot-scope="scope">
                        <el-button-group>
                        <el-button size="small" type="primary" icon="el-icon-edit" circle @click="handleEdit(scope.$index, scope.row)"></el-button>
                        <el-button size="small" type="danger" icon="el-icon-delete" circle  @click="handleDelete(scope.$index, scope.row)"></el-button>
                        <el-button size="small" type="success" icon="el-icon-check" circle  @click="handleDone(scope.$index, scope.row)"></el-button>
                      <el-button size="small" type="warning" icon="el-icon-time" circle  @click="handleStart(scope.$index, scope.row)"></el-button>
                            </el-button-group>
                    </template>
                </el-table-column>
            </el-table>


            <el-dialog  title="Create a new todo" :visible.sync="dialogFormVisible">
                <el-form :model="form" status-icon :rules="rules2" ref="form" label-width="100px" class="demo-ruleForm">
                    <el-form-item prop="name" label="Name" :label-width="formLabelWidth">
                        <el-input v-model="form.name" auto-complete="off"></el-input>
                    </el-form-item>
                    <el-form-item label="Due Date Time" prop="due_date_time" :label-width="formLabelWidth">
                        <el-col>
                            <el-date-picker type="datetime" format="yyyy-MM-dd HH:mm:ss" placeholder="Select Date Time" v-model="form.due_date_time"></el-date-picker>
                        </el-col>
                    </el-form-item>
                    <el-form-item prop="description" label="Description" :label-width="formLabelWidth">
                        <el-input v-model="form.description" auto-complete="off"></el-input>
                    </el-form-item>
                    <el-form-item prop="notes" label="Notes" :label-width="formLabelWidth">
                        <el-input v-model="form.notes" auto-complete="off"></el-input>
                    </el-form-item>

                    <el-form-item label="Project" prop="project" :label-width="formLabelWidth" >
                        <el-select filterable v-model="form.project_id" placeholder="Please select your project.">

                            <el-option
                                    v-for="item in projects"
                                    :label="item.name"
                                    :key="item.id"
                                    :value="item.id">
                            </el-option>

                        </el-select>
                    </el-form-item>

                    <el-form-item label="Frequency" :label-width="formLabelWidth">
                        <el-radio-group v-model="form.frequency" size="medium">
                            <el-radio border label="every day"  auto-complete="off"></el-radio>
                            <el-radio border label="No recurrence"  auto-complete="off"></el-radio>
                        </el-radio-group>
                    </el-form-item>

                </el-form>
                <div slot="footer" class="dialog-footer">
                    <el-button @click="dialogFormVisible = false">Cancel</el-button>
                    <el-button type="primary" @click="submitForm('form')" :loading="createLoading">Submit</el-button>
                </div>
            </el-dialog>


            <el-dialog :title="editTodoTitle" :visible.sync="editFormVisible">
                <el-form :model="editForm" status-icon :rules="rules2" ref="editForm" label-width="100px" class="demo-ruleForm">
                    <el-form-item prop="name" label="Name" :label-width="formLabelWidth">
                        <el-input v-model="editForm.name" auto-complete="off"></el-input>
                    </el-form-item>
                    <el-form-item label="Due Date Time" prop="due_date_time" :label-width="formLabelWidth">
                        <el-col>
                            <el-date-picker type="datetime"  placeholder="Select Date Time" v-model="editForm.due_date_time"></el-date-picker>
                        </el-col>
                    </el-form-item>
                    <el-form-item prop="description" label="Description" :label-width="formLabelWidth">
                        <el-input v-model="editForm.description" auto-complete="off"></el-input>
                    </el-form-item>
                    <el-form-item prop="notes" label="Notes" :label-width="formLabelWidth">
                        <el-input v-model="editForm.notes" auto-complete="off"></el-input>
                    </el-form-item>

                    <el-form-item label="Project" prop="project" :label-width="formLabelWidth" >
                        <el-select filterable v-model="editForm.project_id" placeholder="Please select your project.">

                            <el-option
                                    v-for="item in projects"
                                    :label="item.name"
                                    :key="item.id"
                                    :value="item.id">
                            </el-option>

                        </el-select>
                    </el-form-item>

                    <el-form-item label="Frequency" :label-width="formLabelWidth">
                        <el-radio-group v-model="editForm.frequency" size="medium">
                            <el-radio border label="every day"  auto-complete="off"></el-radio>
                            <el-radio border label="No recurrence"  auto-complete="off"></el-radio>
                        </el-radio-group>
                    </el-form-item>
                </el-form>
                <div slot="footer" class="dialog-footer">
                    <el-button @click="editFormVisible = false">Cancel</el-button>
                    <el-button type="primary" @click="submitEditForm('editForm')" :loading="editLoading">Submit</el-button>
                </div>
            </el-dialog>

        </el-main>
    </el-container>




</template>


<script>
    import moment from 'moment'
    export default {
        data: function () {
            return {
                projects: [],
                editLoading: false,
                createLoading: false,
                editTodoTitle: '',
                editFormVisible:false,
                fullscreenLoading: false,
                loading: true,
                todos: [],
                dialogFormVisible: false,
                form: {
                    due_date_time: new Date()
                },
                editForm:{
                },
                formLabelWidth: '120px',
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
        filters: {
            moment: function (date) {
                return moment(date).format('HH:mm:ss A, MMMM Do');
            }
        },
        mounted() {
            this.getTodos();
            this.getProjects();
        },
        methods: {
            tableRowClassName({row, rowIndex}) {
                console.log(row.name);
                if (row.is_done != 1) {
                    return 'warning-row';
                }else{
                    return 'success-row';
                }
            },
            /**
             * Create a new timer.
             */
            createTimer: function (todoId) {
                vm.hasRunningTimer = true;
                console.log(todoId);
//                let vm = this;
//                axios.post('/api/todolists/v1/todos/' + todoId + '/start').then(function (resp) {
//                    clearInterval(vm.counter.ticker);
//
//                    // Reset the counter and timer string
//                    vm.counter = { seconds: 0, timer: null };
//                    vm.activeTimerString = 'Calculating...';
//
//                    vm.startTimer(resp.data);
//                    vm.runningTimer = resp.data;
//                    vm.hasRunningTimer = true;
//                }).catch(function (resp) {
//                    alert("Could not start timer by todo");
//                });

            },
            getProjects(){
                var app=this;
                app.loading = true;
                api.get('/api/todolists/v1/projects')
                        .then(function (resp) {

                            app.projects = resp.data.results;
                            app.loading = false;
                        })
                        .catch(function (resp) {
                            console.log(resp);
                            app.$message({
                                type: 'error',
                                message: 'Projects cannot be retrieved.'
                            });
                            app.loading = false;
                        });

            },
            getTodos(){
                var app=this;
                app.loading = true;
                api.get('/api/todolists/v1/todos',{
                    params: {
                        due_date_time_from: moment().startOf('day').format("YYYY-MM-DD HH:mm:ss"),
                                due_date_time_to: moment().endOf('day').format("YYYY-MM-DD HH:mm:ss")
                    }
                })
                        .then(function (resp) {

                            app.todos = resp.data.results;
                            app.loading = false;
                        })
                        .catch(function (resp) {
                            console.log(resp);
                            app.$message({
                                type: 'error',
                                message: 'Todos cannot be retrieved.'
                            });
                            app.loading = false;
                        });

            },
            handleCreate(){
                this.createLoading = false;
                this.dialogFormVisible = true
            },
            submitForm(formName) {
                this.createLoading = true;
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        let data = this.form;

                        axios.post('/api/todolists/v1/todos',data)
                                .then(response => {
                            this.todos.push(response.data.results)
                        this.$message({
                            type: 'success',
                            message: response.data.message
                        });
                        this.dialogFormVisible = false;
                        this.$refs['form'].resetFields()
                    })
                    .catch(error => {
                            this.$message({
                            type: 'error',
                            message: error.response.data.message
                        });
                    });
                    } else {
                        console.log('error submit!!');
                return false;
            }
            });
            },
            submitEditForm(formName) {
                this.editLoading = true;
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        let data = this.editForm;

                        axios.put('/api/todolists/v1/todos/'+this.editForm.id,data)
                                .then(response => {
                            this.todos[this.editForm.tableIndex] = response.data.results;
                        this.$message({
                            type: 'success',
                            message: response.data.message
                        });
                        this.editFormVisible = false;
                        this.getTodos();
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
            handleEdit(index, row) {
                console.log(index, row);
                this.editLoading = false;
                this.editFormVisible = false;
                this.editTodoTitle = 'Edit '+'#'+row.id +' todo: '+row.description;
                this.editFormVisible = true;
                this.editForm = row;
//                this.editForm.due_date_time = new Date(row.due_date_time);
            },
            handleDelete(index, row) {
                console.log(index, row);
                this.$confirm('Are you sure you want to delete this todo?', 'Delete a todo', {
                    confirmButtonText: 'Confirm',
                    cancelButtonText: 'Cancel',
                    type: 'warning',
                    center: true
                }).then(() => {

                    axios.delete('/api/todolists/v1/todos/' + row.id)
                        .then(response => {
                    this.todos.splice(index, 1);
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
            handleStart(index, row) {
                console.log(index, row);
                this.$confirm('Are you sure you want to start this todo?', 'Time a todo', {
                    confirmButtonText: 'Confirm',
                    cancelButtonText: 'Cancel',
                    type: 'warning',
                    center: true
                }).then(() => {


                    axios.post('/api/todolists/v1/todos/' + row.id + '/start')
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
            handleDone(index, row) {
                console.log(index, row);
                this.$confirm('Wow, click confirm to finish it!', 'Comeplete a todo', {
                    confirmButtonText: 'Confirm',
                    cancelButtonText: 'Cancel',
                    type: 'warning',
                    center: true
                }).then(() => {

                    axios.post('/api/todolists/v1/todos/' + row.id+'/done')
                        .then(response => {
                    this.todos[index] = row;
                this.$message({
                    type: 'success',
                    message: response.data.message
                });
                this.getTodos();
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
        }
    }
</script>


<style>
    .demo-table-expand {
        font-size: 0;
    }
    .demo-table-expand label {
        width: 90px;
        color: #99a9bf;
    }
    .demo-table-expand .el-form-item {
        margin-right: 0;
        margin-bottom: 0;
        width: 50%;
    }
    .el-table .warning-row {
        background:#F9B6B7 ;
    }

    .el-table .success-row {
        background: #f0f9eb;
    }
</style>
