
<template>
    <div>
        <div class="form-group">
            <router-link to="/" class="btn btn-dark">Back</router-link>
        </div>

        <div class="card">

                <div class="card-header">
                         Edit a task
                          </div>
            <div class="card-body">

                   <form v-on:submit="saveForm()">
                                      <div class="form-group">
                                        <label for="name">Name</label>
                                         <input type="text" v-model="task.name" class="form-control" placeholder="Enter task name">
                                       <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                                      </div>
                                      <div class="form-group">
                                        <label for="exampleInputPassword1">Description</label>
                                         <input type="text" v-model="task.description" class="form-control" placeholder="Enter task description">

                                      </div>

                                      <button type="submit" class="btn btn-primary">Edit</button>
                                    </form>




            </div>
        </div>
    </div>
</template>


<script>
    export default {
        mounted() {
            let app = this;
            let id = app.$route.params.id;
            app.taskId = id;
            axios.get('/api/todolists/v1/tasks/' + id)
                .then(function (resp) {
                    app.task = resp.data;
                })
                .catch(function () {
                    alert("Could not load your task")
                });
        },
        data: function () {
            return {
                taskId: null,
                task: {
                    name: '',
                    description: ''
                }
            }
        },
        methods: {
            saveForm() {
                event.preventDefault();
                var app = this;
                var newtask = app.task;
                axios.patch('/api/todolists/v1/tasks/' + app.taskId, newtask)
                    .then(function (resp) {
                        app.$router.replace('/');
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Could not create your task");
                    });
            }
        }
    }
</script>

