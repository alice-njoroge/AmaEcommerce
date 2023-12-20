import {defineStore} from "pinia";

export const useCartStore = defineStore('cartStore', {
    state: () => {
        return {
            items: [
                {
                    count: 0,
                    product: {}
                }
            ]
        }
    }
})