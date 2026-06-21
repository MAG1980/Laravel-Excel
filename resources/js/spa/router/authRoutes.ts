import type { RouteRecordRaw } from 'vue-router';

// Определите массив ваших маршрутов
export const authRoutes: RouteRecordRaw[] = [
    {
        path: 'login',
        name: 'auth.login',
        component: () => import('@spa/pages/auth/Login.vue'),
        meta: { title: 'Login Page', guest: true },
    },
    {
        path: 'registration',
        name: 'auth.registration',
        component: () => import('@spa/pages/auth/Register.vue'),
        meta: { title: 'Registration Page', guest: true },
    },
    {
        path: 'forgot-password',
        name: 'auth.forgot-password',
        component: () => import('@spa/pages/auth/ForgotPassword.vue'),
        meta: { title: 'Forgot Password Page', guest: true },
    },
    {
        path: 'reset-password',
        name: 'auth.reset-password',
        component: () => import('@spa/pages/auth/ResetPassword.vue'),
        meta: { title: 'Reset Password Page', guest: true },
    },
    {
        path: 'verify-email/:id/:hash',
        name: 'auth.verify-email',
        component: () => import('@spa/pages/auth/VerifyEmail.vue'),
        meta: { title: 'Verify Email Page', requiresAuth: true },
    },
    {
        path: 'two-factor',
        name: 'auth.two-factor',
        component: () => import('@spa/pages/auth/VerifyEmail.vue'),
        meta: { title: 'Two Factor Auth Page', guest: true },
    },
];
