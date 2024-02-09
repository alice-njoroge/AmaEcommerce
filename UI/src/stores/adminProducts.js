import {defineStore} from "pinia";
import {ofetch} from "ofetch";

const api = useApi();

export const useAdminProducts = defineStore('adminProducts', {
    state: () => ({
        products: [],
        product: null,
    }),
    getters: {
        getProduct() {
            return this.product;
        }
    },
    actions: {
        async getProducts() {
            try {
                this.products = await api('/admin/products');
                console.log(this.products);
            } catch (e) {
                console.log(e.data)
            }
        },
        async fetchProduct(id) {
            try {
                this.product = await api(`/admin/products/${id}`);
                console.log(this.product);

            } catch (e) {
                console.log(e.data);
            }
        },
        async uploadImage(formData) {
            return  await api('/admin/products-upload', {
                method: 'POST',
                body: formData,
            })

        },
        async editProduct(id, formValues) {
            try {
                const response = await api(`/admin/products/${id}`, {
                    method: 'PUT',
                    body: formValues
                });
                console.log("edit resp", response);
            } catch (e) {
                console.log(e.data);
            }
        }
    }
})