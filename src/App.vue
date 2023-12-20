<script setup>
import TheHeader from "@/components/TheHeader.vue";
import ProductCard from "@/components/ProductCard.vue";
import {useProductsStore} from "@/stores/ProductsStore";
import {useCartStore} from "@/stores/cartStore"

import {onMounted} from "vue";

const productsStore = useProductsStore();
const cartStore = useCartStore();

const addToCart = (payload) => {
console.log("product", payload );
cartStore.items.push(payload)

}

onMounted(() => {
  productsStore.getProducts();
})
</script>

<template>
  <div class="container">
    <TheHeader/>
    <ul class="sm:flex flex-wrap lg:flex-nowrap gap-5">
      <ProductCard
          v-for="product in productsStore.products"
          :key="product.name"
          :product="product"
          @add-to-cart="addToCart"
      />
    </ul>
  </div>

</template>
