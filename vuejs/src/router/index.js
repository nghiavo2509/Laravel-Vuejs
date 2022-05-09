import { createRouter, createWebHistory } from 'vue-router';

import Home from '../components/Home.vue';
import DashBoard from '../components/Dashboard.vue'


import NotFound from '../components/Pages/NotFound.vue';
import Login from '../views/login.vue';
import Register from '../views/register.vue';

import Borrow from '../components/Pages/Borrow/Index.vue';
import formBorrow from '../components/Pages/Borrow/Form.vue';



import Genre from '../components/Pages/Genre/Index.vue';
import formGenre from '../components/Pages/Genre/Form.vue';

import Category from '../components/Pages/Category/Index.vue';
import formCategory from '../components/Pages/Category/Form.vue';



import Product from '../components/Pages/Product/Index.vue';
import formProduct from '../components/Pages/Product/Form.vue';

import Student from '../components/Pages/Student/Index.vue';

import Staff from '../components/Pages/Staff/Index.vue';
import addStaff from '../components/Pages/Staff/Form.vue';
import changePassStaff from '../components/Pages/Staff/changePassword.vue';

import FCategory from '../components/FrontEnd/Pages/Category/Index.vue';
import FGenre from '../components/FrontEnd/Pages/Genre/Index.vue';





const routes = [

    /**
     *  FrontEnd     */

    {
        path: '/',
        meta: {
            layout: 'fdefault'
        },
        component: Home
    },

    {
        path: '/danh-muc/:category',
        meta: {
            layout: 'fdefault'
        },
        component: FCategory,
        name: 'FCategory',
        props: true,
    },

    {
        path: '/the-loai/:id.html',
        meta: {
            layout: 'fdefault'
        },
        component: FGenre,
    },




    {
        path: '/admin',
        component: DashBoard,
    },
    /**
     * Student
     */
    {
        path: '/admin/student',
        component: Student
    },

    /**
     * Staff
     */
    {
        path: '/admin/staff',
        component: Staff
    },
    {
        path: '/admin/staff/item/:id?',
        component: addStaff
    },
    {
        path: '/admin/staff/item/:id/change',
        component: changePassStaff
    },

    /**
     * Borrow
     */
    {
        path: '/admin/borrow',
        component: Borrow
    },
    {
        path: '/admin/borrow/item/:id?',
        component: formBorrow
    },
    /**
     * Category
     */
    {
        path: '/admin/category',
        component: Category
    },
    {
        path: '/admin/category/item/:id?',
        component: formCategory
    },
    /**
     * Genre
     */
    {
        path: '/admin/genre',
        component: Genre,
    },
    {
        path: '/admin/genre/item/:id?',
        component: formGenre
    },
    /**
     * Product
     */
    {
        path: '/admin/product',
        component: Product
    },
    {
        path: '/admin/product/item/:id?',
        component: formProduct
    },
    /**
     * Auth
     */
    {
        path: '/login',
        meta: {
            layout: 'auth'
        },
        component: Login,
    },

    {
        path: '/register',
        meta: {
            layout: 'auth'
        },
        component: Register,
    },

    {
        path: '/:pathMatch(.*)*',
        name: 'NotFound',
        component: NotFound,
        meta: {
            layout: 'blank'
        }
    },



]
const router = createRouter({
    history: createWebHistory(),
    routes, // short for `routes: routes`
})
router.beforeEach((to, from, next) => {
    // redirect to login page if not logged in and trying to access a restricted page
    const publicPages = ['/login', '/register'];
    const authRequired = !publicPages.includes(to.path);
    const loggedIn = localStorage.getItem('auth_token');
    if (authRequired && !loggedIn) {
        return next('/login');
    }
    return next();

    // next();
})
export default router;