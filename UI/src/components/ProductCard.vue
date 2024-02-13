<script setup>
// imports
import {ref} from "vue";
import AppCountInput from "./AppCountInput.vue";

// props
defineProps({
  product: {
    type: Object
  },
});

const productImageURL = (imageURL) => {

  const path = new URL(`~/assets/images`, import.meta.url).href;
  return `${path}/${imageURL}`

}

// emits
defineEmits(["addToCart"])

// data
const count = ref(0);
</script>
<template>
  <li class="card">
    <p class="flex justify-end text-red-500" v-if="product.quantity < 10"> only {{product.quantity}} items left! </p>
    <img :src="productImageURL(product.imageURL)" class="mb-3" width="300" alt=""/>
    <div>
      {{ product.name }} - <span class="text-green-500">${{ product.price }}</span>
      <div class="text-center m-4">
        <AppCountInput v-model="count"/>
      </div>
      <AppButton
          :disabled="count === 0"
          class="primary" @click="$emit('addToCart', count), (count = 0)"
      >Add to Cart
      </AppButton>
    </div>
  </li>
</template>
