import {defineStore} from "pinia";

const api = useApi();

export const useAdminProducts = defineStore('adminProducts', {
    state: () => ({
        products: []
    }),
    getters: {},
    actions: {
        async getProducts() {
            try {
                this.products = await api('/admin/products');
                console.log(this.products);
            } catch (e) {
                console.log( e.data)
            }
        }
    }
})