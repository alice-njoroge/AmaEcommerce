<script>
// imports
import CartWidget from './CartWidget.vue';
import {useAuthStore} from "@/stores/AuthStore";
import { mapWritableState} from "pinia";


export default {
  components: {CartWidget},
  computed: {
    ...mapWritableState(useAuthStore, {
      user: store => `hello ${store.user}`
    })

  }

}
</script>

<template>
  <header
      class="flex justify-between p-6 mb-10 items-center"
      style="background-image: url('/images/double-bubble-outline.png')"
  >
    <h1 class="text-4xl text-gray-700 font-bold">The Pineapple Stand</h1>
    <div class="flex justify-between gap-5 font-bold">
      <input v-model="user" type="text" >
      <span>{{user}}</span>
      <CartWidget/>
    </div>
  </header>
</template>