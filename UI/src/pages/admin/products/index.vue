<script setup lang="ts">
import {useAdminProducts} from "~/stores/adminProducts";
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
import {faPenToSquare, faTrashCan} from '@fortawesome/free-solid-svg-icons'

console.log(faPenToSquare)
const adminProducts = useAdminProducts();

const editProduct = async (id: number) => {
  navigateTo(`/admin/products/${id}`);
}

onMounted(() => {
  adminProducts.getProducts();
})

</script>

<template>

  <div class="card-table relative overflow-x-auto shadow-md sm:rounded-lg">
    <h1 class="text-center dark:text-green-700 font-bold mt-3 ">Products</h1>
    <table class="w-full text-sm text-left rtl:text-right text-black-700">
      <thead class="text-left text-green-700 uppercase border-b dark:border-gray-700">
      <tr class="font-bold text-black-900">
        <th scope="col" class="pl-4 py-7">Product Name</th>
        <th scope="col" class="py-7">Image URL</th>
        <th scope="col" class="py-7">Quantity</th>
        <th scope="col" class="py-7">Price</th>
        <th scope="col" class="py-7">Status</th>
        <th scope="col" class="py-7">Actions</th>
      </tr>
      </thead>
      <tbody class="text-left">
      <tr class="bg-white border-b dark:border-gray-300" v-for="product in adminProducts.products">
        <td class="px-6 py-4">{{ product.name }}</td>
        <td>
          <NuxtLink to="/">
            {{ product.imageURL }}
          </NuxtLink>
        </td>
        <td> {{ product.quantity }}</td>
        <td> {{ product.price }}</td>
        <td> {{ product.status === true ? 'Active' : 'Inactive'  }}</td>
        <td>
          <button @click="editProduct(product.id)">
            <font-awesome-icon :icon="faPenToSquare" class="mr-4"/>
          </button>
          <button>
            <font-awesome-icon :icon="faTrashCan"/>
          </button>
        </td>

      </tr>
      </tbody>
    </table>

  </div>
</template>

<style scoped>

</style>