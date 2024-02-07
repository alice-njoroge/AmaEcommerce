import {defineStore} from "pinia";

const api = useApi();

export const useAdminProducts = defineStore('adminProducts', {
    state: () => ({
        products: [],
        product: null,
    }),
    getters: {
        getProduct(){
            return this.product;
        }
    },
    actions: {
        async getProducts() {
            try {
                this.products = await api('/admin/products');
                console.log(this.products);
            } catch (e) {
                console.log( e.data)
            }
        },
        async fetchProduct(id){
            try {
                this.product = await api(`/admin/products/${id}`);
                console.log(this.product);

            } catch (e) {
                console.log(e.data);
            }
        }
    }
})