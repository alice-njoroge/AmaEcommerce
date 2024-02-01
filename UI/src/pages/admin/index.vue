<script setup lang="ts">
import {useAdminProducts} from "~/stores/adminProducts";

const adminProducts = useAdminProducts();
onMounted(() => {
  adminProducts.getProducts();
})

</script>

<template>
  <div class="col-md-8">
    <h1 class="text-black-700 text-center">Products</h1>
    <table class="table-fixed w-full text-left">
      <thead>
      <tr>
        <th>Product Name</th>
        <th>Image URL</th>
        <th>Quantity</th>
        <th>Price</th>
      </tr>
      </thead>
      <tbody class="text-left">
      <tr v-for="products in adminProducts.products">
        <td>{{ products.name }}</td>
        <td>
          <NuxtLink to="/">
            {{ products.imageURL }}
          </NuxtLink>
        </td>
        <td> {{products.quantity}} </td>
        <td> {{products.price}} </td>

      </tr>
      </tbody>
    </table>
  </div>

</template>

<style scoped>

</style>