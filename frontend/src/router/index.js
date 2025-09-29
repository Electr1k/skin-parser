import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'main',
    component: () => import('./../pages/Main.vue')
  },

]

const index = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})


export default index
