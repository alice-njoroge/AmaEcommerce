import {createRouter, createWebHistory} from "vue-router";
import ProductsList from "@/views/ProductsList.vue";

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {path:'/', name:'ProductsList', component:ProductsList},
        {path:'/create', name:'ProductsCreate', component:()=>import('@/views/ProductsCreate.vue')},

    ],
    linkActiveClass: 'active'
})

export default router;