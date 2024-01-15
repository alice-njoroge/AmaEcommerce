import {createRouter, createWebHistory} from "vue-router";
import ProductsList from "@/views/ProductsList.vue";
import {useAuthStore} from "@/stores/AuthStore";

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/',
            name: 'ProductsList',
            component: ProductsList,
            beforeEnter: (to, from) => {
                const authenticated = () => useAuthStore().isLoggedIn;
                if (!authenticated()) {
                    return {name: 'LoginUser'}
                }
            }
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


export default router;