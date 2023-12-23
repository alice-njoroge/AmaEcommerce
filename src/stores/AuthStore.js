import {defineStore} from "pinia";
import {ref} from "vue";

export const useAuthStore = defineStore('AuthStore', ()=>{
    const user = ref("Alice");

    return {user}
})