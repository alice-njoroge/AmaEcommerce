export default defineNuxtRouteMiddleware((to, from) => {
    const authenticated = () => useAuthStore().isLoggedIn;

    if ((to.path !== '/login' && !authenticated()) && to.name !== '/register') {
        return navigateTo('/login');
    }
})
