<template>
    <div id="app">
        <nav class="flex gap-4">
            <router-link :to="{ name: 'home' }">Home</router-link>
            <router-link :to="{ name: 'about' }">About</router-link>
            <router-link :to="{ name: 'get.index' }">Get</router-link>
            <router-link v-if="!isLoggedIn" :to="{ name: 'auth.login' }"
                >Login
            </router-link>
            <router-link v-if="!isLoggedIn" :to="{ name: 'auth.registration' }"
                >Registration
            </router-link>
            <router-link v-if="isLoggedIn" :to="{ name: 'user.dashboard' }"
                >Dashboard
            </router-link>
            <button v-if="isLoggedIn" @click="exit">Logout</button>
        </nav>
    </div>
</template>

<script setup lang="ts">
import { storeToRefs } from 'pinia';
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '@spa/stores/auth';
import type { ActionResult } from '@spa/stores/types';

const router = useRouter();

const authStore = useAuthStore();
const { isLoggedIn } = storeToRefs(authStore);

// Реактивная переменная для сообщения об ошибке (опционально)
const logoutError = ref<string | null>(null);
const exit = async () => {
    logoutError.value = null;
    const result: ActionResult = await authStore.logout();
    if (result.success) {
        // Успешный выход – перенаправляем на логин
        router.push({ name: 'auth.login' });
    } else {
        console.error('Ошибка выхода:', result.errors);
        // Безопасное извлечение первого сообщения
        const firstErrorMessage = result.errors
            ? Object.values(result.errors)[0]?.[0] // берём первую ошибку из первого поля
            : null;
        logoutError.value =
            firstErrorMessage || 'Не удалось выйти. Попробуйте позже.';
    }
};
</script>
