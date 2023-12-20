import {defineStore} from "pinia";
import {computed, ref} from "vue";

export const useCartStore = defineStore('cartStore',
    () => {
        const items = ref([]);

        const addToCart = (item) => {
            items.value.push(item);
        }

        const $reset = () => {
            items.value = [];
        }
        const totalItems = computed(() => {
            //just because we want to feel important with our reducer function :)
            return items.value.reduce((accumulator, current) => {
                return accumulator + current.count;
            }, 0)
        })

        return {addToCart, items, $reset, totalItems}

    })