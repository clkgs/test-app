import Vue from 'vue'
import VueRouter from 'vue-router'

import Blog from '../components/pages/Blog'

Vue.use(VueRouter)

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'blog',
            component: Blog,
        },
        {
            path: '/:categoryId',
            name: 'category-blog',
            component: Blog,
        },
    ],
})

export default router
