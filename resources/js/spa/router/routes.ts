import type { RouteRecordRaw } from 'vue-router';

// Определите массив ваших маршрутов
export const routes: RouteRecordRaw[] = [
    {
        path: '/',
        name: 'home',
        // Используйте ленивую загрузку для компонентов
        component: () => import('../pages/Home.vue'),
        meta: { title: 'Главная' },
    },
    {
        path: '/about',
        name: 'about',
        component: () => import('../pages/About.vue'),
        meta: { title: 'О компании' },
    },
    {
        path: '/get',
        name: 'get.index',
        component: () => import('../pages/Get/Index.vue'),
        meta: { title: 'Get' },
    },
    {
        path: '/user',
        children: [
            {
                path: 'login',
                name: 'user.login',
                component: () => import('../pages/user/Login.vue'),
                meta: { title: 'Login Page' },
            },
            {
                path: 'registration',
                name: 'user.registration',
                component: () => import('../pages/user/Registration.vue'),
                meta: { title: 'Registration Page' },
            },
        ],
    },
    // Маршрут для страницы 404 (должен быть последним)
    {
        path: '/:pathMatch(.*)*',
        name: 'not-found',
        component: () => import('../pages/NotFound.vue'),
        meta: { title: 'Страница не найдена' },
    },
];
