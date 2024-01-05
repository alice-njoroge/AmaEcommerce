<script setup>

import AppButton from "@/components/AppButton.vue";
import AppInput from "@/components/AppInput.vue";
import {useRouter} from "vue-router";
import {ref, toRaw} from "vue";
import {Form, Field} from 'vee-validate';
import {number, object, string} from 'yup';
import {useProductsStore} from "@/stores/ProductsStore";

const router = useRouter();
const productStore = useProductsStore();

const form = ref({
  name: '',
  quantity: 0
})
const veeForm = Form;
const veeField = Field;

const schema = object({
  name: string().required('Name is required'),
  quantity: number().positive().required('Quantity is required')
});
const handleClick = () => {
  router.back();
}
const handleSubmit = async validate => {
   const response = await validate();
  if (!response.valid) {
    console.log("error")
  }
  console.log("success", toRaw(form.value));
  await productStore.saveProducts(form.value);

}

</script>

<template>
  <div class="card-form">
    <h1 class="text-center"> Add Products </h1>
    <div class="flex  justify-end">
      <app-button @click="handleClick"> Back</app-button>
    </div>
    <veeForm v-slot="{ validate }" class="space-y-4" :validation-schema="schema">
        <veeField
            v-slot="{field, errors, errorMessage}"
            v-model="form.name"
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
        </veeField>

      <veeField
          v-slot="{field, errors, errorMessage}"
          v-model="form.quantity"
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
      </veeField>

      <div class="flex justify-end flex-wrap">
        <app-button class="secondary mr-2"> Cancel</app-button>
        <app-button class="primary" @click.prevent="handleSubmit(validate)"> Submit</app-button>
      </div>
    </veeForm>
  </div>
</template>

<style scoped>

</style>