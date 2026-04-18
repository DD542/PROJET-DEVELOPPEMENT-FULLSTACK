<template>
  <div class="auth-page">
    <div class="auth-card fade-up">
      <div class="auth-logo">RS</div>
      <h1 class="auth-title">Bon retour</h1>
      <p class="auth-sub">Connecte-toi à ReviewSense</p>

      <div v-if="error" class="error-msg">{{ error }}</div>

      <div class="form-group">
        <label>Email</label>
        <input v-model="email" type="email" class="input" placeholder="toi@exemple.com" />
      </div>
      <div class="form-group">
        <label>Mot de passe</label>
        <input v-model="password" type="password" class="input" placeholder="••••••••" @keyup.enter="handleLogin" />
      </div>
      <button class="btn btn-primary" style="width:100%;justify-content:center;margin-top:8px" :disabled="loading" @click="handleLogin">
        <span v-if="loading" class="spinner"></span>
        <span v-else>Se connecter</span>
      </button>
      <p class="auth-footer">Pas de compte ? <router-link to="/register">S'inscrire</router-link></p>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '../stores/auth'

const auth = useAuthStore()
const router = useRouter()
const email = ref(''); const password = ref(''); const loading = ref(false); const error = ref('')

async function handleLogin() {
  loading.value = true; error.value = ''
  try {
    await auth.login(email.value, password.value)
    router.push('/dashboard')
  } catch (e) {
    error.value = 'Identifiants incorrects.'
  } finally { loading.value = false }
}
</script>

<style scoped>
.auth-page { min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 24px; }
.auth-card { width: 100%; max-width: 400px; background: var(--bg2); border: 1px solid var(--border); border-radius: 20px; padding: 36px; }
.auth-logo { width: 44px; height: 44px; background: var(--accent); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-family: 'Syne', sans-serif; font-weight: 700; color: #fff; font-size: 16px; margin-bottom: 20px; }
.auth-title { font-family: 'Syne', sans-serif; font-size: 22px; font-weight: 700; margin-bottom: 4px; }
.auth-sub { color: var(--text3); font-size: 14px; margin-bottom: 28px; }
.form-group { margin-bottom: 16px; }
.error-msg { background: var(--neg-bg); color: var(--neg); border: 1px solid rgba(248,113,113,.2); border-radius: var(--radius); padding: 10px 14px; font-size: 13px; margin-bottom: 16px; }
.auth-footer { text-align: center; font-size: 13px; color: var(--text3); margin-top: 20px; }
.auth-footer a { color: var(--accent); text-decoration: none; }
</style>