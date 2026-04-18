import { createRouter, createWebHistory } from 'vue-router'
import LoginView from '../views/LoginView.vue'
import RegisterView from '../views/RegisterView.vue'
import DashboardView from '../views/DashboardView.vue'
import ReviewsView from '../views/ReviewsView.vue'
import CreateReviewView from '../views/CreateReviewView.vue'

const routes = [
  { path: '/', redirect: '/dashboard' },
  { path: '/login', component: LoginView, meta: { guest: true } },
  { path: '/register', component: RegisterView, meta: { guest: true } },
  { path: '/dashboard', component: DashboardView, meta: { auth: true } },
  { path: '/reviews', component: ReviewsView, meta: { auth: true } },
  { path: '/reviews/create', component: CreateReviewView, meta: { auth: true } },
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

router.beforeEach((to, _, next) => {
  const token = localStorage.getItem('token')
  if (to.meta.auth && !token) return next('/login')
  if (to.meta.guest && token) return next('/dashboard')
  next()
})

export default router