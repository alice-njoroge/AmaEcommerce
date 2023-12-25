import {defineStore} from "pinia";


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
        }

    }
})