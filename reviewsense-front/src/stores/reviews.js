import { defineStore } from 'pinia'
import { ref } from 'vue'
import api from '../api/axios'

export const useReviewsStore = defineStore('reviews', () => {
  const reviews = ref([])
  const dashboard = ref(null)
  const loading = ref(false)

  async function fetchReviews() {
    loading.value = true
    const res = await api.get('/reviews')
    reviews.value = res.data.data
    loading.value = false
  }

  async function fetchDashboard() {
    const res = await api.get('/dashboard')
    dashboard.value = res.data
  }

  async function createReview(content) {
    const res = await api.post('/reviews', { content })
    reviews.value.unshift(res.data)
    return res.data
  }

  async function deleteReview(id) {
    await api.delete(`/reviews/${id}`)
    reviews.value = reviews.value.filter(r => r.id !== id)
  }

  return { reviews, dashboard, loading, fetchReviews, fetchDashboard, createReview, deleteReview }
})