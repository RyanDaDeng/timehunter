<template>

  <div>

      <el-row >
          <!--<el-col :span="4">-->
              <!--<el-progress type="circle" :percentage="80" color="#8e71c7"></el-progress>-->
          <!--</el-col>-->

          <el-col :span="4" >

              <el-button-group>
              <el-button type="success" @click="handleCreate();" icon="el-icon-plus" circle></el-button>
              <el-button type="primary" icon="el-icon-menu" @click="view='card'"circle></el-button>
                  <el-button type="warning" icon="el-icon-tickets" @click="view='list'"circle></el-button>
              <el-button type="info" icon="el-icon-setting" circle></el-button>

          </el-button-group></el-col>

          <el-col :span="3" > <el-progress type="circle"  :width='80' :percentage="25"></el-progress></el-col>
          <el-col :span="3" > <el-progress type="circle" :width='80' :percentage="finishRatio" color="#87CD66"></el-progress> </el-col>

          <el-col :span="3">
          <el-select v-model="value8" filterable placeholder="Project">
              <el-option
                      key="All"
                      label="All"
                      value="All">
              </el-option>
              <el-option
                      key="Done"
                      label="Done"
                      value="Done">
              </el-option>
              <el-option
                      key="NotDone"
                      label="Not Done"
                      value="NotDone">
              </el-option>
          </el-select>
          </el-col>
          <el-col :span="3">

              <el-select v-model="value9" filterable placeholder="Project">
                  <el-option
                          label="All"
                          key="All"
                          value="All">
                  </el-option>
                  <el-option
                          v-for="item in projects"
                          :label="item.name"
                          :key="item.id"
                          :value="item.id">
                  </el-option>

              </el-select>
          </el-col>
          <el-col :span="8" >  <el-date-picker
                  @change="changeDate()"
                  v-model="value6"
                  type="daterange"
                  range-separator="-"
                  start-placeholder="Start Date"
                  end-placeholder="End Date"
                  :picker-options="pickerOptions2">
          </el-date-picker></el-col>


          <!--<el-col :span="2" :offset="1">  <el-row>-->
              <!--<v-badge color="red" v-model="show">-->
                  <!--<span slot="badge">6</span>-->
                  <!--<el-radio v-model="radio3" label="Today" border>Today</el-radio>-->
              <!--</v-badge>-->

          <!--</el-row></el-col>-->

          <el-col :span="8" :offset="6">  <el-row>

                  <v-chip @click="radio3='Today'" color="blue" text-color="white">Today</v-chip>

                    <v-chip @click="radio3='Week'" color="green" text-color="white">Week</v-chip>

                  <v-chip @click="radio3='Month'" color="orange" text-color="white">Month</v-chip>

                  <v-chip @click="radio3='Expired'" color="red" text-color="white">Delayed</v-chip>


          </el-row></el-col>

          <!--<el-col :span="2" :offset="1">  <el-row>-->
              <!--<v-badge color="red" v-model="show">-->
                  <!--<span slot="badge">6</span>-->
                  <!--<el-radio v-model="radio3" label="Month" border>Month</el-radio>-->
              <!--</v-badge>-->
          <!--</el-row></el-col>-->


          <!--<el-col :span="2" :offset="1">  <el-row>-->
              <!--<v-badge color="red" v-model="show">-->
                  <!--<span slot="badge">6</span>-->
                  <!--<el-radio v-model="radio3" label="Expired" border>Delayed</el-radio>-->
              <!--</v-badge>-->
          <!--</el-row></el-col>-->

      </el-row>


      <el-tabs  v-model="activeName" >
          <el-tab-pane label="Todos" name="first">


              <div  v-loading="loadingFull">


                  <el-row class="el-row">
                      <link href="https://cdn.jsdelivr.net/npm/animate.css@3.5.1" rel="stylesheet" type="text/css">

                      <transition
                              name="custom-classes-transition"
                              enter-active-class="animated tada"
                              leave-active-class="animated bounceOutRight"
                      >
                          <div  id="popup1" class="overlay" v-show="showBox" >
                              <div class="popup">
                                  <h2 style=" margin-top: 0;
        font-size: 180%;
        color:#3DCB9A;
        font-family: Tahoma, Arial, sans-serif;"><i  class="far fa-check-circle"></i> Congratulations!</h2>
                                  <!--<a class="close" @click="showBox = false">&times;</a>-->
                                  <div class="content">
                                      WINNER WINNER, CHICKEN DINNER!
                                  </div>
                              </div>
                          </div>
                          <!--<p v-if="showBox">hello</p>-->
                      </transition>


                          <div v-for="result,index in results">
                              <el-col :span="6">
                                  <div class="div-middle"><span class="attribution">Important and urgent</span></div>
                                  <div  v-bind:class="getGridColorClass(index)" v-loading="gridLoading[index]">

                                      <div v-if="view=='card'">
                                          <ul >

                                              <draggable v-model="results[index]" class="dragArea" :options="{animation:200,group:'due_date_time'}"  @change="updateOne(index,$event)">

                                                  <div v-for="v,x in results[index] " :key="v.id">
                                                      <transition name="slide-fade">
                                                      <div v-show="checkStatusCondition(v)">
                                                  <li class="page-gap" >

                                                      <a v-loading="todoLoading[v.id]" v-bind:class="getClass(v.is_done)" @mouseover="getShow(v.id,true)" @mouseleave="getShow(v.id,false)">

                                                          <h2>{{v.due_date_time | dateName}}</h2>
                                                          <!--style="text-decoration:line-through;"-->
                                                          <p v-bind:class="getDoneClass(v.is_done)" @click="handleDetails(v,x)">{{v.frequency}} {{v.name | truncate}}</p>

                                                          <div class="div-bottom" v-show="show[v.id]"><span class="attribution-right">


                                        <span class='clickableAwesomeFont' @click="handleEdit(v,x)"><i  class="far fa-edit"></i></span>
                                      <span class='clickableAwesomeFont'  @click="handleStart(v)"><i class="far fa-clock"></i></span>
                                         <span class='clickableAwesomeFont' @click="complete(v)"><i  class="far fa-check-circle"></i></span>
                                        <span class='clickableAwesomeFont'  @click="handleDelete(v,x)"><i class="far fa-trash-alt"></i></span>
                                    </span></div>
                                                      </a>

                                                  </li>

                                                  </div>
                                                      </transition>
                                                  </div>

                                              </draggable>

                                          </ul>
                                      </div>

                                      <div v-if="view=='list'">
                                          <div style="cursor: move;">

                                              <draggable v-model="results[index]" class="dragArea" :options="{animation:200,group:'due_date_time'}"  @change="updateOne(index,$event)">

                                                  <div v-for="v,x in results[index] " :key="v.id">
                                                      <transition name="slide-fade">
                                                  <div v-if="checkStatusCondition(v)">
                                                  <li class="page-gap" style=" padding:10px 0;margin-left:10px;"  >

                                                          <a v-loading="todoLoading[v.id]" v-bind:class="getClass(v.is_done)" @mouseover="getShow(v.id,true)" @mouseleave="getShow(v.id,false)">

                                                              <h2 >{{v.due_date_time | dateName}}</h2>
                                                              <!--style="text-decoration:line-through;"-->
                                                              <p v-bind:class="getDoneClass(v.is_done)" @click="handleDetails(v,x)">{{v.frequency}} {{v.name }}</p>

                                                              <div class="div-bottom" v-show="show[v.id]"><span class="attribution-right">


                                        <span class='clickableAwesomeFont' @click="handleEdit(v,x)"><i  class="far fa-edit"></i></span>
                                      <span class='clickableAwesomeFont'  @click="handleStart(v)"><i class="far fa-clock"></i></span>
                                         <span class='clickableAwesomeFont' @click="complete(v)"><i  class="far fa-check-circle"></i></span>
                                        <span class='clickableAwesomeFont'  @click="handleDelete(v,x)"><i class="far fa-trash-alt"></i></span>
                                    </span></div>
                                                          </a>
                                                  </li>
                                                  </div>
                                                          </transition>
                                                  </div>
                                              </draggable>

                                          </div>
                                      </div>
                                  </div>
                              </el-col>
                          </div>




                  </el-row>


              </div>
          </el-tab-pane>

          <el-tab-pane label="Statistics" name="second">

              <!--<el-row :gutter="12">-->
                  <!--<el-col :span="8">-->
                      <!--<el-card shadow="always">-->
                          <!--<el-progress type="circle" :percentage="80" color="#8e71c7"></el-progress>-->
                      <!--</el-card>-->
                  <!--</el-col>-->
                  <!--<el-col :span="8">-->
                      <!--<el-card shadow="hover">-->
                          <!--<el-progress type="circle" :percentage="25"></el-progress>-->
                      <!--</el-card>-->
                  <!--</el-col>-->
                  <!--<el-col :span="8">-->
                      <!--<el-card shadow="never">-->
                          <!--<el-progress type="circle" :percentage="25"></el-progress>-->
                      <!--</el-card>-->
                  <!--</el-col>-->
              <!--</el-row>-->

          </el-tab-pane>
      </el-tabs>










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
                               <el-button type="danger" @click="handleDelete(details,index)" >Delete</el-button>
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





  </div>



            <!--<div  class="list-group col-md-3">-->
                <!--<pre>{{importantAndUrgent}}</pre>-->
            <!--</div>-->
            <!--<div  class="list-group col-md-3">-->
                <!--<pre>{{importantNotUrgent}}</pre>-->
            <!--</div>-->




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
                numDone:0,
                numNotDone:0,
                value2:true,
                summary:{},
                value8: 'All',
                value9:'All',
                view:'list',
                gridLoading: {
                    1: false,
                    2: false,
                    3: false,
                    4: false
                },
                createLoading:false,
                radio3:'',
                audio: null,
                todoLoading:[],
                showBox:false,
                show:[],
                upHere : false,
                projects: [],
                dialogFormVisible: false,
                value6: [

                ],
                form: {
                    due_date_time: new Date()
                },
                results: {
                    1:[],
                    2:[],
                    3:[],
                    4:[]
                },
                editLoading: false,
                editForm:{
                },
                activeName:'first',
                editTodoTitle: '',
                editIndex: null,
                editFormVisible:false,
                importantAndUrgent:[],
                importantNotUrgent:[],
                notImportantButUrgent:[],
                notImportantNotUrgent:[],
                loadingFull:false,
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
                },
                pickerOptions2: {
                    shortcuts: [{
                        text: 'Today',
                        onClick(picker) {
                            const start = moment().startOf('day').toDate();
                            const end   = moment().endOf('day').toDate();

                            picker.$emit('pick', [start, end]);
                        }
                    }, {
                        text: 'This Week',
                        onClick(picker) {
                            const start = moment().startOf('week').toDate();
                            const end   = moment().endOf('week').toDate();
                            picker.$emit('pick', [start, end]);
                        }
                    }, {
                        text: 'This Month',
                        onClick(picker) {
                            const start = moment().startOf('month').toDate();
                            const end   = moment().endOf('month').toDate();
                            picker.$emit('pick', [start, end]);
                        }
                    }]
                }
            };

        },
        computed: {
            finishRatio: function () {
                const a = this.numNotDone + this.numDone

                if(a<=0){
                    return 0;
                }
                return Math.round((this.numDone /a) *100)
            }
        },
        watch:{
            radio3: function(val){
                console.log(val);
                var start;
                var end;
                var expired = false;
                switch(val){
                    case 'Today':
                        start = moment().startOf('day').toDate();
                        end   = moment().endOf('day').toDate();
                        this.value6 = [];
                        this.value6.push( start);
                        this.value6.push(end);
                        break;
                    case 'Week':
                        start = moment().startOf('week').toDate();
                        end   = moment().endOf('week').toDate();
                        this.value6 = [];
                        this.value6.push( start);
                        this.value6.push(end);
                        break;
                    case 'Month':
                        start = moment().startOf('month').toDate();
                        end   = moment().endOf('month').toDate();
                        this.value6 = [];
                        this.value6.push( start);
                        this.value6.push(end);
                        break;
                    case 'Expired':
//                        start = moment().startOf('month').toDate();
//                        end   = moment().endOf('month').toDate();
                        this.value6 = [];
//                        this.value6.push( start);
//                        this.value6.push(end);
                        expired = true;
                        break;
                }
                this.getNotDoneTodos(moment(this.value6[0]).startOf('day').format("YYYY-MM-DD HH:mm:ss"),moment(this.value6[1]).endOf('day').format("YYYY-MM-DD HH:mm:ss"),expired)

            }
        },
        mounted () {
            this.getProjects();
            this.radio3 = 'Today';
//            this.value6.push( new Date());
//            this.value6.push(this.addDays(new Date(),1));
//            this.getNotDoneTodos(moment().startOf('day').format("YYYY-MM-DD HH:mm:ss"),moment().add(7,'day').endOf('day').format("YYYY-MM-DD HH:mm:ss"));
//            console.log(this.importantAndUrgent);
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
                return moment(date).format('ddd, MMMM Do, h:mm a');
            },
            truncate(str){
//                if(str === null || str === ''){
//                    return str;
//                }
                var maxLength = 60;
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
            checkStatusCondition(v){

                if(this.value9 !='All'){
                    if(v.project_id != this.value9){
                        return false;
                    }
                }
                if(this.value8 =='All'){
                    return true;
                }

                if(v.is_done == true && this.value8 =='Done'){

                    return true;
                }

                if(v.is_done == false && this.value8 =='NotDone'){
                    return true;
                }



                return false
            },
            getLoading(index){
              return false;
            },
            getGridColorClass(index){
              switch(index){
                  case '1':
                      return 'grid-content bg-pink';
                  case '2':
                      return 'grid-content bg-yellow';
                  case '3':
                      return 'grid-content bg-blue';
                  case '4':
                      return 'grid-content bg-green';
                  default:
                      return '';
              }
            },
            addDays(date, days) {
                var result = new Date(date);
                result.setDate(result.getDate() + days);
                return result;
            },
            getClass(v){
              return v==1?'success-note':'';
            },
            getClassIcon(v){
                console.log(v);
                return v==1?'far fa-check-circle':'far fa-circle';
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
//                const loading = this.$loading({
//                    lock: true,
//                    text: 'Syncing',
//                    spinner: 'el-icon-loading',
//                    background: 'rgba(0, 0, 0, 0.7)'
//                });

                var data = JSON.parse(JSON.stringify([]));
                data[details.id] = true;
                var app = this;
                app.todoLoading = data;
                axios.post('/api/todolists/v1/todos/' + details.id+'/done')
                        .then(response => {
//                    details = response.data.results.done;
                    details.is_done = response.data.results.done.is_done;
                    details.frequency = response.data.results.done.frequency;
               app.todoLoading[details.id] = false;
                if(response.data.results.newTodo !=null){
                    var dueDate = moment(response.data.results.newTodo.due_date_time).startOf('day');
                    if(moment(this.value6[0]).startOf('day') <= dueDate && moment(this.value6[1]).startOf('day') >= dueDate){
                        this.results[response.data.results.newTodo.priority_level].push(response.data.results.newTodo);
                        this.sortArray(this.results[response.data.results.newTodo.priority_level]);
                    }
                }

                if(response.data.results.done.is_done == 1){
                    this.numDone ++;
                    this.numNotDone --;
                    this.showBox = true;
                    this.audio = new Audio('https://ryandeng.com/audio/teda.mp3');
                    this.audio.play();

                    setTimeout(function () {  this.showBox = false }.bind(this), 3000)
                }else{
                    this.numDone --;
                    this.numNotDone ++;
                }

//                this.$message({
//                    type: 'success',
//                    message: response.data.message
//                });
            })
            .catch(error => {
                    this.$message({
                    type: 'error',
                    message: error.response.data.message
                });
            });
                this.centerDialogVisible = false;
//                this.todoLoading[details.id] = false;
//                loading.close();
            },
            changeDate(){
                this.getNotDoneTodos(moment(this.value6[0]).startOf('day').format("YYYY-MM-DD HH:mm:ss"),moment(this.value6[1]).endOf('day').format("YYYY-MM-DD HH:mm:ss"),false)
            },
            updatePriority(todoId,newPriorityLevel) {
//                const loading = this.$loading({
//                    lock: true,
//                    text: 'Syncing',
//                    spinner: 'el-icon-loading',
//                    background: 'rgba(0, 0, 0, 0.7)'
//                });
                var app=this;

                app.gridLoading[newPriorityLevel] = true;


                api.post('/api/todolists/v1/todos/'+todoId +'/updatePriority',{
                    priority_level:newPriorityLevel
                })
                        .then(function (resp) {
                            app.$message({
                                message: "It's updated!",
                                type: 'success'
                            });
                            app.gridLoading[newPriorityLevel] = false;
                        })
                        .catch(function (resp) {
                            console.log(resp);
                            app.$message({
                                type: 'error',
                                message: 'The todo cannot be synced.'
                            });
                            app.gridLoading[newPriorityLevel] = false;
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
                    return new Date(a.due_date_time) - new Date(b.due_date_time);
                });
            },
            updateOne(index,$event){
//                console.log(e);
                if($event.added){
                    this.updatePriority($event.added.element.id,index);
                    this.sortArray(this.results[index]);
                }

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
            handleDelete(row,index) {
                console.log(row);
                this.$confirm('Are you sure you want to delete this todo?', 'Delete a todo', {
                    confirmButtonText: 'Confirm',
                    cancelButtonText: 'Cancel',
                    type: 'warning',
                    center: true
                }).then(() => {

                    axios.delete('/api/todolists/v1/todos/' + row.id)
                        .then(response => {
                    this.results[row.priority_level].splice(index
                        , 1);
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
            getNotDoneTodos(dateFrom,dateTo,expired){
                var app=this;
                app.loadingFull = true;
                api.get('/api/todolists/v1/todos/notdone',{
                    params:{
                        due_date_time_from: dateFrom,
                        due_date_time_to: dateTo,
                        is_expired:expired
                    }
                })
                        .then(function (resp) {


                            app.summary = resp.data.results['summary'];

                            app.numDone = app.summary.done;
                            app.numNotDone = app.summary.not_done;

                            delete resp.data.results["summary"];
                            app.results = resp.data.results;
                            app.loadingFull = false;
                        })
                        .catch(function (resp) {
                            console.log(resp);
                            app.$message({
                                type: 'error',
                                message: 'Not Todos cannot be retrieved.'
                            });
                            app.loadingFull = false;
                        });

            },

        }
    }
</script>



<style scoped>

    .overlay {
        position: fixed;
        width:1000px;
        height:1000px;
        z-index: 999;
        /*top: 0;*/
        /*bottom: 0;*/
        /*left: 0;*/
        /*right: 0;*/
        /*background: rgba(0, 0, 0, 0.7);*/
    }

    .popup {
        margin: 200px auto;
        left:20%;
        padding: 20px;
        background: #fff;
        border-radius: 5px;
        width: 30%;
        position: relative;
    }
    .popup .cute {
        margin-top: 0;
        color: #333;
        font-family: Tahoma, Arial, sans-serif;
    }
    .popup .close {
        position: absolute;
        top: 20px;
        right: 30px;
        font-size: 30px;
        font-weight: bold;
        text-decoration: none;
        color: #333;
    }
    .popup .close:hover {
        color: #06D85F;
    }
    .popup .content {
        max-height: 50%;
        overflow: auto;
    }

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
    .content {
        flex: 1;
        display: flex;
        overflow: auto;
    }
    .box {
        min-height: min-content; /* needs vendor prefixes */
        display: flex;
    }
    ul li a{
        cursor:move;
        text-decoration:none;
        color:#000;
        background:#ffc;
        display:block;
        height: 200px;
        width:200px;
        padding:1em;
        -moz-box-shadow:5px 5px 7px rgba(33,33,33,1);
        -webkit-box-shadow: 5px 5px 7px rgba(33,33,33,.7);
        box-shadow: 5px 5px 7px rgba(33,33,33,.7);
        -moz-transition:-moz-transform .15s linear;
        -o-transition:-o-transform .15s linear;
        -webkit-transition:-webkit-transform .15s linear;
    }
    ul li{
        margin:30px;
        /*float:left;*/
    }
    ul li h2{
        font-size:100%;
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
    .el-row {
        margin-top: 10px;
    }
    .clickableAwesomeFont {
        cursor: pointer
    }
    .list-item {
        display: inline-block;
        margin-right: 10px;
    }
    .list-enter-active, .list-leave-active {
        transition: all 1s;
    }
    .list-enter, .list-leave-to /* .list-leave-active below version 2.1.8 */ {
        opacity: 0;
        transform: translateY(30px);
    }
    .el-col {
        border-radius: 4px;
    }
    .bg-purple-dark {
        background: #99a9bf;
    }
    .bg-purple {
        background: #d3dce6;
    }
    .bg-purple-light {
        background: #e5e9f2;
    }
    .grid-content {
        border-radius: 4px;
        min-height: 36px;
    }
    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s;
    }
    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
        opacity: 0;
    }
    /* Enter and leave animations can use different */
    /* durations and timing functions.              */
    .slide-fade-enter-active {
        transition: all .5s ease;
    }
    .slide-fade-leave-active {
        transition: all .8s cubic-bezier(1.0, 0.5, 0.8, 1.0);
    }
    .slide-fade-enter, .slide-fade-leave-to
        /* .slide-fade-leave-active below version 2.1.8 */ {
        transform: translateX(10px);
        opacity: 0;
    }
</style>