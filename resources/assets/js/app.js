require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router';

window.Vue.use(VueRouter);

import TodoListsTaskIndex from './components/todolists/TodoListsTaskIndex.vue';
import TodoListsTaskCreate from './components/todolists/TodoListsTaskCreate.vue';
import TodoListsTaskEdit from './components/todolists/TodoListsTaskEdit.vue';
import TodoListsTimerEdit from './components/todolists/TodoListsTimerEdit.vue';
const routes = [
    {
        path: '/',
        components: {
            TodoListsTaskIndex: TodoListsTaskIndex
        }
    },
    {path: '/todolists/tasks/create', component: TodoListsTaskCreate, name: 'TodoListsTaskCreate'},
    {path: '/todolists/tasks/edit/:id', component: TodoListsTaskEdit, name: 'TodoListsTaskEdit'},
    {path: '/todolists/timers/edit/:id', component: TodoListsTimerEdit, name: 'TodoListsTimerEdit'},
]

const router = new VueRouter({ routes })

const app = new Vue({ router }).$mount('#app')