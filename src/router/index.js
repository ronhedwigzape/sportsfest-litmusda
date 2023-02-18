import { createRouter, createWebHistory } from 'vue-router'
import Login from '../views/Login.vue';
import Admin from "../views/Admin.vue";
import Judge from "../views/Judge.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'Home',
      component: Login
    },
    {
      path: '/admin',
      name: 'Admin',
      component: Admin
    },
    {
      path: '/judge',
      name: 'Judge',
      component: Judge
    }
  ]
})

export default router
