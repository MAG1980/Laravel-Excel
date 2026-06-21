import { createWebHistory, createRouter } from 'vue-router';
import { routes } from '@spa/router/routes';

// Создаём экземпляр Vue Router
const router = createRouter({
    // createWebHistory() создаёт ЧПУ-URL без символа '#'[reference:2]
    //Если ваше SPA-приложение обслуживается сервером (например, Laravel) именно по префиксу /spa
    // (т.е. все URL вида /spa/* ведут на один и тот же HTML-файл, в котором живёт Vue),
    // то клиентский роутер должен учитывать этот базовый путь.
    history: createWebHistory(import.meta.env.VITE_SPA_BASE_URL),
    routes,
});

// Экспортируем созданный экземпляр для использования в main.ts
export default router;
