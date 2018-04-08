<template>

    <el-container>

        <el-main>


                <div>
                    <ul>
                        <li class="page-gap" v-for="v in notDoneTodos ">
                            <a  @click="handleDetails(v)">

                                <h2>{{v.due_date_time | dateName}}</h2>
                                <p>{{v.name | truncate}}</p>
                            </a>
                        </li>
                    </ul>
                </div>




        </el-main>


        <el-dialog
                title="Todo Details"
                :visible.sync="centerDialogVisible"
                width="30%"
                center>
            <p>Name: {{details.name}}</p>
            <p>Description: {{details.description}}</p>
            <p>Notes: {{details.notes}}</p>

                  <span slot="footer" class="dialog-footer">
                    <el-button type="primary" @click="centerDialogVisible = false">Close</el-button>
                  </span>
        </el-dialog>

    </el-container>




</template>


<script>
    import moment from 'moment-timezone';
//    import BarChart from '@/components/charts/BarChart.vue'
//    import LineChart from '@/components/charts/LineChart.vue'
//    import PieChart from '@/components/charts/PieChart.vue'
    export default {
//        components: { BarChart,LineChart,PieChart },
        data: function () {

            return {
                notDoneTodos:[],
                loading:false,
                centerDialogVisible:false,
                details:{}
            };

        },
        mounted () {
            this.getNotDoneTodos();
            console.log(this.notDoneTodos);
            this.today = moment();
        },
        filters: {

            dateName: function (date) {

                var REFERENCE = moment(); // fixed just for testing, use moment();
                var TODAY = REFERENCE.clone().startOf('day');
                var YESTERDAY = REFERENCE.clone().subtract(1, 'days').startOf('day');

                var todoDate = moment(date);


                if(todoDate.isSame(TODAY, 'd') ){
                    return 'Today';
                }
                if (todoDate.isSame(YESTERDAY, 'd')){
                    return 'Yesterday';
                }
                return moment(date).format('MMMM Do YYYY');
            },
            truncate(str){
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

            handleDetails(v){
                this.centerDialogVisible = true;
                this.details = v;
            },
            getNotDoneTodos(){
                var app=this;
                app.loading = true;
                api.get('/api/todolists/v1/todos/notdone')
                        .then(function (resp) {

                            app.notDoneTodos = resp.data.results;
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
        padding:3em;
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
        margin:1em;
        float:left;
    }
    ul li h2{
        font-size:140%;
        font-weight:bold;
        padding-bottom:10px;
    }
    ul li p{
        font-family:"Reenie Beanie",arial,sans-serif;
        font-size:180%;
    }
    ul li a{
        -webkit-transform: rotate(-6deg);
        -o-transform: rotate(-6deg);
        -moz-transform:rotate(-6deg);
    }
    ul li:nth-child(even) a{
        -o-transform:rotate(4deg);
        -webkit-transform:rotate(4deg);
        -moz-transform:rotate(4deg);
        position:relative;
        top:5px;
        background:#cfc;
    }
    ul li:nth-child(3n) a{
        -o-transform:rotate(-3deg);
        -webkit-transform:rotate(-3deg);
        -moz-transform:rotate(-3deg);
        position:relative;
        top:-5px;
        background:#ccf;
    }
    ul li:nth-child(5n) a{
        -o-transform:rotate(5deg);
        -webkit-transform:rotate(5deg);
        -moz-transform:rotate(5deg);
        position:relative;
        top:-10px;
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

    .gap-margin {
        margin-bottom: 40px;
    }
    .item {
        margin-top: 10px;
        margin-right: 40px;
    }
</style>