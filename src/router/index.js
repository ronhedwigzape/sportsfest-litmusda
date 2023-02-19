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
      component: Admin,
      beforeEnter: (to, from, next) => {
        if (to.path === '/admin') {
          next('/');
        } else {
          next();
        }
      },
    },
    {
      path: '/judge',
      name: 'Judge',
      component: Judge,
      beforeEnter: (to, from, next) => {
        if (to.path === '/judge') {
          next('/');
        } else {
          next();
        }
      },
    }
  ]
})

export default router
