import axios from 'axios';
import { createPinia } from 'pinia';
import { createApp } from 'vue';
import App from './App.vue';
import router from './router';      // Vue Router
import '../../css/spa.css'; // отдельные стили для SPA (опционально)

// Настройка Axios для работы с Sanctum (httpOnly cookies)
axios.defaults.withCredentials = true;
axios.defaults.baseURL = import.meta.env.VITE_API_URL || '/api';

const app = createApp(App);
app.use(createPinia());
app.use(router);
app.mount('#app');
