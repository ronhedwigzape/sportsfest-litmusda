import { createRouter, createWebHistory } from 'vue-router'
import Login from '../views/Login.vue'
import Admin from "../views/Admin.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'Home',
      component: Login
    },
    {
      path: '/about',
      name: 'Admin',
      component: Admin
    }
  ]
})

export default router
