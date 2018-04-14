<template>

    <el-container>

        <el-header  style="">
            <el-row :gutter="20">
                <el-col :span="6">
                    <el-button type="success" round >Create a new todo</el-button>

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
                    width="30%"
                    center>
                <p>Due Date: {{details.due_date_time|dateName}}</p>
                <p>Name: {{details.name}}</p>
                <p>Description: {{details.description}}</p>
                <p>Notes: {{details.notes}}</p>

                  <span slot="footer" class="dialog-footer">
                        <el-button type="info"  @click="centerDialogVisible = false" icon="el-icon-close" circle></el-button>
  <el-button type="success" @click="complete(details)" icon="el-icon-check" circle></el-button>
  <el-button type="danger" icon="el-icon-delete" circle></el-button>

                  </span>
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
                                <draggable v-model="importantAndUrgent" class="dragArea" :options="{animation:200,group:'due_date_time'}"    @change="updateOne">

                                <li class="page-gap" v-for="v in importantAndUrgent " :key="v.id">
                                <a  @click="handleDetails(v)">

                                <h2>{{v.due_date_time | dateName}}</h2>

                                    <div v-if="v.is_done == 0">
                                        <p>{{v.name | truncate}}</p>
                                    </div>
                                    <div v-else>
                                        <p style="text-decoration:line-through;">{{v.name | truncate}}</p>
                                    </div>

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
                        <draggable v-model="importantNotUrgent" class="dragArea"  :options="{animation:200,group:'due_date_time'}" @change="updateTwo" >

                            <li class="page-gap" v-for="v in importantNotUrgent " :key="v.id">
                                <a  @click="handleDetails(v)">

                                    <h2>{{v.due_date_time | dateName}}</h2>
                                    <div v-if="v.is_done == 0">
                                        <p>{{v.name | truncate}}</p>
                                    </div>
                                    <div v-else>
                                        <p style="text-decoration:line-through;">{{v.name | truncate}}</p>
                                    </div>
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
                                <draggable v-model="notImportantButUrgent" class="dragArea":options="{animation:200,group:'due_date_time'}" @change="updateThree">

                                    <li class="page-gap" v-for="v in notImportantButUrgent ">
                                        <a  @click="handleDetails(v)">

                                            <h2>{{v.due_date_time | dateName}}</h2>
                                            <div v-if="v.is_done == 0">
                                                <p>{{v.name | truncate}}</p>
                                            </div>
                                            <div v-else>
                                                <p style="text-decoration:line-through;">{{v.name | truncate}}</p>
                                            </div>
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
                                <draggable v-model="notImportantNotUrgent" class="dragArea" :options="{animation:200,group:'due_date_time'}" @change="updateFour">

                                    <div v-for="v in notImportantNotUrgent ">
                                        <li class="page-gap" >
                                            <a  @click="handleDetails(v)">

                                                <h2>{{v.due_date_time | dateName}}</h2>
                                                <div v-if="v.is_done == 0">
                                                    <p>{{v.name | truncate}}</p>
                                                </div>
                                                <div v-else>
                                                    <p style="text-decoration:line-through;">{{v.name | truncate}}</p>
                                                </div>
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
                value6: [
                        new Date(),
                        new Date()
                ],
                loadingOne:false,
                loadingTwo:false,
                loadingThree:false,
                loadingFour:false,
                importantAndUrgent:[],
                importantNotUrgent:[],
                notImportantButUrgent:[],
                notImportantNotUrgent:[],
                loading:false,
                centerDialogVisible:false,
                details:{}
            };

        },
        mounted () {
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
                if(str === null || str === ''){
                    return str;
                }
                var maxLength = 40;
                var suffix ='......';
                if(str.length > maxLength)
                {
                    str = str.substring(0, maxLength + 1);
                    str = str.substring(0, Math.min(str.length, str.lastIndexOf(" ")));
                    str = str + suffix;
                }
                return str;
            }
        },
        methods: {
            complete(details){
                const loading = this.$loading({
                    lock: true,
                    text: 'Syncing',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });

                axios.post('/api/todolists/v1/todos/' + details.id+'/done')
                        .then(response => {
                    details.is_done = 1;
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
            openFullScreen2(todoId,newPriorityLevel) {
//                const loading = this.$loading({
//                    lock: true,
//                    text: 'Syncing',
//                    spinner: 'el-icon-loading',
//                    background: 'rgba(0, 0, 0, 0.7)'
//                });
                var app=this;
                api.post('/api/todolists/v1/todos/'+todoId +'/updatePriority',{
                    priority_level:newPriorityLevel
                })
                        .then(function (resp) {
                            app.$message({
                                message: "It's updated!",
                                type: 'success'
                            });
                            console.log('222');
                        })
                        .catch(function (resp) {
                            console.log(resp);
                            app.$message({
                                type: 'error',
                                message: 'The todo cannot be synced.'
                            });

                        });

//                loading.close();

//                setTimeout(() => {
//                    loading.close();
//            }, 2000);
            },
            updateOne(e){
                if(e.added){
                    this.loadingOne = true;
                    this.openFullScreen2(e.added.element.id,1);
                    this.loadingOne = false;

                }
                this.importantAndUrgent.sort(function(a,b){
                    // Turn your strings into dates, and then subtract them
                    // to get a value that is either negative, positive, or zero.
                    return new Date(b.due_date_time) - new Date(a.due_date_time);
                });
            },
            updateTwo(e){
                if(e.added){
                    this.openFullScreen2(e.added.element.id,2);
                }
                this.importantNotUrgent.sort(function(a,b){
                    // Turn your strings into dates, and then subtract them
                    // to get a value that is either negative, positive, or zero.
                    return new Date(b.due_date_time) - new Date(a.due_date_time);
                });
            },
            updateThree(e){
                if(e.added){
                    this.openFullScreen2(e.added.element.id,3);
                }
                this.notImportantButUrgent.sort(function(a,b){
                    // Turn your strings into dates, and then subtract them
                    // to get a value that is either negative, positive, or zero.
                    return new Date(b.due_date_time) - new Date(a.due_date_time);
                });
            },
            updateFour(e){
                if(e.added){
                    this.openFullScreen2(e.added.element.id,4);
                }
                this.notImportantNotUrgent.sort(function(a,b){
                    // Turn your strings into dates, and then subtract them
                    // to get a value that is either negative, positive, or zero.
                    return new Date(b.due_date_time) - new Date(a.due_date_time);
                });
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
            handleDetails(v){
                this.centerDialogVisible = true;
                this.details = v;
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

                            app.importantAndUrgent = resp.data.results[1];
                            app.importantNotUrgent = resp.data.results[2];
                            app.notImportantButUrgent = resp.data.results[3];
                            app.notImportantNotUrgent = resp.data.results[4];
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

    .div-middle {

        text-align: center;
        border: 2px dashed #f69c55;
    }

    .gap-margin {
        margin-bottom: 40px;
    }
    .item {
        margin-top: 10px;
        margin-right: 40px;
    }
</style>