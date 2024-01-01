<script setup>
const emit = defineEmits(['update:modelValue'])

const props = defineProps({
  name: {
    type: String,
    default: 'Name'
  },
  modelValue: {
    type: String,
    default: ''
  },
})



</script>

<template>
  <div>
    <div>
      <label for="name" class="block text-lg font-medium text-gray-700">{{ props.name }}</label>
      <input
          id="name"
          :value="modelValue"
          v-bind="$attrs"
          :name=props.name
          class="mt-1 block w-full px-2 py-2 border border-gray-300 rounded-md hover:border-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 sm:text-sm"
          @input=" emit('update:modelValue', $event.target.value)">
    </div>
  </div>
</template>

<style scoped>

</style>