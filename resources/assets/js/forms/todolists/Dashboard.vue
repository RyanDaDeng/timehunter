<template>

    <el-container>

        <el-header  style="">
            <el-row :gutter="20">
                <el-col :span="6">
                    <el-button type="success" round @click="handleCreate();" >Create a new todo</el-button>

                </el-col>
                <el-col :span="10">
                    <div class="grid-content bg-purple"></div>
                </el-col>

                <div class="block" style="position:absolute;
  right:0;">
                    <el-date-picker
                            @change="changeDate()"
                            v-model="value6"
                            type="daterange"
                            range-separator="-"
                            start-placeholder="Start Date"
                            end-placeholder="End Date">
                    </el-date-picker>
                </div>

            </el-row>

            <el-dialog
                    title="Todo Details"
                    :visible.sync="centerDialogVisible"
                    width="40%"
                    center>
                <p>Due Date: {{details.due_date_time|dateName}}</p>
                <p>Name: {{details.name}}</p>
                <p>Notes: {{details.notes}}</p>

                  <span slot="footer" class="dialog-footer">
                           <el-button-group>
                               <el-button type="danger" @click="handleDelete(details)" >Delete</el-button>
  <el-button v-if="details.is_done == 0" type="success" @click="complete(details)" >Mark it as Completed</el-button>
      <el-button v-else type="success" @click="complete(details)" >Mark it as Uncomplete</el-button>
      <el-button type="warning"   @click="handleStart(details)">Start timer</el-button>
                               <el-button type="info"  @click="centerDialogVisible = false" >Close</el-button>
                               </el-button-group>
                  </span>
            </el-dialog>


            <el-dialog :title="editTodoTitle" :visible.sync="editFormVisible">
                <el-form :model="editForm" status-icon :rules="rules2" ref="editForm" label-width="100px" class="demo-ruleForm">
                    <el-form-item prop="name" label="Name" :label-width="formLabelWidth">
                        <el-input v-model="editForm.name" auto-complete="off"></el-input>
                    </el-form-item>
                    <el-form-item label="Due Date Time" prop="due_date_time" :label-width="formLabelWidth">
                        <el-col>
                            <el-date-picker type="datetime" value-format="yyyy-MM-dd HH:mm:ss" placeholder="Select Date Time" v-model="editForm.due_date_time"></el-date-picker>
                        </el-col>
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
                    <el-form-item label="Priority" :label-width="formLabelWidth">
                        <el-radio-group v-model="editForm.priority_level" size="medium">
                            <el-radio border label=1 auto-complete="off">Important and Urgent</el-radio>
                            <el-radio border label=2 auto-complete="off">Important but Not Urgent</el-radio>
                            <el-radio border label=3 auto-complete="off">Not Important but Urgent</el-radio>
                            <el-radio border label=4 auto-complete="off">Not Important and Not Urgent</el-radio>
                        </el-radio-group>
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
                    <el-form-item prop="priority_level"  label="Priority" :label-width="formLabelWidth">
                        <el-radio-group v-model="form.priority_level" size="medium">
                            <el-radio border label=1 auto-complete="off">Important and Urgent</el-radio>
                            <el-radio border label=2 auto-complete="off">Important but Not Urgent</el-radio>
                            <el-radio border label=3 auto-complete="off">Not Important but Urgent</el-radio>
                            <el-radio border label=4 auto-complete="off">Not Important and Not Urgent</el-radio>
                        </el-radio-group>
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

        </el-header>
        <el-main>

            <!--<div  class="list-group col-md-3">-->
                <!--<pre>{{importantAndUrgent}}</pre>-->
            <!--</div>-->
            <!--<div  class="list-group col-md-3">-->
                <!--<pre>{{importantNotUrgent}}</pre>-->
            <!--</div>-->


            <div  v-loading="loading">


                <el-row >


                    <el-col :span="6">
                        <div class="div-middle"><span class="attribution">Important and urgent</span></div>
                        <div class="grid-content bg-pink" v-loading="loadingOne">

                        <div >
                            <ul >

                                <draggable v-model="results[1]" class="dragArea" :options="{animation:200,group:'due_date_time'}"    @change="updateOne">

                                <li class="page-gap" v-for="v,x in results[1] " :key="v.id">

                                    <a v-bind:class="getClass(v.is_done)" @mouseover="getShow(v.id,true)" @mouseleave="getShow(v.id,false)">

                                        <h2>{{v.due_date_time | dateName}}</h2>
                                        <!--style="text-decoration:line-through;"-->
                                        <p v-bind:class="getDoneClass(v.is_done)" @click="handleDetails(v,x)">{{v.name | truncate}}</p>

                                        <div class="div-bottom" v-show="show[v.id]"><span class="attribution-right">

                                        <span class='clickableAwesomeFont' @click="handleEdit(v,x)"><i  class="el-icon-edit"></i></span>
                                      <span class='clickableAwesomeFont'><i  @click="handleStart(v)" class="el-icon-time"></i></span>
                                         <span class='clickableAwesomeFont'><i  @click="complete(v)" class="el-icon-circle-check-outline"></i></span>
                                        <span class='clickableAwesomeFont'><i @click="handleDelete(v)" class="el-icon-delete"></i></span>
                                    </span></div>
                                    </a>


                                </li>

                                </draggable>

                                <!--<draggable v-model="importantAndUrgent" class="dragArea" :options="{group:'people'}">-->
                                    <!--<div v-for="element in importantAndUrgent">{{element.name}}</div>-->
                                <!--</draggable>-->
                            </ul>
                        </div>
                    </div></el-col>
                    <el-col :span="6">
                        <div class="div-middle"><span class="attribution">Important but not urgent</span></div>
                        <div class="grid-content bg-yellow" v-loading="loadingTwo" >
                        <div >
                            <ul >
                        <draggable v-model="results[2]" class="dragArea"  :options="{animation:200,group:'due_date_time'}" @change="updateTwo" >

                            <li class="page-gap" v-for="v,x in results[2] " :key="v.id">

                                <a v-bind:class="getClass(v.is_done)" @mouseover="getShow(v.id,true)" @mouseleave="getShow(v.id,false)">

                                    <h2>{{v.due_date_time | dateName}}</h2>
                                    <!--style="text-decoration:line-through;"-->
                                    <p v-bind:class="getDoneClass(v.is_done)" @click="handleDetails(v,x)">{{v.name | truncate}}</p>

                                    <div class="div-bottom" v-show="show[v.id]"><span class="attribution-right">

                                        <span class='clickableAwesomeFont' @click="handleEdit(v,x)"><i  class="el-icon-edit"></i></span>
                                      <span class='clickableAwesomeFont'><i  @click="handleStart(v)" class="el-icon-time"></i></span>
                                         <span class='clickableAwesomeFont'><i  @click="complete(v)" class="el-icon-circle-check-outline"></i></span>
                                        <span class='clickableAwesomeFont'><i @click="handleDelete(v)" class="el-icon-delete"></i></span>
                                    </span></div>
                                </a>



                            </li>

                        </draggable>
                            </ul>
                        </div>
                    </div></el-col>
                    <el-col :span="6" >
                        <div class="div-middle"><span class="attribution">Not important but urgent</span></div>
                        <div class="grid-content bg-blue" v-loading="loadingThree">
                        <div >
                            <ul >
                                <draggable v-model="results[3]" class="dragArea":options="{animation:200,group:'due_date_time'}" @change="updateThree">

                                    <li class="page-gap" v-for="v,x in results[3] ">

                                        <a v-bind:class="getClass(v.is_done)" @mouseover="getShow(v.id,true)" @mouseleave="getShow(v.id,false)">

                                            <h2>{{v.due_date_time | dateName}}</h2>
                                            <!--style="text-decoration:line-through;"-->
                                            <p v-bind:class="getDoneClass(v.is_done)" @click="handleDetails(v,x)">{{v.name | truncate}}</p>

                                            <div class="div-bottom" v-show="show[v.id]"><span class="attribution-right">

                                        <span class='clickableAwesomeFont' @click="handleEdit(v,x)"><i  class="el-icon-edit"></i></span>
                                      <span class='clickableAwesomeFont'><i  @click="handleStart(v)" class="el-icon-time"></i></span>
                                         <span class='clickableAwesomeFont'><i  @click="complete(v)" class="el-icon-circle-check-outline"></i></span>
                                        <span class='clickableAwesomeFont'><i @click="handleDelete(v)" class="el-icon-delete"></i></span>
                                    </span></div>
                                        </a>


                                    </li>

                                </draggable>
                            </ul>
                        </div>
                    </div></el-col>
                    <el-col :span="6" >
                        <div class="div-middle"><span class="attribution">Not important not urgent</span></div>
                        <div class="grid-content bg-green" v-loading="loadingFour">
                        <div >
                            <ul >
                                <draggable v-model="results[4]" class="dragArea" :options="{animation:200,group:'due_date_time'}" @change="updateFour">

                                    <div v-for="v,x in results[4] ">
                                        <li class="page-gap" >

                                            <a v-bind:class="getClass(v.is_done)" @mouseover="getShow(v.id,true)" @mouseleave="getShow(v.id,false)">

                                                <h2>{{v.due_date_time | dateName}}</h2>
                                                <!--style="text-decoration:line-through;"-->
                                                <p v-bind:class="getDoneClass(v.is_done)" @click="handleDetails(v,x)">{{v.name | truncate}}</p>

                                                <div class="div-bottom" v-show="show[v.id]"><span class="attribution-right">

                                        <span class='clickableAwesomeFont' @click="handleEdit(v,x)"><i  class="el-icon-edit"></i></span>
                                      <span class='clickableAwesomeFont'><i  @click="handleStart(v)" class="el-icon-time"></i></span>
                                         <span class='clickableAwesomeFont'><i  @click="complete(v)" class="el-icon-circle-check-outline"></i></span>
                                        <span class='clickableAwesomeFont'><i @click="handleDelete(v)" class="el-icon-delete"></i></span>
                                    </span></div>
                                            </a>


                                        </li>
                                    </div>


                                </draggable>
                            </ul>
                        </div>
                    </div></el-col>
                </el-row>


            </div>


            <!--<div class="drag">-->
                <!--<h2>List 1 Draggable</h2>-->
                <!--<draggable v-model="importantAndUrgent" class="dragArea" :options="{group:'people'}">-->
                    <!--<div v-for="element in importantAndUrgent">{{element.name}}</div>-->
                <!--</draggable>-->
                <!--<h2>List 2 Draggable</h2>-->
                <!--<draggable v-model="importantNotUrgent" class="dragArea" :options="{group:'people'}">-->
                    <!--<div v-for="element in importantNotUrgent">{{element.name}}</div>-->
                <!--</draggable>-->
            <!--</div>-->






        </el-main>



    </el-container>




