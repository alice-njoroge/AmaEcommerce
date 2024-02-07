<script setup>
import AppButton from "~/components/AppButton.vue";
import {ref} from "vue";
import {number, object, string} from "yup";

const route = useRoute();
const router = useRouter();
const adminProducts = useAdminProducts();

let id = ref();
const product = ref({
  name: '',
  quantity: 0,
  price: 0,
  productCategory: null,
  status: false,
  imageURL: ''
})

const schema = object({
  name: string().required('Name is required'),
  quantity: number().positive().required('Quantity is required'),
  price: number().positive().required('Price is required'),
});

onMounted(async () => {
  id.value = route.params.id;
  await adminProducts.fetchProduct(id.value);
  product.value = adminProducts.getProduct;
})

const handleClick = () => {
  router.back();
}
const handleSubmit = async (validate) => {
  const response = await validate();
  if (!response.valid) {
    console.log("error")
  }
  await adminProducts.editProduct(id.value, product.value);
  navigateTo(`/admin/products`);

}
const productImageURL = (imageURL) => {
  const path = new URL(`~/assets/images`, import.meta.url).href;
  return `${path}/${imageURL}`

}

</script>

<template>
  <div class="card-form" v-if="product">
    <h1 class="text-center"> {{ product.name }} </h1>
    <div class="flex  justify-end">
      <app-button @click="handleClick"> Back</app-button>
    </div>
    <VeeForm v-slot="{ validate }" class="space-y-4" :validation-schema="schema">
      <div class="flex flex-wrap justify-around">
        <div class="w-5/12">
          <VeeField
              v-slot="{field, errors, errorMessage}"
              v-model="product.name"
              name="name"
              as="div">
            <label for="name" class="block text-lg font-medium text-gray-700">Name</label>
            <input
                v-bind="field"
                id="name"
                type="text"
                class="mt-1 block w-full px-2 py-2 border border-gray-300 rounded-md hover:border-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 sm:text-sm"
                :class="{'border-red-500': !!errors.length}"
            >
            <div
                v-if="errors.length"
                class="text-red-500"
            >
              <p>
                {{ errorMessage }}
              </p>
            </div>
          </VeeField>
        </div>

        <div class="w-5/12">
          <VeeField
              v-slot="{field, errors, errorMessage}"
              v-model="product.quantity"
              name="quantity"
              as="div">
            <label for="name" class="block text-lg font-medium text-gray-700">Quantity</label>
            <input
                v-bind="field"
                id="name"
                type="number"
                class="mt-1 block w-full px-2 py-2 border border-gray-300 rounded-md hover:border-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 sm:text-sm"
                :class="{'border-red-500': !!errors.length}"
            >
            <div
                v-if="errors.length"
                class="text-red-500"
            >
              <p>
                {{ errorMessage }}
              </p>
            </div>
          </VeeField>
        </div>
      </div>
      <div class="flex flex-wrap justify-around">
        <div class="w-5/12">
          <VeeField
              v-slot="{field, errors, errorMessage}"
              v-model="product.price"
              name="price"
              as="div">
            <label for="name" class="block text-lg font-medium text-gray-700">Price</label>
            <input
                v-bind="field"
                id="price"
                type="text"
                class="mt-1 block w-full px-2 py-2 border border-gray-300 rounded-md hover:border-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 sm:text-sm"
                :class="{'border-red-500': !!errors.length}"
            >
            <div
                v-if="errors.length"
                class="text-red-500"
            >
              <p>
                {{ errorMessage }}
              </p>
            </div>
          </VeeField>
        </div>

        <div class="w-5/12">
          <VeeField
              v-slot="{field, errors, errorMessage}"
              v-model="product.productCategory"
              name="productCategory"
              as="div">
            <label for="name" class="block text-lg font-medium text-gray-700">Category</label>
            <input
                v-bind="field"
                id="productCategory"
                type="text"
                class="mt-1 block w-full px-2 py-2 border border-gray-300 rounded-md hover:border-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 sm:text-sm"
                :class="{'border-red-500': !!errors.length}"
            >
            <div
                v-if="errors.length"
                class="text-red-500"
            >
              <p>
                {{ errorMessage }}
              </p>
            </div>
          </VeeField>
        </div>
      </div>
      <div class="flex flex-wrap justify-around">
        <div class="card ml-10 w-5/12">
          <img :src="productImageURL(product.imageURL)" class="mb-3" width="300" alt=""/>
          <app-button class="secondary mr-2"> Update Image</app-button>
        </div>

        <div class="w-4/12">
          <label class="block text-lg font-medium text-gray-700 mb-1.5" > Product Status </label>
          <label class="relative inline-flex items-center cursor-pointer ml-2.5">
            <input type="checkbox" v-model="product.status" :true-value="true" :false-value="false" class="sr-only peer">
            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></div>
            <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Deactivate Product </span>
          </label>
        </div>
      </div>

      <div class="flex justify-end flex-wrap">
        <app-button class="secondary mr-2"> Cancel</app-button>
        <app-button class="primary" @click.prevent="handleSubmit(validate)"> Submit</app-button>
      </div>
    </VeeForm>
  </div>
</template>

<style scoped>

</style>