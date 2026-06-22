import { createWebHistory, createRouter } from 'vue-router';
import { routes } from '@spa/router/routes';
import { useAuthStore } from '@spa/stores/auth';

// Создаём экземпляр Vue Router
const router = createRouter({
    // createWebHistory() создаёт ЧПУ-URL без символа '#'[reference:2]
    //Если ваше SPA-приложение обслуживается сервером (например, Laravel) именно по префиксу /spa
    // (т.е. все URL вида /spa/* ведут на один и тот же HTML-файл, в котором живёт Vue),
    // то клиентский роутер должен учитывать этот базовый путь.
    history: createWebHistory(import.meta.env.VITE_SPA_BASE_URL),
    routes,
});

// Глобальный хук для защиты маршрутов
router.beforeEach(async (to, from) => {
    const authStore = useAuthStore();

    // 1. Если статус авторизации неизвестен (например, после обновления страницы),
    //    запрашиваем данные пользователя с бэкенда.
    if (!authStore.isLoggedIn) {
        await authStore.fetchUser(); // внутри происходит запрос к /api/user
    }

    // 2. Если маршрут требует авторизации, а пользователь не авторизован
    if (to.meta.requiresAuth && !authStore.isLoggedIn) {
        // Если не авторизован – отправляем на страницу входа
        return { name: 'auth.login' };
    }
    // 3. Если маршрут для гостей (login, register) и пользователь уже авторизован –
    //    перенаправляем на dashboard, чтобы он не видел формы входа
    if (to.meta.guest && authStore.isLoggedIn) {
        return { name: 'dashboard' };
    }
    // 4. Во всех остальных случаях разрешаем переход
    return true;
});

// Экспортируем созданный экземпляр для использования в main.ts
export default router;
