<template>
  <nav class="navbar">
    <div class="nav-brand">
      <div class="nav-logo">RS</div>
      <span class="nav-name">ReviewSense</span>
    </div>
    <div class="nav-links">
      <router-link to="/dashboard" class="nav-link">Dashboard</router-link>
      <router-link to="/reviews" class="nav-link">Avis</router-link>
      <router-link to="/reviews/create" class="nav-link">+ Nouvel avis</router-link>
    </div>
    <div class="nav-right">
      <span class="nav-user">{{ auth.user?.name }}</span>
      <button class="btn btn-ghost" style="padding:6px 12px;font-size:13px" @click="handleLogout">Déconnexion</button>
    </div>
  </nav>
</template>

<script setup>
import { useAuthStore } from '../stores/auth'
import { useRouter } from 'vue-router'
const auth = useAuthStore()
const router = useRouter()
async function handleLogout() {
  await auth.logout()
  router.push('/login')
}
</script>

<style scoped>
.navbar {
  display: flex; align-items: center; justify-content: space-between;
  padding: 14px 28px; border-bottom: 1px solid var(--border);
  background: var(--bg); position: sticky; top: 0; z-index: 100;
  backdrop-filter: blur(10px);
}
.nav-brand { display: flex; align-items: center; gap: 10px; }
.nav-logo {
  width: 32px; height: 32px; background: var(--accent); border-radius: 8px;
  display: flex; align-items: center; justify-content: center;
  font-family: 'Syne', sans-serif; font-weight: 700; font-size: 13px; color: #fff;
}
.nav-name { font-family: 'Syne', sans-serif; font-weight: 700; font-size: 16px; }
.nav-links { display: flex; gap: 4px; }
.nav-link {
  padding: 7px 14px; border-radius: 8px; font-size: 13px;
  color: var(--text2); text-decoration: none; transition: all .15s;
}
.nav-link:hover { background: var(--bg3); color: var(--text); }
.nav-link.router-link-active { background: var(--bg3); color: var(--accent); }
.nav-right { display: flex; align-items: center; gap: 12px; }
.nav-user { font-size: 13px; color: var(--text3); }
</style>