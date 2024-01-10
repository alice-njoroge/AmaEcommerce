import {createRouter, createWebHistory} from "vue-router";
import ProductsList from "@/views/ProductsList.vue";

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {path:'/', name:'ProductsList', component:ProductsList},
        {path:'/create', name:'ProductsCreate', component:()=>import('@/views/ProductsCreate.vue')},
        {path:'/register', name:'RegisterUser', component:()=> import('@/views/Auth/RegisterUser.vue')},
    ],
    linkActiveClass: 'active'
})

export default router;