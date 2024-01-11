<script setup>
import TheHeader from "@/components/TheHeader.vue";
import {useAuthStore} from "@/stores/AuthStore";
const auth = useAuthStore();

</script>

<template>
  <div class="container">
    <TheHeader v-if="auth.isLoggedIn"/>
    <router-view/>
  </div>

</template>
