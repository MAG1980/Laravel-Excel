// resources/js/spa/router.ts
import { createWebHistory, createRouter } from 'vue-router'

// Определите массив ваших маршрутов
const routes = [
    {
        path: '/',
        name: 'home',
        // Используйте ленивую загрузку для компонентов
        component: () => import('./pages/Home.vue')
    },
    {
        path: '/about',
        name: 'about',
        component: () => import('./pages/About.vue')
    },
    // Маршрут для страницы 404 (должен быть последним)
    {
        path: '/:pathMatch(.*)*',
        name: 'not-found',
        component: () => import('./pages/NotFound.vue')
    }
]

// Создаём экземпляр Vue Router
const router = createRouter({
    // createWebHistory() создаёт ЧПУ-URL без символа '#'[reference:2]
    //Если ваше SPA-приложение обслуживается сервером (например, Laravel) именно по префиксу /spa
    // (т.е. все URL вида /spa/* ведут на один и тот же HTML-файл, в котором живёт Vue),
    // то клиентский роутер должен учитывать этот базовый путь.
    history: createWebHistory(import.meta.env.VITE_SPA_BASE_URL),
    routes,
})

// Экспортируем созданный экземпляр для использования в main.ts
export default router
