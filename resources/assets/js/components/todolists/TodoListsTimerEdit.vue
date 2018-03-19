
<template>
    <div>
        <div class="form-group">
            <router-link to="/" class="btn btn-dark">Back</router-link>
        </div>

        <div class="card">

                <div class="card-header">
                         Edit a timer
                          </div>
            <div class="card-body">

                   <form v-on:submit="saveForm()">
                                      <div class="form-group">
                                        <label for="name">Name</label>
                                         <input type="text" v-model="timer.name" class="form-control" placeholder="Enter timer name">
                                       <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                                      </div>
                                      <div class="form-group">
                                        <label for="exampleInputPassword1">Description</label>
                                         <input type="text" v-model="timer.description" class="form-control" placeholder="Enter timer description">

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
            app.timerId = id;
            axios.get('/api/todolists/v1/timers/' + id)
                .then(function (resp) {
                    app.timer = resp.data;
                })
                .catch(function () {
                    alert("Could not load your timer")
                });
        },
        data: function () {
            return {
                timerId: null,
                timer: {
                    name: '',
                    description: ''
                }
            }
        },
        methods: {
            saveForm() {
                event.preventDefault();
                var app = this;
                var newtimer = app.timer;
                axios.patch('/api/todolists/v1/timers/' + app.timerId, newtimer)
                    .then(function (resp) {
                        app.$router.replace('/');
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Could not create your timer");
                    });
            }
        }
    }
</script>

