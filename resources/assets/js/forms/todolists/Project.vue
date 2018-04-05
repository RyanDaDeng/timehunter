<template>

    <el-container>

        <el-main >
            <el-button type="success" round @click="handleCreate();">Create a new task</el-button>
            <el-table v-loading="loading"
                      :data="projects"
                      style="width: 100%">

                <el-table-column
                        label="Project Name"
                >
                    <template slot-scope="scope">
                        <i class="el-icon-time"></i>
                        <span style="margin-left: 10px">{{ scope.row.name }}</span>
                    </template>
                </el-table-column>
                <el-table-column
                        label="Project Description"
                >
                    <template slot-scope="scope">
                        <span style="margin-left: 10px">{{ scope.row.description }}</span>
                    </template>

                </el-table-column>

                <el-table-column fixed="right" label="Actions">
                    <template slot-scope="scope">
                        <el-button type="primary" icon="el-icon-edit" circle @click="handleEdit(scope.$index, scope.row)"></el-button>
                        <el-button type="danger" icon="el-icon-delete" circle  @click="handleDelete(scope.$index, scope.row)"></el-button>
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
                </el-form>
                <div slot="footer" class="dialog-footer">
                    <el-button @click="dialogFormVisible = false">Cancel</el-button>
                    <el-button type="primary" @click="submitForm('form')" :loading="createLoading">Submit</el-button>
                </div>
            </el-dialog>


            <el-dialog :title="editProjectTitle" :visible.sync="editFormVisible">
                <el-form :model="editForm" status-icon :rules="rules2" ref="editForm" label-width="100px" class="demo-ruleForm">
                    <el-form-item prop="name" label="Name" :label-width="formLabelWidth">
                        <el-input v-model="editForm.name" auto-complete="off"></el-input>
                    </el-form-item>
                    <el-form-item prop="description" label="Description" :label-width="formLabelWidth">
                        <el-input v-model="editForm.description" auto-complete="off"></el-input>
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
                editProjectTitle: '',
                editFormVisible:false,
                fullscreenLoading: false,
                loading: true,
                projects: [],
                dialogFormVisible: false,
                form: {
                },
                editForm:{
                },
                formLabelWidth: '120px',
                rules2: {
                    name: [
                        { required: true, message: 'Project name is required.', trigger: 'blur' }
                    ]
                }
            }
        },
        mounted() {
          this.getProjects();
        },
        methods: {
            /**
             * Create a new timer.
             */
            createTimer: function (taskId) {
                vm.hasRunningTimer = true;
                console.log(taskId);
//                let vm = this;
//                axios.post('/api/todolists/v1/projects/' + taskId + '/start').then(function (resp) {
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
            handleCreate(){
                this.createLoading = false;
                this.dialogFormVisible = true
            },
            submitForm(formName) {
                this.createLoading = true;
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        let data = this.form;

                        axios.post('/api/todolists/v1/projects',data)
                                .then(response => {
                            this.projects.push(response.data.results)
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

                        axios.put('/api/todolists/v1/projects/'+this.editForm.id,data)
                                .then(response => {
                            this.projects[this.editForm.tableIndex] = response.data.results;
                        this.$message({
                            type: 'success',
                            message: response.data.message
                        });
                        this.editFormVisible = false;
                        this.getProjects();
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
                this.editProjectTitle = 'Edit '+'#'+row.id +' task: '+row.name;
                this.editFormVisible = true;
                this.editForm = row;
            },
            handleDelete(index, row) {
                console.log(index, row);
                this.$confirm('Are you sure you want to delete this task?', 'Delete a task', {
                    confirmButtonText: 'Confirm',
                    cancelButtonText: 'Cancel',
                    type: 'warning',
                    center: true
                }).then(() => {

                    axios.delete('/api/todolists/v1/projects/' + row.id)
                        .then(response => {
                        this.projects.splice(index, 1);
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
