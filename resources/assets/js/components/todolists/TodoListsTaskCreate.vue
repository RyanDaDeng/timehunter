<template>
    <div>
        <div class="form-group">
            <router-link to="/" class="btn btn-dark">Back</router-link>
        </div>

        <div class="card">

            <div class="card-header">
                Create a new task
            </div>
            <div class="card-body">

                <form v-on:submit="saveForm()">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" v-model="task.name" class="form-control" placeholder="Enter task name">
                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone
                            else.
                        </small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Description</label>
                        <input type="text" v-model="task.description" class="form-control"
                               placeholder="Enter task description">

                    </div>

                    <button type="submit" class="btn btn-primary">Create</button>
                </form>


            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                task: {
                    name: '',
                    description: '',

                }
            }
        },
        methods: {
            saveForm() {
                event.preventDefault();
                var app = this;
                var newtask = app.task;
                axios.post('/api/todolists/v1/tasks', newtask)
                        .then(function (resp) {
                            app.$router.push({path: '/'});
                        })
                        .catch(function (resp) {
                            console.log(resp);
                            alert("Could not create your task");
                        });
            }
        }
    }
</script>
