import axios from 'axios';

const api = axios.create({
    baseURL: import.meta.env.VITE_APP_API_URL, // ваш бэкенд
    // При включении этого параметра Axios сам читает cookie XSRF-TOKEN и добавляет заголовок X-XSRF-TOKEN.
    withCredentials: true,
    headers: {
        Accept: 'application/json',
        'Content-Type': 'application/json',
    },
});

// Автоматически запрашиваем CSRF-токен перед каждым POST/PUT/DELETE
api.interceptors.request.use(async (config) => {
    if(config.method){
        if (['post', 'put', 'delete', 'patch'].includes(config.method)) {
            // После выполнения этого GET-запроса сервер Laravel автоматически устанавливает cookie с именем XSRF-TOKEN,
            // что позволяет Laravel проверить CSRF-токен на каждом запросе.
            // Затем Axios сам читает cookie XSRF-TOKEN и добавляет заголовок X-XSRF-TOKEN с её значением во все следующие запросы,
            // если в настройках Axios указано withCredentials: true.
            await api.get('/sanctum/csrf-cookie');
        }
    }

    return config;
});

export default api;
