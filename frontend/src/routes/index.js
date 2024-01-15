import {createRouter, createWebHistory} from "vue-router";
import ProductsList from "@/views/ProductsList.vue";
import {useAuthStore} from "@/stores/AuthStore";

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/',
            name: 'ProductsList',
            component: ProductsList
        },
        {
            path: '/create',
            name: 'ProductsCreate',
            component: () => import('@/views/ProductsCreate.vue')
        },
        {
            path: '/register',
            name: 'RegisterUser',
            component: () => import('@/views/Auth/RegisterUser.vue')
        },
        {
            path: '/login',
            name: 'LoginUser',
            component: () => import('@/views/Auth/LoginUser.vue')
        },
    ],
    linkActiveClass: 'active'
})

//adding global guards
router.beforeEach((to, from)=>{
    const authenticated = () => useAuthStore().isLoggedIn;
    if ((to.name !== 'LoginUser' && !authenticated()) && to.name !== 'RegisterUser') {
      return {name: 'LoginUser'};
    }
})


export default router;