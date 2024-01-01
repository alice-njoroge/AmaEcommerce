<script setup>
import ProductCard from "@/components/ProductCard.vue";
import {useProductsStore} from "@/stores/ProductsStore";
import {useCartStore} from "@/stores/CartStore"
import {useRouter} from "vue-router";

const router = useRouter();

import {onMounted} from "vue";

const productsStore = useProductsStore();
const cartStore = useCartStore();

const addToCart = (count, product) => {
  cartStore.addToCart({count: count, product: product})
}
const handleClick = ()=>{
  router.push({name: 'ProductsCreate'})
}

onMounted(() => {
  productsStore.getProducts();
})
</script>

<template>
  <div>
    <div class="flex justify-end">
      <app-button  class="secondary mb-2" @click=handleClick> Create New </app-button>
    </div>
    <ul class="sm:flex flex-wrap lg:flex-nowrap gap-5">
      <ProductCard
          v-for="product in productsStore.products"
          :key="product.name"
          :product="product"
          @add-to-cart="addToCart($event, product)"
      />
    </ul>
  </div>

</template>

<style scoped>

</style>