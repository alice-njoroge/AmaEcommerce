import {defineStore} from "pinia";
import {ref} from "vue";

export const useAuthStore = defineStore('AuthStore', ()=>{
    const user = ref("someUserFromTheAPI");

    return {user}
})