import {createRouter, createWebHistory} from "vue-router";
import ProductsList from "@/views/ProductsList.vue";
import ProductsCreate from "@/components/ProductsCreate.vue";

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {path:'/', name:'ProductsList', component:ProductsList},
        {path:'/create', name:'ProductsCreate', component:ProductsCreate},

    ],
    linkActiveClass: 'active'
})

export default router;