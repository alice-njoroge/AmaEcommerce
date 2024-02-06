<script setup lang="ts">
import {useAdminProducts} from "~/stores/adminProducts";
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
import { faPenToSquare, faTrashCan } from '@fortawesome/free-solid-svg-icons'

console.log(faPenToSquare)
const adminProducts = useAdminProducts();
onMounted(() => {
  adminProducts.getProducts();
})

</script>

<template>


  <h1 class="text-center dark:text-black-700 font-bold ">Products</h1>


    <div class="card-table relative overflow-x-auto shadow-md sm:rounded-lg">
      <table class="w-full text-sm text-left rtl:text-right text-black-500 ">
        <thead class="text-left text-green-700 uppercase border-b dark:border-gray-700">
        <tr class="font-bold text-black-900">
          <th scope="col" class="pl-2 py-7">Product Name</th>
          <th scope="col" class="py-7">Image URL</th>
          <th scope="col" class="py-7">Quantity</th>
          <th scope="col" class="py-7">Price</th>
          <th scope="col" class="py-7">Actions</th>
        </tr>
        </thead>
        <tbody class="text-left">
        <tr class="bg-white border-b dark:border-gray-300" v-for="products in adminProducts.products">
          <td class="px-6 py-4">{{ products.name }}</td>
          <td>
            <NuxtLink to="/">
              {{ products.imageURL }}
            </NuxtLink>
          </td>
          <td> {{ products.quantity }}</td>
          <td> {{ products.price }}</td>
          <td>
            <font-awesome-icon :icon="faPenToSquare" class="mr-4" />
            <font-awesome-icon :icon="faTrashCan" />
          </td>

        </tr>
        </tbody>
      </table>

    </div>
</template>

<style scoped>

</style>