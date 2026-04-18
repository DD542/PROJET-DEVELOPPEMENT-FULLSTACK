<template>
  <div class="page">
    <div class="page-header fade-up">
      <div>
        <h1 class="page-title">Dashboard</h1>
        <p class="page-sub">Vue d'ensemble des avis clients</p>
      </div>
    </div>

    <div v-if="!store.dashboard" class="loading-wrap"><span class="spinner"></span></div>

    <template v-else>
      <div class="stats-grid fade-up">
        <div class="stat-card">
          <div class="stat-label">Total avis</div>
          <div class="stat-value">{{ store.dashboard.total }}</div>
        </div>
        <div class="stat-card">
          <div class="stat-label">Score moyen</div>
          <div class="stat-value">{{ store.dashboard.average_score }}<span class="stat-unit">/100</span></div>
        </div>
        <div class="stat-card">
          <div class="stat-label">Positifs</div>
          <div class="stat-value" style="color:var(--pos)">{{ store.dashboard.sentiment_breakdown.positive_pct }}%</div>
        </div>
        <div class="stat-card">
          <div class="stat-label">Négatifs</div>
          <div class="stat-value" style="color:var(--neg)">{{ store.dashboard.sentiment_breakdown.negative_pct }}%</div>
        </div>
      </div>

      <div class="two-col fade-up" style="animation-delay:.1s">
        <div class="card">
          <h2 class="card-title">Avis récents</h2>
          <div v-for="r in store.dashboard.recent_reviews" :key="r.id" class="review-row">
            <div class="review-meta">
              <span class="review-author">{{ r.user?.name }}</span>
              <span class="badge" :class="'badge-' + (r.sentiment === 'positive' ? 'pos' : r.sentiment === 'negative' ? 'neg' : 'neu')">
                {{ r.sentiment }}
              </span>
            </div>
            <p class="review-content">{{ r.content }}</p>
          </div>
          <div v-if="!store.dashboard.recent_reviews?.length" class="empty">Aucun avis pour l'instant.</div>
        </div>

        <div class="card">
          <h2 class="card-title">Top thèmes</h2>
          <div v-if="store.dashboard.top_topics?.length">
            <div v-for="(t, i) in store.dashboard.top_topics" :key="t" class="topic-row" :style="`animation-delay:${i*.06}s`">
              <span class="topic-rank">#{{ i+1 }}</span>
              <span class="topic-name">{{ t }}</span>
            </div>
          </div>
          <div v-else class="empty">Pas encore de thèmes détectés.</div>

          <div style="margin-top:24px">
            <h2 class="card-title">Répartition</h2>
            <div class="sent-row"><span class="sent-label">Positif</span><div class="sent-bar-bg"><div class="sent-bar-fill" :style="`width:${store.dashboard.sentiment_breakdown.positive_pct}%;background:var(--pos)`"></div></div><span class="sent-pct">{{ store.dashboard.sentiment_breakdown.positive_pct }}%</span></div>
            <div class="sent-row"><span class="sent-label">Neutre</span><div class="sent-bar-bg"><div class="sent-bar-fill" :style="`width:${100 - store.dashboard.sentiment_breakdown.positive_pct - store.dashboard.sentiment_breakdown.negative_pct}%;background:var(--neu)`"></div></div><span class="sent-pct">{{ 100 - store.dashboard.sentiment_breakdown.positive_pct - store.dashboard.sentiment_breakdown.negative_pct }}%</span></div>
            <div class="sent-row"><span class="sent-label">Négatif</span><div class="sent-bar-bg"><div class="sent-bar-fill" :style="`width:${store.dashboard.sentiment_breakdown.negative_pct}%;background:var(--neg)`"></div></div><span class="sent-pct">{{ store.dashboard.sentiment_breakdown.negative_pct }}%</span></div>
          </div>
        </div>
      </div>
    </template>
  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import { useReviewsStore } from '../stores/reviews'
const store = useReviewsStore()
onMounted(() => store.fetchDashboard())
</script>

<style scoped>
.page { max-width: 1100px; margin: 0 auto; padding: 32px 24px; }
.page-header { margin-bottom: 28px; }
.page-title { font-family: 'Syne', sans-serif; font-size: 22px; font-weight: 700; }
.page-sub { color: var(--text3); font-size: 14px; margin-top: 4px; }
.loading-wrap { display: flex; justify-content: center; padding: 60px; }
.stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-bottom: 20px; }
@media(max-width:700px) { .stats-grid { grid-template-columns: repeat(2,1fr); } }
.stat-card { background: var(--bg2); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 18px; }
.stat-label { font-size: 11px; color: var(--text3); text-transform: uppercase; letter-spacing: .05em; margin-bottom: 8px; }
.stat-value { font-family: 'Syne', sans-serif; font-size: 28px; font-weight: 700; }
.stat-unit { font-size: 14px; color: var(--text3); }
.two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
@media(max-width:700px) { .two-col { grid-template-columns: 1fr; } }
.card-title { font-family: 'Syne', sans-serif; font-size: 14px; font-weight: 700; margin-bottom: 16px; }
.review-row { padding: 12px 0; border-bottom: 1px solid var(--border); }
.review-row:last-child { border-bottom: none; }
.review-meta { display: flex; align-items: center; gap: 8px; margin-bottom: 5px; }
.review-author { font-size: 13px; font-weight: 500; }
.review-content { font-size: 13px; color: var(--text2); line-height: 1.5; }
.topic-row { display: flex; align-items: center; gap: 10px; padding: 8px 0; border-bottom: 1px solid var(--border); animation: fadeUp .3s ease both; }
.topic-rank { font-family: 'Syne', sans-serif; font-size: 13px; color: var(--accent); font-weight: 700; width: 24px; }
.topic-name { font-size: 14px; text-transform: capitalize; }
.sent-row { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; }
.sent-label { font-size: 12px; color: var(--text2); width: 52px; }
.sent-bar-bg { flex: 1; height: 5px; background: var(--bg4); border-radius: 3px; }
.sent-bar-fill { height: 5px; border-radius: 3px; transition: width .6s ease; }
.sent-pct { font-size: 12px; color: var(--text3); width: 32px; text-align: right; }
.empty { font-size: 13px; color: var(--text3); padding: 20px 0; text-align: center; }
</style>