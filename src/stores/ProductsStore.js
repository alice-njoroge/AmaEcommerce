import {defineStore} from "pinia";


export const useProductsStore = defineStore('ProductsStore', {
    state: () => {
        return {
            products: []
        }
    },
    actions: {
        async getProducts(){
            this.products = (await import("@/data/products.json")).default
        }
    }
})