<template>
    <div
        class="flex min-h-screen items-center justify-center bg-gray-50 px-4 py-12 sm:px-6 lg:px-8"
    >
        <AppCard>
            <h2 class="text-center text-3xl font-extrabold text-gray-900">
                Создайте аккаунт
            </h2>
            <form @submit.prevent="submit" class="mt-8 space-y-6">
                <AppInput
                    v-model="form.name"
                    label="Имя"
                    :error="errors.name"
                />
                <AppInput
                    v-model="form.email"
                    label="Email"
                    type="email"
                    :error="errors.email"
                />
                <AppInput
                    v-model="form.password"
                    label="Пароль"
                    type="password"
                    :error="errors.password"
                />
                <AppInput
                    v-model="form.password_confirmation"
                    label="Подтверждение пароля"
                    type="password"
                />
                <AppButton :loading="loading">Зарегистрироваться</AppButton>
            </form>
            <p class="mt-4 text-center text-sm text-gray-600">
                Уже есть аккаунт?
                <router-link
                    :to="{ name: 'auth.login' }"
                    class="font-medium text-indigo-600 hover:text-indigo-500"
                >
                    Войдите
                </router-link>
            </p>
        </AppCard>
    </div>
</template>

<script setup lang="ts">
import { reactive, ref } from 'vue';
import { useRouter } from 'vue-router';
import api from '@spa/axios';
import AppButton from '@spa/components/ui/AppButton.vue';
import AppCard from '@spa/components/ui/AppCard.vue';
import AppInput from '@spa/components/ui/AppInput.vue';
import { useAuthStore } from '@spa/stores/auth';

const authStore = useAuthStore();
const router = useRouter();
const form = reactive({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});
const errors = ref({});
const loading = ref(false);

const submit = async () => {
    errors.value = {};
    loading.value = true;
    try {
        await api.post('/register', form);
        await authStore.fetchUser();
        router.push({ name: 'dashboard' });
    } catch (error) {
        errors.value = error.response?.data?.errors || {};
    } finally {
        loading.value = false;
    }
};
</script>
