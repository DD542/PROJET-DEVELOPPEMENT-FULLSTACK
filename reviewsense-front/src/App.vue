<template>
  <div>
    <NavBar v-if="auth.token" />
    <router-view v-slot="{ Component }">
      <transition name="page" mode="out-in">
        <component :is="Component" />
      </transition>
    </router-view>
  </div>
</template>

<script setup>
import NavBar from './components/NavBar.vue'
import { useAuthStore } from './stores/auth'
const auth = useAuthStore()
</script>