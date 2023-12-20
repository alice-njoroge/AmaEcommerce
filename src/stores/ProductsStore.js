import {defineStore} from "pinia";
import products from "@/data/products.json"

export const useProductsStore = defineStore('ProductsStore', {
    state: () => {
        return {
            products
        }

    }
})