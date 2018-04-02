import VueRouter from 'vue-router';

import Login from './forms/public/Login.vue';
import Signup from './forms/public/Signup.vue';
import VueDashboard from './components/ExampleComponent.vue';
import PublicHome from './forms/public/Navigation.vue';
import Task from './forms/todolists/Task.vue';
import Timer from './forms/todolists/Timer.vue';
import AboutApp from '@/forms/public/AboutApp.vue';
import AppControl from '@/forms/public/AuthControl.vue';
import Dashboard from  './forms/todolists/Dashboard.vue';
import Reports from  './forms/todolists/Reports.vue';
import AboutMe from '@/forms/public/AboutMe.vue';
import DonateMe from '@/forms/public/Donate.vue';
import TodoInbox from './forms/todolists/TodosInbox.vue';
import TodosToday from './forms/todolists/TodosToday.vue';
let routes = [
    {
        path: '/',
        component: AppControl,
        children: [
            // UserHome will be rendered inside User's <router-view>
            // when /user/:id is matched
            { path: '/timers', name:'Timers',component: Timer },
            { path: '/tasks', name:'Tasks',component: Task },
            {
                path: '/dashboard',
                component: Dashboard,
                name: 'Dashboard'
            },
            {
                path: '/reports',
                component: Reports,
                name: 'Reports'
            },
            {
                path: '/todos/inbox',
                component: TodoInbox,
                name: 'TodosInbox'
            },
            {
                path: '/todos/today',
                component: TodosToday,
                name: 'TodosToday'
            }
            // ...other sub routes
        ],
        name: 'App',
        redirect: '/timers',
        meta: { requiresAuth: true }
    },
    {
        path: '/aboutapp',
        component: AboutApp,
        name: 'AboutApp'
    },
    {
        path: '/aboutme',
        component: AboutMe,
        name: 'AboutMe'
    },
    {
        path: '/donateme',
        component: DonateMe,
        name: 'DonateMe'
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
