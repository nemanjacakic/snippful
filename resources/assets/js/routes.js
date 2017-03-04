import VueRouter from 'vue-router';

import Home from './components/Home.vue';
import Dashboard from './components/Dashboard.vue';
import Tags from './components/tags/Tags.vue';
import SnippetCreate from './components/snippets/SnippetCreate.vue';
import SnippetEdit from './components/snippets/SnippetEdit.vue';
import Login from './components/auth/Login.vue';
import Register from './components/auth/Register.vue';
import Logout from './components/auth/Logout.vue';

const routes = [
    {
        name: 'home',
        path: '/',
        component: Home
    },
    {
        name: 'dashboard',
        path: '/dashboard',
        component: Dashboard,
        meta: { requiresUser: true }
    },
    {
        name: 'tags',
        path: '/tags',
        component: Tags,
        meta: { requiresUser: true }
    },
    {
        name: 'create',
        path: '/create',
        component: SnippetCreate,
        meta: { requiresUser: true }
    },
    {
        name: 'edit',
        path: '/:id/edit',
        component: SnippetEdit,
        meta: { requiresUser: true }
    },{
        name: 'logout',
        path: '/logout',
        component: Logout,
        meta: { requiresUser: true }
    },{
        name: 'register',
        path: '/register',
        component: Register,
        meta: { requiresGuest: true }
    },{
        name: 'login',
        path: '/login',
        component: Login,
        meta: { requiresGuest: true }
    }
];

const router = new VueRouter({
  mode: 'history',
  routes,
  linkActiveClass: 'active'
});

export default router;