<template>
  <div class="page">
    <div class="page-header fade-up">
      <div>
        <h1 class="page-title">Avis clients</h1>
        <p class="page-sub">{{ store.reviews.length }} avis chargés</p>
      </div>
      <router-link to="/reviews/create" class="btn btn-primary">+ Nouvel avis</router-link>
    </div>

    <div v-if="store.loading" class="loading-wrap"><span class="spinner"></span></div>

    <div v-else class="reviews-list">
      <div v-for="(r, i) in store.reviews" :key="r.id" class="review-card fade-up" :style="`animation-delay:${i*.04}s`">
        <div class="rc-header">
          <div class="rc-user">
            <div class="rc-avatar">{{ r.user?.name?.charAt(0) }}</div>
            <div>
              <div class="rc-name">{{ r.user?.name }}</div>
              <div class="rc-date">{{ formatDate(r.created_at) }}</div>
            </div>
          </div>
          <div class="rc-right">
            <span class="badge" :class="'badge-' + (r.sentiment === 'positive' ? 'pos' : r.sentiment === 'negative' ? 'neg' : 'neu')">{{ r.sentiment }}</span>
            <span class="score-pill">{{ r.score }}/100</span>
            <button class="btn btn-danger" style="padding:5px 10px;font-size:12px" @click="handleDelete(r.id)">Suppr.</button>
          </div>
        </div>
        <p class="rc-content">{{ r.content }}</p>
        <div v-if="r.topics?.length" class="rc-topics">
          <span v-for="t in r.topics" :key="t" class="topic-tag">{{ t }}</span>
        </div>
      </div>
      <div v-if="!store.reviews.length" class="empty">Aucun avis. <router-link to="/reviews/create">Créer le premier →</router-link></div>
    </div>
  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import { useReviewsStore } from '../stores/reviews'
const store = useReviewsStore()
onMounted(() => store.fetchReviews())

function formatDate(d) {
  return new Date(d).toLocaleDateString('fr-FR', { day:'2-digit', month:'short', year:'numeric' })
}
async function handleDelete(id) {
  if (confirm('Supprimer cet avis ?')) await store.deleteReview(id)
}
</script>

<style scoped>
.page { max-width: 860px; margin: 0 auto; padding: 32px 24px; }
.page-header { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 28px; }
.page-title { font-family: 'Syne', sans-serif; font-size: 22px; font-weight: 700; }
.page-sub { color: var(--text3); font-size: 14px; margin-top: 4px; }
.loading-wrap { display: flex; justify-content: center; padding: 60px; }
.reviews-list { display: flex; flex-direction: column; gap: 12px; }
.review-card { background: var(--bg2); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 18px; transition: border-color .15s; }
.review-card:hover { border-color: var(--border2); }
.rc-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; flex-wrap: wrap; gap: 8px; }
.rc-user { display: flex; align-items: center; gap: 10px; }
.rc-avatar { width: 34px; height: 34px; border-radius: 50%; background: linear-gradient(135deg,var(--accent),#34D399); display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 13px; color: #fff; flex-shrink: 0; }
.rc-name { font-size: 14px; font-weight: 500; }
.rc-date { font-size: 12px; color: var(--text3); }
.rc-right { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
.score-pill { background: var(--bg3); border: 1px solid var(--border2); border-radius: 20px; padding: 3px 10px; font-size: 12px; color: var(--text2); }
.rc-content { font-size: 14px; color: var(--text2); line-height: 1.6; margin-bottom: 12px; }
.rc-topics { display: flex; gap: 6px; flex-wrap: wrap; }
.topic-tag { padding: 3px 10px; border-radius: 6px; background: var(--bg3); border: 1px solid var(--border2); font-size: 11px; color: var(--text2); }
.empty { text-align: center; padding: 60px; color: var(--text3); font-size: 14px; }
.empty a { color: var(--accent); text-decoration: none; }
</style>