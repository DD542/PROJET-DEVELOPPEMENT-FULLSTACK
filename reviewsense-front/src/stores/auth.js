import { defineStore } from 'pinia'
import { ref } from 'vue'
import api from '../api/axios'

export const useAuthStore = defineStore('auth', () => {
  const user = ref(JSON.parse(localStorage.getItem('user') || 'null'))
  const token = ref(localStorage.getItem('token') || null)

  async function login(email, password) {
    const res = await api.post('/login', { email, password })
    token.value = res.data.token
    user.value = res.data.user
    localStorage.setItem('token', res.data.token)
    localStorage.setItem('user', JSON.stringify(res.data.user))
  }

  async function register(name, email, password, password_confirmation) {
    const res = await api.post('/register', { name, email, password, password_confirmation })
    token.value = res.data.token
    user.value = res.data.user
    localStorage.setItem('token', res.data.token)
    localStorage.setItem('user', JSON.stringify(res.data.user))
  }

  async function logout() {
    await api.post('/logout')
    token.value = null
    user.value = null
    localStorage.removeItem('token')
    localStorage.removeItem('user')
  }

  return { user, token, login, register, logout }
})