</template>


<script>
    import moment from 'moment-timezone';
    import draggable from 'vuedraggable';
//    import BarChart from '@/components/charts/BarChart.vue'
//    import LineChart from '@/components/charts/LineChart.vue'
//    import PieChart from '@/components/charts/PieChart.vue'
    export default {
        components: {
            draggable
        },
//        components: { BarChart,LineChart,PieChart },
        data: function () {

            return {
                show:[],
                upHere : false,
                projects: [],
                dialogFormVisible: false,
                value6: [
                        new Date(),
                        new Date()
                ],
                form: {
                    due_date_time: new Date()
                },
                loadingOne:false,
                createLoading:false,
                loadingTwo:false,
                loadingThree:false,
                loadingFour:false,
                results: {
                    1:[],
                    2:[],
                    3:[],
                    4:[]
                },
                editLoading: false,
                editForm:{
                },
                editTodoTitle: '',
                editIndex: null,
                editFormVisible:false,
                importantAndUrgent:[],
                importantNotUrgent:[],
                notImportantButUrgent:[],
                notImportantNotUrgent:[],
                loading:false,
                centerDialogVisible:false,
                formLabelWidth: '120px',
                index:null,
                details:{},
                rules2: {
                    due_date_time: [
                        { required: true, message: 'Due Date Time is required.', trigger: 'blur' }
                    ],
                    name:[
                        { required: true, message: 'Name is required.', trigger: 'blur' }
                    ],
                    priority_level:[
                        { required: true, message: 'Priroity is required.', trigger: 'blur' }
                    ]
                }
            };

        },
        mounted () {
            this.getProjects();

            this.getNotDoneTodos(moment().startOf('day').format("YYYY-MM-DD HH:mm:ss"),moment().endOf('day').format("YYYY-MM-DD HH:mm:ss"));
            console.log(this.importantAndUrgent);
            this.today = moment();
        },
        filters: {

            dateName: function (date) {

                var REFERENCE = moment(); // fixed just for testing, use moment();
                var TODAY = REFERENCE.clone().startOf('day');
                var YESTERDAY = REFERENCE.clone().subtract(1, 'days').startOf('day');

                var todoDate = moment(date);


                if(todoDate.isSame(TODAY, 'd') ){
                    return 'Today'+moment(date).format(', h:mm a');
                }
                if (todoDate.isSame(YESTERDAY, 'd')){
                    return 'Yesterday'+moment(date).format(', h:mm a');
                }
                return moment(date).format('MMMM Do YYYY, h:mm a');
            },
            truncate(str){
//                if(str === null || str === ''){
//                    return str;
//                }
                var maxLength = 35;
                var suffix ='......';
                if(str.length > maxLength)
                {
                    str = str.substring(0, maxLength + 1);
                    str = str.substring(0, Math.min(str.length, str.lastIndexOf("")));
                    str = str + suffix;
                }
                return str;
            }
        },
        methods: {
            getClass(v){
              return v==1?'success-note':'';
            },
            getDoneClass(v){
                return v==1?'success-done':'';
            },
            getProjects(){
                var app = this;
                api.get('/api/todolists/v1/projects')
                        .then(function (resp) {

                            app.projects = resp.data.results;
                        })
                        .catch(function (resp) {
                            console.log(resp);
                            app.$message({
                                type: 'error',
                                message: 'Projects cannot be retrieved.'
                            });
                        });

            },
            handleCreate(){
                this.createLoading = false;
                this.dialogFormVisible = true
            },
            handleEdit(row,index) {
                console.log(row);
                this.editLoading = false;
                this.editIndex = index;
                this.editFormVisible = false;
                this.editTodoTitle = 'Edit '+'#'+row.id +' todo: '+row.name;
                this.editFormVisible = true;
                this.editForm = JSON.parse(JSON.stringify(row));
//                this.editForm.due_date_time = new Date(row.due_date_time);
            },
            complete(details){
                const loading = this.$loading({
                    lock: true,
                    text: 'Syncing',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });

                axios.post('/api/todolists/v1/todos/' + details.id+'/done')
                        .then(response => {
                    details.is_done = !(details.is_done);
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
                this.centerDialogVisible = false;
                loading.close();
            },
            changeDate(){
                this.getNotDoneTodos(moment(this.value6[0]).startOf('day').format("YYYY-MM-DD HH:mm:ss"),moment(this.value6[1]).endOf('day').format("YYYY-MM-DD HH:mm:ss"))
            },
            updatePriority(todoId,newPriorityLevel) {
//                const loading = this.$loading({
//                    lock: true,
//                    text: 'Syncing',
//                    spinner: 'el-icon-loading',
//                    background: 'rgba(0, 0, 0, 0.7)'
//                });
                var app=this;

                switch(newPriorityLevel){
                    case 1:
                        app.loadingOne = true;
                        break;
                    case 2:
                        app.loadingTwo = true;
                        break;
                    case 3:
                        app.loadingThree = true;
                        break;
                    case 4:
                        app.loadingFour = true;
                        break;
                }

                api.post('/api/todolists/v1/todos/'+todoId +'/updatePriority',{
                    priority_level:newPriorityLevel
                })
                        .then(function (resp) {
                            app.$message({
                                message: "It's updated!",
                                type: 'success'
                            });
                            switch(newPriorityLevel){
                                case 1:
                                    app.loadingOne = false;
                                    break;
                                case 2:
                                    app.loadingTwo = false;
                                    break;
                                case 3:
                                    app.loadingThree = false;
                                    break;
                                case 4:
                                    app.loadingFour = false;
                                    break;
                            }
                        })
                        .catch(function (resp) {
                            console.log(resp);
                            app.$message({
                                type: 'error',
                                message: 'The todo cannot be synced.'
                            });
                            switch(newPriorityLevel){
                                case 1:
                                    app.loadingOne = false;
                                    break;
                                case 2:
                                    app.loadingTwo = false;
                                    break;
                                case 3:
                                    app.loadingThree = false;
                                    break;
                                case 4:
                                    app.loadingFour = false;
                                    break;
                            }
                        });


//                this.loadingOne = false;
//                loading.close();

//                setTimeout(() => {
//                    loading.close();
//            }, 2000);
            },
            sortArray(array){
                array.sort(function(a,b){
                    // Turn your strings into dates, and then subtract them
                    // to get a value that is either negative, positive, or zero.
                    return new Date(b.due_date_time) - new Date(a.due_date_time);
                });
            },
            updateOne(e){
                if(e.added){
                    this.updatePriority(e.added.element.id,1);
                }
                this.sortArray(this.results[1]);
            },
            updateTwo(e){
                if(e.added){
                    this.updatePriority(e.added.element.id,2);
                }
                this.sortArray(this.results[2]);
            },
            updateThree(e){
                if(e.added){
                    this.updatePriority(e.added.element.id,3);
                }
                this.sortArray(this.results[3]);
            },
            updateFour(e){
                if(e.added){
                    this.updatePriority(e.added.element.id,4);
                }
                this.sortArray(this.results[4]);
            },
            getShow(id,state){
                var data = [];
                data[id] = state;
                this.show = data;
            },
            onMove ({relatedContext, draggedContext}) {
                const relatedElement = relatedContext.element;
                const draggedElement = draggedContext.element;
                console.log(relatedElement);
                console.log(draggedContext);
                return (!relatedElement || !relatedElement.fixed) && !draggedElement.fixed
            },
            handleChange() {
                console.log('changed');
            },
            inputChanged(value) {
                this.activeNames = value;
                console.log('input change');
            },
            getComponentData() {
                return {
                    on: {
                        change: this.handleChange,
                        input: this.inputChanged
                    },
                    props: {
                        value: this.activeNames
                    }
                };
            },
            submitForm(formName) {
                this.createLoading = true;
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        let data = this.form;

                        axios.post('/api/todolists/v1/todos',data)
                                .then(response => {
                            console.log(response.data.results)
                        var dueDate = moment(response.data.results.due_date_time).startOf('day');
                        if(moment(this.value6[0]).startOf('day') <= dueDate && moment(this.value6[1]).startOf('day') >= dueDate){
                            this.results[response.data.results.priority_level].push(response.data.results)
                            this.sortArray(this.results[response.data.results.priority_level]);
                        }
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
                        this.createLoading = false;
                    });
                    } else {
                        console.log('error submit!!');
                this.createLoading = false;
                return false;
            }
            });
            },
            handleDelete(row) {
                console.log(row);
                this.$confirm('Are you sure you want to delete this todo?', 'Delete a todo', {
                    confirmButtonText: 'Confirm',
                    cancelButtonText: 'Cancel',
                    type: 'warning',
                    center: true
                }).then(() => {

                    axios.delete('/api/todolists/v1/todos/' + row.id)
                        .then(response => {
                    this.results[row.priority_level].splice(this.index, 1);
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

                this.centerDialogVisible = false;
            }).catch(() => {
                    this.$message({
                    type: 'info',
                    message: 'Action Cancelled'
                });
            });
            },
            handleStart(row) {
                console.log(row);
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
                this.centerDialogVisible = false;
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
            handleDetails(v,index){
                this.centerDialogVisible = true;
                this.details = v;
                this.index = index;
            },
            submitEditForm(formName) {
                this.editLoading = true;
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        let data = this.editForm;

                        axios.put('/api/todolists/v1/todos/'+this.editForm.id,data)
                                .then(response => {
                            this.results[response.data.results.priority_level][this.editIndex] = response.data.results;
                        this.$message({
                            type: 'success',
                            message: response.data.message
                        });
                        this.editFormVisible = false;
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
            getNotDoneTodos(dateFrom,dateTo){
                var app=this;
                app.loading = true;
                api.get('/api/todolists/v1/todos/notdone',{
                    params:{
                        due_date_time_from: dateFrom,
                        due_date_time_to: dateTo
                    }
                })
                        .then(function (resp) {

                            app.results = resp.data.results;
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

            },

        }
    }
</script>



<style scoped>
    body{
        font-family:arial,sans-serif;
        font-size:100%;
        margin:3em;
        background:#666;
        color:#fff;
    }
    h2,p{
        font-size:100%;
        font-weight:normal;
    }
    ul,li{
        list-style:none;
    }
    ul{
        overflow:hidden;
        padding:2em;
    }

    ul li a{
        text-decoration:none;
        color:#000;
        background:#ffc;
        display:block;
        height: 170px;
        width:170px;
        padding:1em;
        -moz-box-shadow:5px 5px 7px rgba(33,33,33,1);
        -webkit-box-shadow: 5px 5px 7px rgba(33,33,33,.7);
        box-shadow: 5px 5px 7px rgba(33,33,33,.7);
        -moz-transition:-moz-transform .15s linear;
        -o-transition:-o-transform .15s linear;
        -webkit-transition:-webkit-transform .15s linear;
    }
    ul li{
        margin:10px;
        /*float:left;*/
    }
    ul li h2{
        font-size:80%;
        font-weight:bold;
        padding-bottom:5px;
    }
    ul li p{
        /*font-family:"Reenie Beanie",arial,sans-serif;*/
        font-size:120%;
        word-wrap: break-word;
    }
    /*ul li:nth-child(even) a{*/
        /*-o-transform:rotate(4deg);*/
        /*-webkit-transform:rotate(4deg);*/
        /*-moz-transform:rotate(4deg);*/
        /*position:relative;*/
        /*top:5px;*/
        /*background:#cfc;*/
    /*}*/
    /*ul li:nth-child(3n) a{*/
        /*-o-transform:rotate(-3deg);*/
        /*-webkit-transform:rotate(-3deg);*/
        /*-moz-transform:rotate(-3deg);*/
        /*position:relative;*/
        /*top:-5px;*/
        /*background:#ccf;*/
    /*}*/
    /*ul li:nth-child(5n) a{*/
        /*-o-transform:rotate(5deg);*/
        /*-webkit-transform:rotate(5deg);*/
        /*-moz-transform:rotate(5deg);*/
        /*position:relative;*/
        /*top:-10px;*/
    /*}*/
    /*ul li:nth-child(even) a{*/
        /*-o-transform:rotate(4deg);*/
        /*-webkit-transform:rotate(4deg);*/
        /*-moz-transform:rotate(4deg);*/
        /*position:relative;*/
        /*top:5px;*/
        /*background:#cfc;*/
    /*}*/
    /*ul li:nth-child(3n) a{*/
        /*-o-transform:rotate(-3deg);*/
        /*-webkit-transform:rotate(-3deg);*/
        /*-moz-transform:rotate(-3deg);*/
        /*position:relative;*/
        /*top:-5px;*/
        /*background:#ccf;*/
    /*}*/
    /*ul li:nth-child(5n) a{*/
        /*-o-transform:rotate(5deg);*/
        /*-webkit-transform:rotate(5deg);*/
        /*-moz-transform:rotate(5deg);*/
        /*position:relative;*/
        /*top:-10px;*/
    /*}*/
    .bg-green {
        /*position:relative;*/
        /*-o-transform:rotate(4deg);*/
        /*-webkit-transform:rotate(4deg);*/
        /*-moz-transform:rotate(4deg);*/
        background:#cfc;
    }

    .bg-pink{
        /*position:relative;*/
        /*-o-transform:rotate(-4deg);*/
        /*-webkit-transform:rotate(-4deg);*/
        /*-moz-transform:rotate(-4deg);*/
        background:#FEDEDE;
    }
    .bg-blue{
        /*position:relative;*/
        /*-o-transform:rotate(-2deg);*/
        /*-webkit-transform:rotate(-2deg);*/
        /*-moz-transform:rotate(-2deg);*/
        background:#CBEFFE;
    }
    .bg-yellow{
        /*position:relative;*/
        /*-o-transform:rotate(3deg);*/
        /*-webkit-transform:rotate(3deg);*/
        /*-moz-transform:rotate(-6deg);*/
        background:#FEF3C6;
    }
    ul li a:hover,ul li a:focus{
        box-shadow:10px 10px 7px rgba(0,0,0,.7);
        -moz-box-shadow:10px 10px 7px rgba(0,0,0,.7);
        -webkit-box-shadow: 10px 10px 7px rgba(0,0,0,.7);
        -webkit-transform: scale(1.25);
        -moz-transform: scale(1.25);
        -o-transform: scale(1.25);
        position:relative;
        z-index:5;
    }
    ol{text-align:center;}
    ol li{display:inline;padding-right:1em;}
    ol li a{color:#fff;}

    .dragArea {
        min-height:800px;
    }

    .attribution{
        font-family:"Reenie Beanie",arial,sans-serif;
        font-size:120%;
        display: inline-block;
        vertical-align: middle;
        line-height: normal;
    }
    .attribution-right{
        font-family:"Reenie Beanie",arial,sans-serif;
        font-size:120%;
        display: inline-block;
        horiz-align:right;
    }

    .div-middle {

        text-align: center;
        border: 2px dashed #f69c55;
    }
    .div-bottom {

        text-align: right;
    }

    .success-note{
        background:#87CD66;
    }
    .success-done{
        text-decoration:line-through;
    }
    .gap-margin {
        margin-bottom: 40px;
    }
    .item {
        margin-top: 10px;
        margin-right: 40px;
    }
    .clickableAwesomeFont {
        cursor: pointer
    }
</style>