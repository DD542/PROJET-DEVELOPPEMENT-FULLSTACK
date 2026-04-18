<template>
  <div class="auth-page">
    <div class="auth-card fade-up">
      <div class="auth-logo">RS</div>
      <h1 class="auth-title">Créer un compte</h1>
      <p class="auth-sub">Rejoins ReviewSense</p>
      <div v-if="error" class="error-msg">{{ error }}</div>
      <div class="form-group"><label>Nom</label><input v-model="name" class="input" placeholder="Dylan" /></div>
      <div class="form-group"><label>Email</label><input v-model="email" type="email" class="input" placeholder="toi@exemple.com" /></div>
      <div class="form-group"><label>Mot de passe</label><input v-model="password" type="password" class="input" placeholder="••••••••" /></div>
      <div class="form-group"><label>Confirmer</label><input v-model="confirm" type="password" class="input" placeholder="••••••••" @keyup.enter="handleRegister" /></div>
      <button class="btn btn-primary" style="width:100%;justify-content:center;margin-top:8px" :disabled="loading" @click="handleRegister">
        <span v-if="loading" class="spinner"></span>
        <span v-else>S'inscrire</span>
      </button>
      <p class="auth-footer">Déjà un compte ? <router-link to="/login">Se connecter</router-link></p>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '../stores/auth'

const auth = useAuthStore()
const router = useRouter()
const name = ref(''); const email = ref(''); const password = ref(''); const confirm = ref('')
const loading = ref(false); const error = ref('')

async function handleRegister() {
  loading.value = true; error.value = ''
  try {
    await auth.register(name.value, email.value, password.value, confirm.value)
    router.push('/dashboard')
  } catch (e) {
    error.value = e.response?.data?.message || 'Erreur lors de l\'inscription.'
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