import { createRouter, createWebHistory } from 'vue-router'
import store from '../store'

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/',
            name: 'login',
            component: () => import('../views/Login.vue'),
            beforeEnter: (to, from, next) => {
                const user = store.getters['auth/getUser'];
                if(user)
                    next({ name: user.userType });
                else
                    next();
            }
        },
        {
            path: '/admin/:eventSlug?',
            name: 'admin',
            component: () => import('../views/Admin.vue'),
            beforeEnter: (to, from, next) => {
                const user = store.getters['auth/getUser'];
                if(!user)
                    next({ name: 'login' });
                else {
                    if(user.userType !== to.name)
                        next({ name: user.userType })
                    else
                        next();
                }
            }
        },
        {
            path: '/judge/:eventSlug?',
            name: 'judge',
            component: () => import('../views/Judge.vue'),
            beforeEnter: (to, from, next) => {
                const user = store.getters['auth/getUser'];
                if(!user)
                    next({ name: 'login' });
                else {
                    if(user.userType !== to.name)
                        next({ name: user.userType })
                    else
                        next();
                }
            }
        },
        {
            path: '/technical/:eventSlug?',
            name: 'technical',
            component: () => import('../views/Technical.vue'),
            beforeEnter: (to, from, next) => {
                const user = store.getters['auth/getUser'];
                if(!user)
                    next({ name: 'login' });
                else {
                    if(user.userType !== to.name)
                        next({ name: user.userType })
                    else
                        next();
                }
            }
        }
    ]
})

export default router
