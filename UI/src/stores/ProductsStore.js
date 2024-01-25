import {defineStore} from "pinia";
import {ref} from "vue";
import {ofetch} from "ofetch";
import useApi from "@/composables/useApi";
const api = useApi();

export const useProductsStore = defineStore('ProductsStore',
    () => {
        const products = ref([]);
        const getProducts = async () => {
            products.value = (await api('/products'));
            console.log('products', products.value)
        }
        const saveProducts = async (formValues) => {
            const response = await api('/products/create', {
                method: 'POST',
                body: formValues
            })
            console.log('response', response)

        }

        return {products, getProducts, saveProducts}

    })