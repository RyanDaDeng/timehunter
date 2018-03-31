import VueRouter from 'vue-router';

import Login from './forms/public/Login.vue';
import Signup from './forms/public/signup.vue';
import VueDashboard from './components/ExampleComponent.vue';
import PublicHome from './forms/public/Navigation.vue';
import Task from './forms/todolists/Task.vue';
import Timer from './forms/todolists/Timer.vue';

let routes = [
    {
        path: '/',
        component: Timer,
        name: 'App',
        meta: { requiresAuth: true }
    },
    {
        path: '/timers',
        component: Timer,
        name: 'Timer',
        meta: { requiresAuth: true }
    },
    {
        path: '/tasks',
        component: Task,
        name: 'Task',
        meta: { requiresAuth: true }
    },
    {
        path: '/signin',
        component: Login,
        name: 'Signin'
    },
    {
        path: '/signup',
        component: Signup,
        name: 'Signup'
    },
    {
        path: '/home',
        component: PublicHome,
        name: 'PublicHome',
        meta: { requiresAuth: true }
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
        next('/signin');
    }else{
        next();
    }


})

export default router;
