import {defineStore} from "pinia";
import useApi from "@/composables/useApi";

const api = useApi();


export const useAuthStore = defineStore('AuthStore', {
    state: () => {
        return {
            user: "Alice",
            isLoggedIn:false,
            userRoles: []
        };
    },
    getters: {
        checkIfUserHasRole: (state) => {
            return (role)=> state.userRoles.includes(role);
        }
    },
    actions: {
        visitTwitterProfile() {
            window.open(`https://twitter.com/${this.user}`, "_blank")
        },
        async registerUser(formValues) {
            try {
                const response = await api('http://127.0.0.1:8000/register', {
                    method: 'POST',
                    body: formValues,
                })
                console.log("response", response);

            } catch (e) {
                console.log("eee", e);

            }

        },
        async userLogin(formValues) {
            try {
                const response = await api('/login', {
                    method: 'POST',
                    body: formValues,
                });
                const user = await api('/me')
                console.log("response", user);
                this.isLoggedIn = true;
                this.userRoles = user.roles;
                localStorage.setItem('user', JSON.stringify(user));
            } catch (e) {
                console.log(e.data.error)
            }
        },

        async userLogout() {
            await api('/logout');
            this.isLoggedIn = false;
        },

        setRoles (roles){
            this.userRoles = roles;
        },

        setIsLoggedIn (isLoggedIn){
            this.isLoggedIn = isLoggedIn;
        }

    }
})