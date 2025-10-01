import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'main',
    component: () => import('../pages/SkinSearch.vue')
  },
  {
    path: '/dashboard',
    name: 'dashboard',
    component: () => import('./../pages/Dashboard.vue') // Создайте этот файл
  },
  {
    path: '/found-skins',
    name: 'found-skins',
    component: () => import('../pages/Skins.vue') // Создайте этот файл
  },
  {
    path: '/settings',
    name: 'settings',
    component: () => import('./../pages/Settings.vue') // Создайте этот файл
  }
]

const index = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default index
