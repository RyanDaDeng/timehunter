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
import Project from './forms/todolists/Project.vue';
import Timeline from './forms/todolists/Timeline.vue';
let routes = [
    {
        path: '/app',
        component: AppControl,
        children: [
            // UserHome will be rendered inside User's <router-view>
            // when /user/:id is matched
            { path: '/app/timers', name:'Timers',component: Timer },
            { path: '/app/tasks', name:'Tasks',component: Task },
            {
                path: '/app/dashboard',
                component: Dashboard,
                name: 'Dashboard'
            },
            {
                path: '/app/reports',
                component: Reports,
                name: 'Reports'
            },
            {
                path: '/app/timeline',
                component: Timeline,
                name: 'Timeline'
            },
            {
                path: '/app/todos/inbox',
                component: TodoInbox,
                name: 'TodosInbox'
            },
            {
                path: '/app/todos/today',
                component: TodosToday,
                name: 'TodosToday'
            },
            {
                path: '/app/projects',
                component: Project,
                name: 'Projects'
            }
            // ...other sub routes
        ],
        name: 'App',
        redirect: '/app/dashboard',
        meta: { requiresAuth: true }
    },
    {
        path: '/app/aboutapp',
        component: AboutApp,
        name: 'AboutApp'
    },
    {
        path: '/app/aboutme',
        component: AboutMe,
        name: 'AboutMe'
    },
    {
        path: '/app/donateme',
        component: DonateMe,
        name: 'DonateMe'
    },
    {
        path: '/app/signin',
        component: Login,
        name: 'Signin'
    },
    {
        path: '/app/signup',
        component: Signup,
        name: 'Signup'
    },
    {
        path: '/app/home',
        component: PublicHome,
        name: 'PublicHome',
        meta: { requiresAuth: true }
    }
]


const router = new VueRouter({
    history: true,
    mode: 'history',
    routes: routes
});

router.beforeEach((to, from, next) => {
    const requiresAuth = to.matched.some(record => record.meta.requiresAuth);

    if (requiresAuth == true && auth.check() == false) {
        next('/app/signin');
    }else{
        next();
    }


})

export default router;
