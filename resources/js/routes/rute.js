import { createRouter, createWebHistory } from 'vue-router';

import Hero from "@/pages/Hero.vue";
import Blog from "@/pages/Blog.vue";

const routes = [
    {
        path: "/",
        component: Hero
    },
    {
        path: "/blog",
        component: Blog
    }
    // {
    //     path: "/:catchAll(.*)",
    //     component: NotFound
    // }
]

const router = createRouter({
    linkActiveClass: 'active',
    history: createWebHistory(),
    routes,
})

export default router;