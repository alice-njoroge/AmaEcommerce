export default defineNuxtRouteMiddleware((to, from) => {
    if(process.client){
        const userString = localStorage.getItem('user')
        if (userString) {
            const user = JSON.parse(userString);
            //set data
            useAuthStore().setIsLoggedIn(true);
            useAuthStore().setRoles(user.roles);
        }
        const authenticated = () => useAuthStore().isLoggedIn;
        if ((to.path !== '/login' && !authenticated()) && to.name !== '/register') {
            return navigateTo('/login');
        }
    }
})
