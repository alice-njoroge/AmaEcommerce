<script setup>

import AppButton from "@/components/AppButton.vue";
import AppInput from "@/components/AppInput.vue";
import {useRouter} from "vue-router"
import {ref, toRaw} from "vue";

const router = useRouter();
const form = ref({
  name: '',
  quantity: 0
})

const handleClick = () => {
  router.push({name: 'ProductsList'})
}
const handleSubmit = () => {
  console.log("clicked", toRaw(form.value))
}

</script>

<template>
  <div class="card-form">
    <h1 class="text-center"> Add Products </h1>
    <div class="flex  justify-end">
      <app-button @click="handleClick"> Back</app-button>
    </div>
    <form class="space-y-4">
      <div>
        <app-input v-model="form.name" type="text" name="Name"/>
        <app-input v-model:number="form.quantity" type="number" name="Number"/>
      </div>
      <div class="flex justify-end flex-wrap">
        <app-button class="secondary mr-2"> Cancel</app-button>
        <app-button class="primary" @click.prevent="handleSubmit"> Submit</app-button>
      </div>
    </form>
  </div>
</template>

<style scoped>

</style>