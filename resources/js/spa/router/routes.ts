import type { RouteRecordRaw } from 'vue-router';
import { authRoutes } from '@spa/router/authRoutes';

// Определите массив ваших маршрутов
export const routes: RouteRecordRaw[] = [
    {
        path: '/',
        name: 'home',
        // Используйте ленивую загрузку для компонентов
        component: () => import('@spa/pages/Home.vue'),
        meta: { title: 'Главная' },
    },
    {
        path: '/about',
        name: 'about',
        component: () => import('@spa/pages/About.vue'),
        meta: { title: 'О компании' },
    },
    {
        path: '/get',
        name: 'get.index',
        component: () => import('@spa/pages/Get/Index.vue'),
        meta: { title: 'Get' },
    },
    {
        path: '/auth',
        children: [...authRoutes],
    },
    {
        path: '/user',
        children: [
            {
                path: '/dashboard',
                name: 'user.dashboard',
                component: () => import('@spa/pages/dashboard/Index.vue'),
                meta: { title: 'Dashboard', requiresAuth: true },
                children:[
                    {
                        path: '',
                        name: 'user.dashboard.main',
                        component: () => import('@spa/pages/dashboard/Main.vue'),
                        meta: { title: 'Main' },
                    },
                    {
                        path: '/create-post',
                        name: 'user.dashboard.create-post',
                        component: () => import('@spa/pages/dashboard/CreatePost.vue'),
                        meta: { title: 'Create Post' },
                    },
                    {
                        path: '/upload-image',
                        name: 'user.dashboard.upload-image',
                        component: () => import('@spa/pages/dashboard/UploadImage.vue'),
                        meta: { title: 'Upload Image' },
                    },
                ]
            },
            {
                path: 'login',
                name: 'user.login',
                component: () => import('@spa/pages/user/Login.vue'),
                meta: { title: 'Login Page' },
            },
            {
                path: 'registration',
                name: 'user.registration',
                component: () => import('@spa/pages/user/Registration.vue'),
                meta: { title: 'Registration Page' },
            },
        ],
    },
    // Маршрут для страницы 404 (должен быть последним)
    {
        path: '/:pathMatch(.*)*',
        name: 'not-found',
        component: () => import('@spa/pages/NotFound.vue'),
        meta: { title: 'Страница не найдена' },
    },
];
