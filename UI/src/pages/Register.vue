<template>
  <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
      <img
          class="mx-auto h-10 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600"
          alt="Your Company">
      <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Sign up to the
        Platform</h2>
    </div>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
      <VeeForm v-slot="{ validate }" class="space-y-6" :validation-schema="schema">

        <VeeField
            v-slot="{ errors, errorMessage, field}"
            v-model="form.email"
            name="email"
            as="div"
        >
          <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
          <div class="mt-2">
            <input
                id="email"
                v-bind="field"
                name="email"
                autocomplete="email"
                required
                class="block w-full rounded-md border-0 p-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                :class="{'border-red-500': !!errors.length}"
            >
            <div v-if="errors.length" class="text-red-500">
              <p>
                {{ errorMessage }}
              </p>
            </div>
          </div>
        </VeeField>

        <VeeField
            v-slot="{ errors, errorMessage, field }"
            v-model="form.password"
            name="password"
            as="div">
          <div class="flex items-center justify-between">
            <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
          </div>
          <div class="mt-2">
            <input
                v-bind="field"
                id="password"
                type="password"
                autocomplete="current-password"
                required
                class="block w-full rounded-md border-0 p-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                :class="{'border-red-500': !!errors.length }"
            >
            <div v-if="errors.length" class="text-red-500">
              <p>
                {{ errorMessage }}
              </p>
            </div>
          </div>
        </VeeField>
        <VeeField
            v-slot="{ errors, errorMessage, field }"
            v-model="form.confirmPassword"
            name="confirmPassword"
            as="div">
          <div class="flex items-center justify-between">
            <label for="confirmPassword" class="block text-sm font-medium leading-6 text-gray-900">Confirm
              Password</label>
          </div>
          <div class="mt-2">
            <input
                v-bind="field"
                id="confirmPassword"
                name="confirmPassword"
                type="password"
                autocomplete="current-password"
                required
                class="block w-full rounded-md border-0 p-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                :class="{ 'border-red-500': !!errors.length }"
                >
            <div v-if="errors.length" class="text-red-500">
              <p>
                {{ errorMessage }}
              </p>
            </div>
          </div>
        </VeeField>

        <div>
          <button
              type="submit"
              class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
              @click.prevent="handleSubmit(validate)">
            Sign Up
          </button>
        </div>
      </VeeForm>
    </div>
  </div>
</template>

<script setup>
import {ref} from 'vue';
import {Form, Field} from 'vee-validate';
import {object, string, ref as yupRef} from "yup";
import {useAuthStore} from "~/stores/AuthStore.js";

const authStore = useAuthStore();
const veeForm = Form;
const veeField = Field;

definePageMeta({
  layout: 'plain'
})

const form = ref({
  email: '',
  password: '',
  confirmPassword: ''
})
const schema = object({
  email: string().required('Email address is required').email('Invalid email address'),
  password: string().required('Password is required').min(8, 'Password is too short - minimum 8 characters'),
  confirmPassword: string().required('Confirm Password is required').oneOf([yupRef('password'), null], 'Passwords must match')
});

const handleSubmit = async validate => {
  const response = await validate();
  if (!response.valid){
    console.log("error", response);
  }
  await authStore.registerUser(form.value);


}
</script>

<style scoped>
/* You can add your specific styles here */
</style>