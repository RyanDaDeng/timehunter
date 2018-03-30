import VueRouter from 'vue-router';

import TodoListsTaskIndex from './components/todolists/TodoListsTaskIndex.vue';
import TodoListsTaskCreate from './components/todolists/TodoListsTaskCreate.vue';
import TodoListsTaskEdit from './components/todolists/TodoListsTaskEdit.vue';
import TodoListsTimerEdit from './components/todolists/TodoListsTimerEdit.vue';
import VueLogin from './components/auth/Login.vue';
import VueDashboard from './components/ExampleComponent.vue';
import PublicHome from './forms/public/Navigation.vue';
import Task from './forms/todolists/Task.vue';
import Timer from './forms/todolists/Timer.vue';
let routes = [
    {
        path: '/',
        component: Timer,
        name: 'App'
    },
    {
        path: '/timers',
        component: Timer,
        name: 'Timer'
    },
    {
        path: '/tasks',
        component: Task,
        name: 'Task'
    },
    {
        path: '/todolists/tasks/create',
        component: TodoListsTaskCreate,
        name: 'TodoListsTaskCreate'
    },
    {
        path: '/todolists/tasks/edit/:id',
        component: TodoListsTaskEdit,
        name: 'TodoListsTaskEdit'
    },
    {
        path: '/todolists/timers/edit/:id',
        component: TodoListsTimerEdit,
        name: 'TodoListsTimerEdit'
    },
    {
        path: '/login',
        component: VueLogin,
        name: 'VueLogin'
    },
    {
        path: '/home',
        component: PublicHome,
        name: 'PublicHome'
    },
    {
        path: '/dashboard',
        component: VueDashboard,
        name: 'VueDashboard',
        meta: { requiresAuth: true }
    }
]


const router = new VueRouter({
    routes
});

router.beforeEach((to, from, next) => {
    const requiresAuth = to.matched.some(record => record.meta.requiresAuth);

    if (requiresAuth == true && auth.check() == false) {
        next('/login');
    }else{
        next();
    }


})

export default router;
