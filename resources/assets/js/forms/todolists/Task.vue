<template>

    <el-container>
        <el-header style="text-align: left;">
            <el-button type="success" round @click="handleCreate();">Create a new task</el-button>
        </el-header>

        <el-main>
            <el-table v-loading="loading"
                      :data="tasks"
                      style="width: 100%">

                <el-table-column
                        label="Task Name"
                >
                    <template slot-scope="scope">
                        <i class="el-icon-time"></i>
                        <span style="margin-left: 10px">{{ scope.row.name }}</span>
                    </template>
                </el-table-column>
                <el-table-column
                        label="Task Description"
                >
                    <template slot-scope="scope">
                        <span style="margin-left: 10px">{{ scope.row.description }}</span>
                    </template>

                </el-table-column>

                <el-table-column
                        label="Task Notes"
                >
                    <template slot-scope="scope">
                        <span style="margin-left: 10px"><pre>{{ scope.row.notes }}</pre></span>
                    </template>

                </el-table-column>

                <el-table-column fixed="right" label="Actions">
                    <template slot-scope="scope">
                        <el-button type="primary" icon="el-icon-edit" circle @click="handleEdit(scope.$index, scope.row)"></el-button>
                        <el-button type="danger" icon="el-icon-delete" circle  @click="handleDelete(scope.$index, scope.row)"></el-button>
                        <el-button type="warning" icon="el-icon-caret-right" circle  @click="handleStart(scope.$index, scope.row)"></el-button>
                    </template>
                </el-table-column>
            </el-table>


            <el-dialog  title="Create a new task" :visible.sync="dialogFormVisible">
                <el-form :model="form" status-icon :rules="rules2" ref="form" label-width="100px" class="demo-ruleForm">
                    <el-form-item prop="name" label="Name" :label-width="formLabelWidth">
                        <el-input v-model="form.name" auto-complete="off"></el-input>
                    </el-form-item>
                    <el-form-item prop="description" label="Description" :label-width="formLabelWidth">
                        <el-input v-model="form.description" auto-complete="off"></el-input>
                    </el-form-item>
                    <el-form-item label="Notes" prop="desc" :label-width="formLabelWidth">
                        <el-input type="textarea" v-model="form.notes"></el-input>
                    </el-form-item>
                </el-form>
                <div slot="footer" class="dialog-footer">
                    <el-button @click="dialogFormVisible = false">Cancel</el-button>
                    <el-button type="primary" @click="submitForm('form')" :loading="createLoading">Submit</el-button>
                </div>
            </el-dialog>


            <el-dialog :title="editTaskTitle" :visible.sync="editFormVisible">
                <el-form :model="editForm" status-icon :rules="rules2" ref="editForm" label-width="100px" class="demo-ruleForm">
                    <el-form-item prop="name" label="Name" :label-width="formLabelWidth">
                        <el-input v-model="editForm.name" auto-complete="off"></el-input>
                    </el-form-item>
                    <el-form-item prop="description" label="Description" :label-width="formLabelWidth">
                        <el-input v-model="editForm.description" auto-complete="off"></el-input>
                    </el-form-item>
                    <el-form-item label="Notes" prop="desc" :label-width="formLabelWidth">
                        <el-input type="textarea" v-model="editForm.notes"></el-input>
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

    export default {
        data: function () {
            return {
                editLoading: false,
                createLoading: false,
                editTaskTitle: '',
                editFormVisible:false,
                fullscreenLoading: false,
                loading: true,
                tasks: [],
                dialogFormVisible: false,
                form: {
                    name: '',
                    description:'',
                    notes:'',
                },
                editForm:{
                    id: null,
                    name: '',
                    description:'',
                    notes:'',
                    tableIndex:null
                },
                formLabelWidth: '120px',
                rules2: {
                    name: [
                        { required: true, message: 'Task name is required.', trigger: 'blur' }
                    ],
                    description:[
                        { required: true, message: 'Task description is required.', trigger: 'blur' }
                    ]
                }
            }
        },
        mounted() {
          this.getTasks();
        },
        methods: {
            /**
             * Create a new timer.
             */
            createTimer: function (taskId) {
                vm.hasRunningTimer = true;
                console.log(taskId);
//                let vm = this;
//                axios.post('/api/todolists/v1/tasks/' + taskId + '/start').then(function (resp) {
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
//                    alert("Could not start timer by task");
//                });

            },
            getTasks(){
                var app = this;
                app.loading = true;
                api.get('/api/todolists/v1/tasks')
                        .then(function (resp) {

                            app.tasks = resp.data.results;

                        })
                        .catch(function (resp) {
                            console.log(resp);
                            app.$message({
                                type: 'error',
                                message: 'Tasks cannot be retrieved.'
                            });
                        });
                app.loading = false;
            },
            handleCreate(){
                this.createLoading = false;
                this.dialogFormVisible = true
            },
            submitForm(formName) {
                this.createLoading = true;
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        let data = {
                            name: this.form.name,
                            description: this.form.description,
                            notes:this.form.notes
                        };

                        axios.post('/api/todolists/v1/tasks',data)
                                .then(response => {
                            this.tasks.push(response.data.results)
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
                        let data = {
                            name: this.editForm.name,
                            description: this.editForm.description,
                            notes:this.editForm.notes
                        };

                        axios.put('/api/todolists/v1/tasks/'+this.editForm.id,data)
                                .then(response => {
                            this.tasks[this.editForm.tableIndex] = response.data.results;
                        this.$message({
                            type: 'success',
                            message: response.data.message
                        });
                        this.editFormVisible = false;
                        this.getTasks();
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
                this.editTaskTitle = 'Edit '+'#'+row.id +' task: '+row.name;
                this.editFormVisible = true;
                this.editForm.name = row.name;
                this.editForm.id= row.id;
                this.editForm.description = row.description;
                this.editForm.notes = row.notes;
                this.editForm.tableIndex = row.tableIndex;
            },
            handleDelete(index, row) {
                console.log(index, row);
                this.$confirm('Are you sure you want to delete this task?', 'Delete a task', {
                    confirmButtonText: 'Confirm',
                    cancelButtonText: 'Cancel',
                    type: 'warning',
                    center: true
                }).then(() => {

                    axios.delete('/api/todolists/v1/tasks/' + row.id)
                        .then(response => {
                        this.tasks.splice(index, 1);
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
                this.$confirm('Are you sure you want to start this task?', 'Time a task', {
                    confirmButtonText: 'Confirm',
                    cancelButtonText: 'Cancel',
                    type: 'warning',
                    center: true
                }).then(() => {


                    axios.post('/api/todolists/v1/tasks/' + row.id + '/start')
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
            }
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
</style>
