<template>
  <div class="page">
    <div class="create-card fade-up">
      <router-link to="/reviews" class="back-link">← Retour</router-link>
      <h1 class="page-title">Nouvel avis</h1>
      <p class="page-sub">L'IA analysera automatiquement le sentiment et les thèmes.</p>

      <div v-if="result" class="result-box fade-up">
        <div class="result-header">
          <span>Analyse IA</span>
          <span class="badge" :class="'badge-' + (result.sentiment === 'positive' ? 'pos' : result.sentiment === 'negative' ? 'neg' : 'neu')">{{ result.sentiment }}</span>
        </div>
        <div class="result-score">Score : <strong>{{ result.score }}/100</strong></div>
        <div v-if="result.topics?.length" class="result-topics">
          <span v-for="t in result.topics" :key="t" class="topic-tag">{{ t }}</span>
        </div>
      </div>

      <div class="form-group" style="margin-top:24px">
        <label>Contenu de l'avis</label>
        <textarea v-model="content" class="input" rows="6" placeholder="Décris ton expérience..."></textarea>
      </div>

      <div style="display:flex;gap:10px;margin-top:16px">
        <button class="btn btn-primary" :disabled="loading || !content.trim()" @click="handleSubmit">
          <span v-if="loading" class="spinner"></span>
          <span v-else>Soumettre l'avis</span>
        </button>
        <router-link to="/reviews" class="btn btn-ghost">Annuler</router-link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useReviewsStore } from '../stores/reviews'

const store = useReviewsStore()
const router = useRouter()
const content = ref(''); const loading = ref(false); const result = ref(null)

async function handleSubmit() {
  loading.value = true
  try {
    const r = await store.createReview(content.value)
    result.value = { sentiment: r.sentiment, score: r.score, topics: r.topics }
    setTimeout(() => router.push('/reviews'), 1800)
  } catch (e) {
    console.error(e)
  } finally { loading.value = false }
}
</script>

<style scoped>
.page { min-height: 100vh; display: flex; align-items: flex-start; justify-content: center; padding: 40px 24px; }
.create-card { width: 100%; max-width: 600px; background: var(--bg2); border: 1px solid var(--border); border-radius: 20px; padding: 32px; }
.back-link { font-size: 13px; color: var(--text3); text-decoration: none; display: inline-block; margin-bottom: 20px; transition: color .15s; }
.back-link:hover { color: var(--text); }
.page-title { font-family: 'Syne', sans-serif; font-size: 20px; font-weight: 700; margin-bottom: 4px; }
.page-sub { color: var(--text3); font-size: 13px; }
.form-group { margin-bottom: 16px; }
textarea.input { resize: vertical; min-height: 120px; line-height: 1.6; }
.result-box { background: var(--bg3); border: 1px solid var(--border2); border-radius: var(--radius-lg); padding: 16px; margin-top: 20px; }
.result-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px; font-size: 13px; font-weight: 500; }
.result-score { font-size: 13px; color: var(--text2); margin-bottom: 10px; }
.result-topics { display: flex; gap: 6px; flex-wrap: wrap; }
.topic-tag { padding: 3px 10px; border-radius: 6px; background: var(--bg4); border: 1px solid var(--border2); font-size: 11px; color: var(--text2); }
</style>