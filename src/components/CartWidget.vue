<script setup>
// imports
import {ref} from "vue";
import CartItem from "./CartItem.vue";

import {useCartStore} from "@/stores/cartStore";

const cartStore = useCartStore();

// data
const active = ref(false);
</script>
<template>
  <div class="relative">
    <!-- Icon that always shows -->
    <span class="cursor-pointer" @click="active = true">
      <fa icon="shopping-cart" size="lg" class="text-gray-700"/>
      <div class="cart-count absolute">{{ cartStore.totalItems }}</div>
    </span>
    <!-- Modal Overlay only shows when cart is clicked on -->
    <AppModalOverlay :active="active" @close="active = false">
      <div v-if="cartStore.totalItems > 0 ">
        <ul v-for="item in cartStore.items" :key="item.product.id" class="items-in-cart">
          <CartItem
              v-model="item.count"
              :product="item.product"
              :count="item.count"
              @updateCount="cartStore.updateCount(item, $event)"
              @clear="cartStore.removeItem(item.product)"
          />

        </ul>
        <div class="flex justify-end text-2xl mb-5">
          Total: <strong>${{cartStore.cartTotals}}</strong>
        </div>
        <div class="flex justify-end">
          <AppButton @click="cartStore.$reset()" class="secondary mr-2">Clear Cart</AppButton>
          <AppButton class="primary">Checkout</AppButton>
        </div>
      </div>
      <!-- Uncomment and use condition to show when cart is empty -->
      <div v-else><em>Cart is Empty</em></div>
    </AppModalOverlay>
  </div>
</template>
<style lang="pcss" scoped>
.items-in-cart {
  @apply mb-5;
}

.items-in-cart li {
  @apply flex justify-between p-2;
}

.items-in-cart li:nth-of-type(even) {
  @apply bg-gray-300;
}
</style>
