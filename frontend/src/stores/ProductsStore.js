import {defineStore} from "pinia";
import {ref} from "vue";


export const useProductsStore = defineStore('ProductsStore',
    () => {
        const products = ref([]);
        const getProducts = async () => {
            products.value = (await import("@/data/products.json")).default
        }

        return {products, getProducts}

    })