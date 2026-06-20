import { watch } from 'vue';
import { useRoute } from 'vue-router';

/**
 * Хук для управления заголовком страницы.
 * @param title - явный заголовок (если передан, используется он)
 * @param suffix - суффикс, добавляемый к заголовку (по умолчанию из env или ' | My App')
 */
export function useTitle(title?: string, suffix?: string) {
    const route = useRoute();
    const appSuffix = suffix || import.meta.env.VITE_APP_TITLE_SUFFIX || ' | My App';

    const setTitle = (newTitle: string) => {
        document.title = newTitle + appSuffix;
    };

    // Если передан явный title, используем его
    if (title !== undefined && title !== null) {
        // Гарантируем, что title - строка
        setTitle(String(title));
    } else {
        // Иначе слушаем meta.title из маршрута
        watch(
            () => route.meta.title,
            (metaTitle) => {
                // Приводим к строке, если есть
                if (metaTitle !== undefined && metaTitle !== null) {
                    setTitle(String(metaTitle));
                }
            },
            { immediate: true }
        );
    }
}
