import {defineStore} from "pinia";
import {ofetch} from "ofetch";
import useApi from "@/composables/useApi";

const api = useApi();


export const useAuthStore = defineStore('AuthStore', {
    state: () => {
        return {
            user: "Alice"
        };
    },
    getters: {},
    actions: {
        visitTwitterProfile() {
            window.open(`https://twitter.com/${this.user}`, "_blank")
        },
        async registerUser(formValues){
            console.log(`User registered successfully`,  formValues);

                const response = await api('http://127.0.0.1:8000/register', {
                    method: 'POST',
                    body: formValues,

                })
                console.log("response", response);

        },
        async userLogin(formValues){
            console.log("attempting to log in");
            const response = await api('/login', {
                method: 'POST',
                body: formValues,
            });
            console.log("response", response);
        }

    }
})